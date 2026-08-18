<?php
/*
Template Name: Da7em Fullscreen
Description: Da7em — a living digital practice (engine: LUMEN). Full standalone HTML output, no theme header/footer. English only.
License: CC BY 4.0 — attribute Da7_Tech (da7tech.com) — see LICENSE/NOTICE.
*/
?>
<!doctype html>
<html lang="en">
<head>
<!--
  Da7em — a living digital practice
  Copyright © 2026 Da7_Tech — https://da7tech.com

  License: Creative Commons Attribution 4.0 International (CC BY 4.0)
  https://creativecommons.org/licenses/by/4.0/

  Free to use, share and adapt — even commercially — for any purpose,
  PROVIDED you give credit to the source: Da7_Tech (da7tech.com),
  link the license, and indicate if you made changes.

  Engine credit: LUMEN — a living digital organism.
-->
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
<title>Da7em — a living digital practice</title>
<meta name="description" content="Da7em — management & technology advisor, AI evaluator and tester. A living digital practice: up to 26,000 GPU-simulated particles, WebGL2, reactive physics, generative sound. One file. Zero dependencies.">
<meta name="theme-color" content="#05070c">
<meta property="og:title" content="Da7em — a living digital practice">
<meta property="og:description" content="Management & technology advisor, AI evaluator and tester — rendered as up to 26,000 particles of light that advise, evaluate, test, lead and finally become the name. One HTML file. Zero dependencies.">
<meta name="author" content="Da7_Tech">
<link rel="canonical" href="https://da7tech.com/da7em/">
<meta property="og:type" content="website">
<meta property="og:url" content="https://da7tech.com/da7em/">
<meta property="og:site_name" content="Da7em — Da7_Tech">
<meta property="og:locale" content="en_US">
<meta property="og:image" content="https://da7tech.com/da7em/og-image.png">
<meta property="og:image:width" content="1200">
<meta property="og:image:height" content="630">
<meta property="og:image:alt" content="Golden particles of light forming the name DA7EM on a dark void">
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:site" content="@Da7_Tech">
<meta name="twitter:title" content="Da7em — a living digital practice">
<meta name="twitter:description" content="Management & technology advisor, AI evaluator and tester — up to 26,000 particles of light. One HTML file. Zero dependencies.">
<meta name="twitter:image" content="https://da7tech.com/da7em/og-image.png">
<link rel="icon" href="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 64 64'%3E%3Ccircle cx='32' cy='32' r='9' fill='%237df9ff'/%3E%3Ccircle cx='32' cy='32' r='18' fill='none' stroke='%237df9ff' stroke-opacity='.4' stroke-width='2'/%3E%3Ccircle cx='32' cy='32' r='28' fill='none' stroke='%237df9ff' stroke-opacity='.15' stroke-width='1.5'/%3E%3C/svg%3E">
<style>
  :root{
    --ink: #e8f1ff;
    --ink-dim: rgba(232,241,255,.55);
    --hair: rgba(232,241,255,.14);
    --glass: rgba(8,12,20,.38);
    --mono: ui-monospace, "SF Mono", SFMono-Regular, Menlo, Consolas, monospace;
    --serif: "New York", "Iowan Old Style", Georgia, "Times New Roman", serif;
    --sans: ui-sans-serif, -apple-system, BlinkMacSystemFont, "Helvetica Neue", Arial, sans-serif;
  }
  *{ margin:0; padding:0; box-sizing:border-box; }
  html{ scrollbar-color: rgba(232,241,255,.18) transparent; }
  body{
    background:#05070c; color:var(--ink);
    font-family:var(--sans);
    overflow-x:hidden;
    -webkit-font-smoothing:antialiased;
    text-rendering:optimizeLegibility;
    touch-action:pan-y;
    cursor:none;
  }
  body.native-cursor, body.native-cursor *{ cursor:auto; }
  body.native-cursor button, body.native-cursor a{ cursor:pointer; }
  ::selection{ background:rgba(125,249,255,.25); color:#fff; }
  ::-webkit-scrollbar{ width:9px; }
  ::-webkit-scrollbar-thumb{ background:rgba(232,241,255,.14); border-radius:99px; border:2px solid #05070c; }
  ::-webkit-scrollbar-track{ background:transparent; }

  button{ cursor:pointer; }
  :focus{ outline:none; }
  :focus-visible{ outline:1.5px solid rgba(125,249,255,.9); outline-offset:3px; border-radius:4px; }

  /* ---------- fixed stage ---------- */
  #gl{
    position:fixed; inset:0; width:100%; height:100%;
    display:block; z-index:1;
  }
  #grain-progress{
    position:fixed; top:0; left:0; height:2px; width:100%;
    transform-origin:0 50%; transform:scaleX(0);
    background:linear-gradient(90deg,#35f0ff,#a78bfa,#4ade80,#ff3b5c,#2dd4bf,#ffd166);
    z-index:40; opacity:.85; pointer-events:none;
  }

  /* ---------- header ---------- */
  header{
    position:fixed; top:0; left:0; right:0; z-index:30;
    display:flex; align-items:center; justify-content:space-between;
    padding:clamp(14px,2.4vw,26px) clamp(16px,3vw,34px);
    pointer-events:none;
  }
  .wordmark{
    font-family:var(--mono); font-size:12px; letter-spacing:.42em;
    color:var(--ink-dim); display:flex; align-items:center; gap:10px;
    user-select:none;
  }
  .wordmark .pulse-dot{
    width:6px; height:6px; border-radius:50%;
    background:#7df9ff; box-shadow:0 0 12px 2px rgba(125,249,255,.8);
    animation:dotbreathe 3.2s ease-in-out infinite;
  }
  @keyframes dotbreathe{ 0%,100%{ opacity:.45; transform:scale(.8);} 50%{ opacity:1; transform:scale(1.15);} }
  .controls{ display:flex; gap:10px; pointer-events:auto; }
  .chip{
    display:inline-flex; align-items:center; gap:8px;
    font-family:var(--mono); font-size:10px; letter-spacing:.22em;
    color:var(--ink-dim);
    background:var(--glass); border:1px solid var(--hair); border-radius:999px;
    padding:8px 14px; backdrop-filter:blur(10px); -webkit-backdrop-filter:blur(10px);
    transition:color .3s, border-color .3s, background .3s;
    user-select:none;
  }
  .chip svg{ width:13px; height:13px; stroke:currentColor; fill:none; stroke-width:1.6; stroke-linecap:round; stroke-linejoin:round; }
  .chip:hover{ color:var(--ink); border-color:rgba(232,241,255,.32); }
  /* iOS re-blurs the live canvas under every chip each frame — on touch devices
     trade the glass blur for a plain opaque chip and keep the frames */
  @media (pointer:coarse){
    .chip{ backdrop-filter:none; -webkit-backdrop-filter:none; background:rgba(7,10,16,.85); }
    .panel{ will-change:auto; } /* don't pin six compositor layers over the live canvas */
    h2{ text-shadow:0 2px 22px rgba(5,7,12,.9); } /* the 80px glow shadow re-rasters per frame while scrolling */
  }
  .chip[aria-pressed="true"]{ color:rgba(207,255,255,.95); border-color:rgba(125,249,255,.4); }
  .chip .on-off{ opacity:.85; }

  /* ---------- chapter dots ---------- */
  nav.dots{
    position:fixed; right:clamp(12px,2.2vw,28px); top:50%; transform:translateY(-50%);
    z-index:30; display:flex; flex-direction:column; gap:14px;
  }
  .dots button{
    width:26px; height:26px; display:grid; place-items:center;
    background:none; border:none; position:relative;
  }
  .dots button i{
    width:5px; height:5px; border-radius:50%;
    background:rgba(232,241,255,.28);
    transition:transform .35s cubic-bezier(.2,.9,.3,1.4), background .35s, box-shadow .35s;
    font-style:normal; display:block;
  }
  .dots button:hover i{ background:rgba(232,241,255,.75); transform:scale(1.5); }
  .dots button[aria-current="true"] i{
    background:#fff; transform:scale(1.9);
    box-shadow:0 0 10px 2px rgba(255,255,255,.5);
  }
  .dots button .tip{
    position:absolute; right:32px; top:50%; transform:translateY(-50%) translateX(6px);
    font-family:var(--mono); font-size:9px; letter-spacing:.3em; color:var(--ink-dim);
    white-space:nowrap; opacity:0; transition:opacity .25s, transform .25s; pointer-events:none;
  }
  .dots button:hover .tip, .dots button:focus-visible .tip{ opacity:1; transform:translateY(-50%) translateX(0); }

  /* ---------- hint line ---------- */
  #hint{
    position:fixed; left:clamp(16px,3vw,34px); bottom:clamp(14px,2.4vw,24px);
    z-index:30; font-family:var(--mono); font-size:9.5px; letter-spacing:.3em;
    color:rgba(232,241,255,.4); text-transform:uppercase;
    transition:opacity .6s; pointer-events:none; user-select:none;
  }

  /* ---------- sections ---------- */
  main{ position:relative; z-index:10; }
  section.chapter{
    min-height:116vh; min-height:116svh; position:relative;
    display:flex; align-items:center;
    padding:0 clamp(20px,6vw,90px);
    pointer-events:none;
  }
  .panel{
    max-width:min(420px, 84vw);
    opacity:0; transform:translateY(18px);
    will-change:opacity, transform;
  }
  section[data-side="right"]{ justify-content:flex-end; text-align:right; }
  section[data-side="right"] .readouts{ justify-content:flex-end; }
  section[data-side="center"]{ justify-content:center; text-align:center; }
  section[data-side="center"] .readouts{ justify-content:center; }

  .kicker{
    font-family:var(--mono); font-size:10.5px; letter-spacing:.5em;
    color:rgba(232,241,255,.68); margin-bottom:18px; text-transform:uppercase;
  }
  .kicker b{ font-weight:400; color:rgba(125,249,255,.95); }
  h2{
    font-family:var(--serif); font-style:italic; font-weight:400;
    font-size:clamp(26px, 3.6vw, 44px); line-height:1.16;
    letter-spacing:.01em; margin-bottom:20px;
    text-shadow:0 2px 30px rgba(5,7,12,.9), 0 0 80px rgba(5,7,12,.7);
  }
  .readouts{
    display:flex; gap:26px; margin-top:26px; flex-wrap:wrap;
  }
  .readouts div{ min-width:64px; }
  .readouts dt{
    font-family:var(--mono); font-size:8.5px; letter-spacing:.34em;
    color:rgba(232,241,255,.52); margin-bottom:6px; text-transform:uppercase;
  }
  .readouts dd{
    font-family:var(--mono); font-size:15px; color:rgba(220,246,255,.95);
    font-variant-numeric:tabular-nums;
    text-shadow:0 0 14px rgba(125,249,255,.35);
  }

  /* contact — plain quiet links */
  .panel .links{
    margin-top:22px; font-family:var(--mono); font-size:11.5px; letter-spacing:.12em;
    color:rgba(232,241,255,.62); line-height:2.3; pointer-events:auto;
    text-shadow:0 1px 10px rgba(5,7,12,.95), 0 0 26px rgba(5,7,12,.8);
  }
  .panel .links a{
    color:rgba(222,247,255,.95); text-decoration:none;
    border-bottom:1px solid rgba(232,241,255,.28);
    transition:color .3s, border-color .3s;
  }
  .panel .links a:hover{ color:#fff; border-color:rgba(125,249,255,.65); }

  /* license — the quietest line in the panel */
  .panel .license{
    margin-top:16px; font-family:var(--mono); font-size:9.5px; letter-spacing:.1em;
    color:rgba(232,241,255,.42); line-height:1.8; pointer-events:auto;
    text-shadow:0 1px 10px rgba(5,7,12,.95), 0 0 26px rgba(5,7,12,.8);
  }
  .panel .license a{
    color:rgba(222,247,255,.75); text-decoration:none;
    border-bottom:1px solid rgba(232,241,255,.22);
    transition:color .3s, border-color .3s;
  }
  .panel .license a:hover{ color:#fff; border-color:rgba(125,249,255,.55); }

  .sr-only{
    position:absolute; width:1px; height:1px; overflow:hidden;
    clip:rect(0 0 0 0); white-space:nowrap;
  }
  .skip{
    position:fixed; top:10px; left:10px; z-index:100;
    background:#0b1220; color:var(--ink); border:1px solid var(--hair);
    font-family:var(--mono); font-size:11px; letter-spacing:.2em;
    padding:10px 16px; border-radius:8px; transform:translateY(-200%);
    transition:transform .3s; text-decoration:none;
  }
  .skip:focus-visible{ transform:none; }

  /* ---------- intro veil ---------- */
  #veil{
    position:fixed; inset:0; z-index:50;
    display:grid; place-items:center; text-align:center;
    background:rgba(4,6,11,.42);
    backdrop-filter:blur(16px) saturate(1.15); -webkit-backdrop-filter:blur(16px) saturate(1.15);
    transition:opacity 1.1s ease, backdrop-filter 1.1s ease;
  }
  #veil.gone{ opacity:0; pointer-events:none; backdrop-filter:blur(0); -webkit-backdrop-filter:blur(0); }
  #veil .v-kicker{
    font-family:var(--mono); font-size:10px; letter-spacing:.6em;
    color:rgba(232,241,255,.5); margin-bottom:26px; text-transform:uppercase;
  }
  #veil h1{
    font-family:var(--serif); font-style:italic; font-weight:400;
    font-size:clamp(64px, 14vw, 168px); line-height:1; letter-spacing:.02em;
    animation:veilbreathe 5s ease-in-out infinite;
  }
  @keyframes veilbreathe{ 0%,100%{ opacity:.86; } 50%{ opacity:1; } }
  #veil .v-sub{
    margin-top:22px; font-family:var(--mono); font-size:11px; letter-spacing:.44em;
    color:rgba(232,241,255,.66); text-transform:uppercase;
  }
  #veil .v-wake{
    margin-top:54px; font-family:var(--mono); font-size:10px; letter-spacing:.34em;
    color:rgba(125,249,255,.85); text-transform:uppercase;
    animation:dotbreathe 2.4s ease-in-out infinite;
  }
  #veil .v-note{
    margin-top:14px; font-family:var(--mono); font-size:9px; letter-spacing:.24em;
    color:rgba(232,241,255,.32); text-transform:uppercase;
  }

  /* ---------- no-webgl fallback ---------- */
  .webgl-fail{
    display:none; position:fixed; inset:0; z-index:60; padding:24px;
    background:#05070c;
  }
  body.no-webgl .webgl-fail{ display:grid; place-items:center; text-align:center; }
  body.no-webgl #veil{ display:none; }
  body.no-webgl header, body.no-webgl nav.dots{ display:none; }
  .webgl-fail p{
    font-family:var(--mono); font-size:12px; letter-spacing:.2em; line-height:2.2;
    color:var(--ink-dim); max-width:60ch;
  }

  html.reduced #veil h1, html.reduced .wordmark .pulse-dot, html.reduced #veil .v-wake{ animation:none; }
  html.reduced body, html.motion-off body{ cursor:auto; }
  html.reduced button, html.motion-off button, html.reduced a, html.motion-off a{ cursor:pointer; }
  @media (prefers-reduced-motion: reduce){
    #veil h1, .wordmark .pulse-dot, #veil .v-wake{ animation:none; }
    body{ cursor:auto; }
    button, a{ cursor:pointer; }
  }
  @media (max-width:640px){
    nav.dots{ right:8px; gap:10px; }
    .dots button .tip{ display:none; }
    section.chapter{ min-height:112vh; }
    #hint{ display:none; }
    /* narrow phones: icon-only chips so the whole header fits 320px */
    .chip{ padding:8px 11px; gap:0; }
    .chip .on-off{ display:none; }
    .wordmark{ letter-spacing:.3em; }
  }
</style>
</head>
<body>
<a class="skip" href="#signal">Skip to content</a>

<canvas id="gl" aria-hidden="true" role="presentation"></canvas>
<div id="grain-progress" aria-hidden="true"></div>

<header>
  <div class="wordmark"><span class="pulse-dot" aria-hidden="true"></span>DA7EM</div>
  <div class="controls">
    <button class="chip" id="btn-sound" aria-pressed="false" aria-label="Toggle sound">
      <svg viewBox="0 0 24 24" aria-hidden="true">
        <path d="M4 9v6h4l5 4V5L8 9H4z"/>
        <path class="w1" d="M16 9.5a4 4 0 0 1 0 5"/>
        <path class="w2" d="M18.5 7a8 8 0 0 1 0 10"/>
      </svg>
      <span class="on-off" id="sound-label">SOUND&nbsp;OFF</span>
    </button>
    <button class="chip" id="btn-motion" aria-pressed="true" aria-label="Toggle motion">
      <svg viewBox="0 0 24 24" aria-hidden="true">
        <circle cx="12" cy="12" r="3.2"/>
        <ellipse cx="12" cy="12" rx="9.5" ry="4.2" transform="rotate(-24 12 12)"/>
      </svg>
      <span class="on-off" id="motion-label">MOTION&nbsp;FULL</span>
    </button>
  </div>
</header>

<nav class="dots" aria-label="Chapters">
  <button data-ch="0" aria-current="true"><i></i><span class="tip">01 — SIGNAL</span><span class="sr-only">Chapter 1, Signal</span></button>
  <button data-ch="1"><i></i><span class="tip">02 — SERVICES</span><span class="sr-only">Chapter 2, Services</span></button>
  <button data-ch="2"><i></i><span class="tip">03 — EVALUATE</span><span class="sr-only">Chapter 3, Evaluate</span></button>
  <button data-ch="3"><i></i><span class="tip">04 — TEST</span><span class="sr-only">Chapter 4, Test</span></button>
  <button data-ch="4"><i></i><span class="tip">05 — LEAD</span><span class="sr-only">Chapter 5, Lead</span></button>
  <button data-ch="5"><i></i><span class="tip">06 — DA7EM</span><span class="sr-only">Chapter 6, Da7em</span></button>
</nav>

<div id="hint" aria-hidden="true">move to disturb it · click to feed it · scroll to grow it</div>

<main id="main">

  <section class="chapter" id="signal" data-ch="0" data-side="center" aria-labelledby="h-0">
    <div class="panel">
      <p class="kicker"><b>01</b> — <span>SIGNAL</span></p>
      <h2 id="h-0">Management and technology expertise across products, operations and AI.</h2>
      <dl class="readouts">
        <div><dt>Cells</dt><dd id="ro-cells">—</dd></div>
        <div><dt>State</dt><dd id="ro-state">dormant</dd></div>
        <div><dt>Signal</dt><dd id="ro-signal">100%</dd></div>
      </dl>
    </div>
  </section>

  <section class="chapter" data-ch="1" data-side="right" aria-labelledby="h-1">
    <div class="panel">
      <p class="kicker"><b>02</b> — <span>SERVICES</span></p>
      <h2 id="h-1">Advisory, evaluation, testing and product work.</h2>
      <dl class="readouts">
        <div><dt>Attention</dt><dd id="ro-attention">—</dd></div>
        <div><dt>Listening</dt><dd id="ro-tracking">active</dd></div>
      </dl>
    </div>
  </section>

  <section class="chapter" data-ch="2" data-side="left" aria-labelledby="h-2">
    <div class="panel">
      <p class="kicker"><b>03</b> — <span>EVALUATE</span></p>
      <h2 id="h-2">Evaluation of AI projects and models and failure analysis.</h2>
      <dl class="readouts">
        <div><dt>Turbulence</dt><dd id="ro-turb">—</dd></div>
        <div><dt>Weather</dt><dd id="ro-weather">calm</dd></div>
      </dl>
    </div>
  </section>

  <section class="chapter" data-ch="3" data-side="right" aria-labelledby="h-3">
    <div class="panel">
      <p class="kicker"><b>04</b> — <span>TEST</span></p>
      <h2 id="h-3">I test products, tools and new technology, publicly or privately.</h2>
      <dl class="readouts">
        <div><dt>Pulse</dt><dd id="ro-bpm">56 bpm</dd></div>
        <div><dt>Answer</dt><dd id="ro-answer">waiting</dd></div>
      </dl>
    </div>
  </section>

  <section class="chapter" data-ch="4" data-side="left" aria-labelledby="h-4">
    <div class="panel">
      <p class="kicker"><b>05</b> — <span>LEAD</span></p>
      <h2 id="h-4">Experience across management, technology, product and creative work.</h2>
      <dl class="readouts">
        <div><dt>Memory</dt><dd id="ro-memory">0 pts</dd></div>
        <div><dt>Replay</dt><dd id="ro-replay">recording</dd></div>
      </dl>
    </div>
  </section>

  <section class="chapter" data-ch="5" data-side="center" aria-labelledby="h-5">
    <div class="panel">
      <p class="kicker"><b>06</b> — <span>DA7EM</span></p>
      <h2 id="h-5">Find me here.</h2>
      <p class="links">
        <a href="mailto:da7em@da7tech.com">da7em@da7tech.com</a><br>
        <a href="https://x.com/Da7_Tech" target="_blank" rel="noopener noreferrer">x.com/Da7_Tech</a><br>
        <a href="https://github.com/Da7-Tech" target="_blank" rel="noopener noreferrer">github.com/Da7-Tech</a>
      </p>
      <dl class="readouts">
        <div><dt>Presence</dt><dd id="ro-lumen">0%</dd></div>
      </dl>
      <p class="license">Open · <a href="https://creativecommons.org/licenses/by/4.0/" target="_blank" rel="noopener noreferrer">CC&nbsp;BY&nbsp;4.0</a> — use, adapt, even commercially · credit Da7_Tech</p>
    </div>
  </section>

</main>

<div id="veil">
  <div>
    <p class="v-kicker">da7tech.com</p>
    <h1>Da7em</h1>
    <p class="v-sub">a living digital practice</p>
    <p class="v-wake">click anywhere to wake it</p>
    <p class="v-note">sound on recommended · up to 26,000 particles · one file</p>
  </div>
</div>

<noscript>
  <div style="position:fixed;inset:0;background:#05070c;color:#e8f1ff;display:grid;place-items:center;z-index:99;text-align:center;padding:24px;">
    <p style="font-family:monospace;font-size:12px;letter-spacing:.2em;line-height:2.2">DA7EM IS ALIVE IN LIGHT —<br>but it needs JavaScript to breathe.<br><br>It began as a signal. It advised. It evaluated.<br>It tested. It led. It became the name.</p>
  </div>
</noscript>
<div class="webgl-fail" role="alert">
  <p>This practice needs WebGL2 to live.<br>Your browser said no — but the words survive:<br><br>
  It began as a signal. It advised. It evaluated.<br>It tested. It led. It became the name.</p>
</div>

<script>
'use strict';
/* ============================================================
   DA7EM — a living digital practice (engine: LUMEN)
   One file. Zero dependencies. Everything below is hand-rolled:
   WebGL2 GPGPU particles (transform feedback), FBM "flesh",
   trail accumulation, bloom, filmic composite, Web Audio synth,
   scroll-driven morphogenesis, idle dreaming, memory replay.
   Content: da7tech.com — advisory · AI evaluation · testing.
   ============================================================ */

history.scrollRestoration = 'manual';
window.scrollTo(0, 0);

const $ = (s) => document.querySelector(s);
const clamp = (v, a, b) => v < a ? a : v > b ? b : v;
const lerp = (a, b, t) => a + (b - a) * t;
const smooth = (t) => t * t * (3 - 2 * t);
const expDamp = (cur, target, rate, dt) => cur + (target - cur) * (1 - Math.exp(-rate * dt));

/* deterministic RNG for stable formations */
function mulberry32(a){ return function(){ a |= 0; a = a + 0x6D2B79F5 | 0; let t = Math.imul(a ^ a >>> 15, 1 | a); t = t + Math.imul(t ^ t >>> 7, 61 | t) ^ t; return ((t ^ t >>> 14) >>> 0) / 4294967296; }; }

/* ============================ chapters ============================ */
const CH = [
  { name:'SIGNAL',   bg:[0.012,0.020,0.040], fleshA:[0.06,0.24,0.34], fleshB:[0.015,0.09,0.17],
    colA:[0.16,0.85,1.0], colB:[0.80,0.98,1.0], glow:[0.42,0.90,1.0],
    spring:6.0, turb:0.16, push:3.0, swirl:1.0, r:0.30, bloom:1.0, vein:0.35, pulse:0.15, drone:0.50, pad:0.30,
    chord:[220.0,277.18,329.63], root:110.0, state:'dormant',
    hint:'move to disturb it · click to feed it · scroll to grow it' },
  { name:'SERVICES', bg:[0.030,0.020,0.062], fleshA:[0.17,0.10,0.34], fleshB:[0.05,0.03,0.13],
    colA:[0.66,0.55,1.0], colB:[1.0,0.45,0.80], glow:[0.76,0.62,1.0],
    spring:6.4, turb:0.20, push:2.2, swirl:2.6, r:0.26, bloom:1.05, vein:0.45, pulse:0.15, drone:0.42, pad:0.36,
    chord:[246.94,311.13,369.99], root:123.47, state:'advising',
    hint:'move slowly — let it follow your hand' },
  { name:'EVALUATE', bg:[0.010,0.046,0.030], fleshA:[0.06,0.32,0.19], fleshB:[0.02,0.13,0.09],
    colA:[0.30,0.95,0.55], colB:[0.60,1.0,0.86], glow:[0.50,1.0,0.72],
    spring:5.2, turb:0.42, push:1.4, swirl:1.8, r:0.34, bloom:1.1, vein:0.62, pulse:0.12, drone:0.46, pad:0.40,
    chord:[174.61,220.0,261.63], root:87.31, state:'evaluating',
    hint:'scroll fast — whip it into a storm' },
  { name:'TEST',     bg:[0.052,0.014,0.030], fleshA:[0.34,0.07,0.13], fleshB:[0.14,0.03,0.06],
    colA:[1.0,0.26,0.36], colB:[1.0,0.73,0.36], glow:[1.0,0.46,0.50],
    spring:8.8, turb:0.30, push:4.5, swirl:1.2, r:0.22, bloom:1.25, vein:0.50, pulse:1.0, drone:0.55, pad:0.34,
    chord:[146.83,185.0,220.0], root:73.42, state:'testing',
    hint:'click — answer its heartbeat' },
  { name:'LEAD',     bg:[0.010,0.040,0.046], fleshA:[0.05,0.27,0.29], fleshB:[0.02,0.11,0.14],
    colA:[0.25,0.85,0.80], colB:[0.72,0.96,1.0], glow:[0.60,0.95,0.95],
    spring:5.6, turb:0.18, push:1.8, swirl:2.2, r:0.30, bloom:0.95, vein:0.40, pulse:0.15, drone:0.44, pad:0.30,
    chord:[164.81,207.65,246.94], root:82.41, state:'retracing',
    hint:'stop moving — let it retrace your path' },
  { name:'DA7EM',    bg:[0.052,0.042,0.018], fleshA:[0.32,0.25,0.10], fleshB:[0.12,0.09,0.04],
    colA:[1.0,0.82,0.36], colB:[1.0,0.98,0.92], glow:[1.0,0.90,0.60],
    spring:10.0, turb:0.10, push:5.0, swirl:2.8, r:0.36, bloom:0.95, vein:0.25, pulse:0.2, drone:0.6, pad:0.42,
    chord:[220.0,277.18,329.63,440.0], root:110.0, state:'transcending',
    hint:'click — become the name' },
];
const NC = CH.length;

/* ============================ GL bootstrap ============================ */
const canvas = $('#gl');
const gl = canvas.getContext('webgl2', {
  alpha:false, antialias:false, depth:false, stencil:false,
  powerPreference:'high-performance', preserveDrawingBuffer:false,
});
if (!gl){ document.body.classList.add('no-webgl'); throw new Error('WebGL2 unavailable'); }

const extCBF = gl.getExtension('EXT_color_buffer_float');
const hdrCapable = !!extCBF;
let HDR = hdrCapable; // tier 0 drops to RGBA8 — half-float linear blending is the priciest thing on mobile GPUs

function compile(type, src){
  const s = gl.createShader(type);
  gl.shaderSource(s, src.trim());
  gl.compileShader(s);
  if (!gl.getShaderParameter(s, gl.COMPILE_STATUS)){
    console.error(gl.getShaderInfoLog(s), src.trim().split('\n').map((l,i)=>`${i+1}: ${l}`).join('\n'));
    throw new Error('shader compile failed');
  }
  return s;
}
function program(vs, fs, tfVaryings){
  const p = gl.createProgram();
  gl.attachShader(p, compile(gl.VERTEX_SHADER, vs));
  gl.attachShader(p, compile(gl.FRAGMENT_SHADER, fs));
  if (tfVaryings) gl.transformFeedbackVaryings(p, tfVaryings, gl.SEPARATE_ATTRIBS);
  gl.linkProgram(p);
  if (!gl.getProgramParameter(p, gl.LINK_STATUS)){
    console.error(gl.getProgramInfoLog(p)); throw new Error('program link failed');
  }
  const u = {};
  const n = gl.getProgramParameter(p, gl.ACTIVE_UNIFORMS);
  for (let i=0;i<n;i++){ const info = gl.getActiveUniform(p, i); u[info.name.replace('[0]','')] = gl.getUniformLocation(p, info.name); }
  return { p, u };
}
function makeFBO(w, h, filter){
  const tex = gl.createTexture();
  gl.bindTexture(gl.TEXTURE_2D, tex);
  gl.texImage2D(gl.TEXTURE_2D, 0, HDR ? gl.RGBA16F : gl.RGBA8, w, h, 0, gl.RGBA, HDR ? gl.HALF_FLOAT : gl.UNSIGNED_BYTE, null);
  gl.texParameteri(gl.TEXTURE_2D, gl.TEXTURE_MIN_FILTER, filter);
  gl.texParameteri(gl.TEXTURE_2D, gl.TEXTURE_MAG_FILTER, filter);
  gl.texParameteri(gl.TEXTURE_2D, gl.TEXTURE_WRAP_S, gl.CLAMP_TO_EDGE);
  gl.texParameteri(gl.TEXTURE_2D, gl.TEXTURE_WRAP_T, gl.CLAMP_TO_EDGE);
  const fb = gl.createFramebuffer();
  gl.bindFramebuffer(gl.FRAMEBUFFER, fb);
  gl.framebufferTexture2D(gl.FRAMEBUFFER, gl.COLOR_ATTACHMENT0, gl.TEXTURE_2D, tex, 0);
  gl.bindFramebuffer(gl.FRAMEBUFFER, null);
  return { tex, fb, w, h };
}

/* ============================ shaders ============================ */
const NOISE = `
float hash21(vec2 p){ return fract(sin(dot(p, vec2(127.1,311.7))) * 43758.5453123); }
float vnoise(vec2 p){
  vec2 i = floor(p), f = fract(p);
  vec2 u = f*f*(3.0-2.0*f);
  float a = hash21(i), b = hash21(i+vec2(1.0,0.0)), c = hash21(i+vec2(0.0,1.0)), d = hash21(i+vec2(1.0,1.0));
  return mix(mix(a,b,u.x), mix(c,d,u.x), u.y);
}
float fbm(vec2 p){
  float v = 0.0, a = 0.5;
  mat2 R = mat2(0.8,-0.6,0.6,0.8);
  for(int i=0;i<4;i++){ v += a * vnoise(p); p = R * p * 2.03 + vec2(11.7, 7.3); a *= 0.5; }
  return v;
}`;

/* --- simulation (transform feedback) --- */
const SIM_VS = `#version 300 es
precision highp float;
layout(location=0) in vec2 a_pos;
layout(location=1) in vec2 a_vel;
layout(location=2) in float a_seed;
layout(location=3) in vec2 a_homeA;
layout(location=4) in vec2 a_homeB;

uniform float u_dt, u_time, u_morph, u_spring, u_turb, u_push, u_swirl, u_cursorR, u_shock, u_homeScale, u_ghostW;
uniform vec2 u_cursor, u_shockPos, u_homeShift, u_ghost;

out vec2 v_pos;
out vec2 v_vel;

${NOISE}

vec2 curl2(vec2 p, float t){
  float e = 0.35;
  float s = 0.9;
  vec2 dr = vec2(t*0.11, t*0.07);
  float t1 = vnoise(p*s + dr + vec2(0.0, e));
  float t2 = vnoise(p*s + dr - vec2(0.0, e));
  float t3 = vnoise(p*s + dr + vec2(e, 0.0));
  float t4 = vnoise(p*s + dr - vec2(e, 0.0));
  return vec2(t1 - t2, -(t3 - t4)) / (2.0*e);
}

void main(){
  float amb = step(0.9, a_seed);
  // staggered morph — particles ripple into new form
  float m = clamp(u_morph * 1.55 - fract(a_seed*7.31) * 0.55, 0.0, 1.0);
  m = m*m*(3.0-2.0*m);
  vec2 home = mix(a_homeA, a_homeB, m) * u_homeScale + u_homeShift; // ambient homes are already wide

  vec2 f = vec2(0.0);
  f += (home - a_pos) * u_spring * mix(1.0, 0.22, amb);

  // organic wander via curl of evolving noise field — must stay WELL below
  // spring force at rest, else the formation smears into fog
  vec2 flow = curl2(a_pos + a_seed*13.7, u_time + a_seed*4.0);
  f += flow * u_turb * mix(1.0, 2.6, amb) * (0.55 + 0.9*fract(a_seed*3.7)) * 2.4;

  // cursor: liquid repulsion + swirl
  vec2 d = a_pos - u_cursor;
  float r = length(d) + 1e-5;
  float R = u_cursorR;
  if (r < R){
    float k = 1.0 - r/R;
    f += (d/r) * k*k * u_push * 26.0;
    f += vec2(-d.y, d.x)/r * k * u_swirl * 9.0;
  }

  // memory ghost attraction
  if (u_ghostW > 0.001){
    vec2 g = u_ghost - a_pos;
    float rg = length(g) + 1e-5;
    f += (g/rg) * u_ghostW * 34.0 * exp(-rg*3.4);
  }

  // click shockwave
  vec2 sd = a_pos - u_shockPos;
  float sr = length(sd) + 1e-5;
  f += (sd/sr) * u_shock * 200.0 * exp(-sr*4.2);

  vec2 vel = a_vel + f * u_dt;
  vel *= pow(0.885, u_dt * 60.0);                       // damping
  float sp = length(vel);
  if (sp > 3.4) vel = vel / sp * 3.4;                    // speed clamp
  // tiny ambient jitter keeps the body shimmering even at rest
  vel += curl2(a_pos*0.7 - u_time*0.3, u_time*1.7) * 0.012 * (1.0 - amb*0.5);

  v_pos = a_pos + vel * u_dt;
  v_vel = vel;
  gl_PointSize = 1.0;
  gl_Position = vec4(0.0, 0.0, 0.0, 1.0);
}`;

const DUMMY_FS = `#version 300 es
precision mediump float;
out vec4 o;
void main(){ o = vec4(0.0); }`;

/* --- particle rendering into trail buffer --- */
const PTS_VS = `#version 300 es
precision highp float;
layout(location=0) in vec2 a_pos;
layout(location=1) in vec2 a_vel;
layout(location=2) in float a_seed;

uniform float u_aspect, u_beat, u_px, u_dim;
uniform vec3 u_colA, u_colB;
out vec3 v_col;
out float v_a;

void main(){
  float amb = step(0.9, a_seed);
  float sp = clamp(length(a_vel) * 1.6 + fract(a_seed*5.13)*0.18, 0.0, 1.0);
  v_col = mix(u_colA, u_colB, clamp(sp * 1.5, 0.0, 1.0));
  // the resting body glows brightest — structure IS the light;
  // motion adds heat (colour shift + size), not just brightness.
  // radial falloff keeps the heart (the word) dominant over the rim
  float radial = 1.0 - 0.42 * smoothstep(0.52, 1.05, length(a_pos));
  v_col *= (1.05 + 0.45*sp + 0.5*u_beat) * mix(1.0, 0.16, amb) * radial * u_dim;
  v_a = mix(1.0, 0.85, sp) * mix(1.0, 0.4, amb);
  gl_Position = vec4(a_pos.x / u_aspect, a_pos.y, 0.0, 1.0);
  gl_PointSize = mix(2.2, 3.4, sp) * mix(1.0, 0.5, amb) * u_px;
}`;

const PTS_FS = `#version 300 es
precision mediump float;
in vec3 v_col;
in float v_a;
out vec4 o;
void main(){
  vec2 q = gl_PointCoord - 0.5;
  float d = length(q);
  float fall = smoothstep(0.5, 0.06, d);
  float core = smoothstep(0.16, 0.0, d) * 0.85;
  o = vec4(v_col * (fall + core), fall * v_a);
}`;

/* --- flat quad (fade pass) --- */
const FLAT_VS = `#version 300 es
precision mediump float;
out vec2 v_uv;
void main(){
  vec2 p = vec2(gl_VertexID == 1 ? 3.0 : -1.0, gl_VertexID == 2 ? 3.0 : -1.0);
  v_uv = p * 0.5 + 0.5;
  gl_Position = vec4(p, 0.0, 1.0);
}`;
const FLAT_FS = `#version 300 es
precision mediump float;
uniform vec4 u_color;
out vec4 o;
void main(){ o = u_color; }`;

/* --- the flesh: domain-warped fbm organism skin --- */
const FLESH_FS = `#version 300 es
precision highp float;
in vec2 v_uv;
uniform float u_time, u_aspect, u_cursorGlow, u_vein, u_beatEnv, u_beatT, u_pulse, u_flash, u_quality;
uniform vec2 u_cursor;
uniform vec3 u_bg, u_tintA, u_tintB, u_glow;
out vec4 o;

${NOISE}

void main(){
  vec2 p = (v_uv * 2.0 - 1.0) * vec2(u_aspect, 1.0);
  float t = u_time * 0.05;
  vec2 q = vec2(fbm(p*1.1 + t), fbm(p*1.1 + vec2(5.2,1.3) - t));
  vec2 r = vec2(fbm(p*1.7 + 2.2*q + vec2(1.7,9.2) + t*0.6), fbm(p*1.7 + 2.2*q + vec2(8.3,2.8) - t*0.4));
  float v = fbm(p*1.9 + 2.4*r);
  float depth = clamp(length(r)*0.75, 0.0, 1.0);

  vec3 col = u_bg * 1.1;
  col += u_tintB * v * v * 0.65;
  col += u_tintA * pow(v, 3.0) * 0.85;

  // capillary veins — ridged noise filaments
  float vein = abs(fbm(r*3.4 + q*1.2 - t*1.4) - 0.5);
  col += u_tintA * smoothstep(0.055, 0.0, vein) * u_vein * (0.35 + 0.4*v);

  // it leans toward your light
  float d = distance(p, u_cursor);
  col += u_glow * exp(-d*d*7.0) * u_cursorGlow * 0.34;
  col += u_glow * exp(-d*30.0) * u_cursorGlow * 0.10;

  // heartbeat ripples
  if (u_pulse > 0.01){
    float ring = sin(d*16.0 - u_beatT*7.5) * exp(-d*1.9) * exp(-u_beatT*1.1);
    col += u_glow * max(ring, 0.0) * u_pulse * u_beatEnv * 0.9;
  }

  col *= 1.0 + u_flash * 1.6;
  o = vec4(col * (u_quality > 0.5 ? 1.0 : 0.92), 1.0);
}`;

/* --- bloom: bright pass + separable blur --- */
const BRIGHT_FS = `#version 300 es
precision mediump float;
in vec2 v_uv;
uniform sampler2D u_tex;
uniform float u_threshold;
out vec4 o;
void main(){
  vec3 c = texture(u_tex, v_uv).rgb;
  float l = dot(c, vec3(0.2126, 0.7152, 0.0722));
  float k = max(l - u_threshold, 0.0) / max(l, 1e-4);
  o = vec4(c * k, 1.0);
}`;
const BLUR_FS = `#version 300 es
precision mediump float;
in vec2 v_uv;
uniform sampler2D u_tex;
uniform vec2 u_dir;
out vec4 o;
void main(){
  float w[5];
  w[0]=0.227027; w[1]=0.1945946; w[2]=0.1216216; w[3]=0.054054; w[4]=0.016216;
  vec3 c = texture(u_tex, v_uv).rgb * w[0];
  for(int i=1;i<5;i++){
    c += texture(u_tex, v_uv + u_dir * float(i)).rgb * w[i];
    c += texture(u_tex, v_uv - u_dir * float(i)).rgb * w[i];
  }
  o = vec4(c, 1.0);
}`;

/* --- final composite: flesh + trails + bloom + cursor orb + lens + grain --- */
const FINAL_FS = `#version 300 es
precision highp float;
in vec2 v_uv;
uniform sampler2D u_flesh, u_trail, u_bloom;
uniform float u_time, u_aspect, u_beatEnv, u_bloomAmt, u_flash, u_lens, u_orbVis, u_ghostVis, u_wake, u_fleshAmt, u_cheap;
uniform vec2 u_cursor, u_ghost;
uniform vec3 u_glow, u_bg;
out vec4 o;

vec3 aces(vec3 x){
  return clamp((x*(2.51*x + 0.03)) / (x*(2.43*x + 0.59) + 0.14), 0.0, 1.0);
}
float hash(vec2 p){ return fract(sin(dot(p, vec2(12.9898,78.233))) * 43758.5453); }

void main(){
  vec2 world = (v_uv * 2.0 - 1.0) * vec2(u_aspect, 1.0);
  vec2 d = world - u_cursor;
  float r = length(d);

  // cursor lens — light bends around the attention point
  float lens = exp(-r*r*90.0) * u_lens;
  vec2 suv = v_uv - (d / max(length(vec2(u_aspect,1.0))*0.5, 1e-3)) * lens * -0.016;

  float ca = (0.0016 + u_beatEnv * 0.002) * (1.0 - u_cheap); // chromatic aberration breathes with pulse; cheap mode: single tap
  vec2 caDir = d * ca;
  vec3 trail;
  if (u_cheap > 0.5){ trail = texture(u_trail, suv).rgb; }
  else {
    trail.r = texture(u_trail, suv + caDir).r;
    trail.g = texture(u_trail, suv).g;
    trail.b = texture(u_trail, suv - caDir).b;
  }

  vec3 flesh = texture(u_flesh, suv).rgb;
  vec3 bloom = texture(u_bloom, suv).rgb;

  vec3 col = mix(u_bg, flesh, u_fleshAmt) + trail * (1.0 + u_beatEnv*0.55 + u_flash*1.8) + bloom * u_bloomAmt;

  // the cursor organism — core + halo + pulse ring
  if (u_orbVis > 0.001){
    float core = exp(-r*r*2600.0) * 1.5;
    float halo = exp(-r*14.0) * 0.16;
    float ringR = 0.055 + u_beatEnv * 0.05;
    float ring = exp(-abs(r - ringR)*90.0) * (0.25 + u_beatEnv*0.9);
    col += u_glow * (core + halo + ring) * u_orbVis;
  }

  // memory ghost — faint double of your attention
  if (u_ghostVis > 0.001){
    vec2 gd = world - u_ghost;
    float gr = length(gd);
    col += u_glow * (exp(-gr*gr*1400.0)*0.9 + exp(-gr*20.0)*0.08) * u_ghostVis;
  }

  // vignette + grain + faint filmic lift
  float vig = 1.0 - 0.42 * smoothstep(0.5, 1.3, length(world) / max(u_aspect, 1.0) * 1.9);
  col *= vig;
  col += (hash(v_uv * (mod(u_time, 100.0)*913.0) ) - 0.5) * 0.030 * (1.0 - u_cheap); // mod: no once-per-second frozen frame; cheap mode: no grain
  col *= mix(0.35, 1.0, u_wake); // asleep behind the veil

  col = aces(col * 1.06);
  col = pow(col, vec3(0.94));
  o = vec4(col, 1.0);
}`;

/* ============================ GL programs ============================ */
const pSim = program(SIM_VS, DUMMY_FS, ['v_pos', 'v_vel']);
const pPts = program(PTS_VS, PTS_FS);
const pFlat = program(FLAT_VS, FLAT_FS);
const pFlesh = program(FLAT_VS, FLESH_FS);
const pBright = program(FLAT_VS, BRIGHT_FS);
const pBlur = program(FLAT_VS, BLUR_FS);
const pFinal = program(FLAT_VS, FINAL_FS);

/* ============================ particles ============================ */
const MAXP = 26000;
const AMB_FRAC = 0.11; // fraction of particles that live as ambient stardust
// nBody (body/halo split) is declared after the quality tier — it follows the LIVE tier,
// so a phone drawing 9,000 points gets a complete 8,010-point word, not a truncated 26,000-point one
const QUALITY = [
  { count:  9000, dpr: 0.60, flesh: 0.24, bloomIter: 1 },
  { count: 16000, dpr: 0.85, flesh: 0.50, bloomIter: 1 },
  { count: 26000, dpr: 1.00, flesh: 0.50, bloomIter: 2 },
];
const urlParams = new URLSearchParams(location.search);
const urlQ = urlParams.get('q');
const freezeQ = urlParams.has('freeze');
let quality = urlQ !== null ? clamp(parseInt(urlQ,10)||0, 0, 2) : (matchMedia('(pointer:coarse)').matches ? 0 : (devicePixelRatio > 1.6 ? 1 : 2));
const startQuality = quality;
let nBody = Math.floor(QUALITY[quality].count * (1 - AMB_FRAC)); // body indices [0, nBody), halo [nBody, count)

const posA = gl.createBuffer(), posB = gl.createBuffer();
const velA = gl.createBuffer(), velB = gl.createBuffer();
const seedBuf = gl.createBuffer();
const homeBufs = []; for (let i=0;i<NC;i++) homeBufs.push(gl.createBuffer());

const seeds = new Float32Array(MAXP);
function fillSeeds(){
  const rng = mulberry32(777);
  for (let i=0;i<MAXP;i++){
    const amb = i >= nBody; // halo indices ARE the ambient set — physics and homes agree exactly
    seeds[i] = amb ? 0.9 + rng()*0.099 : rng()*0.9;
  }
}
fillSeeds();
function seedPos(i, aspect){ // initial scatter across the void
  const rng = mulberry32(1000 + i);
  return [ (rng()*2-1) * aspect, rng()*2-1 ];
}
function seedVel(i){
  const rng = mulberry32(5000 + i);
  return [ (rng()*2-1)*0.02, (rng()*2-1)*0.02 ];
}

const vaoA = gl.createVertexArray(), vaoB = gl.createVertexArray();
const tfA = gl.createTransformFeedback(), tfB = gl.createTransformFeedback();

function attribs(vao, pos, vel){
  gl.bindVertexArray(vao);
  gl.bindBuffer(gl.ARRAY_BUFFER, pos);
  gl.enableVertexAttribArray(0); gl.vertexAttribPointer(0, 2, gl.FLOAT, false, 0, 0);
  gl.bindBuffer(gl.ARRAY_BUFFER, vel);
  gl.enableVertexAttribArray(1); gl.vertexAttribPointer(1, 2, gl.FLOAT, false, 0, 0);
  gl.bindBuffer(gl.ARRAY_BUFFER, seedBuf);
  gl.enableVertexAttribArray(2); gl.vertexAttribPointer(2, 1, gl.FLOAT, false, 0, 0);
  // homes are re-bound per chapter by setHomeAttribs; start on chapters 0 and 1
  gl.bindBuffer(gl.ARRAY_BUFFER, homeBufs[0]);
  gl.enableVertexAttribArray(3); gl.vertexAttribPointer(3, 2, gl.FLOAT, false, 0, 0);
  gl.bindBuffer(gl.ARRAY_BUFFER, homeBufs[Math.min(1, NC-1)]);
  gl.enableVertexAttribArray(4); gl.vertexAttribPointer(4, 2, gl.FLOAT, false, 0, 0);
  gl.bindVertexArray(null);
  gl.bindBuffer(gl.ARRAY_BUFFER, null);
}
attribs(vaoA, posA, velA);
attribs(vaoB, posB, velB);

function attachTF(tf, pos, vel){
  gl.bindTransformFeedback(gl.TRANSFORM_FEEDBACK, tf);
  gl.bindBufferBase(gl.TRANSFORM_FEEDBACK_BUFFER, 0, pos);
  gl.bindBufferBase(gl.TRANSFORM_FEEDBACK_BUFFER, 1, vel);
  gl.bindTransformFeedback(gl.TRANSFORM_FEEDBACK, null);
}
attachTF(tfA, posB, velB); // drawing from A writes into B
attachTF(tfB, posA, velA);

/* ============================ formations ============================ */
let aspect = 1.78;
const formationData = []; // Float32Array per chapter

function padFormation(pts, targetN, rng, jitter){
  // fill exactly targetN points, cycling with jitter when source is smaller
  const out = new Float32Array(targetN * 2);
  const n = pts.length / 2;
  for (let i=0;i<targetN;i++){
    const j = i % n;
    out[i*2]   = pts[j*2]   + (rng()*2-1) * jitter;
    out[i*2+1] = pts[j*2+1] + (rng()*2-1) * jitter;
  }
  return out;
}
function ambientHomes(targetN, rng, aspect){
  const pts = [];
  for (let i=0;i<Math.ceil(targetN*1.1);i++){
    const a = rng() * Math.PI * 2;
    const r = 0.92 + rng() * 0.42;
    pts.push(Math.cos(a) * r * aspect * 0.62, Math.sin(a) * r * 0.78);
  }
  return pts;
}

function safeCanvasFont(ctx, weight, px){
  // Canvas2D rejects the WHOLE font declaration if any family is unknown
  // (e.g. ui-sans-serif) — silently falling back to 10px. Try safe stacks
  // and verify the assignment actually took.
  const stacks = [
    `${weight} ${px}px "Helvetica Neue", Helvetica, Arial, sans-serif`,
    `${weight} ${px}px Helvetica, Arial, sans-serif`,
    `bold ${px}px Arial, sans-serif`,
    `bold ${px}px sans-serif`,
  ];
  for (const f of stacks){
    ctx.font = f;
    if (ctx.font.startsWith(`${weight}`) || ctx.font.includes(`${px}px`)) return true;
  }
  return false;
}
function sampleText(str, weight, targetN, spanX, yCenter){
  const W = 1600, H = 800;
  const cv = document.createElement('canvas');
  cv.width = W; cv.height = H;
  const ctx = cv.getContext('2d', { willReadFrequently:true });
  let px = 300;
  safeCanvasFont(ctx, weight, px);
  let w = Math.max(1, ctx.measureText(str).width);
  px = Math.min(520, Math.floor(px * (W * 0.9) / w));
  safeCanvasFont(ctx, weight, px);
  try { ctx.letterSpacing = (px * 0.15) + 'px'; } catch(e){}
  ctx.textAlign = 'center'; ctx.textBaseline = 'middle';
  // fill + heavy stroke: guarantees thick letterforms even if the
  // engine ignores weight 900
  ctx.fillStyle = '#fff';
  ctx.strokeStyle = '#fff';
  ctx.lineWidth = Math.max(2, px * 0.085);
  ctx.lineJoin = 'round';
  ctx.fillText(str, W/2, H/2 + yCenter * H);
  ctx.strokeText(str, W/2, H/2 + yCenter * H);
  const img = ctx.getImageData(0, 0, W, H).data;
  const cand = [];
  for (let y=0;y<H;y+=2) for (let x=0;x<W;x+=2){
    if (img[(y*W + x)*4 + 3] > 140) cand.push(x, y);
  }
  // map to world
  const sX = spanX / W;
  const pts = [];
  // exact-count uniform sampling — never truncates the glyph, never overflows targetN
  const m = cand.length / 2;
  const step = Math.max(1, m / targetN);
  const rng = mulberry32(4242);
  for (let k=0, f=0; k<targetN && f<m; k++, f+=step){
    const i = Math.floor(f);
    const jx = (rng()-0.5) * 1.8, jy = (rng()-0.5) * 1.8;
    pts.push((cand[i*2] - W/2 + jx) * sX, -(cand[i*2+1] - H/2 + jy) * sX);
  }
  return pts;
}

function genText(str, n, span){ return sampleText(str, 900, n, span, 0); }

function genIris(n){
  const pts = [];
  const rng = mulberry32(101);
  const push = (x,y) => pts.push(x,y);
  // sclera ring
  for (let i=0;i<n*0.26;i++){ const a = rng()*Math.PI*2; push(Math.cos(a)*0.60 + (rng()-0.5)*0.02, Math.sin(a)*0.60 + (rng()-0.5)*0.02); }
  // iris — dashed radial fibres
  for (let i=0;i<n*0.42;i++){
    const a = rng()*Math.PI*2;
    const r = 0.30 + rng()*0.10;
    push(Math.cos(a)*r + (rng()-0.5)*0.012, Math.sin(a)*r + (rng()-0.5)*0.012);
  }
  // limbal accent ring
  for (let i=0;i<n*0.06;i++){ const a = rng()*Math.PI*2; push(Math.cos(a)*0.42, Math.sin(a)*0.42); }
  // pupil
  for (let i=0;i<n*0.14;i++){ const a = rng()*Math.PI*2, r = Math.sqrt(rng())*0.10; push(Math.cos(a)*r, Math.sin(a)*r); }
  // ciliary lashes
  for (let k=0;k<9;k++){
    const a0 = (k/9)*Math.PI*2 + 0.3;
    for (let i=0;i<n*0.012;i++){
      const t = rng();
      const r = 0.63 + t*0.17;
      const a = a0 + (rng()-0.5)*0.14;
      push(Math.cos(a)*r, Math.sin(a)*r);
    }
  }
  return pts;
}

function genNeuron(n){
  const pts = [];
  const rng = mulberry32(202);
  // soma
  for (let i=0;i<n*0.06;i++){ const a = rng()*Math.PI*2, r = Math.sqrt(rng())*0.075; pts.push(Math.cos(a)*r, Math.sin(a)*r); }
  // dendrites — random-walk with branching, normalized to fit
  const stack = [];
  for (let k=0;k<8;k++){
    const a = (k/8)*Math.PI*2 + rng()*0.5;
    stack.push({ x:0, y:0, dx:Math.cos(a), dy:Math.sin(a), steps: 150, depth:0 });
  }
  let guard = 0;
  while (stack.length && guard++ < 6000){
    const b = stack.pop();
    for (let s=0;s<b.steps;s++){
      b.x += b.dx * 0.0095; b.y += b.dy * 0.0095;
      const rot = (rng()-0.5) * 0.34;
      const cos = Math.cos(rot), sin = Math.sin(rot);
      const ndx = b.dx*cos - b.dy*sin, ndy = b.dx*sin + b.dy*cos;
      b.dx = ndx; b.dy = ndy;
      pts.push(b.x + (rng()-0.5)*0.010, b.y + (rng()-0.5)*0.010);
      if (rng() < 0.055 && b.depth < 3){
        const rot2 = (rng() < 0.5 ? -1 : 1) * (0.5 + rng()*0.4);
        const c2 = Math.cos(rot2), s2 = Math.sin(rot2);
        stack.push({ x:b.x, y:b.y, dx: b.dx*c2 - b.dy*s2, dy: b.dx*s2 + b.dy*c2, steps: Math.floor(b.steps*0.55), depth: b.depth+1 });
      }
      if (Math.hypot(b.x, b.y) > 0.88) break;
    }
  }
  return pts;
}

function genRings(n){
  const pts = [];
  const rng = mulberry32(303);
  const radii = [0.15, 0.28, 0.41, 0.54, 0.67, 0.80];
  const weights = [1.4, 1.5, 1.6, 1.6, 1.5, 1.4];
  const total = weights.reduce((a,b)=>a+b,0);
  radii.forEach((R, i) => {
    const cnt = Math.floor(n * weights[i] / total);
    for (let k=0;k<cnt;k++){
      const a = rng()*Math.PI*2;
      const r = R + (rng()-0.5)*0.014;
      pts.push(Math.cos(a)*r, Math.sin(a)*r);
    }
  });
  return pts;
}

function genSpiral(n){
  const pts = [];
  const rng = mulberry32(404);
  // core
  for (let i=0;i<n*0.12;i++){ const a = rng()*Math.PI*2, r = Math.sqrt(rng())*0.11; pts.push(Math.cos(a)*r, Math.sin(a)*r); }
  // two arms
  const armN = Math.floor(n*0.44);
  for (let arm=0;arm<2;arm++){
    for (let i=0;i<armN;i++){
      const t = Math.pow(rng(), 0.72);
      const r = 0.10 + t*0.78;
      const a = arm*Math.PI + t*4.7 + (rng()-0.5)*(0.55 - t*0.3);
      pts.push(Math.cos(a)*r + (rng()-0.5)*0.02, Math.sin(a)*r + (rng()-0.5)*0.02);
    }
  }
  return pts;
}

function genBecome(n, aspect){
  const pts = [];
  const rng = mulberry32(505);
  // word at the heart — the light is the name; on low tiers the word takes a larger share so it reads clearly
  const wordN = Math.floor(n * (n < 15000 ? 0.82 : 0.76));
  const word = sampleText('DA7EM', 900, wordN, Math.min(2.9, aspect*1.62), 0);
  for (let i=0;i<word.length;i++) pts.push(word[i]);
  // radiance — rays kept OUT of the word band so letters own the centre
  const rayN = n - wordN - Math.floor(n*0.05);
  const rays = 26;
  for (let k=0;k<rays;k++){
    const a0 = (k/rays)*Math.PI*2 + 0.12;
    for (let i=0;i<Math.floor(rayN/rays);i++){
      const t = Math.pow(rng(), 0.6);
      const r = 0.50 + t*0.55;
      const a = a0 + (rng()-0.5)*(0.10 + (1-t)*0.22);
      pts.push(Math.cos(a)*r, Math.sin(a)*r);
    }
  }
  // halo
  for (let i=0;i<Math.floor(n*0.05);i++){ const a = rng()*Math.PI*2; pts.push(Math.cos(a)*0.98, Math.sin(a)*0.98); }
  return pts;
}

function buildFormations(){
  const count = QUALITY[quality].count;
  const n = nBody = Math.floor(count * (1 - AMB_FRAC));
  const gens = [
    () => genText('DA7EM', n, Math.min(2.7, aspect*1.62)),
    () => genIris(n),
    () => genNeuron(n),
    () => genRings(n),
    () => genSpiral(n),
    () => genBecome(n, aspect),
  ];
  const ambPts = new Float32Array(ambientHomes(count, mulberry32(909), aspect));
  for (let c=0;c<NC;c++){
    const rng = mulberry32(1000 + c*17);
    const body = padFormation(gens[c](), n, rng, 0.012);
    const full = new Float32Array(count*2);
    full.set(body, 0);
    full.set(ambPts.subarray(0, (count - n)*2), n*2);
    formationData[c] = full;
    gl.bindBuffer(gl.ARRAY_BUFFER, homeBufs[c]);
    gl.bufferData(gl.ARRAY_BUFFER, full, gl.STATIC_DRAW);
  }
  gl.bindBuffer(gl.ARRAY_BUFFER, null);
}
buildFormations();

/* ============================ FBOs ============================ */
let W = 2, H = 2, dpr = 1;
let trailFBO, fleshFBO, bloomA, bloomB;

function targetSize(){
  const q = QUALITY[quality];
  dpr = Math.min(devicePixelRatio || 1, 2) * q.dpr;
  return {
    w: Math.max(2, Math.round(innerWidth * dpr)),
    h: Math.max(2, Math.round(innerHeight * dpr)),
  };
}
function makeTargets(){
  HDR = hdrCapable && quality > 0;
  const t = targetSize();
  W = t.w; H = t.h;
  canvas.width = W; canvas.height = H;
  canvas.style.width = innerWidth + 'px'; canvas.style.height = innerHeight + 'px';
  if (trailFBO){ gl.deleteTexture(trailFBO.tex); gl.deleteFramebuffer(trailFBO.fb); }
  if (fleshFBO){ gl.deleteTexture(fleshFBO.tex); gl.deleteFramebuffer(fleshFBO.fb); }
  if (bloomA){ gl.deleteTexture(bloomA.tex); gl.deleteFramebuffer(bloomA.fb); }
  if (bloomB){ gl.deleteTexture(bloomB.tex); gl.deleteFramebuffer(bloomB.fb); }
  trailFBO = makeFBO(W, H, gl.LINEAR);
  const fs = QUALITY[quality].flesh;
  fleshFBO = makeFBO(Math.max(2, Math.round(W*fs)), Math.max(2, Math.round(H*fs)), gl.LINEAR);
  const bw = Math.max(2, Math.round(W*0.25)), bh = Math.max(2, Math.round(H*0.25));
  bloomA = makeFBO(bw, bh, gl.LINEAR);
  bloomB = makeFBO(bw, bh, gl.LINEAR);
  gl.bindFramebuffer(gl.FRAMEBUFFER, trailFBO.fb);
  gl.clearColor(0,0,0,0); gl.clear(gl.COLOR_BUFFER_BIT);
  gl.bindFramebuffer(gl.FRAMEBUFFER, null);
}
function applyQuality(){ // tier switch: resize targets AND rebuild the swarm at the new density
  makeTargets();
  buildFormations();
  fillSeeds();
  seedParticles();
  setHomeAttribs(state.ch, Math.min(state.ch + 1, NC - 1));
}
function seedParticles(){
  const a = aspect;
  const pos = new Float32Array(MAXP*2), vel = new Float32Array(MAXP*2);
  for (let i=0;i<MAXP;i++){
    const p = seedPos(i, a); const v = seedVel(i);
    pos[i*2] = p[0]; pos[i*2+1] = p[1];
    vel[i*2] = v[0]; vel[i*2+1] = v[1];
  }
  gl.bindBuffer(gl.ARRAY_BUFFER, posA); gl.bufferData(gl.ARRAY_BUFFER, pos, gl.DYNAMIC_COPY);
  gl.bindBuffer(gl.ARRAY_BUFFER, posB); gl.bufferData(gl.ARRAY_BUFFER, pos, gl.DYNAMIC_COPY);
  gl.bindBuffer(gl.ARRAY_BUFFER, velA); gl.bufferData(gl.ARRAY_BUFFER, vel, gl.DYNAMIC_COPY);
  gl.bindBuffer(gl.ARRAY_BUFFER, velB); gl.bufferData(gl.ARRAY_BUFFER, vel, gl.DYNAMIC_COPY);
  gl.bindBuffer(gl.ARRAY_BUFFER, seedBuf); gl.bufferData(gl.ARRAY_BUFFER, seeds, gl.STATIC_DRAW);
  gl.bindBuffer(gl.ARRAY_BUFFER, null);
}

/* ============================ audio engine ============================ */
const AudioEngine = {
  ctx:null, ok:false, enabled:false, master:null, padFilter:null, padGain:null,
  droneGain:null, noiseGain:null, noiseFilter:null, chimeBus:null,
  init(){
    if (this.ctx) return;
    const AC = window.AudioContext || window.webkitAudioContext;
    if (!AC) return;
    const ctx = this.ctx = new AC();
    const master = this.master = ctx.createGain(); master.gain.value = 0;
    const comp = ctx.createDynamicsCompressor();
    comp.threshold.value = -18; comp.ratio.value = 6; comp.knee.value = 18;
    master.connect(comp).connect(ctx.destination);

    // drone — two detuned sines, breathing
    const droneGain = this.droneGain = ctx.createGain(); droneGain.gain.value = 0.0;
    [0, 3.5].forEach((det,i) => {
      const o = ctx.createOscillator();
      o.type = 'sine'; o.frequency.value = 110 * (i ? 1.006 : 1) + det*0.01;
      o.connect(droneGain); o.start();
      this['drone'+i] = o;
    });
    droneGain.connect(master);

    // pad — detuned saws through a sweeping lowpass
    const padFilter = this.padFilter = ctx.createBiquadFilter();
    padFilter.type = 'lowpass'; padFilter.frequency.value = 160; padFilter.Q.value = 7;
    const padGain = this.padGain = ctx.createGain(); padGain.gain.value = 0;
    [-6, 0, 6.2].forEach(det => {
      const o = ctx.createOscillator();
      o.type = 'sawtooth'; o.frequency.value = 220; o.detune.value = det;
      o.connect(padFilter); o.start();
    });
    padFilter.connect(padGain).connect(master);

    // air — filtered noise, swells with turbulence
    const len = ctx.sampleRate * 2;
    const buf = ctx.createBuffer(1, len, ctx.sampleRate);
    const ch = buf.getChannelData(0);
    for (let i=0;i<len;i++) ch[i] = Math.random()*2-1;
    const noise = ctx.createBufferSource();
    noise.buffer = buf; noise.loop = true;
    const noiseFilter = this.noiseFilter = ctx.createBiquadFilter();
    noiseFilter.type = 'bandpass'; noiseFilter.frequency.value = 900; noiseFilter.Q.value = 0.8;
    const noiseGain = this.noiseGain = ctx.createGain(); noiseGain.gain.value = 0;
    noise.connect(noiseFilter).connect(noiseGain).connect(master);
    noise.start();

    // chime bus with feedback delay (poor man's reverb)
    const delay = ctx.createDelay(1.0); delay.delayTime.value = 0.38;
    const fb = ctx.createGain(); fb.gain.value = 0.34;
    const dampen = ctx.createBiquadFilter(); dampen.type = 'lowpass'; dampen.frequency.value = 2600;
    const bus = this.chimeBus = ctx.createGain(); bus.gain.value = 1;
    bus.connect(master); bus.connect(delay); delay.connect(dampen).connect(fb).connect(delay); fb.connect(master);

    this.ok = true;
  },
  setEnabled(on){
    if (!this.ctx) return;
    this.enabled = on;
    const t = this.ctx.currentTime;
    this.master.gain.cancelScheduledValues(t);
    this.master.gain.setTargetAtTime(on ? 0.55 : 0.0, t, 0.4);
    if (on && this.ctx.state === 'suspended') this.ctx.resume();
  },
  setChapter(chIdx, cross){
    if (!this.ok || !this.enabled) return;
    const t = this.ctx.currentTime;
    const ch = CH[chIdx], nx = CH[clamp(chIdx+1, 0, NC-1)];
    const mixv = (a, b) => a + (b - a) * cross;
    const set = (p, v) => { p.cancelScheduledValues(t); p.setTargetAtTime(v, t, 0.8); }; // 10 Hz caller — cancel or the timeline piles up
    set(this['drone0'].frequency, mixv(ch.root, nx.root));
    set(this['drone1'].frequency, mixv(ch.root, nx.root) * 1.006 + 0.035);
    set(this.droneGain.gain, mixv(ch.drone, nx.drone) * 0.16);
    set(this.padGain.gain, mixv(ch.pad, nx.pad) * 0.05);
    // pad cutoff is driven solely by update() — one writer, motion-reactive
  },
  update(speedN, turbN){
    if (!this.ok || !this.enabled) return;
    const t = this.ctx.currentTime;
    const set = (p, v, tc) => { p.cancelScheduledValues(t); p.setTargetAtTime(v, t, tc); };
    set(this.padFilter.frequency, 150 + speedN * 2400 + turbN * 900, 0.08);
    set(this.noiseFilter.frequency, 700 + turbN * 2100, 0.1);
    set(this.noiseGain.gain, 0.012 + turbN * 0.10, 0.12);
  },
  kick(strength){
    if (!this.ok || !this.enabled) return;
    const ctx = this.ctx, t = ctx.currentTime;
    const o = ctx.createOscillator(), g = ctx.createGain();
    o.type = 'sine';
    o.frequency.setValueAtTime(150, t);
    o.frequency.exponentialRampToValueAtTime(42, t + 0.16);
    g.gain.setValueAtTime(0.9 * strength, t);
    g.gain.exponentialRampToValueAtTime(0.001, t + 0.30);
    o.connect(g).connect(this.master);
    o.start(t); o.stop(t + 0.32);
  },
  chime(freq, when, vel){
    if (!this.ok || !this.enabled) return;
    const ctx = this.ctx, t = when || ctx.currentTime;
    [1, 2.01].forEach((h, i) => {
      const o = ctx.createOscillator(), g = ctx.createGain();
      o.type = i ? 'sine' : 'triangle';
      o.frequency.value = freq * h;
      g.gain.setValueAtTime(0.0001, t);
      g.gain.exponentialRampToValueAtTime(vel * (i ? 0.06 : 0.16), t + 0.02);
      g.gain.exponentialRampToValueAtTime(0.0001, t + 1.9);
      o.connect(g).connect(this.chimeBus);
      o.start(t); o.stop(t + 2.0);
    });
  },
  chord(chIdx, vel){
    if (!this.ok) return;
    const t = this.ctx.currentTime;
    CH[chIdx].chord.forEach((f, i) => this.chime(f, t + i * 0.06, vel));
  },
  tick(){
    if (!this.ok || !this.enabled) return;
    const ctx = this.ctx, t = ctx.currentTime;
    const o = ctx.createOscillator(), g = ctx.createGain();
    o.type = 'square'; o.frequency.value = 1900;
    g.gain.setValueAtTime(0.05, t);
    g.gain.exponentialRampToValueAtTime(0.0001, t + 0.03);
    o.connect(g).connect(this.master);
    o.start(t); o.stop(t + 0.04);
  },
  whoosh(){
    if (!this.ok || !this.enabled) return;
    const ctx = this.ctx, t = ctx.currentTime;
    const len = ctx.sampleRate * 1.4;
    const buf = ctx.createBuffer(1, len, ctx.sampleRate);
    const d = buf.getChannelData(0);
    for (let i=0;i<len;i++) d[i] = (Math.random()*2-1) * Math.pow(1 - i/len, 2);
    const src = ctx.createBufferSource(); src.buffer = buf;
    const bp = ctx.createBiquadFilter(); bp.type = 'bandpass'; bp.Q.value = 1.1;
    bp.frequency.setValueAtTime(180, t);
    bp.frequency.exponentialRampToValueAtTime(2600, t + 1.1);
    const g = ctx.createGain(); g.gain.setValueAtTime(0.5, t);
    g.gain.exponentialRampToValueAtTime(0.001, t + 1.4);
    src.connect(bp).connect(g).connect(this.master);
    src.start(t);
  },
  supernova(){
    if (!this.ok || !this.enabled) return;
    const ctx = this.ctx, t = ctx.currentTime;
    this.whoosh();
    [0,1,2,3].forEach(i => this.chime(CH[5].chord[i % CH[5].chord.length] * (i === 3 ? 2 : 1), t + 0.05 + i*0.1, 0.3));
    this.kick(1.0);
  },
};

/* ============================ state ============================ */
const reducedAtBirth = matchMedia('(prefers-reduced-motion: reduce)').matches;
const state = {
  awake:false, motionFull:!reducedAtBirth, soundOn:false,
  time:0, lastT:0,
  scroll:0, scrollSmooth:0, scrollVel:0,
  p6:0, ch:0, chF:0, seam:0,
  morph:0,
  cursor:{ x:0, y:0.1, tx:0, ty:0.1, vx:0, vy:0, speedN:0, lastMove:0, hasMoved:false },
  dream:false, dreamT:0,
  shock:0, shockPos:[0,0], flash:0,
  beatEnv:0, beatT:9, nextBeat:0, bpm:56,
  turbBoost:0,
  release:0, // ch5 transcendence
  mem:{ pts:[], idx:0, recording:false, replay:0 },
  ghost:[0,0], ghostW:0, ghostVis:0,
  homeShift:[0,0], homeScale:1,
  springRamp:0,
  frameMs:16, qualityEvents:[],
  clicks:0,
};
const RM = () => !state.motionFull; // reduced-motion shortcut

/* DOM refs */
const sections = Array.from(document.querySelectorAll('section.chapter'));
const panelEls = sections.map(s => s.querySelector('.panel'));
const dots = Array.from(document.querySelectorAll('.dots button'));
const hintEl = $('#hint');
const progressBar = $('#grain-progress');
const veil = $('#veil');
const btnSound = $('#btn-sound'), btnMotion = $('#btn-motion');
const soundLabel = $('#sound-label'), motionLabel = $('#motion-label');

const lastSec = sections[sections.length-1];
function measure(){ return lastSec.offsetTop; }
let lastOffsetTop = measure();

/* pointer → world */
function toWorld(cx, cy){
  return [ (cx / innerWidth * 2 - 1) * aspect, -(cy / innerHeight * 2 - 1) ];
}

const memPush = (x, y) => {
  const m = state.mem, last = m.pts[m.pts.length-1];
  if (!last || Math.hypot(x-last[0], y-last[1]) > 0.035){
    m.pts.push([x, y]);
    if (m.pts.length > 700) m.pts.shift();
  }
};

let pointerDown = false;
function onMove(cx, cy){
  const w = toWorld(cx, cy);
  state.cursor.tx = w[0]; state.cursor.ty = w[1];
  state.cursor.lastMove = state.time;
  state.dream = false;
  if (state.awake && !RM()) memPush(w[0], w[1]);
}
window.addEventListener('pointermove', (e) => onMove(e.clientX, e.clientY), { passive:true });
let downPos = null;
window.addEventListener('pointerdown', (e) => {
  pointerDown = true;
  downPos = [e.clientX, e.clientY];
  if (e.target instanceof Element && e.target.closest('header, .dots')) return; // chrome presses are not food for the swarm
  onMove(e.clientX, e.clientY);
  if (!state.awake) wake();
  // no feed here — on touch, every scroll begins with a pointerdown; only a released tap may feed
}, { passive:true });
window.addEventListener('pointerup', (e) => {
  pointerDown = false;
  if (downPos && state.awake && Math.hypot(e.clientX - downPos[0], e.clientY - downPos[1]) < 12
      && !(e.target instanceof Element && e.target.closest('header, .dots'))){
    feed(toWorld(e.clientX, e.clientY)); // a tap feeds; a scroll-drag never does
  }
  downPos = null;
}, { passive:true });
window.addEventListener('pointercancel', () => { pointerDown = false; downPos = null; }, { passive:true });

function feed(worldPos){
  state.clicks++;
  state.shockPos = worldPos;
  const ch = state.ch;
  if (ch === 5){
    if (RM()){ AudioEngine.chord(5, 0.15); } // calm mode: a chime, not an explosion
    else { state.shock = 2.6; state.flash = 1.0; state.release = 1; AudioEngine.supernova(); }
  } else {
    state.shock = 1.4; state.flash = Math.max(state.flash, 0.42);
    if (ch === 3){ AudioEngine.kick(0.85); state.beatEnv = 1; state.beatT = 0; $('#ro-answer').textContent = 'answered'; setTimeout(()=>{ $('#ro-answer').textContent = 'waiting'; }, 1800); }
    else { AudioEngine.tick(); AudioEngine.kick(0.25); }
  }
}

function wake(){
  if (state.awake) return;
  state.awake = true;
  state.shockPos = [0, 0];
  state.shock = 1.6;
  state.flash = 0.7;
  veil.style.backdropFilter = 'none'; // kill the fullscreen blur layer NOW — the opacity fade alone remains
  veil.style.webkitBackdropFilter = 'none';
  veil.classList.add('gone');
  const killVeil = () => { veil.style.display = 'none'; };
  veil.addEventListener('transitionend', killVeil, { once:true });
  setTimeout(killVeil, 1400); // fallback if transitionend is swallowed
  document.body.style.overflow = '';
  AudioEngine.init();
  if (AudioEngine.ok){
    AudioEngine.setEnabled(true);
    state.soundOn = true;
    btnSound.setAttribute('aria-pressed', 'true');
    soundLabel.innerHTML = 'SOUND&nbsp;ON';
    AudioEngine.whoosh();
    AudioEngine.chord(0, 0.22);
  }
}
document.body.style.overflow = 'hidden'; // locked until wake
window.addEventListener('keydown', (e) => {
  if (!state.awake){ wake(); return; }
  if (e.key === 'ArrowDown' || e.key === 'PageDown'){ e.preventDefault(); gotoChapter(Math.min(state.ch+1, NC-1)); }
  if (e.key === 'ArrowUp' || e.key === 'PageUp'){ e.preventDefault(); gotoChapter(Math.max(state.ch-1, 0)); }
});

function gotoChapter(i){
  const top = i === 0 ? 0 : sections[i].offsetTop;
  window.scrollTo({ top, behavior: RM() ? 'auto' : 'smooth' });
}
dots.forEach((b, i) => b.addEventListener('click', () => gotoChapter(i)));

btnSound.addEventListener('click', () => {
  AudioEngine.init();
  if (!AudioEngine.ok) return;
  const on = !state.soundOn;
  state.soundOn = on;
  AudioEngine.setEnabled(on);
  btnSound.setAttribute('aria-pressed', String(on));
  soundLabel.innerHTML = on ? 'SOUND&nbsp;ON' : 'SOUND&nbsp;OFF';
  if (on) AudioEngine.chord(state.ch, 0.18);
});
btnMotion.addEventListener('click', () => {
  const on = !state.motionFull;
  state.motionFull = on;
  btnMotion.setAttribute('aria-pressed', String(on));
  motionLabel.innerHTML = on ? 'MOTION&nbsp;FULL' : 'MOTION&nbsp;CALM';
  document.documentElement.classList.toggle('reduced', !on);
  document.documentElement.classList.toggle('motion-off', !on);
  // sound is independent of motion — it keeps playing in calm mode
});
if (reducedAtBirth){
  btnMotion.setAttribute('aria-pressed', 'false');
  motionLabel.innerHTML = 'MOTION&nbsp;CALM';
  document.documentElement.classList.add('reduced');
  document.documentElement.classList.add('motion-off');
}

window.addEventListener('wheel', (e) => {
  state.turbBoost = clamp(state.turbBoost + Math.abs(e.deltaY) * 0.0007, 0, 1.6);
  state.cursor.lastMove = state.time;
}, { passive:true });

document.addEventListener('visibilitychange', () => {
  if (document.hidden && AudioEngine.ctx) AudioEngine.ctx.suspend();
  else if (AudioEngine.ctx && state.soundOn) AudioEngine.ctx.resume();
});

/* ============================ resize ============================ */
function applyAspect(){
  const newAspect = innerWidth / innerHeight;
  const changed = Math.abs(newAspect - aspect) / aspect > 0.12;
  aspect = newAspect;
  lastOffsetTop = measure(); // svh-based layout shifts chapter offsets when the viewport resizes
  makeTargets();
  if (changed){ buildFormations(); seedParticles(); } // a mere address-bar collapse must not re-scatter the swarm
}
let resizeTimer = null;
const coarsePointer = matchMedia('(pointer:coarse)').matches;
let lastResizeW = innerWidth;
window.addEventListener('resize', () => {
  clearTimeout(resizeTimer);
  resizeTimer = setTimeout(() => {
    // iOS toolbar collapse fires resize with a height-only change; the canvas is
    // svh-stable, so reacting would just realloc every FBO mid-scroll — skip it
    if (coarsePointer && innerWidth === lastResizeW) return;
    lastResizeW = innerWidth;
    applyAspect();
  }, 220);
});

/* ============================ render helpers ============================ */
function drawQuad(){
  gl.drawArrays(gl.TRIANGLES, 0, 3);
}
function bindTex(unit, tex, loc){
  gl.activeTexture(gl.TEXTURE0 + unit);
  gl.bindTexture(gl.TEXTURE_2D, tex);
  gl.uniform1i(loc, unit);
}

function setHomeAttribs(chA, chB){
  // re-point attrib 3/4 in both VAOs to formation buffers
  for (const vao of [vaoA, vaoB]){
    gl.bindVertexArray(vao);
    gl.bindBuffer(gl.ARRAY_BUFFER, homeBufs[chA]);
    gl.vertexAttribPointer(3, 2, gl.FLOAT, false, 0, 0);
    gl.bindBuffer(gl.ARRAY_BUFFER, homeBufs[chB]);
    gl.vertexAttribPointer(4, 2, gl.FLOAT, false, 0, 0);
  }
  gl.bindVertexArray(null);
  gl.bindBuffer(gl.ARRAY_BUFFER, null);
}

/* ============================ main loop ============================ */
let src = 0; // 0: draw A→B, 1: draw B→A
let lastChapter = -1;
let frames = 0, fpsT = 0, fps = 60, adaptT = 0, roT = 0;
let auT = 0;

applyAspect();
seedParticles(); // initial seed — after this, only a real aspect change re-seeds
setHomeAttribs(0, Math.min(1, NC-1));
requestAnimationFrame((t) => { state.lastT = t; requestAnimationFrame(loop); });

function loop(now){
  requestAnimationFrame(loop);
  const t0 = performance.now();
  let dt = (now - state.lastT) / 1000;
  state.lastT = now;
  if (dt > 0.07) dt = 0.07; // bounds a background-tab catapult; substeps keep this real-time down to ~14 fps
  if (dt <= 0) return;
  state.time += dt;

  /* ---- scroll & chapters ---- */
  state.scroll = window.scrollY;
  const lerpRate = RM() ? 14 : 5.2;
  const prevSmooth = state.scrollSmooth;
  state.scrollSmooth = expDamp(state.scrollSmooth, state.scroll, lerpRate, dt);
  state.scrollVel = expDamp(state.scrollVel, Math.abs(state.scrollSmooth - prevSmooth) / dt * 0.02, 6, dt);
  const span = Math.max(1, lastOffsetTop);
  state.p6 = clamp(state.scrollSmooth / span, 0, 1) * (NC - 1);
  const ch = Math.min(NC-1, Math.floor(state.p6 + 0.001));
  const f = state.p6 - ch;
  state.ch = ch; state.chF = f;

  // seam morph window: last 16% of a chapter dissolves into the next
  const seam = smooth(clamp((f - 0.84) / 0.16, 0, 1));
  state.seam = seam;
  state.morph = seam;
  if (ch !== lastChapter){
    if (lastChapter !== -1){
      if (state.awake) AudioEngine.chord(ch, 0.16);
      setHomeAttribs(ch, Math.min(ch+1, NC-1));
    }
    dots.forEach((d, i) => d.setAttribute('aria-current', String(i === ch)));
    hintEl.textContent = CH[ch].hint;
    lastChapter = ch;
  }

  /* ---- palette crossfade ---- */
  const cA = CH[ch], cB = CH[Math.min(ch+1, NC-1)];
  const mixv = (a, b) => a + (b - a) * seam;
  const bg = cA.bg.map((v,i) => mixv(v, cB.bg[i]));
  const fleshA = cA.fleshA.map((v,i) => mixv(v, cB.fleshA[i]));
  const fleshB = cA.fleshB.map((v,i) => mixv(v, cB.fleshB[i]));
  const colA = cA.colA.map((v,i) => mixv(v, cB.colA[i]));
  const colB = cA.colB.map((v,i) => mixv(v, cB.colB[i]));
  const glow = cA.glow.map((v,i) => mixv(v, cB.glow[i]));
  const spring = mixv(cA.spring, cB.spring);
  let turb = mixv(cA.turb, cB.turb);
  const push = mixv(cA.push, cB.push);
  const swirl = mixv(cA.swirl, cB.swirl);
  const cursorR = mixv(cA.r, cB.r);
  const bloomAmt = mixv(cA.bloom, cB.bloom);
  const vein = mixv(cA.vein, cB.vein);
  const pulse = mixv(cA.pulse, cB.pulse);

  /* ---- turbulence & energy ---- */
  state.turbBoost = expDamp(state.turbBoost, 0, 1.1, dt);
  const cursorSpeedRaw = Math.hypot(state.cursor.vx, state.cursor.vy);
  state.cursor.speedN = expDamp(state.cursor.speedN, clamp(cursorSpeedRaw / 1.4, 0, 1), 4, dt);
  const energy = clamp(state.turbBoost * 0.8 + state.cursor.speedN * 0.5, 0, 1.4);
  if (!RM()) turb = Math.min(turb * (1 + energy * 1.6), 1.3); else turb *= 0.05;

  // ch5 release (transcendence)
  if (state.release > 0){
    state.release = Math.max(0, state.release - dt * 0.28);
  }
  const springEff = spring * state.springRamp * (1 - state.release * 0.82) * (state.awake ? 1 : 0.35);
  turb += state.release * 1.1;

  /* ---- cursor / dream / ghost ---- */
  const idle = state.time - state.cursor.lastMove;
  if (state.awake && idle > 4.5 && !RM()){
    state.dream = true; state.dreamT += dt;
  }
  let cx, cy;
  if (state.dream){
    const t = state.dreamT;
    cx = Math.sin(t * 0.33 + 1.3) * aspect * 0.5 + Math.sin(t*0.71) * 0.2;
    cy = Math.sin(t * 0.21 + 4.2) * 0.55 + Math.cos(t*0.53) * 0.15;
    state.cursor.tx = cx; state.cursor.ty = cy;
  }
  const prevCx = state.cursor.x, prevCy = state.cursor.y;
  state.cursor.x = expDamp(state.cursor.x, state.cursor.tx, RM() ? 22 : 13, dt);
  state.cursor.y = expDamp(state.cursor.y, state.cursor.ty, RM() ? 22 : 13, dt);
  state.cursor.vx = (state.cursor.x - prevCx) / dt;
  state.cursor.vy = (state.cursor.y - prevCy) / dt;

  // ch1: the iris tracks you. other chapters: slight parallax.
  const trackW = ch === 1 ? 0.16 : 0.035;
  const shiftScale = ch === 1 ? clamp(1 - seam, 0, 1) : 1;
  state.homeShift[0] = expDamp(state.homeShift[0], state.cursor.x * trackW * shiftScale, 4, dt);
  state.homeShift[1] = expDamp(state.homeShift[1], state.cursor.y * trackW * shiftScale, 4, dt);

  // memory ghost — replay when you rest in ch4 (or dreaming elsewhere it fades)
  const wantGhost = (ch === 4 && idle > 1.4 && state.mem.pts.length > 12) ? 1 : 0;
  state.mem.replay = expDamp(state.mem.replay, wantGhost, 1.6, dt);
  if (wantGhost){
    state.mem.idx = (state.mem.idx + dt * 65) % state.mem.pts.length;
    const p = state.mem.pts[Math.floor(state.mem.idx)];
    state.ghost[0] = expDamp(state.ghost[0], p[0], 10, dt);
    state.ghost[1] = expDamp(state.ghost[1], p[1], 10, dt);
  }
  state.ghostW = state.mem.replay * 1.0;
  state.ghostVis = state.mem.replay * 0.85;

  /* ---- heartbeat ---- */
  state.bpm = expDamp(state.bpm, 56 + clamp(state.scrollVel * 170 + energy * 46, 0, 130), 2, dt);
  const beatInterval = 60 / state.bpm;
  if (state.awake && state.time >= state.nextBeat){
    state.nextBeat = state.time + beatInterval;
    state.beatEnv = 1; state.beatT = 0;
    if (ch === 3 || state.release > 0.1) AudioEngine.kick(ch === 3 ? 0.5 : 0.22);
  }
  state.beatEnv *= Math.exp(-dt * 5.2);
  state.beatT += dt;
  state.homeScale = 1 + (RM() ? 0 : state.beatEnv * 0.045 * (0.4 + pulse)); // calm = formation holds still
  state.flash *= Math.exp(-dt * 3.4);
  state.shock *= Math.exp(-dt * 2.4);
  state.springRamp = Math.min(1, state.springRamp + (state.awake ? dt * 0.9 : 0));

  /* ---- GL passes ---- */
  const count = QUALITY[quality].count;

  // 1. simulate (transform feedback) — substepped: below ~45 fps the physics takes
  // several small steps per frame, so motion stays REAL TIME at any frame rate.
  // (The old single clamped step is what read as slow motion on phones.)
  const sub = dt > 0.022 ? Math.min(4, Math.ceil(dt / 0.0167)) : 1;
  const sdt = dt / sub;
  gl.enable(gl.RASTERIZER_DISCARD);
  gl.useProgram(pSim.p);
  const su = pSim.u;
  gl.uniform1f(su.u_morph, state.morph);
  gl.uniform1f(su.u_spring, springEff);
  gl.uniform1f(su.u_turb, turb);
  gl.uniform1f(su.u_push, push * (pointerDown ? 0.4 : 1));
  gl.uniform1f(su.u_swirl, swirl);
  gl.uniform1f(su.u_cursorR, cursorR);
  gl.uniform1f(su.u_shock, state.shock);
  gl.uniform1f(su.u_homeScale, state.homeScale);
  gl.uniform1f(su.u_ghostW, state.ghostW);
  gl.uniform2f(su.u_cursor, state.cursor.x, state.cursor.y);
  gl.uniform2f(su.u_shockPos, state.shockPos[0], state.shockPos[1]);
  gl.uniform2f(su.u_homeShift, state.homeShift[0], state.homeShift[1]);
  gl.uniform2f(su.u_ghost, state.ghost[0], state.ghost[1]);
  for (let s = 0; s < sub; s++){
    gl.uniform1f(su.u_dt, sdt);
    gl.uniform1f(su.u_time, state.time - dt + sdt * (s + 1));
    gl.bindVertexArray(src === 0 ? vaoA : vaoB);
    gl.bindTransformFeedback(gl.TRANSFORM_FEEDBACK, src === 0 ? tfA : tfB);
    gl.beginTransformFeedback(gl.POINTS);
    gl.drawArrays(gl.POINTS, 0, count);
    gl.endTransformFeedback();
    src = 1 - src; // each substep hands the just-written side to the next
  }
  gl.bindTransformFeedback(gl.TRANSFORM_FEEDBACK, null);
  gl.disable(gl.RASTERIZER_DISCARD);
  gl.bindVertexArray(null);

  // 2. trail: fade then accumulate points
  gl.bindFramebuffer(gl.FRAMEBUFFER, trailFBO.fb);
  gl.viewport(0, 0, W, H);
  gl.useProgram(pFlat.p);
  gl.enable(gl.BLEND);
  gl.blendFunc(gl.SRC_ALPHA, gl.ONE_MINUS_SRC_ALPHA);
  const fadeBase = RM() ? 0.34 : (quality === 0 ? 0.32 : 0.26); // per-frame alpha at 60 fps…
  gl.uniform4f(pFlat.u.u_color, 0, 0, 0, 1 - Math.pow(1 - fadeBase, dt * 60)); // …scaled so trails persist the same wall-clock time at any frame rate
  drawQuad();
  gl.blendFunc(gl.ONE, gl.ONE);
  gl.useProgram(pPts.p);
  gl.uniform1f(pPts.u.u_aspect, aspect);
  gl.uniform1f(pPts.u.u_beat, RM() ? 0 : state.beatEnv * (0.4 + pulse*0.6)); // calm = no glow pulse
  gl.uniform1f(pPts.u.u_px, dpr * (quality === 0 ? 1.75 : quality === 1 ? 1.28 : 1.15)); // low tiers draw fewer points — keep them fat enough to read the word (tier-0 boost compensates the smaller canvas, so screen size is unchanged)
  gl.uniform1f(pPts.u.u_dim, state.awake ? 1 : 0.5);
  gl.uniform3f(pPts.u.u_colA, colA[0], colA[1], colA[2]);
  gl.uniform3f(pPts.u.u_colB, colB[0], colB[1], colB[2]);
  gl.bindVertexArray(src === 0 ? vaoA : vaoB); // read what the last substep wrote
  gl.drawArrays(gl.POINTS, 0, count);
  gl.bindVertexArray(null);
  gl.disable(gl.BLEND);
  // src already points at the fresh side — the substep loop flipped it

  // 3. flesh
  gl.bindFramebuffer(gl.FRAMEBUFFER, fleshFBO.fb);
  gl.viewport(0, 0, fleshFBO.w, fleshFBO.h);
  gl.useProgram(pFlesh.p);
  const fu = pFlesh.u;
  gl.uniform1f(fu.u_time, state.time * (RM() ? 0.35 : 1));
  gl.uniform1f(fu.u_aspect, aspect);
  gl.uniform1f(fu.u_cursorGlow, 0.35 + state.cursor.speedN * 0.65);
  gl.uniform1f(fu.u_vein, vein);
  gl.uniform1f(fu.u_beatEnv, state.beatEnv);
  gl.uniform1f(fu.u_beatT, state.beatT);
  gl.uniform1f(fu.u_pulse, pulse);
  gl.uniform1f(fu.u_flash, state.flash);
  gl.uniform1f(fu.u_quality, quality);
  gl.uniform2f(fu.u_cursor, state.cursor.x, state.cursor.y);
  gl.uniform3f(fu.u_bg, bg[0], bg[1], bg[2]);
  gl.uniform3f(fu.u_tintA, fleshA[0], fleshA[1], fleshA[2]);
  gl.uniform3f(fu.u_tintB, fleshB[0], fleshB[1], fleshB[2]);
  gl.uniform3f(fu.u_glow, glow[0], glow[1], glow[2]);
  drawQuad();

  // 4. bloom
  gl.bindFramebuffer(gl.FRAMEBUFFER, bloomA.fb);
  gl.viewport(0, 0, bloomA.w, bloomA.h);
  gl.useProgram(pBright.p);
  bindTex(0, trailFBO.tex, pBright.u.u_tex);
  gl.uniform1f(pBright.u.u_threshold, 0.42);
  drawQuad();
  gl.useProgram(pBlur.p);
  const iters = QUALITY[quality].bloomIter;
  for (let i=0;i<iters;i++){
    gl.bindFramebuffer(gl.FRAMEBUFFER, bloomB.fb);
    bindTex(0, bloomA.tex, pBlur.u.u_tex);
    gl.uniform2f(pBlur.u.u_dir, 1.4 / bloomA.w, 0);
    drawQuad();
    gl.bindFramebuffer(gl.FRAMEBUFFER, bloomA.fb);
    bindTex(0, bloomB.tex, pBlur.u.u_tex);
    gl.uniform2f(pBlur.u.u_dir, 0, 1.4 / bloomA.h);
    drawQuad();
  }

  // 5. final composite to screen
  gl.bindFramebuffer(gl.FRAMEBUFFER, null);
  gl.viewport(0, 0, W, H);
  gl.useProgram(pFinal.p);
  const fin = pFinal.u;
  bindTex(0, fleshFBO.tex, fin.u_flesh);
  bindTex(1, trailFBO.tex, fin.u_trail);
  bindTex(2, bloomA.tex, fin.u_bloom);
  gl.uniform1f(fin.u_time, state.time);
  gl.uniform1f(fin.u_aspect, aspect);
  gl.uniform1f(fin.u_beatEnv, RM() ? 0 : state.beatEnv * pulse);
  gl.uniform1f(fin.u_bloomAmt, bloomAmt * (0.75 + state.flash * 1.6));
  gl.uniform1f(fin.u_fleshAmt, 1);
  gl.uniform1f(fin.u_cheap, quality === 0 ? 1 : 0);
  gl.uniform3f(fin.u_bg, bg[0], bg[1], bg[2]);
  gl.uniform1f(fin.u_flash, state.flash);
  gl.uniform1f(fin.u_lens, 0.4 + state.cursor.speedN * 0.6);
  gl.uniform1f(fin.u_orbVis, !RM() ? 1 : 0.0);
  gl.uniform1f(fin.u_ghostVis, state.ghostVis);
  gl.uniform1f(fin.u_wake, state.awake ? 1 : 0.42);
  gl.uniform2f(fin.u_cursor, state.cursor.x, state.cursor.y);
  gl.uniform2f(fin.u_ghost, state.ghost[0], state.ghost[1]);
  gl.uniform3f(fin.u_glow, glow[0], glow[1], glow[2]);
  drawQuad();

  /* ---- audio update — 10 Hz is plenty for parameter automation ---- */
  if (state.awake && AudioEngine.ok){
    auT += dt;
    if (auT >= 0.1){
      auT = 0;
      AudioEngine.update(state.cursor.speedN, clamp(energy, 0, 1));
      AudioEngine.setChapter(ch, seam);
    }
  }

  /* ---- DOM: panels, progress, readouts ---- */
  for (let i=0;i<NC;i++){
    const d = state.p6 - i;
    const panel = panelEls[i];
    const opS = clamp(1 - Math.abs(d) * 1.35, 0, 1).toFixed(3);
    const tyS = (clamp(-d, -1, 1) * -34).toFixed(1);
    if (panel._op !== opS || panel._ty !== tyS){ // write only on change — per-frame style churn stutters mobile
      panel._op = opS; panel._ty = tyS;
      panel.style.opacity = opS;
      panel.style.transform = `translateY(${tyS}px)`;
    }
  }
  const pbS = (state.p6 / (NC-1)).toFixed(4);
  if (progressBar._s !== pbS){ progressBar._s = pbS; progressBar.style.transform = `scaleX(${pbS})`; }

  roT += dt;
  if (roT > 0.15){
    roT = 0;
    const att = clamp(Math.round((1 - clamp(idle / 5, 0, 1)) * 70 + state.cursor.speedN * 30 + (state.dream ? 12 : 0)), 0, 100);
    $('#ro-cells').textContent = count.toLocaleString('en-US');
    $('#ro-state').textContent = state.awake ? (state.dream ? 'dreaming' : CH[ch].state) : 'dormant';
    $('#ro-attention').textContent = att + '%';
    $('#ro-tracking').textContent = state.dream ? 'wandering' : 'locked';
    $('#ro-turb').textContent = Math.round(clamp(energy, 0, 1.4) * 100 / 1.4) + '%';
    $('#ro-weather').textContent = energy > 0.75 ? 'storm' : energy > 0.35 ? 'breeze' : 'calm';
    $('#ro-bpm').textContent = Math.round(state.bpm) + ' bpm';
    $('#ro-memory').textContent = state.mem.pts.length.toLocaleString('en-US') + ' pts';
    $('#ro-replay').textContent = state.mem.replay > 0.5 ? 'replaying' : 'recording';
    $('#ro-lumen').textContent = Math.round(clamp(f * 1.25 + (ch === 5 ? state.clicks > 0 ? 1 : 0.5 : 0), 0, 1) * 100) + '%';
    $('#ro-signal').textContent = (100 - Math.round(state.qualityEvents.length * 2)).toFixed(0) + '%';
  }

  /* ---- adaptive quality ---- */
  const frameMs = performance.now() - t0;
  state.frameMs = lerp(state.frameMs, frameMs, 0.06);
  frames++; fpsT += dt; adaptT += dt;
  if (fpsT >= 0.5){ fps = frames / fpsT; frames = 0; fpsT = 0; }
  if (adaptT > 2.2 && !freezeQ){
    adaptT = 0;
    if (fps < 42 && quality > 0){
      quality--; state.qualityEvents.push({ t: Math.round(state.time), to: quality, fps: Math.round(fps) });
      applyQuality();
    } else if (fps > 56 && quality < startQuality){
      quality++; state.qualityEvents.push({ t: Math.round(state.time), to: quality, fps: Math.round(fps) });
      applyQuality();
    }
  }
}

/* ============================ debug API ============================ */
window.__DA7EM__ = {
  ok: true, hdr: HDR,
  get fps(){ return fps; },
  get ms(){ return Math.round(state.frameMs * 10) / 10; },
  get quality(){ return quality; },
  get particles(){ return QUALITY[quality].count; },
  get time(){ return state.time; }, // wall-clock tracking probe: Δtime/Δwall = 1 means real-time motion
  get chapter(){ return state.ch; },
  get progress(){ return Math.round(state.p6 * 1000) / 1000; },
  get awake(){ return state.awake; },
  get dream(){ return state.dream; },
  get attention(){ return Math.round((1 - clamp((state.time - state.cursor.lastMove) / 5, 0, 1)) * 100); },
  get bpm(){ return Math.round(state.bpm); },
  get memory(){ return state.mem.pts.length; },
  get replay(){ return state.mem.replay > 0.5; },
  get audio(){ return { ok: AudioEngine.ok, enabled: AudioEngine.enabled, state: AudioEngine.ctx ? AudioEngine.ctx.state : 'none' }; },
  get qualityEvents(){ return state.qualityEvents; },
  get clicks(){ return state.clicks; },
  wake, feed,
  get formations(){ return formationData; },
  snapHome(chIdx){ // DEBUG: teleport all particles exactly onto their formation homes
    const f = formationData[chIdx];
    const zero = new Float32Array(MAXP * 2);
    gl.bindBuffer(gl.ARRAY_BUFFER, posA); gl.bufferSubData(gl.ARRAY_BUFFER, 0, f);
    gl.bindBuffer(gl.ARRAY_BUFFER, posB); gl.bufferSubData(gl.ARRAY_BUFFER, 0, f);
    gl.bindBuffer(gl.ARRAY_BUFFER, velA); gl.bufferSubData(gl.ARRAY_BUFFER, 0, zero);
    gl.bindBuffer(gl.ARRAY_BUFFER, velB); gl.bufferSubData(gl.ARRAY_BUFFER, 0, zero);
    gl.bindBuffer(gl.ARRAY_BUFFER, null);
    return true;
  },
  positions(sample){ // read live particle positions from the TF buffer
    const last = src === 0 ? posA : posB; // src flips after each TF write — this is the last-written buffer
    gl.bindBuffer(gl.TRANSFORM_FEEDBACK_BUFFER, last);
    const all = new Float32Array(MAXP * 2);
    gl.getBufferSubData(gl.TRANSFORM_FEEDBACK_BUFFER, 0, all);
    gl.bindBuffer(gl.TRANSFORM_FEEDBACK_BUFFER, null);
    const step = sample || 7;
    const out = [];
    for (let i = 0; i < MAXP; i += step) out.push(all[i*2], all[i*2+1]);
    return { n: out.length / 2, pts: out };
  },
  displacement(chIdx){ // RMS distance of live particles vs their formation homes
    const { pts } = this.positions(13);
    const home = formationData[chIdx];
    const nHome = Math.min(MAXP, home.length / 2); // tier-sized formations
    let sum = 0, n = 0, maxX = 0;
    for (let k = 0; k < pts.length / 2; k++){
      const i = k * 13;
      if (i >= nHome) break;
      if (seeds[i] >= 0.9) continue; // skip ambient (matches the shader's step)
      const dx = pts[k*2] - home[i*2], dy = pts[k*2+1] - home[i*2+1];
      const d = Math.hypot(dx, dy);
      sum += d * d; n++;
      if (d > maxX) maxX = d;
    }
    return { rms: +(Math.sqrt(sum / Math.max(1,n))).toFixed(3), max: +maxX.toFixed(3), n };
  },
  snapshot(layer){ // read a render target as raw pixels: 'trail' | 'flesh' | 'bloom'
    const t = layer === 'flesh' ? fleshFBO : layer === 'bloom' ? bloomA : trailFBO;
    gl.bindFramebuffer(gl.FRAMEBUFFER, t.fb);
    const w = t.w, h = t.h;
    let px = new Uint8Array(w * h * 4);
    if (HDR){
      const f = new Float32Array(w * h * 4);
      gl.readPixels(0, 0, w, h, gl.RGBA, gl.FLOAT, f);
      for (let i = 0; i < f.length; i++) px[i] = Math.min(255, Math.round(Math.max(0, f[i]) * 255));
    } else {
      gl.readPixels(0, 0, w, h, gl.RGBA, gl.UNSIGNED_BYTE, px);
    }
    gl.bindFramebuffer(gl.FRAMEBUFFER, null);
    return { w, h, px };
  },
  stats(layer){
    const { w, h, px } = this.snapshot(layer);
    // luminance inside the central letter box (25%..75% x, 30%..70% y) vs outside
    let inSum = 0, inN = 0, outSum = 0, outN = 0, maxL = 0;
    for (let y = 0; y < h; y++){
      for (let x = 0; x < w; x++){
        const i = (y * w + x) * 4;
        const l = 0.2126*px[i] + 0.7152*px[i+1] + 0.0722*px[i+2];
        if (l > maxL) maxL = l;
        const inBox = x > w*0.25 && x < w*0.75 && y > h*0.30 && y < h*0.70;
        if (inBox){ inSum += l; inN++; } else { outSum += l; outN++; }
      }
    }
    return { w, h, maxL: Math.round(maxL), inAvg: +(inSum/inN).toFixed(1), outAvg: +(outSum/outN).toFixed(1), ratio: +(inSum/inN / (outSum/outN || 1)).toFixed(2) };
  },
};
</script>
</body>
</html>
