// Layer-by-layer quantitative debug: where do the letters die?
// Reads trail/flesh/bloom FBOs via __DA7EM__.stats() at each chapter.
// Exits 1 on any failure; the server and browser are always cleaned up.
import { spawn } from 'node:child_process';
import { fileURLToPath } from 'node:url';
import path from 'node:path';
import { chromium } from 'playwright';

const ROOT = fileURLToPath(new URL('..', import.meta.url));
const PORT = 8799;
const p = spawn('node', ['-e', `
  const http = require('http'), fs = require('fs'), path = require('path');
  http.createServer((req, res) => {
    let p = req.url.split('?')[0]; if (p === '/') p = '/index.html';
    fs.readFile(path.join(${JSON.stringify(ROOT)}, p), (err, data) => {
      if (err) { res.writeHead(404); res.end(); return; }
      res.writeHead(200, { 'content-type': 'text/html' }); res.end(data);
    });
  }).listen(${PORT}, '127.0.0.1', () => console.log('READY'));
`], { stdio: ['ignore', 'pipe', 'pipe'] });
const serverReady = new Promise((resolve, reject) => {
  let buf = '';
  p.stdout.on('data', d => { buf += d.toString(); if (buf.includes('READY')) resolve(); });
  p.stderr.on('data', d => process.stderr.write(d));
  setTimeout(() => reject(new Error(`debug server timeout on port ${PORT}`)), 8000);
});

async function main() {
  await serverReady;
  const browser = await chromium.launch({ headless: true, args: ['--enable-unsafe-swiftshader'] });
  let pageErrors = 0; // fail-closed, like the main harness
  try {
    const page = await browser.newPage({ viewport: { width: 1280, height: 720 } });
    page.on('pageerror', e => { pageErrors++; console.error('[exc]', e.message); });
    page.on('console', m => { if (m.type() === 'error') { pageErrors++; console.error('[console.error]', m.text()); } });
    await page.goto(`http://127.0.0.1:${PORT}/?q=2&freeze`, { waitUntil: 'load' });
    await page.waitForTimeout(500);
    await page.mouse.click(640, 360);
    await page.waitForTimeout(2500);
    await page.mouse.move(1160, 90, { steps: 4 });

    for (const layer of ['trail', 'flesh', 'bloom']) {
      const s = await page.evaluate((l) => __DA7EM__.stats(l), layer);
      console.log(`${layer.padEnd(6)} maxL=${s.maxL} inAvg=${s.inAvg} outAvg=${s.outAvg} in/out=${s.ratio}`);
    }
    // save trail layer as PNG for visual check
    const snap = await page.evaluate(() => __DA7EM__.snapshot('trail'));
    const img = await page.evaluate(({ px, w, h }) => {
      const cv = document.createElement('canvas');
      cv.width = w; cv.height = h;
      const ctx = cv.getContext('2d');
      const id = ctx.createImageData(w, h);
      id.data.set(px);
      ctx.putImageData(id, 0, 0);
      return cv.toDataURL('image/png');
    }, snap);
    const b64 = img.split(',')[1];
    const { writeFileSync } = await import('node:fs');
    writeFileSync(path.join(ROOT, 'screenshots', 'debug_trail.png'), Buffer.from(b64, 'base64'));
    console.log('📸 debug_trail.png (flipped rows are expected — GL origin bottom-left)');
  } finally {
    if (pageErrors) { console.error(`FAIL: ${pageErrors} page error(s) observed`); process.exitCode = 1; }
    await browser.close();
    p.kill('SIGTERM');
  }
}

main().catch(e => { console.error(e); p.kill('SIGTERM'); process.exit(1); });
