<!DOCTYPE html>
<html class="dark" lang="id">
<head>
<meta charset="utf-8"/>
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<title>WeeklyReport - Daily Activity & Weekly Report Portal</title>
<script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet"/>
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>
<script id="tailwind-config">
  tailwind.config = {
    darkMode: "class",
    theme: {
      extend: {
        colors: {
          "surface-container-lowest": "#0c0e10",
          "surface": "#111415",
          "on-surface": "#e2e2e4",
          "primary-fixed-dim": "#c6c6cc",
          "on-secondary": "#002388",
          "surface-tint": "#c6c6cc",
          "outline": "#909095",
          "on-secondary-container": "#c6ceff",
          "tertiary-container": "#1a0026",
          "on-secondary-fixed": "#001356",
          "tertiary-fixed": "#f9d8ff",
          "on-error": "#690005",
          "surface-bright": "#37393b",
          "inverse-surface": "#e2e2e4",
          "background": "#111415",
          "on-primary-fixed": "#1a1c20",
          "tertiary-fixed-dim": "#edb1ff",
          "on-tertiary": "#520070",
          "primary": "#c6c6cc",
          "inverse-primary": "#5d5e63",
          "surface-container": "#1e2021",
          "outline-variant": "#45474b",
          "primary-container": "#0a0c10",
          "on-tertiary-fixed": "#320046",
          "on-error-container": "#ffdad6",
          "secondary": "#b8c3ff",
          "surface-variant": "#333537",
          "on-primary": "#2f3035",
          "inverse-on-surface": "#2f3132",
          "on-primary-fixed-variant": "#45474b",
          "secondary-container": "#0043eb",
          "on-primary-container": "#797a7f",
          "tertiary": "#edb1ff",
          "on-secondary-fixed-variant": "#0035be",
          "on-surface-variant": "#c6c6cb",
          "secondary-fixed": "#dde1ff",
          "on-tertiary-fixed-variant": "#6e208c",
          "surface-dim": "#111415",
          "surface-container-high": "#282a2c",
          "surface-container-highest": "#333537",
          "error-container": "#93000a",
          "on-tertiary-container": "#a759c5",
          "primary-fixed": "#e2e2e8",
          "surface-container-low": "#1a1c1d",
          "error": "#ffb4ab",
          "secondary-fixed-dim": "#b8c3ff",
          "on-background": "#e2e2e4"
        },
      }
    }
  }
</script>
<style>
  *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

  :root {
    --ease-apple: cubic-bezier(0.25, 0.1, 0.25, 1);
    --ease-spring: cubic-bezier(0.34, 1.56, 0.64, 1);
    --ease-smooth: cubic-bezier(0.16, 1, 0.3, 1);
  }

  html { scroll-behavior: smooth; }

  body {
    background: #0a0b0d;
    color: #e2e2e4;
    font-family: 'Inter', -apple-system, sans-serif;
    overflow-x: hidden;
  }

  .material-symbols-outlined {
    font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
  }

  /* ── NOISE GRAIN ── */
  body::before {
    content: '';
    position: fixed;
    inset: 0;
    background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 256 256' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='noise'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.9' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23noise)' opacity='0.04'/%3E%3C/svg%3E");
    pointer-events: none;
    z-index: 9999;
    opacity: 0.4;
  }

  /* ── NAV ── */
  .nav {
    position: fixed;
    top: 0;
    width: 100%;
    z-index: 100;
    transition: background 0.4s var(--ease-apple), border-color 0.4s var(--ease-apple);
  }
  .nav.scrolled {
    background: rgba(10,11,13,0.75);
    backdrop-filter: saturate(180%) blur(24px);
    -webkit-backdrop-filter: saturate(180%) blur(24px);
    border-bottom: 1px solid rgba(255,255,255,0.06);
  }
  .nav-inner {
    display: flex;
    justify-content: space-between;
    align-items: center;
    height: 72px;
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 32px;
  }
  .nav-logo {
    font-size: 18px;
    font-weight: 700;
    letter-spacing: -0.02em;
    color: #e2e2e4;
  }
  .nav-links {
    display: flex;
    gap: 36px;
    list-style: none;
  }
  .nav-links a {
    font-size: 14px;
    font-weight: 500;
    color: rgba(226,226,228,0.65);
    text-decoration: none;
    transition: color 0.2s;
  }
  .nav-links a:hover { color: #e2e2e4; }
  .nav-actions { display: flex; align-items: center; gap: 16px; }
  .btn-ghost {
    font-size: 14px;
    font-weight: 500;
    color: rgba(226,226,228,0.7);
    background: none;
    border: none;
    cursor: pointer;
    transition: color 0.2s;
  }
  .btn-ghost:hover { color: #e2e2e4; }
  .btn-primary {
    font-size: 14px;
    font-weight: 600;
    color: #fff;
    background: #0043eb;
    border: none;
    border-radius: 999px;
    padding: 9px 20px;
    cursor: pointer;
    transition: transform 0.2s var(--ease-spring), box-shadow 0.2s, background 0.2s;
    position: relative;
    overflow: hidden;
  }
  .btn-primary::after {
    content: '';
    position: absolute;
    inset: 0;
    background: rgba(255,255,255,0.12);
    opacity: 0;
    transition: opacity 0.2s;
  }
  .btn-primary:hover { transform: scale(1.04); box-shadow: 0 0 28px rgba(0,67,235,0.5); }
  .btn-primary:hover::after { opacity: 1; }
  .btn-primary:active { transform: scale(0.97); }

  /* ── HERO ── */
  .hero {
    min-height: 100svh;
    display: flex;
    align-items: center;
    position: relative;
    overflow: hidden;
    padding: 120px 32px 80px;
  }
  .hero-bg {
    position: absolute;
    inset: 0;
    z-index: 0;
  }
  .hero-bg img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    opacity: 0.25;
    transform: scale(1.05);
    transition: transform 12s ease-out;
  }
  .hero-bg img.loaded { transform: scale(1); }
  .hero-overlay {
    position: absolute;
    inset: 0;
    background: linear-gradient(115deg, #0a0b0d 40%, rgba(10,11,13,0.5) 70%, rgba(10,11,13,0.15) 100%);
  }
  /* Aurora blobs */
  .aurora {
    position: absolute;
    inset: 0;
    overflow: hidden;
    pointer-events: none;
  }
  .aurora-blob {
    position: absolute;
    border-radius: 50%;
    filter: blur(80px);
    opacity: 0.15;
    animation: auroraDrift 20s ease-in-out infinite alternate;
  }
  .aurora-blob-1 { width: 600px; height: 600px; background: #0043eb; top: -200px; right: -100px; animation-duration: 22s; }
  .aurora-blob-2 { width: 400px; height: 400px; background: #a759c5; bottom: -100px; right: 200px; animation-duration: 18s; animation-delay: -6s; }
  .aurora-blob-3 { width: 300px; height: 300px; background: #0077ff; top: 40%; left: 55%; animation-duration: 25s; animation-delay: -12s; }
  @keyframes auroraDrift {
    0%   { transform: translate(0,0) scale(1); }
    50%  { transform: translate(40px, -30px) scale(1.1); }
    100% { transform: translate(-20px, 40px) scale(0.95); }
  }

  .hero-content {
    position: relative;
    z-index: 1;
    max-width: 1200px;
    margin: 0 auto;
    width: 100%;
  }
  .hero-eyebrow {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    font-size: 12px;
    font-weight: 600;
    letter-spacing: 0.08em;
    text-transform: uppercase;
    color: #b8c3ff;
    background: rgba(0,67,235,0.12);
    border: 1px solid rgba(0,67,235,0.25);
    border-radius: 999px;
    padding: 6px 14px;
    margin-bottom: 28px;
    opacity: 0;
    transform: translateY(16px);
    animation: fadeSlideUp 0.8s var(--ease-smooth) 0.2s forwards;
  }
  .hero-eyebrow-dot { width: 6px; height: 6px; border-radius: 50%; background: #4d8aff; animation: pulse 2s ease-in-out infinite; }
  @keyframes pulse { 0%,100%{opacity:1;transform:scale(1)} 50%{opacity:0.5;transform:scale(0.8)} }

  .hero-title {
    font-size: clamp(40px, 6.5vw, 80px);
    font-weight: 800;
    letter-spacing: -0.04em;
    line-height: 1.05;
    color: #f0f0f2;
    margin-bottom: 24px;
    max-width: 800px;
    opacity: 0;
    transform: translateY(24px);
    animation: fadeSlideUp 0.9s var(--ease-smooth) 0.35s forwards;
  }
  .hero-title .accent {
    background: linear-gradient(135deg, #4d8aff 0%, #c27fff 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
  }
  .hero-sub {
    font-size: 18px;
    font-weight: 400;
    line-height: 1.65;
    color: rgba(226,226,228,0.6);
    max-width: 520px;
    margin-bottom: 44px;
    opacity: 0;
    transform: translateY(20px);
    animation: fadeSlideUp 0.9s var(--ease-smooth) 0.5s forwards;
  }
  .hero-cta {
    display: flex;
    gap: 14px;
    flex-wrap: wrap;
    opacity: 0;
    transform: translateY(20px);
    animation: fadeSlideUp 0.9s var(--ease-smooth) 0.65s forwards;
  }
  .btn-hero-primary {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    background: #0043eb;
    color: #fff;
    font-size: 16px;
    font-weight: 600;
    border: none;
    border-radius: 999px;
    padding: 15px 32px;
    cursor: pointer;
    transition: transform 0.25s var(--ease-spring), box-shadow 0.25s;
  }
  .btn-hero-primary:hover { transform: scale(1.04) translateY(-1px); box-shadow: 0 16px 48px rgba(0,67,235,0.45); }
  .btn-hero-primary:active { transform: scale(0.97); }
  .btn-hero-secondary {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    background: rgba(255,255,255,0.06);
    color: #e2e2e4;
    font-size: 16px;
    font-weight: 500;
    border: 1px solid rgba(255,255,255,0.1);
    border-radius: 999px;
    padding: 15px 32px;
    cursor: pointer;
    backdrop-filter: blur(12px);
    transition: background 0.25s, transform 0.25s var(--ease-spring);
  }
  .btn-hero-secondary:hover { background: rgba(255,255,255,0.1); transform: scale(1.02); }
  .btn-hero-secondary:active { transform: scale(0.97); }

  /* Hero stats */
  .hero-stats {
    display: flex;
    gap: 40px;
    margin-top: 64px;
    padding-top: 40px;
    border-top: 1px solid rgba(255,255,255,0.07);
    opacity: 0;
    transform: translateY(20px);
    animation: fadeSlideUp 0.9s var(--ease-smooth) 0.85s forwards;
  }
  .stat-item {}
  .stat-num {
    font-size: 28px;
    font-weight: 700;
    letter-spacing: -0.03em;
    color: #f0f0f2;
    display: flex;
    align-items: baseline;
    gap: 3px;
  }
  .stat-num sup { font-size: 14px; font-weight: 600; color: #4d8aff; }
  .stat-label { font-size: 13px; color: rgba(226,226,228,0.45); margin-top: 2px; }

  /* Scroll indicator */
  .scroll-hint {
    position: absolute;
    bottom: 36px;
    left: 50%;
    transform: translateX(-50%);
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 8px;
    z-index: 2;
    opacity: 0;
    animation: fadeSlideUp 0.9s var(--ease-smooth) 1.2s forwards;
  }
  .scroll-hint-text { font-size: 11px; letter-spacing: 0.1em; text-transform: uppercase; color: rgba(226,226,228,0.3); }
  .scroll-hint-line {
    width: 1px;
    height: 40px;
    background: linear-gradient(to bottom, rgba(226,226,228,0.3), transparent);
    animation: scrollLineAnim 2s ease-in-out infinite;
  }
  @keyframes scrollLineAnim {
    0%,100% { transform: scaleY(1); opacity: 1; }
    50% { transform: scaleY(0.5); opacity: 0.4; }
  }

  @keyframes fadeSlideUp {
    to { opacity: 1; transform: translateY(0); }
  }

  /* ── SECTION REVEAL ── */
  .reveal {
    opacity: 0;
    transform: translateY(40px);
    transition: opacity 0.85s var(--ease-smooth), transform 0.85s var(--ease-smooth);
  }
  .reveal.visible { opacity: 1; transform: translateY(0); }
  .reveal-delay-1 { transition-delay: 0.1s; }
  .reveal-delay-2 { transition-delay: 0.2s; }
  .reveal-delay-3 { transition-delay: 0.3s; }
  .reveal-delay-4 { transition-delay: 0.4s; }

  /* ── FEATURES ── */
  .section-label {
    display: inline-block;
    font-size: 11px;
    font-weight: 700;
    letter-spacing: 0.1em;
    text-transform: uppercase;
    color: #4d8aff;
    margin-bottom: 16px;
  }
  .section-title {
    font-size: clamp(28px, 4vw, 48px);
    font-weight: 700;
    letter-spacing: -0.03em;
    line-height: 1.1;
    color: #f0f0f2;
    margin-bottom: 16px;
  }
  .section-sub {
    font-size: 17px;
    line-height: 1.65;
    color: rgba(226,226,228,0.55);
    max-width: 520px;
  }

  .features-section {
    padding: 120px 32px;
    max-width: 1200px;
    margin: 0 auto;
  }
  .features-header { margin-bottom: 72px; }
  .features-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 20px;
  }
  @media (max-width: 900px) { .features-grid { grid-template-columns: 1fr; } }

  .feature-card {
    background: rgba(20,22,25,0.7);
    border: 1px solid rgba(255,255,255,0.06);
    border-radius: 24px;
    padding: 36px;
    position: relative;
    overflow: hidden;
    transition: border-color 0.3s, transform 0.4s var(--ease-smooth), box-shadow 0.4s;
    cursor: default;
  }
  .feature-card::before {
    content: '';
    position: absolute;
    inset: 0;
    background: radial-gradient(circle at 50% 0%, rgba(0,67,235,0.06) 0%, transparent 60%);
    opacity: 0;
    transition: opacity 0.4s;
  }
  .feature-card:hover { border-color: rgba(255,255,255,0.12); transform: translateY(-4px); box-shadow: 0 32px 64px rgba(0,0,0,0.4); }
  .feature-card:hover::before { opacity: 1; }
  .feature-card.purple-glow:hover::before { background: radial-gradient(circle at 50% 0%, rgba(167,89,197,0.08) 0%, transparent 60%); }

  .feature-icon {
    width: 52px;
    height: 52px;
    border-radius: 16px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-bottom: 24px;
    position: relative;
  }
  .feature-icon-blue { background: rgba(0,67,235,0.15); }
  .feature-icon-purple { background: rgba(167,89,197,0.15); }
  .feature-icon-green { background: rgba(29,158,117,0.15); }
  .feature-icon .material-symbols-outlined { font-size: 26px; }
  .feature-icon-blue .material-symbols-outlined { color: #4d8aff; }
  .feature-icon-purple .material-symbols-outlined { color: #c27fff; }
  .feature-icon-green .material-symbols-outlined { color: #3ecf8e; }

  .feature-tag {
    display: inline-block;
    font-size: 10px;
    font-weight: 700;
    letter-spacing: 0.08em;
    text-transform: uppercase;
    color: #4d8aff;
    background: rgba(0,67,235,0.12);
    border-radius: 999px;
    padding: 3px 10px;
    margin-bottom: 12px;
  }
  .feature-title { font-size: 20px; font-weight: 600; letter-spacing: -0.02em; color: #f0f0f2; margin-bottom: 10px; }
  .feature-desc { font-size: 15px; line-height: 1.65; color: rgba(226,226,228,0.5); }

  /* ── SHOWCASE ── */
  .showcase-section {
    padding: 40px 32px 120px;
    position: relative;
    overflow: hidden;
  }
  .showcase-inner { max-width: 1100px; margin: 0 auto; text-align: center; }
  .showcase-header { margin-bottom: 56px; }
  .showcase-img-wrap {
    position: relative;
    border-radius: 28px;
    overflow: hidden;
  }
  .showcase-img-glow {
    position: absolute;
    inset: -2px;
    background: linear-gradient(135deg, rgba(0,67,235,0.4), rgba(167,89,197,0.4));
    border-radius: 30px;
    z-index: -1;
    filter: blur(24px);
    opacity: 0;
    transition: opacity 0.8s;
  }
  .showcase-img-wrap:hover .showcase-img-glow { opacity: 1; }
  .showcase-img-wrap img {
    width: 100%;
    display: block;
    border-radius: 26px;
    border: 1px solid rgba(255,255,255,0.08);
    transition: transform 0.8s var(--ease-smooth);
  }
  .showcase-img-wrap:hover img { transform: scale(1.01); }

  /* floating badges */
  .float-badge {
    position: absolute;
    background: rgba(12,14,16,0.85);
    backdrop-filter: blur(16px);
    -webkit-backdrop-filter: blur(16px);
    border: 1px solid rgba(255,255,255,0.1);
    border-radius: 16px;
    padding: 12px 18px;
    display: flex;
    align-items: center;
    gap: 10px;
    white-space: nowrap;
    box-shadow: 0 16px 48px rgba(0,0,0,0.4);
  }
  .badge-1 { top: 8%; left: -2%; animation: floatA 6s ease-in-out infinite; }
  .badge-2 { bottom: 12%; right: -2%; animation: floatB 7s ease-in-out infinite 1s; }
  @keyframes floatA { 0%,100%{transform:translateY(0)} 50%{transform:translateY(-10px)} }
  @keyframes floatB { 0%,100%{transform:translateY(0)} 50%{transform:translateY(8px)} }
  .badge-icon { width: 32px; height: 32px; border-radius: 10px; display: flex; align-items: center; justify-content: center; }
  .badge-icon-green { background: rgba(29,158,117,0.2); }
  .badge-icon-blue { background: rgba(0,67,235,0.2); }
  .badge-icon .material-symbols-outlined { font-size: 18px; }
  .badge-icon-green .material-symbols-outlined { color: #3ecf8e; }
  .badge-icon-blue .material-symbols-outlined { color: #4d8aff; }
  .badge-text { font-size: 13px; font-weight: 600; color: #f0f0f2; }
  .badge-sub { font-size: 11px; color: rgba(226,226,228,0.45); margin-top: 1px; }

  /* ── WORKFLOW ── */
  .workflow-section {
    padding: 120px 32px;
    background: #0c0e10;
    position: relative;
    overflow: hidden;
  }
  .workflow-section::before {
    content: '';
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%,-50%);
    width: 800px;
    height: 800px;
    background: radial-gradient(circle, rgba(0,67,235,0.04) 0%, transparent 70%);
    pointer-events: none;
  }
  .workflow-inner { max-width: 1200px; margin: 0 auto; }
  .workflow-header { text-align: center; margin-bottom: 80px; }
  .workflow-steps {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 24px;
    position: relative;
  }
  @media (max-width: 800px) { .workflow-steps { grid-template-columns: 1fr; } }

  /* connecting line */
  .workflow-steps::before {
    content: '';
    position: absolute;
    top: 44px;
    left: calc(16.7% + 24px);
    right: calc(16.7% + 24px);
    height: 1px;
    background: linear-gradient(to right, transparent, rgba(0,67,235,0.4) 20%, rgba(0,67,235,0.4) 80%, transparent);
    pointer-events: none;
  }
  @media (max-width: 800px) { .workflow-steps::before { display: none; } }

  .workflow-step {
    display: flex;
    flex-direction: column;
    align-items: center;
    text-align: center;
    padding: 40px 28px;
    background: rgba(20,22,25,0.5);
    border: 1px solid rgba(255,255,255,0.05);
    border-radius: 24px;
    transition: border-color 0.3s, transform 0.4s var(--ease-smooth);
  }
  .workflow-step:hover { border-color: rgba(0,67,235,0.2); transform: translateY(-4px); }
  .step-num {
    width: 44px;
    height: 44px;
    border-radius: 50%;
    background: rgba(0,67,235,0.12);
    border: 1px solid rgba(0,67,235,0.25);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 16px;
    font-weight: 700;
    color: #4d8aff;
    margin-bottom: 20px;
    position: relative;
    z-index: 1;
    transition: background 0.3s, border-color 0.3s, transform 0.3s var(--ease-spring);
  }
  .workflow-step:hover .step-num {
    background: rgba(0,67,235,0.25);
    border-color: rgba(0,67,235,0.5);
    transform: scale(1.12);
  }
  .step-icon .material-symbols-outlined { font-size: 36px; color: rgba(226,226,228,0.3); margin-bottom: 16px; transition: color 0.3s; }
  .workflow-step:hover .step-icon .material-symbols-outlined { color: #4d8aff; }
  .step-title { font-size: 19px; font-weight: 600; letter-spacing: -0.02em; color: #f0f0f2; margin-bottom: 10px; }
  .step-desc { font-size: 15px; line-height: 1.65; color: rgba(226,226,228,0.45); }

  /* ── CTA ── */
  .cta-section {
    padding: 80px 32px 120px;
    max-width: 1200px;
    margin: 0 auto;
  }
  .cta-card {
    position: relative;
    overflow: hidden;
    border-radius: 32px;
    padding: 100px 60px;
    text-align: center;
    background: #0f1115;
    border: 1px solid rgba(255,255,255,0.06);
  }
  .cta-card::before {
    content: '';
    position: absolute;
    top: -200px;
    left: 50%;
    transform: translateX(-50%);
    width: 700px;
    height: 500px;
    background: radial-gradient(ellipse, rgba(0,67,235,0.15) 0%, rgba(167,89,197,0.08) 50%, transparent 70%);
    pointer-events: none;
  }
  .cta-grid-overlay {
    position: absolute;
    inset: 0;
    background-image:
      linear-gradient(rgba(255,255,255,0.02) 1px, transparent 1px),
      linear-gradient(90deg, rgba(255,255,255,0.02) 1px, transparent 1px);
    background-size: 60px 60px;
    mask-image: radial-gradient(ellipse 80% 80% at 50% 0%, black, transparent);
  }
  .cta-badge {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    font-size: 12px;
    font-weight: 600;
    letter-spacing: 0.06em;
    text-transform: uppercase;
    color: #4d8aff;
    background: rgba(0,67,235,0.1);
    border: 1px solid rgba(0,67,235,0.2);
    border-radius: 999px;
    padding: 6px 16px;
    margin-bottom: 32px;
    position: relative;
    z-index: 1;
  }
  .cta-title {
    font-size: clamp(32px, 5vw, 64px);
    font-weight: 800;
    letter-spacing: -0.04em;
    line-height: 1.05;
    color: #f0f0f2;
    margin-bottom: 20px;
    position: relative;
    z-index: 1;
  }
  .cta-desc {
    font-size: 18px;
    line-height: 1.6;
    color: rgba(226,226,228,0.5);
    max-width: 500px;
    margin: 0 auto 48px;
    position: relative;
    z-index: 1;
  }
  .cta-actions {
    display: flex;
    justify-content: center;
    gap: 14px;
    flex-wrap: wrap;
    position: relative;
    z-index: 1;
  }
  .btn-cta {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    background: #0043eb;
    color: #fff;
    font-size: 16px;
    font-weight: 600;
    border: none;
    border-radius: 999px;
    padding: 16px 40px;
    cursor: pointer;
    transition: transform 0.25s var(--ease-spring), box-shadow 0.25s;
  }
  .btn-cta:hover { transform: scale(1.04) translateY(-2px); box-shadow: 0 20px 56px rgba(0,67,235,0.5); }
  .btn-cta:active { transform: scale(0.97); }

  /* ── FOOTER ── */
  .footer {
    background: #0a0b0d;
    border-top: 1px solid rgba(255,255,255,0.05);
    padding: 60px 32px;
  }
  .footer-inner {
    max-width: 1200px;
    margin: 0 auto;
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 24px;
  }
  .footer-logo { font-size: 16px; font-weight: 700; color: #e2e2e4; letter-spacing: -0.02em; }
  .footer-links { display: flex; gap: 28px; flex-wrap: wrap; }
  .footer-links a {
    font-size: 13px;
    color: rgba(226,226,228,0.4);
    text-decoration: none;
    transition: color 0.2s;
  }
  .footer-links a:hover { color: rgba(226,226,228,0.8); }
  .footer-copy { font-size: 12px; color: rgba(226,226,228,0.25); }

  /* ── COUNTER ANIMATION ── */
  .count-up { display: inline-block; }

  /* ── FOCUS RING ── */
  button:focus-visible { outline: 2px solid #4d8aff; outline-offset: 3px; }
</style>
</head>
<body>

<!-- NAV -->
<nav class="nav" id="mainNav" role="navigation" aria-label="Navigasi utama">
  <div class="nav-inner">
    <div class="nav-logo">WeeklyReport</div>
    <ul class="nav-links" style="display:flex">
      <li><a href="#features">Fitur</a></li>
      <li><a href="#workflow">Alur</a></li>
      <li><a href="#showoff">Dashboard</a></li>
      <li><a href="#cta">Login</a></li>
    </ul>
    <div class="nav-actions">
      <a href="<?php echo e(route('login')); ?>" class="btn-ghost" style="display:inline-flex;align-items:center;text-decoration:none;">Login</a>
      <a href="<?php echo e(route('login')); ?>" class="btn-primary" style="display:inline-flex;align-items:center;text-decoration:none;">Mulai</a>
    </div>
  </div>
</nav>

<!-- HERO -->
<section class="hero" id="hero">
  <div class="hero-bg">
    <img src="https://lh3.googleusercontent.com/aida-public/AB6AXuDZ0z1nmiQoWvX0DsNY6U-ABEbMXdf2G7qkkt9DM3zes2eHd_kq67nfDDkgJl5xmwZ1lY3-s9wr5uR6WxZP336KVCDpxnC9j7JJExfAqDs6uHeD5ATwhF6Cr7gZjtgCTkLZTIP8hqV6lYcsE1LBVmEke_nY3OxIVtkfP72vbMJjwYpQnRllPFt8ptgXUJx-yxGRapWrv4uuv4jgrnVOYrOhZ4o4eFCNXNGQyYeJpPT0nYF6yeYSN8xKrfXhpraI2Rs4ZvKSSfk_5it5" alt="" id="heroBgImg"/>
    <div class="hero-overlay"></div>
  </div>
  <div class="aurora">
    <div class="aurora-blob aurora-blob-1"></div>
    <div class="aurora-blob aurora-blob-2"></div>
    <div class="aurora-blob aurora-blob-3"></div>
  </div>

  <div class="hero-content">
    <div class="hero-eyebrow">
      <div class="hero-eyebrow-dot"></div>
      Baru — Portal laporan harian dan weekly report
    </div>
    <h1 class="hero-title">
      Kelola aktivitas<br/>
      <span class="accent">harian tim</span><br/>
      jadi weekly report rapi
    </h1>
    <p class="hero-sub">
      Catat aktivitas harian, pantau status pekerjaan, lalu gabungkan semua data akun menjadi laporan mingguan yang siap diunduh sebagai Word atau PDF.
    </p>
    <div class="hero-cta">
      <a href="<?php echo e(route('login')); ?>" class="btn-hero-primary" style="text-decoration:none;">
        Masuk ke Dashboard
        <span class="material-symbols-outlined" style="font-size:20px">arrow_forward</span>
      </a>
      <button class="btn-hero-secondary" onclick="document.getElementById('workflow').scrollIntoView({behavior:'smooth'})">
        <span class="material-symbols-outlined" style="font-size:20px">play_circle</span>
        Lihat alur kerja
      </button>
    </div>
    <div class="hero-stats">
      <div class="stat-item">
        <div class="stat-num"><span class="count-up" data-target="5000" data-suffix="+">0</span></div>
        <div class="stat-label">User aktif</div>
      </div>
      <div class="stat-item">
        <div class="stat-num"><span class="count-up" data-target="98" data-suffix="%">0</span></div>
        <div class="stat-label">Waktu rekap tersimpan</div>
      </div>
      <div class="stat-item">
        <div class="stat-num"><span class="count-up" data-target="4.9" data-suffix="★" data-decimals="1">0</span></div>
        <div class="stat-label">Export siap pakai</div>
      </div>
    </div>
  </div>

  <div class="scroll-hint">
    <div class="scroll-hint-text">Scroll</div>
    <div class="scroll-hint-line"></div>
  </div>
</section>

<!-- FEATURES -->
<section class="features-section" id="features">
  <div class="features-header">
    <div class="reveal">
      <span class="section-label">Fitur Utama</span>
      <h2 class="section-title">Satu platform,<br/>untuk input, review, dan export laporan.</h2>
    </div>
    <p class="section-sub reveal reveal-delay-1">Dirancang untuk tim yang butuh pencatatan harian yang cepat, ringkasan mingguan yang rapi, dan akses admin yang jelas.</p>
  </div>
  <div class="features-grid">
    <div class="feature-card reveal reveal-delay-1">
      <div class="feature-icon feature-icon-blue">
        <span class="material-symbols-outlined">edit_note</span>
      </div>
      <div class="feature-tag">Input</div>
      <div class="feature-title">Input Aktivitas Harian</div>
      <p class="feature-desc">Isi aktivitas per hari dengan status, keterangan, dan hasil kerja agar weekly report langsung terbentuk dari data nyata.</p>
    </div>
    <div class="feature-card purple-glow reveal reveal-delay-2">
      <div class="feature-icon feature-icon-purple">
        <span class="material-symbols-outlined">auto_awesome</span>
      </div>
      <div class="feature-tag" style="color:#c27fff;background:rgba(167,89,197,0.12)">Report</div>
      <div class="feature-title">Rekap Weekly Otomatis</div>
      <p class="feature-desc">Seluruh aktivitas dalam satu akun akan dirangkum ke weekly report mingguan dan siap diekspor sebagai DOCX atau PDF.</p>
    </div>
    <div class="feature-card reveal reveal-delay-3">
      <div class="feature-icon feature-icon-green">
        <span class="material-symbols-outlined">chat</span>
      </div>
      <div class="feature-tag" style="color:#3ecf8e;background:rgba(29,158,117,0.12)">Role</div>
      <div class="feature-title">Akses User & Admin</div>
      <p class="feature-desc">User fokus input harian, admin fokus monitoring, user management, dan system report dalam satu portal yang sama.</p>
    </div>
  </div>
</section>

<!-- SHOWCASE -->
<section class="showcase-section" id="showoff">
  <div class="showcase-inner">
    <div class="showcase-header reveal">
      <span class="section-label">Dashboard</span>
      <h2 class="section-title">Tampilan yang dibuat<br/>untuk kerja tim nyata</h2>
    </div>
    <div class="showcase-img-wrap reveal">
      <div class="showcase-img-glow"></div>
      
 <img src="<?php echo e(asset('assets/img/logosite.png')); ?>" alt="Logo">
      <!-- floating badges -->
      <div class="float-badge badge-1">
        <div class="badge-icon badge-icon-green">
          <span class="material-symbols-outlined">trending_up</span>
        </div>
        <div>
          <div class="badge-text">+32% aktivitas masuk</div>
          <div class="badge-sub">vs minggu lalu</div>
        </div>
      </div>
      <div class="float-badge badge-2">
        <div class="badge-icon badge-icon-blue">
          <span class="material-symbols-outlined">auto_awesome</span>
        </div>
        <div>
          <div class="badge-text">DOCX / PDF Ready</div>
          <div class="badge-sub">dari data harian</div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- WORKFLOW -->
<section class="workflow-section" id="workflow">
  <div class="workflow-inner">
    <div class="workflow-header reveal">
      <span class="section-label">Alur Kerja</span>
      <h2 class="section-title">Tiga langkah menuju<br/>weekly report yang rapi.</h2>
    </div>
    <div class="workflow-steps">
      <div class="workflow-step reveal reveal-delay-1">
        <div class="step-num">1</div>
        <div class="step-icon"><span class="material-symbols-outlined">input</span></div>
        <div class="step-title">Input Harian</div>
        <p class="step-desc">User mengisi aktivitas harian lewat form yang cepat di desktop maupun mobile.</p>
      </div>
      <div class="workflow-step reveal reveal-delay-2">
        <div class="step-num">2</div>
        <div class="step-icon"><span class="material-symbols-outlined">analytics</span></div>
        <div class="step-title">Rekap Otomatis</div>
        <p class="step-desc">Data yang masuk langsung dikumpulkan per minggu, per user, dan siap diringkas untuk admin.</p>
      </div>
      <div class="workflow-step reveal reveal-delay-3">
        <div class="step-num">3</div>
        <div class="step-icon"><span class="material-symbols-outlined">verified</span></div>
        <div class="step-title">Export</div>
        <p class="step-desc">Weekly report bisa dibuka sebagai print view untuk PDF atau diunduh sebagai file Word template perusahaan.</p>
      </div>
    </div>
  </div>
</section>

<!-- CTA -->
<section class="cta-section" id="cta">
  <div class="cta-card reveal">
    <div class="cta-grid-overlay"></div>
    <div class="cta-badge">
      <span class="material-symbols-outlined" style="font-size:14px">bolt</span>
      Siap dipakai tim kerja
    </div>
    <h2 class="cta-title">Siap rapikan report tim?</h2>
    <p class="cta-desc">Masuk ke portal, input aktivitas harian, dan biarkan weekly report tersusun dari data nyata yang kamu kirim setiap hari.</p>
    <div class="cta-actions">
      <a href="<?php echo e(route('login')); ?>" class="btn-cta" style="text-decoration:none;">
        Masuk Sekarang
        <span class="material-symbols-outlined" style="font-size:20px">arrow_forward</span>
      </a>
    </div>
  </div>
</section>

<!-- FOOTER -->
<footer class="footer">
  <div class="footer-inner">
    <div class="footer-logo">WeeklyReport</div>
    <div class="footer-links">
      <a href="#">Privasi</a>
      <a href="#">Syarat &amp; Ketentuan</a>
      <a href="#">Bantuan</a>
      <a href="#">Kontak</a>
    </div>
    <div class="footer-copy">© 2026 WeeklyReport. Daily activity to weekly report.</div>
  </div>
</footer>

<script>
  // ── NAV SCROLL ──
  const nav = document.getElementById('mainNav');
  window.addEventListener('scroll', () => {
    nav.classList.toggle('scrolled', window.scrollY > 40);
  }, { passive: true });

  // ── HERO BG KEN BURNS ──
  const heroBg = document.getElementById('heroBgImg');
  heroBg.addEventListener('load', () => heroBg.classList.add('loaded'));
  if (heroBg.complete) heroBg.classList.add('loaded');

  // ── INTERSECTION OBSERVER – REVEAL ──
  const revealEls = document.querySelectorAll('.reveal');
  const revealObs = new IntersectionObserver((entries) => {
    entries.forEach(e => { if (e.isIntersecting) { e.target.classList.add('visible'); } });
  }, { threshold: 0.12, rootMargin: '0px 0px -60px 0px' });
  revealEls.forEach(el => revealObs.observe(el));

  // ── COUNT UP ──
  function countUp(el) {
    const target = parseFloat(el.dataset.target);
    const suffix = el.dataset.suffix || '';
    const decimals = parseInt(el.dataset.decimals || '0');
    const duration = 1600;
    const start = performance.now();
    function frame(now) {
      const progress = Math.min((now - start) / duration, 1);
      const eased = 1 - Math.pow(1 - progress, 3);
      const val = eased * target;
      el.textContent = (decimals ? val.toFixed(decimals) : Math.round(val)) + suffix;
      if (progress < 1) requestAnimationFrame(frame);
    }
    requestAnimationFrame(frame);
  }
  const statsSection = document.querySelector('.hero-stats');
  let counted = false;
  const countObs = new IntersectionObserver(([e]) => {
    if (e.isIntersecting && !counted) {
      counted = true;
      document.querySelectorAll('.count-up').forEach(countUp);
    }
  }, { threshold: 0.5 });
  if (statsSection) countObs.observe(statsSection);

  // ── PARALLAX HERO BG ──
  window.addEventListener('scroll', () => {
    const y = window.scrollY;
    const bg = document.querySelector('.hero-bg img');
    if (bg && y < window.innerHeight * 1.2) {
      bg.style.transform = `scale(1) translateY(${y * 0.25}px)`;
    }
  }, { passive: true });

  // ── FEATURE CARD MOUSE TILT ──
  document.querySelectorAll('.feature-card').forEach(card => {
    card.addEventListener('mousemove', e => {
      const rect = card.getBoundingClientRect();
      const cx = rect.left + rect.width / 2;
      const cy = rect.top + rect.height / 2;
      const dx = (e.clientX - cx) / (rect.width / 2);
      const dy = (e.clientY - cy) / (rect.height / 2);
      card.style.transform = `translateY(-4px) rotateX(${-dy * 4}deg) rotateY(${dx * 4}deg)`;
    });
    card.addEventListener('mouseleave', () => {
      card.style.transform = '';
    });
  });
</script>
</body>
</html>
<?php /**PATH /Users/rizkihiibrahim/Downloads/folder tanpa judul/projects/weekly-report/resources/views/welcome.blade.php ENDPATH**/ ?>