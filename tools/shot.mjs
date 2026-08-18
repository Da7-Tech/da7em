// Headless screenshot + telemetry harness for DA7EM (engine: LUMEN).
// Serves the project, drives the live practice via window.__DA7EM__,
// captures PNG frames per chapter/state, and dumps perf telemetry.
//
// Usage:
//   node tools/shot.mjs               # full set: all chapters + states
//   node tools/shot.mjs quick         # chapters only
//   node tools/shot.mjs perf          # perf telemetry only (24 × 1 s samples)
import { spawn } from 'node:child_process';
import { mkdirSync, writeFileSync } from 'node:fs';
import { fileURLToPath } from 'node:url';
import path from 'node:path';
import { chromium } from 'playwright';

const ROOT = fileURLToPath(new URL('..', import.meta.url));
const PORT = 8797;
const OUT = process.env.SHOTS_DIR || path.join(ROOT, 'screenshots');

const MIME = { '.html': 'text/html', '.js': 'text/javascript', '.css': 'text/css', '.png': 'image/png', '.svg': 'image/svg+xml' };
function startServer() {
  const p = spawn('node', ['-e', `
    const http = require('http'), fs = require('fs'), path = require('path');
    const ROOT = ${JSON.stringify(ROOT)}, PORT = ${PORT};
    http.createServer((req, res) => {
      let p = req.url.split('?')[0]; if (p === '/') p = '/index.html';
      const f = path.join(ROOT, p);
      fs.readFile(f, (err, data) => {
        if (err) { res.writeHead(404); res.end('nf'); return; }
        res.writeHead(200, { 'content-type': ${JSON.stringify(MIME)}[path.extname(f)] || 'application/octet-stream' });
        res.end(data);
      });
    }).listen(PORT, '127.0.0.1', () => console.log('DA7EM_SERVE_READY'));
  `], { stdio: ['ignore', 'pipe', 'pipe'] });
  return new Promise((resolve, reject) => {
    let buf = '';
    p.stdout.on('data', d => { buf += d.toString(); if (buf.includes('DA7EM_SERVE_READY')) resolve(p); });
    p.stderr.on('data', d => process.stderr.write(d));
    setTimeout(() => reject(new Error('server timeout')), 8000);
  });
}
const sleep = (ms) => new Promise(r => setTimeout(r, ms));

async function boot(page, url) {
  await page.goto(url, { waitUntil: 'load' });
  const ok = await page.evaluate(() => !!(window.__DA7EM__ && window.__DA7EM__.ok));
  if (!ok) throw new Error('__DA7EM__ missing — script crashed?');
  await sleep(400);
  // wake the organism (click center)
  await page.mouse.click(640, 360);
  await sleep(1600);
}

async function gotoChapter(page, i) {
  await page.evaluate((idx) => {
    const secs = document.querySelectorAll('section.chapter');
    window.scrollTo({ top: idx === 0 ? 0 : secs[idx].offsetTop, behavior: 'auto' });
    // force smooth-scroll state to land instantly for deterministic shots
    window.dispatchEvent(new Event('scroll'));
  }, i);
  // park cursor away from the formation so the hero text reads clean
  await page.mouse.move(1160, 90, { steps: 4 });
  await sleep(2200);
}

async function capture(page, name) {
  const file = path.join(OUT, `${name}.png`);
  await page.screenshot({ path: file });
  const tel = await page.evaluate(() => ({
    ch: __DA7EM__.chapter, p: __DA7EM__.progress, fps: Math.round(__DA7EM__.fps),
    ms: __DA7EM__.ms, q: __DA7EM__.quality, n: __DA7EM__.particles, dream: __DA7EM__.dream,
  }));
  console.log(`  📷 ${name}.png  ch=${tel.ch} p=${tel.p} fps=${tel.fps} ms=${tel.ms} q=${tel.q} n=${tel.n}`);
  return file;
}

async function main() {
  mkdirSync(OUT, { recursive: true });
  const server = await startServer();
  const url = `http://127.0.0.1:${PORT}/?q=2&freeze`;
  const browser = await chromium.launch({
    headless: true,
    args: ['--enable-unsafe-swiftshader', '--use-angle=swiftshader', '--enable-webgl', '--ignore-gpu-blocklist'],
  });
  let pageErrors = 0; // fail-closed: any console error or page exception fails the audit
  const watch = (p, tag) => {
    p.on('console', m => { if (m.type() === 'error') { pageErrors++; console.error(`  [${tag} error]`, m.text()); } });
    p.on('pageerror', e => { pageErrors++; console.error(`  [${tag} exception]`, e.message); });
  };
  const page = await browser.newPage({ viewport: { width: 1280, height: 720 }, deviceScaleFactor: 1 });
  watch(page, 'page');

  const mode = process.argv[2] || 'full';
  try {
    await boot(page, url);

    if (mode === 'perf') {
      await page.evaluate(() => { const l = window.__DA7EM__; l.wake(); });
      await sleep(500);
      const samples = [];
      for (let i = 0; i < 24; i++) { await sleep(1000); samples.push(await page.evaluate(() => __DA7EM__.ms)); }
      const sorted = [...samples].sort((a, b) => a - b);
      console.log('perf ms samples:', samples.join(' '));
      console.log(`median=${sorted[12]} p95=${sorted[22]} max=${sorted[23]}`);
      console.log('qualityEvents:', JSON.stringify(await page.evaluate(() => __DA7EM__.qualityEvents)));
      const audio = await page.evaluate(() => __DA7EM__.audio);
      console.log('audio:', JSON.stringify(audio));
      if (pageErrors) { console.error(`FAIL: ${pageErrors} console error(s)/exception(s) observed`); process.exitCode = 1; }
      await browser.close(); server.kill('SIGTERM'); return;
    }

    // chapters
    for (let i = 0; i < 6; i++) {
      await gotoChapter(page, i);
      await capture(page, `ch${i}`);
    }

    if (mode === 'full') {
      // hover disturbance — ch1 iris tracking cursor
      await gotoChapter(page, 1);
      await page.mouse.move(300, 200, { steps: 12 });
      await sleep(250);
      await page.mouse.move(980, 520, { steps: 18 });
      await sleep(420);
      await capture(page, 'state_hover_iris');

      // click shock on ch3
      await gotoChapter(page, 3);
      await page.mouse.move(640, 360, { steps: 6 });
      await page.mouse.click(640, 360);
      await sleep(160);
      await capture(page, 'state_click_shock');

      // ch5 transcendence — click and let go
      await gotoChapter(page, 5);
      await page.mouse.click(640, 360);
      await sleep(700);
      await capture(page, 'state_become');

      // dream mode — idle in ch0 until the organism wanders
      await gotoChapter(page, 0);
      await sleep(5200);
      await capture(page, 'state_dream');

      // memory replay — move a lot in ch4, then rest
      await gotoChapter(page, 4);
      for (let i = 0; i < 14; i++) {
        await page.mouse.move(200 + i * 60, i % 2 ? 200 : 500, { steps: 8 });
        await sleep(60);
      }
      await sleep(2400);
      await capture(page, 'state_memory_replay');

      // audio state check
      const audio = await page.evaluate(() => __DA7EM__.audio);
      console.log('audio:', JSON.stringify(audio));

      // reduced motion — fresh page with emulation
      const page2 = await browser.newPage({ viewport: { width: 1280, height: 720 }, deviceScaleFactor: 1 });
      await page2.emulateMedia({ reducedMotion: 'reduce' });
      watch(page2, 'page2');
      await page2.goto(url, { waitUntil: 'load' });
      await page2.mouse.click(640, 360);
      await sleep(1500);
      await gotoChapter(page2, 2);
      await page2.screenshot({ path: path.join(OUT, 'state_reduced_motion.png') });
      console.log('  📷 state_reduced_motion.png');
      await page2.close();
    }

    // keyboard nav check — from a middle chapter, ArrowDown must advance.
    // The eased chapter readout trails the smooth scroll (~1.5 s headless), so poll.
    await gotoChapter(page, 2);
    const chBefore = await page.evaluate(() => __DA7EM__.chapter);
    await page.keyboard.press('ArrowDown');
    let chAfter = chBefore;
    for (let waited = 0; waited < 4000 && chAfter <= chBefore; waited += 250) {
      await sleep(250);
      chAfter = await page.evaluate(() => __DA7EM__.chapter);
    }
    if (chAfter > chBefore) console.log(`keyboard ArrowDown → chapter ${chBefore} → ${chAfter} (ok)`);
    else { console.error(`keyboard check FAILED: ArrowDown left chapter at ${chBefore} → ${chAfter}`); process.exitCode = 1; }
    if (pageErrors) { console.error(`FAIL: ${pageErrors} console error(s)/exception(s) observed during the audit`); process.exitCode = 1; }
    else console.log('no console errors or page exceptions observed (ok)');
  } finally {
    await browser.close();
    server.kill('SIGTERM');
  }
}

main().catch(e => { console.error(e); process.exit(1); });
