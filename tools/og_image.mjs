// Regenerates og-image.png (1200x630) from the LIVE chapter 6 of the site.
//
// Serves the project, boots headless Chromium, wakes the organism, scrolls to
// chapter 6 ("Find me here." + contact links) and captures several frames.
// The composite shader adds per-frame grain, so the frames are averaged
// in-page (grain decorrelates, the scene stays), then the result is quantized
// to a small median-cut palette and encoded here as a true indexed PNG via
// node:zlib — no native image tooling, no external deps beyond playwright.
//
// Usage:
//   node tools/og_image.mjs          # write og-image.png at the project root
//
// Exits 0 only if the image was written under SIZE_LIMIT_KB; 1 otherwise.
import { spawn } from 'node:child_process';
import { writeFileSync, statSync } from 'node:fs';
import { fileURLToPath } from 'node:url';
import path from 'node:path';
import zlib from 'node:zlib';
import { chromium } from 'playwright';

const ROOT = fileURLToPath(new URL('..', import.meta.url));
const PORT = 8809;
const OUT = path.join(ROOT, 'og-image.png');
const SIZE_LIMIT_KB = 300; // hard budget from the release checklist
const FRAMES = 16;         // averaged to cancel per-frame grain
const FRAME_GAP_MS = 220;  // gap between frames (lets the sim advance)
const PALETTES = [256, 192, 128, 96, 64, 48, 32]; // tried largest-first

const srv = spawn('node', ['-e', `
  const http=require('http'), fs=require('fs'), path=require('path');
  const R=${JSON.stringify(ROOT)}, PORT=${PORT};
  http.createServer((q,r)=>{let p=q.url.split('?')[0];if(p==='/')p='/index.html';
    fs.readFile(path.join(R,p),(e,d)=>{if(e){r.writeHead(404);r.end();return;}
      r.writeHead(200,{'content-type':{'.html':'text/html','.png':'image/png'}[path.extname(p)]||'text/html'});r.end(d);});
  }).listen(PORT,'127.0.0.1',()=>console.log('DA7EM_OG_READY'));
`], { stdio: ['ignore', 'pipe', 'pipe'] });
const serverReady = new Promise((resolve, reject) => {
  let buf = '';
  srv.stdout.on('data', d => { buf += d.toString(); if (buf.includes('DA7EM_OG_READY')) resolve(); });
  srv.stderr.on('data', d => process.stderr.write(d));
  setTimeout(() => reject(new Error(`og-image server timeout on port ${PORT}`)), 8000);
});

const sleep = (ms) => new Promise(r => setTimeout(r, ms));

// ---- in-page stage: average frames, median-cut quantize, return indices ----
async function quantizeFrames(page, frameB64s, nColors) {
  return page.evaluate(async (args) => {
    const { frames, n } = args;
    const img = new Image();
    const load = (f) => new Promise((res, rej) => {
      img.onload = res;
      img.onerror = () => rej(new Error('screenshot decode failed'));
      img.src = 'data:image/png;base64,' + f;
    });
    await load(frames[0]);
    const W = img.naturalWidth, H = img.naturalHeight;
    const tmp = document.createElement('canvas');
    tmp.width = W; tmp.height = H;
    const tctx = tmp.getContext('2d', { willReadFrequently: true });

    // running sum of all frames (grain averages out, scene persists)
    const acc = new Float32Array(W * H * 3);
    for (const f of frames) {
      await load(f);
      tctx.drawImage(img, 0, 0);
      const d = tctx.getImageData(0, 0, W, H).data;
      for (let i = 0, j = 0; i < d.length; i += 4, j += 3) {
        acc[j] += d[i]; acc[j + 1] += d[i + 1]; acc[j + 2] += d[i + 2];
      }
    }
    const k = frames.length;
    for (let i = 0; i < acc.length; i++) acc[i] /= k; // sums → averaged values
    const px = (j) => [acc[j], acc[j + 1], acc[j + 2]];

    // median cut on a strided sample of the averaged pixels
    const sample = [];
    for (let y = 0; y < H; y += 5) for (let x = 0; x < W; x += 5) {
      sample.push(px((y * W + x) * 3));
    }
    const rangeOf = (b) => {
      const mn = [255, 255, 255], mx = [0, 0, 0];
      for (const p of b) for (let c = 0; c < 3; c++) {
        if (p[c] < mn[c]) mn[c] = p[c];
        if (p[c] > mx[c]) mx[c] = p[c];
      }
      let axis = 0;
      if (mx[1] - mn[1] > mx[0] - mn[0]) axis = 1;
      if (mx[2] - mn[2] > mx[axis] - mn[axis]) axis = 2;
      return { span: mx[axis] - mn[axis], axis };
    };
    let boxes = [sample];
    while (boxes.length < n) {
      let bi = -1, best = -1;
      for (let k2 = 0; k2 < boxes.length; k2++) {
        if (boxes[k2].length < 2) continue;
        const score = rangeOf(boxes[k2]).span * Math.sqrt(boxes[k2].length);
        if (score > best) { best = score; bi = k2; }
      }
      if (bi < 0) break;
      const b = boxes[bi];
      const { axis } = rangeOf(b);
      b.sort((p, q) => p[axis] - q[axis]);
      const mid = b.length >> 1;
      boxes.splice(bi, 1, b.slice(0, mid), b.slice(mid));
    }
    const pal = boxes.map(b => {
      let r = 0, g = 0, bl = 0;
      for (const p of b) { r += p[0]; g += p[1]; bl += p[2]; }
      return b.length
        ? [Math.round(r / b.length), Math.round(g / b.length), Math.round(bl / b.length)]
        : [0, 0, 0];
    });

    // index every averaged pixel to its nearest palette color
    const idx = new Uint8Array(W * H);
    const cache = new Map();
    for (let p = 0, j = 0; p < idx.length; p++, j += 3) {
      const r = acc[j], g = acc[j + 1], b = acc[j + 2];
      const key = ((r * 4) << 20) | ((g * 4) << 10) | (b * 4); // 1/4-level key: visually identical, cache-friendly
      let e = cache.get(key);
      if (e === undefined) {
        let bd = Infinity, bk = 0;
        for (let c = 0; c < pal.length; c++) {
          const pc = pal[c];
          const dr = r - pc[0], dg = g - pc[1], db = b - pc[2];
          const dist = dr * dr + dg * dg + db * db;
          if (dist < bd) { bd = dist; bk = c; }
        }
        e = bk;
        cache.set(key, e);
      }
      idx[p] = e;
    }
    let s = '';
    for (let i = 0; i < idx.length; i += 65536) {
      s += String.fromCharCode.apply(null, idx.subarray(i, Math.min(i + 65536, idx.length)));
    }
    return { w: W, h: H, pal, idxB64: btoa(s) };
  }, { frames: frameB64s, n: nColors });
}

// ---- node-side stage: true indexed PNG (PLTE + filtered IDAT via zlib) ----
const CRC_TABLE = (() => {
  const t = new Int32Array(256);
  for (let nn = 0; nn < 256; nn++) {
    let c = nn;
    for (let k = 0; k < 8; k++) c = c & 1 ? 0xEDB88320 ^ (c >>> 1) : c >>> 1;
    t[nn] = c;
  }
  return t;
})();
function crc32(...bufs) {
  let c = 0xFFFFFFFF;
  for (const b of bufs) for (let i = 0; i < b.length; i++) c = CRC_TABLE[(c ^ b[i]) & 0xFF] ^ (c >>> 8);
  return (c ^ 0xFFFFFFFF) >>> 0;
}
function chunk(type, data) {
  const len = Buffer.alloc(4);
  len.writeUInt32BE(data.length);
  const body = Buffer.concat([Buffer.from(type, 'latin1'), data]);
  const crc = Buffer.alloc(4);
  crc.writeUInt32BE(crc32(body));
  return Buffer.concat([len, body, crc]);
}
const paeth = (a, b, c) => {
  const p = a + b - c, pa = Math.abs(p - a), pb = Math.abs(p - b), pc = Math.abs(p - c);
  return pa <= pb && pa <= pc ? a : pb <= pc ? b : c;
};
function encodeIndexedPNG(w, h, palette, indices) {
  const plte = Buffer.alloc(palette.length * 3);
  palette.forEach((c, i) => c.copy ? c.copy(plte, i * 3) : plte.set(c, i * 3));
  // per-row adaptive filtering (bpp = 1 for 8-bit indices)
  const stride = w;
  const out = Buffer.alloc(h * (stride + 1));
  const prev = Buffer.alloc(stride);
  const raw = Buffer.alloc(stride), filt = Buffer.alloc(stride);
  const cost = (b) => { let s = 0; for (let i = 0; i < b.length; i++) s += Math.min(b[i], 256 - b[i]); return s; };
  for (let y = 0; y < h; y++) {
    indices.copy(raw, 0, y * stride, (y + 1) * stride);
    let bestF = 0, bestCost = Infinity, bestBuf = raw;
    for (let f = 0; f <= 4; f++) {
      for (let x = 0; x < stride; x++) {
        const left = x ? raw[x - 1] : 0, up = prev[x], ul = x ? prev[x - 1] : 0;
        filt[x] = f === 0 ? raw[x]
          : f === 1 ? raw[x] - left
          : f === 2 ? raw[x] - up
          : f === 3 ? raw[x] - ((left + up) >> 1)
          : raw[x] - paeth(left, up, ul);
      }
      const c = cost(filt);
      if (c < bestCost) { bestCost = c; bestF = f; bestBuf = Buffer.from(filt); }
    }
    out[y * (stride + 1)] = bestF;
    bestBuf.copy(out, y * (stride + 1) + 1);
    raw.copy(prev);
  }
  const ihdr = Buffer.alloc(13);
  ihdr.writeUInt32BE(w, 0); ihdr.writeUInt32BE(h, 4);
  ihdr[8] = 8;  // bit depth
  ihdr[9] = 3;  // color type: indexed
  // pick whichever deflate strategy compresses this image best
  const idat = [zlib.constants.Z_FILTERED, zlib.constants.Z_RLE, zlib.constants.Z_DEFAULT_STRATEGY]
    .map(strategy => zlib.deflateSync(out, { level: 9, strategy }))
    .reduce((a, b) => (b.length < a.length ? b : a));
  return Buffer.concat([
    Buffer.from([0x89, 0x50, 0x4E, 0x47, 0x0D, 0x0A, 0x1A, 0x0A]),
    chunk('IHDR', ihdr), chunk('PLTE', plte), chunk('IDAT', idat), chunk('IEND', Buffer.alloc(0)),
  ]);
}

async function main() {
  let browser;
  try {
    await serverReady;
    browser = await chromium.launch({
      headless: true,
      args: ['--enable-unsafe-swiftshader', '--use-angle=swiftshader', '--enable-webgl', '--ignore-gpu-blocklist'],
    });
    const page = await browser.newPage({ viewport: { width: 1200, height: 630 }, deviceScaleFactor: 1 });
    let errs = 0;
    page.on('console', m => { if (m.type() === 'error') { errs++; console.error('  [page error]', m.text()); } });
    page.on('pageerror', e => { errs++; console.error('  [page exception]', e.message); });

    await page.goto(`http://127.0.0.1:${PORT}/?q=2&freeze`, { waitUntil: 'load' });
    if (!(await page.evaluate(() => !!(window.__DA7EM__ && window.__DA7EM__.ok))))
      throw new Error('__DA7EM__ missing — script crashed?');
    await sleep(400);
    await page.mouse.click(600, 315); // wake the organism (dismisses the veil)
    await sleep(1600);
    // aim at the CENTER of chapter 6 (its top edge sits on a chapter seam);
    // verify + nudge until the engine reports chapter 5 (the sixth chapter)
    let ch = -1;
    for (let attempt = 0; attempt < 3; attempt++) {
      await page.evaluate(() => {
        const secs = document.querySelectorAll('section.chapter');
        const s = secs[5];
        window.scrollTo({ top: s.offsetTop + s.offsetHeight / 2 - innerHeight / 2, behavior: 'auto' });
        window.dispatchEvent(new Event('scroll'));
      });
      await sleep(1200);
      ch = await page.evaluate(() => __DA7EM__.chapter);
      if (ch === 5) break;
    }
    await page.mouse.move(1140, 80, { steps: 4 }); // park cursor off the formation
    await sleep(2200); // panel reveal + formation settle

    const tel = await page.evaluate(() => ({ ch: __DA7EM__.chapter, fps: Math.round(__DA7EM__.fps) }));
    console.log(`capturing chapter ${tel.ch} (expect 5) at ${tel.fps} fps...`);
    if (tel.ch !== 5) throw new Error(`landed on chapter ${tel.ch}, expected 5`);

    const frames = [];
    for (let i = 0; i < FRAMES; i++) {
      frames.push((await page.screenshot({ type: 'png' })).toString('base64'));
      if (i < FRAMES - 1) await sleep(FRAME_GAP_MS);
    }
    console.log(`averaging ${FRAMES} frames (raw each ~${(frames[0].length * 3 / 4 / 1024).toFixed(0)} KB)...`);

    let wrote = null;
    for (const n of PALETTES) {
      const { w, h, pal, idxB64 } = await quantizeFrames(page, frames, n);
      const png = encodeIndexedPNG(w, h, pal, Buffer.from(idxB64, 'base64'));
      console.log(`  palette ${String(n).padStart(3)} colors → ${Math.ceil(png.length / 1024)} KB (indexed PNG)`);
      wrote = png; // each step shrinks further; keep the latest
      if (png.length / 1024 < SIZE_LIMIT_KB * 0.95) break;
    }
    if (!wrote) throw new Error('quantization produced nothing');

    writeFileSync(OUT, wrote);
    const kb = statSync(OUT).size / 1024;
    console.log(`wrote og-image.png: ${kb.toFixed(0)} KB (budget ${SIZE_LIMIT_KB} KB)`);
    if (kb >= SIZE_LIMIT_KB) { console.error('over budget'); process.exitCode = 1; }
    if (errs > 0) { console.error(`${errs} page error(s) during capture`); process.exitCode = 1; }
  } finally {
    if (browser) { try { await browser.close(); } catch {} }
    srv.kill('SIGTERM');
  }
}

main().catch(e => { console.error(e); process.exit(1); });
