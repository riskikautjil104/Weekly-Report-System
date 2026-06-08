<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
        <title><?php echo e(config('app.name', 'WeeklyReport')); ?></title>
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800&display=swap" rel="stylesheet" />
        <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet">
        <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>
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
        <style>
            .material-symbols-outlined {
                font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
            }
        </style>
    </head>
    <body class="min-h-screen bg-[#0a0b0d] font-sans text-[#e2e2e4] antialiased">
        <div class="relative min-h-screen overflow-hidden">
            <div class="absolute inset-0" style="background-image: radial-gradient(circle at top right, rgba(0,67,235,0.22), transparent 32%), radial-gradient(circle at bottom left, rgba(167,89,197,0.18), transparent 30%), linear-gradient(115deg, #0a0b0d 0%, #0f1114 50%, #08090b 100%);"></div>
            <div class="absolute -left-28 top-24 h-80 w-80 rounded-full bg-[#0043eb]/20 blur-3xl"></div>
            <div class="absolute -right-20 top-1/2 h-96 w-96 rounded-full bg-[#a759c5]/20 blur-3xl"></div>
            <div class="absolute inset-0" style="background-image: url('data:image/svg+xml,%3Csvg viewBox=%220 0 256 256%22 xmlns=%22http://www.w3.org/2000/svg%22%3E%3Cfilter id=%22noise%22%3E%3CfeTurbulence type=%22fractalNoise%22 baseFrequency=%220.9%22 numOctaves=%224%22 stitchTiles=%22stitch%22/%3E%3C/filter%3E%3Crect width=%22100%25%22 height=%22100%25%22 filter=%22url(%23noise)%22 opacity=%220.04%22/%3E%3C/svg%3E'); opacity: 0.4;"></div>

            <header class="relative z-10 mx-auto flex w-full max-w-7xl items-center justify-between px-6 py-6 lg:px-8">
                <a href="<?php echo e(url('/')); ?>" class="inline-flex items-center gap-3 text-sm font-semibold tracking-[0.08em] text-[#e2e2e4]">
                    <span class="inline-flex h-10 w-10 items-center justify-center rounded-2xl border border-white/10 bg-white/5 text-[#b8c3ff] shadow-lg shadow-black/20">
                        WR
                    </span>
                    <span class="flex flex-col leading-tight">
                        <span>WeeklyReport</span>
                        <span class="text-[11px] font-medium tracking-[0.24em] text-white/60">REVOLUSI PRODUKTIVITAS TIM</span>
                    </span>
                </a>
                <a href="<?php echo e(url('/')); ?>" class="inline-flex items-center gap-2 rounded-full border border-white/10 bg-white/5 px-4 py-2 text-sm font-medium text-white/75 backdrop-blur transition hover:bg-white/10 hover:text-white">
                    <span class="material-symbols-outlined text-[18px]">arrow_back</span>
                    Home
                </a>
            </header>

            <main class="relative z-10 mx-auto grid min-h-[calc(100vh-88px)] max-w-7xl items-center gap-10 px-6 pb-10 pt-4 lg:grid-cols-[1.05fr_0.95fr] lg:px-8">
                <section class="max-w-2xl">
                    <p class="mb-5 inline-flex items-center gap-2 rounded-full border border-[#0043eb]/20 bg-[#0043eb]/10 px-4 py-2 text-xs font-semibold uppercase tracking-[0.14em] text-[#b8c3ff]">
                        <span class="h-2 w-2 rounded-full bg-[#4d8aff]"></span>
                        Secure access portal
                    </p>
                    <h1 class="max-w-xl text-5xl font-extrabold tracking-tight text-[#f3f4f6] sm:text-6xl">
                        Masuk ke ruang kerja weekly report yang lebih rapi.
                    </h1>
                    <p class="mt-5 max-w-xl text-base leading-7 text-white/70">
                        Login untuk input aktivitas harian, memantau laporan mingguan, dan mengunduh format perusahaan tanpa harus pindah-pindah aplikasi.
                    </p>

                    <div class="mt-10 grid gap-4 sm:grid-cols-2">
                        <div class="rounded-3xl border border-white/10 bg-white/5 p-5 backdrop-blur">
                            <p class="text-xs font-semibold uppercase tracking-[0.22em] text-[#b8c3ff]">Quick Access</p>
                            <p class="mt-3 text-lg font-semibold text-white">User dashboard, system report, dan file export.</p>
                        </div>
                        <div class="rounded-3xl border border-white/10 bg-white/5 p-5 backdrop-blur">
                            <p class="text-xs font-semibold uppercase tracking-[0.22em] text-[#b8c3ff]">Designed for teams</p>
                            <p class="mt-3 text-lg font-semibold text-white">Satu tempat untuk kerja harian dan rekap mingguan.</p>
                        </div>
                    </div>
                </section>

                <section class="lg:justify-self-end">
                    <div class="rounded-[28px] border border-white/10 bg-white/10 p-6 shadow-2xl shadow-black/40 backdrop-blur-xl sm:p-8">
                        <?php echo e($slot); ?>

                    </div>
                </section>
            </main>
        </div>
    </body>
</html>
<?php /**PATH /Users/rizkihiibrahim/Downloads/weekly_report/projects/weekly-report/resources/views/layouts/guest.blade.php ENDPATH**/ ?>