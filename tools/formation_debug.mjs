// Debug: plot formation[5] (DA7EM sunburst) homes directly on a 2D canvas to
// isolate whether the bug is in formation data or in the sim/render pipeline.
// Exits 1 on any failure; the server and browser are always cleaned up.
import { spawn } from 'node:child_process';
import { fileURLToPath } from 'node:url';
import path from 'node:path';
import { chromium } from 'playwright';

const ROOT = fileURLToPath(new URL('..', import.meta.url));
const PORT = 8798;
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
    await page.goto(`http://127.0.0.1:${PORT}/`, { waitUntil: 'load' });
    await page.waitForTimeout(600);

    const stats = await page.evaluate(() => {
      const f = window.__DA7EM__.formations[5];
      let minX = 1e9, maxX = -1e9, minY = 1e9, maxY = -1e9, n = f.length / 2;
      for (let i = 0; i < n; i++) {
        minX = Math.min(minX, f[i*2]); maxX = Math.max(maxX, f[i*2]);
        minY = Math.min(minY, f[i*2+1]); maxY = Math.max(maxY, f[i*2+1]);
      }
      // plot on 2d canvas: world (x,y) → pixels, aspect=1.78
      const A = 1.78;
      const cv = document.createElement('canvas');
      cv.width = 1280; cv.height = 720; cv.style.cssText = 'position:fixed;inset:0;z-index:999;background:#000';
      document.body.appendChild(cv);
      const ctx = cv.getContext('2d');
      ctx.fillStyle = '#fff';
      for (let i = 0; i < n; i++) {
        const px = (f[i*2] / A * 0.5 + 0.5) * 1280;
        const py = (0.5 - f[i*2+1] * 0.5) * 720;
        ctx.fillRect(px, py, 1.5, 1.5);
      }
      return { n, minX, maxX, minY, maxY };
    });
    console.log('formation[5] bounds:', JSON.stringify(stats));
    await page.screenshot({ path: path.join(ROOT, 'screenshots', 'debug_formation5.png') });
    console.log('📸 debug_formation5.png');
  } finally {
    if (pageErrors) { console.error(`FAIL: ${pageErrors} page error(s) observed`); process.exitCode = 1; }
    await browser.close();
    p.kill('SIGTERM');
  }
}

main().catch(e => { console.error(e); p.kill('SIGTERM'); process.exit(1); });
