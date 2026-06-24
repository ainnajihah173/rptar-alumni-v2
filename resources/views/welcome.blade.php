<!DOCTYPE html>
<html lang="ms">
<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>Portal RPTAR Alumni</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Sora:wght@300;400;600;700;800&family=DM+Sans:ital,wght@0,300;0,400;0,500;1,300&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        :root {
            --red: #a12c2f;
            --red-deep: #7a1f22;
            --red-muted: #c9494d;
            --ink: #141010;
            --ink-soft: #2e2424;
            --sand: #f5f0eb;
            --sand-deep: #ede6dd;
            --cream: #faf8f5;
            --white: #ffffff;
            --text-muted: #7a706a;
            --ease: cubic-bezier(0.25, 0.46, 0.45, 0.94);
        }

        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        html { scroll-behavior: smooth; }

        body {
            font-family: 'DM Sans', sans-serif;
            background: var(--cream);
            color: var(--ink);
            overflow-x: hidden;
        }

        h1, h2, h3, h4, .display { font-family: 'Sora', sans-serif; }

        /* ─── NAV ─────────────────────────────────── */
        nav {
            position: fixed;
            top: 0; left: 0; right: 0;
            z-index: 100;
            padding: 28px 0;
            transition: all 0.5s var(--ease);
        }
        nav.scrolled {
            background: rgba(250, 248, 245, 0.94);
            backdrop-filter: blur(18px);
            padding: 16px 0;
            border-bottom: 1px solid rgba(161,44,47,0.12);
        }
        .nav-inner {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 40px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        .nav-logo {
            font-family: 'Sora', sans-serif;
            font-weight: 800;
            font-size: 1.25rem;
            color: white;
            text-decoration: none;
            letter-spacing: -0.5px;
            transition: color 0.4s;
        }
        nav.scrolled .nav-logo { color: var(--ink); }
        .nav-logo span { color: var(--red-muted); font-weight: 300; }
        nav.scrolled .nav-logo span { color: var(--red); }

        .nav-links {
            display: flex;
            gap: 36px;
            list-style: none;
        }
        .nav-links a {
            font-size: 0.9rem;
            font-weight: 500;
            color: rgba(255,255,255,0.85);
            text-decoration: none;
            letter-spacing: 0.02em;
            transition: color 0.3s;
        }
        nav.scrolled .nav-links a { color: var(--ink-soft); }
        .nav-links a:hover { color: var(--red-muted) !important; }

        .nav-cta {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: var(--red);
            color: white;
            padding: 11px 24px;
            border-radius: 100px;
            font-family: 'Sora', sans-serif;
            font-size: 0.85rem;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.3s var(--ease);
            letter-spacing: 0.02em;
        }
        .nav-cta:hover {
            background: var(--red-deep);
            color: white;
            transform: translateY(-1px);
            box-shadow: 0 8px 24px rgba(161,44,47,0.35);
        }

        /* ─── HERO ────────────────────────────────── */
        .hero {
            min-height: 100vh;
            position: relative;
            display: flex;
            align-items: center;
            overflow: hidden;
            background: var(--ink);
        }

        /* Islamic geometric SVG pattern — the signature element */
        .hero-pattern {
            position: absolute;
            inset: 0;
            opacity: 0.06;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='80' height='80'%3E%3Cg fill='none' stroke='%23ffffff' stroke-width='0.8'%3E%3Cpolygon points='40,4 76,22 76,58 40,76 4,58 4,22'/%3E%3Cpolygon points='40,16 64,28 64,52 40,64 16,52 16,28'/%3E%3Cline x1='40' y1='4' x2='40' y2='16'/%3E%3Cline x1='76' y1='22' x2='64' y2='28'/%3E%3Cline x1='76' y1='58' x2='64' y2='52'/%3E%3Cline x1='40' y1='76' x2='40' y2='64'/%3E%3Cline x1='4' y1='58' x2='16' y2='52'/%3E%3Cline x1='4' y1='22' x2='16' y2='28'/%3E%3C/g%3E%3C/svg%3E");
            background-size: 80px 80px;
        }

        /* Diagonal photo panel — the layout signature */
        .hero-photo {
            position: absolute;
            top: 0; right: 0;
            width: 52%;
            height: 100%;
            clip-path: polygon(15% 0%, 100% 0%, 100% 100%, 0% 100%);
            overflow: hidden;
        }
        .hero-photo img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            opacity: 0.45;
            filter: grayscale(30%);
        }
        .hero-photo::after {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(to right, var(--ink) 0%, transparent 60%);
        }

        .hero-content {
            position: relative;
            z-index: 2;
            max-width: 1200px;
            margin: 0 auto;
            padding: 120px 40px 80px;
            width: 100%;
        }

        .hero-eyebrow {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 32px;
            opacity: 0;
            animation: fadeUp 0.8s var(--ease) 0.2s forwards;
        }
        .hero-eyebrow-line {
            width: 40px;
            height: 2px;
            background: var(--red-muted);
        }
        .hero-eyebrow span {
            font-size: 0.8rem;
            font-weight: 600;
            letter-spacing: 0.15em;
            text-transform: uppercase;
            color: var(--red-muted);
        }

        .hero h1 {
            font-size: clamp(3rem, 6vw, 5.5rem);
            font-weight: 800;
            color: white;
            line-height: 1.0;
            letter-spacing: -2px;
            max-width: 640px;
            margin-bottom: 28px;
            opacity: 0;
            animation: fadeUp 0.9s var(--ease) 0.35s forwards;
        }
        .hero h1 em {
            font-style: normal;
            color: var(--red-muted);
        }

        .hero-sub {
            font-size: 1.15rem;
            color: rgba(255,255,255,0.6);
            max-width: 480px;
            line-height: 1.7;
            margin-bottom: 48px;
            font-weight: 300;
            opacity: 0;
            animation: fadeUp 0.9s var(--ease) 0.5s forwards;
        }

        .hero-actions {
            display: flex;
            gap: 16px;
            align-items: center;
            flex-wrap: wrap;
            opacity: 0;
            animation: fadeUp 0.9s var(--ease) 0.65s forwards;
        }

        .btn-primary-hero {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            background: var(--red);
            color: white;
            padding: 16px 32px;
            border-radius: 100px;
            font-family: 'Sora', sans-serif;
            font-size: 0.95rem;
            font-weight: 700;
            text-decoration: none;
            transition: all 0.3s var(--ease);
        }
        .btn-primary-hero:hover {
            background: var(--red-deep);
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 12px 32px rgba(161,44,47,0.45);
        }
        .btn-ghost-hero {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            color: rgba(255,255,255,0.7);
            font-size: 0.95rem;
            font-weight: 500;
            text-decoration: none;
            border-bottom: 1px solid rgba(255,255,255,0.25);
            padding-bottom: 2px;
            transition: all 0.3s;
        }
        .btn-ghost-hero:hover { color: white; border-color: white; }

        .hero-quote {
            margin-top: 64px;
            max-width: 520px;
            padding: 24px 28px;
            border-left: 3px solid var(--red);
            opacity: 0;
            animation: fadeUp 0.9s var(--ease) 0.8s forwards;
        }
        .hero-quote p {
            font-size: 0.95rem;
            color: rgba(255,255,255,0.55);
            font-style: italic;
            line-height: 1.7;
            font-weight: 300;
            margin-bottom: 8px;
        }
        .hero-quote cite {
            font-size: 0.8rem;
            color: rgba(255,255,255,0.35);
            font-style: normal;
            letter-spacing: 0.05em;
        }

        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(24px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        /* ─── TICKER / STATS ──────────────────────── */
        .stats-bar {
            background: var(--red);
            padding: 0;
            overflow: hidden;
        }
        .stats-track {
            display: flex;
            padding: 20px 0;
        }
        .stat-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 0 60px;
            white-space: nowrap;
            flex-shrink: 0;
        }
        .stat-num {
            font-family: 'Sora', sans-serif;
            font-size: 1.6rem;
            font-weight: 800;
            color: white;
            letter-spacing: -1px;
        }
        .stat-label {
            font-size: 0.8rem;
            color: rgba(255,255,255,0.6);
            font-weight: 400;
            line-height: 1.4;
        }
        .stat-divider {
            width: 1px;
            height: 32px;
            background: rgba(255,255,255,0.2);
            flex-shrink: 0;
        }

        /* ─── SECTION SHARED ─────────────────────── */
        .section-label {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 16px;
        }
        .section-label-dot {
            width: 8px;
            height: 8px;
            background: var(--red);
            border-radius: 50%;
        }
        .section-label span {
            font-size: 0.75rem;
            font-weight: 700;
            letter-spacing: 0.15em;
            text-transform: uppercase;
            color: var(--red);
        }
        .section-h2 {
            font-size: clamp(2rem, 4vw, 3rem);
            font-weight: 800;
            color: var(--ink);
            letter-spacing: -1px;
            line-height: 1.1;
        }

        /* ─── ABOUT ───────────────────────────────── */
        .about {
            padding: 120px 0;
            background: var(--cream);
        }
        .about-grid {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 40px;
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 80px;
            align-items: center;
        }
        .about-visual {
            position: relative;
        }
        .about-img-main {
            width: 100%;
            border-radius: 24px;
            aspect-ratio: 4/5;
            object-fit: cover;
            display: block;
            background: var(--sand-deep);
        }
        .about-img-placeholder {
            width: 100%;
            border-radius: 24px;
            aspect-ratio: 4/5;
            background: var(--sand-deep);
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .about-badge {
            position: absolute;
            bottom: -20px;
            right: -20px;
            background: var(--red);
            color: white;
            padding: 24px 28px;
            border-radius: 20px;
            font-family: 'Sora', sans-serif;
        }
        .about-badge-num {
            font-size: 2.5rem;
            font-weight: 800;
            letter-spacing: -2px;
            display: block;
            line-height: 1;
        }
        .about-badge-text {
            font-size: 0.78rem;
            font-weight: 400;
            opacity: 0.7;
            margin-top: 4px;
        }
        .about-body {
            padding-left: 20px;
        }
        .about-body p {
            font-size: 1.05rem;
            color: var(--text-muted);
            line-height: 1.8;
            margin-bottom: 20px;
            font-weight: 300;
        }
        .about-pillars {
            margin-top: 40px;
            display: flex;
            flex-direction: column;
            gap: 16px;
        }
        .pillar {
            display: flex;
            align-items: flex-start;
            gap: 16px;
        }
        .pillar-icon {
            width: 44px;
            height: 44px;
            background: var(--sand-deep);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }
        .pillar-icon svg { color: var(--red); }
        .pillar-text h4 {
            font-family: 'Sora', sans-serif;
            font-size: 0.95rem;
            font-weight: 700;
            color: var(--ink);
            margin-bottom: 4px;
        }
        .pillar-text p {
            font-size: 0.88rem;
            color: var(--text-muted);
            margin: 0;
            line-height: 1.6;
        }

        /* ─── DONATIONS ──────────────────────────── */
        .donations {
            padding: 120px 0;
            background: var(--ink);
            position: relative;
            overflow: hidden;
        }
        .donations-pattern {
            position: absolute;
            inset: 0;
            opacity: 0.04;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='80' height='80'%3E%3Cg fill='none' stroke='%23ffffff' stroke-width='0.8'%3E%3Cpolygon points='40,4 76,22 76,58 40,76 4,58 4,22'/%3E%3Cpolygon points='40,16 64,28 64,52 40,64 16,52 16,28'/%3E%3Cline x1='40' y1='4' x2='40' y2='16'/%3E%3Cline x1='76' y1='22' x2='64' y2='28'/%3E%3Cline x1='76' y1='58' x2='64' y2='52'/%3E%3Cline x1='40' y1='76' x2='40' y2='64'/%3E%3Cline x1='4' y1='58' x2='16' y2='52'/%3E%3Cline x1='4' y1='22' x2='16' y2='28'/%3E%3C/g%3E%3C/svg%3E");
            background-size: 80px 80px;
        }
        .donations-inner {
            position: relative;
            z-index: 1;
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 40px;
        }
        .donations-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
            margin-bottom: 60px;
            flex-wrap: wrap;
            gap: 24px;
        }
        .donations-header .section-label span { color: var(--red-muted); }
        .donations-header .section-h2 { color: white; }

        .donations-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
            gap: 24px;
        }

        .don-card {
            background: rgba(255,255,255,0.05);
            border: 1px solid rgba(255,255,255,0.08);
            border-radius: 24px;
            overflow: hidden;
            transition: all 0.4s var(--ease);
        }
        .don-card:hover {
            background: rgba(255,255,255,0.08);
            border-color: rgba(161,44,47,0.35);
            transform: translateY(-6px);
        }
        .don-img {
            height: 220px;
            overflow: hidden;
            position: relative;
        }
        .don-img-placeholder {
            width: 100%;
            height: 100%;
            background: rgba(255,255,255,0.05);
            display: flex;
            align-items: center;
            justify-content: center;
            color: rgba(255,255,255,0.15);
            font-size: 3rem;
        }
        .don-img img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.6s var(--ease);
        }
        .don-card:hover .don-img img { transform: scale(1.06); }

        .don-body { padding: 28px; }
        .don-title {
            font-family: 'Sora', sans-serif;
            font-size: 1.1rem;
            font-weight: 700;
            color: white;
            margin-bottom: 20px;
            line-height: 1.3;
        }
        .don-progress-track {
            height: 4px;
            background: rgba(255,255,255,0.1);
            border-radius: 4px;
            margin-bottom: 12px;
            overflow: hidden;
        }
        .don-progress-fill {
            height: 100%;
            background: var(--red);
            border-radius: 4px;
            transition: width 1s var(--ease);
        }
        .don-amounts {
            display: flex;
            justify-content: space-between;
            margin-bottom: 24px;
        }
        .don-current {
            font-family: 'Sora', sans-serif;
            font-size: 1rem;
            font-weight: 700;
            color: white;
        }
        .don-target {
            font-size: 0.82rem;
            color: rgba(255,255,255,0.4);
        }
        .don-cta {
            display: block;
            text-align: center;
            background: transparent;
            border: 1px solid rgba(161,44,47,0.5);
            color: var(--red-muted);
            padding: 13px;
            border-radius: 12px;
            font-family: 'Sora', sans-serif;
            font-size: 0.88rem;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.3s var(--ease);
            letter-spacing: 0.03em;
        }
        .don-cta:hover {
            background: var(--red);
            border-color: var(--red);
            color: white;
        }

        /* ─── EVENTS ─────────────────────────────── */
        .events {
            padding: 120px 0;
            background: var(--sand);
        }
        .events-inner {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 40px;
        }
        .events-header {
            margin-bottom: 60px;
        }
        .events-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(340px, 1fr));
            gap: 24px;
        }
        .event-card {
            background: white;
            border-radius: 24px;
            overflow: hidden;
            transition: all 0.4s var(--ease);
            border: 1px solid transparent;
        }
        .event-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 24px 60px rgba(20,16,16,0.1);
            border-color: rgba(161,44,47,0.1);
        }
        .event-img {
            height: 240px;
            overflow: hidden;
            position: relative;
        }
        .event-img img {
            width: 100%; height: 100%;
            object-fit: cover;
            transition: transform 0.6s var(--ease);
        }
        .event-card:hover .event-img img { transform: scale(1.06); }
        .event-img-placeholder {
            width: 100%; height: 100%;
            background: var(--sand-deep);
            display: flex; align-items: center; justify-content: center;
            color: var(--text-muted); font-size: 2.5rem;
        }
        .event-date-badge {
            position: absolute;
            top: 16px; left: 16px;
            background: var(--red);
            color: white;
            padding: 8px 14px;
            border-radius: 10px;
            font-family: 'Sora', sans-serif;
            font-size: 0.78rem;
            font-weight: 700;
            letter-spacing: 0.03em;
        }
        .event-body { padding: 28px; }
        .event-title {
            font-family: 'Sora', sans-serif;
            font-size: 1.05rem;
            font-weight: 700;
            color: var(--ink);
            margin-bottom: 10px;
            line-height: 1.35;
        }
        .event-loc {
            display: flex;
            align-items: center;
            gap: 6px;
            font-size: 0.85rem;
            color: var(--text-muted);
            margin-bottom: 20px;
        }
        .event-link {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            font-family: 'Sora', sans-serif;
            font-size: 0.82rem;
            font-weight: 700;
            color: var(--red);
            text-decoration: none;
            letter-spacing: 0.05em;
            text-transform: uppercase;
            transition: gap 0.3s;
        }
        .event-link:hover { gap: 10px; color: var(--red-deep); }

        /* ─── CONTACT ────────────────────────────── */
        .contact {
            padding: 120px 0;
            background: var(--cream);
        }
        .contact-inner {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 40px;
            display: grid;
            grid-template-columns: 1fr 1.4fr;
            gap: 80px;
            align-items: start;
        }
        .contact-info {}
        .contact-info-items { margin-top: 44px; display: flex; flex-direction: column; gap: 24px; }
        .contact-item {
            display: flex;
            gap: 16px;
            align-items: flex-start;
        }
        .contact-icon {
            width: 48px;
            height: 48px;
            background: var(--sand-deep);
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            color: var(--red);
        }
        .contact-item-label {
            font-family: 'Sora', sans-serif;
            font-size: 0.8rem;
            font-weight: 700;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            color: var(--red);
            margin-bottom: 4px;
        }
        .contact-item-value {
            font-size: 0.95rem;
            color: var(--ink-soft);
            line-height: 1.6;
        }
        .map-frame {
            border-radius: 24px;
            overflow: hidden;
            box-shadow: 0 20px 60px rgba(20,16,16,0.08);
        }
        .map-frame iframe { display: block; }

        /* ─── FOOTER ─────────────────────────────── */
        footer {
            background: var(--ink);
            padding: 60px 0 40px;
        }
        .footer-inner {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 40px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 24px;
        }
        .footer-logo {
            font-family: 'Sora', sans-serif;
            font-size: 1.4rem;
            font-weight: 800;
            color: white;
            letter-spacing: -0.5px;
        }
        .footer-logo span { color: var(--red-muted); font-weight: 300; }
        .footer-copy {
            font-size: 0.82rem;
            color: rgba(255,255,255,0.3);
        }

        /* ─── MOBILE ─────────────────────────────── */
        @media (max-width: 768px) {
            .hero-photo { display: none; }
            .hero h1 { font-size: 2.8rem; }
            .about-grid { grid-template-columns: 1fr; gap: 40px; }
            .about-body { padding-left: 0; }
            .contact-inner { grid-template-columns: 1fr; gap: 48px; }
            .nav-links { display: none; }
            .nav-inner { padding: 0 20px; }
            .hero-content { padding: 100px 20px 60px; }
            .about, .donations, .events, .contact { padding: 80px 0; }
            .about-grid, .donations-inner, .events-inner, .contact-inner { padding: 0 20px; }
        }

        /* scroll reveal */
        .reveal {
            opacity: 0;
            transform: translateY(32px);
            transition: opacity 0.8s var(--ease), transform 0.8s var(--ease);
        }
        .reveal.visible {
            opacity: 1;
            transform: none;
        }
    </style>
</head>
<body>

<!-- NAV -->
<nav id="nav">
    <div class="nav-inner">
        <a href="#" class="nav-logo">RPTAR <span>Alumni</span></a>
        <ul class="nav-links">
            <li><a href="#tentang">Tentang</a></li>
            <li><a href="#derma">Derma</a></li>
            <li><a href="#acara">Acara</a></li>
            <li><a href="#hubungi">Hubungi</a></li>
        </ul>
        <a href="{{ route('login') }}" class="nav-cta">Log Masuk →</a>
    </div>
</nav>

<!-- HERO -->
<section class="hero" id="hero">
    <div class="hero-pattern"></div>
    <div class="hero-photo">
        <img src="assets/images/slide3.jpg" alt="Rumah Penyayang Tun Abdul Razak">
    </div>
    <div class="hero-content">
        <div class="hero-eyebrow">
            <div class="hero-eyebrow-line"></div>
            <span>Portal Alumni Rasmi</span>
        </div>
        <h1>Hubungan<br><em>Abadi</em></h1>
        <p class="hero-sub">Rumah Penyayang Tun Abdul Razak — tempat kita membesar, tempat kita kembali. Bersama kami membina masa depan anak-anak amanah.</p>
        <div class="hero-actions">
            <a href="#derma" class="btn-primary-hero">Sumbang Sekarang</a>
            <a href="#tentang" class="btn-ghost-hero">Ketahui lebih lanjut ↓</a>
        </div>
        <div class="hero-quote">
            <p>"Barangsiapa yang memelihara anak yatim dan memberinya makan dan minum, nescaya Allah akan memasukkannya ke dalam syurga..."</p>
            <cite>— Riwayat al-Tirmidzi</cite>
        </div>
    </div>
</section>

<!-- STATS BAR -->
<div class="stats-bar">
    <div class="stats-track" id="stats-track">
        <div class="stat-item">
            <div>
                <div class="stat-num">100+</div>
                <div class="stat-label">Penghuni Aktif</div>
            </div>
        </div>
        <div class="stat-divider"></div>
        <div class="stat-item">
            <div>
                <div class="stat-num">2005</div>
                <div class="stat-label">Tahun Beroperasi</div>
            </div>
        </div>
        <div class="stat-divider"></div>
        <div class="stat-item">
            <div>
                <div class="stat-num">RM 2.5M</div>
                <div class="stat-label">Nilai Pembangunan</div>
            </div>
        </div>
        <div class="stat-divider"></div>
        <div class="stat-item">
            <div>
                <div class="stat-num">Pahang</div>
                <div class="stat-label">Pekan, Malaysia</div>
            </div>
        </div>
    </div>
</div>

<!-- ABOUT -->
<section class="about" id="tentang">
    <div class="about-grid">
        <div class="about-visual reveal">
            <div class="about-img-placeholder">
                <svg width="80" height="80" viewBox="0 0 80 80" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <rect width="80" height="80" rx="8" fill="none"/>
                    <path d="M40 8C22.3 8 8 22.3 8 40s14.3 32 32 32 32-14.3 32-32S57.7 8 40 8zm0 12c5.5 0 10 4.5 10 10s-4.5 10-10 10-10-4.5-10-10 4.5-10 10-10zm0 46c-8 0-15.1-3.9-19.6-10 .1-6.5 13.1-10.1 19.6-10.1s19.5 3.6 19.6 10.1C55.1 62.1 48 66 40 66z" fill="rgba(161,44,47,0.15)"/>
                </svg>
            </div>
            <div class="about-badge">
                <span class="about-badge-num">20+</span>
                <div class="about-badge-text">Tahun berkhidmat</div>
            </div>
        </div>
        <div class="about-body reveal">
            <div class="section-label">
                <div class="section-label-dot"></div>
                <span>Tentang Kami</span>
            </div>
            <h2 class="section-h2" style="margin-bottom: 24px;">Membina generasi<br>yang bermaruah</h2>
            <p>Rumah Penyayang Tun Abdul Razak (RPTAR) adalah sebuah institusi yang menjaga, mendidik, dan memberdayakan anak-anak amanah sejak tahun 2005. Kami percaya setiap kanak-kanak berhak mendapat kasih sayang, pendidikan, dan peluang.</p>
            <p>Portal alumni ini menghubungkan semula mereka yang pernah menjadi sebahagian daripada keluarga RPTAR — supaya ikatan itu tidak pernah putus.</p>
            <div class="about-pillars">
                <div class="pillar">
                    <div class="pillar-icon">
                        <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" color="#a12c2f">
                            <path d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                        </svg>
                    </div>
                    <div class="pillar-text">
                        <h4>Kasih Sayang & Penjagaan</h4>
                        <p>Persekitaran yang selamat, penuh kasih untuk setiap kanak-kanak berkembang dengan jayanya.</p>
                    </div>
                </div>
                <div class="pillar">
                    <div class="pillar-icon">
                        <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" color="#a12c2f">
                            <path d="M12 14l9-5-9-5-9 5 9 5z"/><path d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"/>
                        </svg>
                    </div>
                    <div class="pillar-text">
                        <h4>Pendidikan Holistik</h4>
                        <p>Program akademik dan pembangunan sahsiah yang menyeluruh untuk memastikan kejayaan jangka panjang.</p>
                    </div>
                </div>
                <div class="pillar">
                    <div class="pillar-icon">
                        <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" color="#a12c2f">
                            <path d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                    </div>
                    <div class="pillar-text">
                        <h4>Komuniti Alumni yang Kuat</h4>
                        <p>Jaringan sokongan bersama di antara mereka yang pernah berkongsi pengalaman yang sama.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- DONATIONS -->
<section class="donations" id="derma">
    <div class="donations-pattern"></div>
    <div class="donations-inner">
        <div class="donations-header reveal">
            <div>
                <div class="section-label">
                    <div class="section-label-dot" style="background: var(--red-muted);"></div>
                    <span>Inisiatif</span>
                </div>
                <h2 class="section-h2">Sokong misi kami</h2>
            </div>
            <a href="#" class="nav-cta">Lihat semua kempen →</a>
        </div>
        <div class="donations-grid">
            @foreach ($donations as $donation)
            @php $percent = ($donation->current_amount / $donation->target_amount) * 100; @endphp
            <div class="don-card reveal">
                <div class="don-img">
                    <div class="don-img-placeholder"><img src="{{ asset('storage/' . $donation->image_path) }}" alt=""></div>
                </div>
                <div class="don-body">
                    <div class="don-title">{{ $donation->title }}</div>
                    <div class="don-progress-track">
                        <div class="don-progress-fill" style="width: {{ $percent }}%"></div>
                    </div>
                    <div class="don-amounts">
                        <span class="don-current">RM {{ number_format($donation->current_amount) }}</span>
                        <span class="don-target">Sasaran: RM {{ number_format($donation->target_amount) }}</span>
                    </div>
                    <a href="{{ route('login') }}" class="don-cta">Derma Sekarang</a>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-- EVENTS -->
<section class="events" id="acara">
    <div class="events-inner">
        <div class="events-header reveal">
            <div class="section-label">
                <div class="section-label-dot"></div>
                <span>Kalendar</span>
            </div>
            <h2 class="section-h2">Acara Alumni</h2>
        </div>
        <div class="events-grid">
            @foreach ($events as $event )
            <div class="event-card reveal">
                <div class="event-img">
                    <div class="event-img-placeholder"><img src="{{ asset('storage/' . $event->image_path) }}" alt=""></div>
                    <div class="event-date-badge">{{ \Carbon\Carbon::parse($event->start_date)->format('d M') }}</div>
                </div>
                <div class="event-body">
                    <div class="event-title">{{ $event->name }}</div>
                    <div class="event-loc">
                        <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        {{ $event->location }}
                    </div>
                    <a href="{{ route('login') }}" class="event-link">Lihat butiran <span>→</span></a>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-- CONTACT -->
<section class="contact" id="hubungi">
    <div class="contact-inner">
        <div class="reveal">
            <div class="section-label">
                <div class="section-label-dot"></div>
                <span>Hubungi</span>
            </div>
            <h2 class="section-h2" style="margin-bottom: 0;">Kami sentiasa di sini untuk anda</h2>
            <div class="contact-info-items">
                <div class="contact-item">
                    <div class="contact-icon">
                        <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    </div>
                    <div>
                        <div class="contact-item-label">Alamat</div>
                        <div class="contact-item-value">Lot 324, Kampung Ulu Parit,<br>26600 Pekan, Pahang</div>
                    </div>
                </div>
                <div class="contact-item">
                    <div class="contact-icon">
                        <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                    </div>
                    <div>
                        <div class="contact-item-label">Telefon</div>
                        <div class="contact-item-value">+609-4228050</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="reveal" style="transition-delay: 0.15s;">
            <div class="map-frame">
                <iframe
                    src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d15930.013202817157!2d103.3837851!3d3.4700457!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31cf5077646451bf%3A0xdd69afade6d0fa4a!2sRumah%20Penyayang%20Tun%20Abdul%20Razak!5e0!3m2!1sen!2smy!4v1732824146976!5m2!1sen!2smy"
                    width="100%" height="440" style="border:0;" allowfullscreen="" loading="lazy">
                </iframe>
            </div>
        </div>
    </div>
</section>

<!-- FOOTER -->
<footer>
    <div class="footer-inner">
        <div class="footer-logo">RPTAR <span>Alumni</span></div>
        <div class="footer-copy">© {{ date('Y') }} Hak Cipta Terpelihara. Rumah Penyayang Tun Abdul Razak.</div>
    </div>
</footer>

<script>
    // Nav scroll
    window.addEventListener('scroll', () => {
        document.getElementById('nav').classList.toggle('scrolled', window.scrollY > 60);
    });

    // Scroll reveal
    const reveals = document.querySelectorAll('.reveal');
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(e => { if (e.isIntersecting) { e.target.classList.add('visible'); observer.unobserve(e.target); } });
    }, { threshold: 0.12, rootMargin: '0px 0px -40px 0px' });
    reveals.forEach(el => observer.observe(el));
</script>
</body>
</html>