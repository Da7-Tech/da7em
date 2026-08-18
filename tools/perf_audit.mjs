// Real performance audit: actual GPU renderer detection, desktop + mobile soak.
//
// Usage:
//   node tools/perf_audit.mjs          # headless (if the GPU falls back to
//                                      # SwiftShader, the soak runs on software
//                                      # and says so in the report)
//   node tools/perf_audit.mjs headed   # allow relaunching a VISIBLE browser
//                                      # window when headless falls back, to
//                                      # measure the real GPU
//
// Exits 0 only when the verdict is READY; 1 on any failure or ISSUES verdict.
import { spawn } from 'node:child_process';
import { fileURLToPath } from 'node:url';
import { chromium } from 'playwright';

const ROOT = fileURLToPath(new URL('..', import.meta.url));
const PORT = 8807;
const HEADED_ALLOWED = process.argv.includes('headed');

const srv = spawn('node', ['-e', `
  const http=require('http'), fs=require('fs'), path=require('path');
  const R=${JSON.stringify(ROOT)}, PORT=${PORT};
  http.createServer((q,r)=>{let p=q.url.split('?')[0];if(p==='/')p='/index.html';
    fs.readFile(path.join(R,p),(e,d)=>{if(e){r.writeHead(404);r.end();return;}
      r.writeHead(200,{'content-type':{'.html':'text/html','.png':'image/png'}[path.extname(p)]||'text/html'});r.end(d);});
  }).listen(PORT,'127.0.0.1',()=>console.log('DA7EM_AUDIT_READY'));
`], { stdio: ['ignore', 'pipe', 'pipe'] });
const serverReady = new Promise((resolve, reject) => {
  let buf = '';
  srv.stdout.on('data', d => { buf += d.toString(); if (buf.includes('DA7EM_AUDIT_READY')) resolve(); });
  srv.stderr.on('data', d => process.stderr.write(d));
  setTimeout(() => reject(new Error(`audit server timeout on port ${PORT}`)), 8000);
});

async function soak(browser, label, opts, seconds) {
  const page = await browser.newPage(opts);
  let errs = 0;
  page.on('pageerror', e => { errs++; console.error(`[${label} exc]`, e.message); });
  await page.goto(`http://127.0.0.1:${PORT}/`, { waitUntil: 'load' });
  await new Promise(r => setTimeout(r, 600));
  await page.mouse.click(640, 360); // wake
  await new Promise(r => setTimeout(r, 1200));
  const fpsSamples = [], heapSamples = [];
  const t0 = Date.now();
  let i = 0;
  while (Date.now() - t0 < seconds * 1000) {
    const m = await page.evaluate(() => ({
      fps: __DA7EM__.fps, ms: __DA7EM__.ms, q: __DA7EM__.quality,
      n: __DA7EM__.particles, heap: performance.memory ? performance.memory.usedJSHeapSize : 0,
    }));
    fpsSamples.push(m.fps); if (m.heap) heapSamples.push(m.heap);
    // keep it lively: sweep chapters + cursor every ~5s
    if (i % 5 === 0) {
      await page.evaluate((k) => {
        const secs = document.querySelectorAll('section.chapter');
        window.scrollTo({ top: secs[(k/5) % 6].offsetTop, behavior:'auto' });
      }, i);
      await page.mouse.move(300 + (i*97)%700, 200 + (i*61)%400, { steps:6 });
    }
    i++;
    await new Promise(r => setTimeout(r, 1000));
  }
  const sorted = [...fpsSamples].sort((a,b)=>a-b);
  const med = sorted[Math.floor(sorted.length/2)];
  const p5 = sorted[Math.floor(sorted.length*0.05)];
  const qEvents = await page.evaluate(() => __DA7EM__.qualityEvents);
  const audio = await page.evaluate(() => __DA7EM__.audio);
  const heapGrowth = heapSamples.length > 1 ? ((heapSamples[heapSamples.length-1] - heapSamples[0]) / 1048576).toFixed(1) : 'n/a';
  console.log(`\n[${label}] ${seconds}s soak:`);
  console.log(`  fps median=${med.toFixed(1)} p5=${p5.toFixed(1)} min=${sorted[0].toFixed(1)}  particles=${await page.evaluate(()=>__DA7EM__.particles)} q=${await page.evaluate(()=>__DA7EM__.quality)}`);
  console.log(`  qualityEvents(adaptive): ${JSON.stringify(qEvents)}`);
  console.log(`  audio: ${JSON.stringify(audio)}  heapGrowth=${heapGrowth} MB  pageErrors=${errs}`);
  await page.close();
  return { med, p5, qEvents, errs, heapGrowth };
}

async function main() {
  let browser;
  try {
    await serverReady;
    browser = await chromium.launch({
      headless: true,
      args: ['--ignore-gpu-blocklist'],
    });
    const probe = await browser.newPage();
    await probe.goto(`http://127.0.0.1:${PORT}/`, { waitUntil: 'load' });
    const gpu = await probe.evaluate(() => {
      const c = document.createElement('canvas');
      const gl = c.getContext('webgl2');
      const dbg = gl.getExtension('WEBGL_debug_renderer_info');
      return {
        renderer: dbg ? gl.getParameter(dbg.UNMASKED_RENDERER_WEBGL) : gl.getParameter(gl.RENDERER),
        vendor: dbg ? gl.getParameter(dbg.UNMASKED_VENDOR_WEBGL) : gl.getParameter(gl.VENDOR),
      };
    });
    await probe.close();
    console.log(`GPU renderer: ${gpu.renderer}  (vendor: ${gpu.vendor})`);
    const isRealGPU = !/swiftshader|software|llvmpipe/i.test(gpu.renderer);
    if (!isRealGPU) {
      if (HEADED_ALLOWED) {
        console.log('headless fell back to software — relaunching a VISIBLE window (the "headed" argument) to measure the real GPU...');
        await browser.close();
        browser = await chromium.launch({ headless: false, args: ['--ignore-gpu-blocklist'] });
      } else {
        console.log('headless fell back to software rendering — the numbers below reflect SwiftShader, not a real GPU.');
        console.log('To measure the real GPU instead, re-run with: node tools/perf_audit.mjs headed  (this opens a visible browser window).');
      }
    }

    // 1) desktop real-GPU soak 45s
    const desk = await soak(browser, 'desktop 1280x720', { viewport: { width: 1280, height: 720 } }, 45);
    // 2) mobile emulation (coarse pointer -> tier 0) 30s
    const mob = await soak(browser, 'mobile 390x844 touch', { viewport: { width: 390, height: 844 }, hasTouch: true, isMobile: true, deviceScaleFactor: 2 }, 30);

    const ready = desk.med >= 50 && mob.med >= 24 && desk.errs === 0 && mob.errs === 0;
    console.log(`\nVERDICT: ${ready ? 'READY' : 'ISSUES'} — desktop median ${desk.med.toFixed(1)} fps · mobile median ${mob.med.toFixed(1)} fps`);
    process.exitCode = ready ? 0 : 1;
  } finally {
    if (browser) { try { await browser.close(); } catch {} }
    srv.kill('SIGTERM');
  }
}

main().catch(e => { console.error(e); process.exit(1); });
