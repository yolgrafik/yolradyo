<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @php
        $siteSettings = $siteSettings ?? [];
        $siteName = $siteSettings['site_name'] ?? 'RADYOYOL';
        $metaTitle = $siteSettings['seo_meta_title'] ?? $siteName;
        $metaDesc = $siteSettings['seo_meta_description'] ?? '';
        $metaKeywords = $siteSettings['seo_meta_keywords'] ?? '';
        $ogImage = isset($siteSettings['seo_og_image_path']) && $siteSettings['seo_og_image_path']
            ? asset('storage/' . $siteSettings['seo_og_image_path']) : '';
        $faviconPath = isset($siteSettings['brand_favicon_path']) && $siteSettings['brand_favicon_path']
            ? asset('storage/' . $siteSettings['brand_favicon_path']) : asset('favicon.ico');
        $themePrimary = $siteSettings['theme_primary'] ?? '#0f1319';
        $themeAccent = $siteSettings['theme_accent'] ?? '#c92a2a';
        $themeBg = $siteSettings['theme_bg'] ?? '#0f1319';
        $themeText = $siteSettings['theme_text'] ?? '#f0f2f5';
        $themeGlow = $siteSettings['theme_glow'] ?? '#c92a2a';
    @endphp
    <link rel="icon" href="{{ $faviconPath }}" type="image/x-icon">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <title>@yield('title', $metaTitle) - Radyo</title>
    @if($metaDesc)<meta name="description" content="{{ $metaDesc }}">@endif
    @if($metaKeywords)<meta name="keywords" content="{{ $metaKeywords }}">@endif
    <meta property="og:title" content="{{ $metaTitle }}">
    @if($metaDesc)<meta property="og:description" content="{{ $metaDesc }}">@endif
    @if($ogImage)<meta property="og:image" content="{{ $ogImage }}">@endif
    <style>
        :root {
            --bg: {{ $themeBg }};
            --panel: #161c24;
            --text: {{ $themeText }};
            --muted: #8b95a5;
            --border: rgba(255, 255, 255, 0.08);
            --accent: {{ $themeAccent }};
            --primary: {{ $themePrimary }};
            --glow: {{ $themeGlow }};
        }
        * { box-sizing: border-box; margin: 0; padding: 0; }
        html, body { overflow-x: hidden; }
        html { font-family: Arial, sans-serif; }
        body {
            font-family: Arial, sans-serif;
            background: var(--bg);
            color: var(--text);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            padding-bottom: 175px;
        }
        .navbar {
            position: sticky;
            top: 0;
            z-index: 1000;
            height: 80px;
            min-height: 80px;
            display: flex;
            align-items: center;
            background: linear-gradient(180deg, rgba(11,15,26,0.92) 0%, rgba(17,24,39,0.9) 100%);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border-bottom: 1px solid rgba(255,255,255,0.06);
            box-shadow: 0 2px 20px rgba(0,0,0,0.2);
            padding: 0 1.5rem;
            transition: height 0.25s ease, box-shadow 0.25s ease, background 0.25s ease;
        }
        .navbar.is-scrolled {
            height: 68px;
            min-height: 68px;
            background: rgba(11,15,26,0.95);
            box-shadow: 0 4px 24px rgba(0,0,0,0.4);
        }
        .navbar-inner {
            max-width: 1280px;
            width: 100%;
            margin: 0 auto;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 1.5rem;
        }
        .nav-logo {
            flex-shrink: 0;
        }
        .nav-logo img {
            height: 72px;
            width: auto;
            object-fit: contain;
            transition: height 0.25s ease;
        }
        .navbar.is-scrolled .nav-logo img { height: 56px; }
        .nav-logo-text {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--accent);
            letter-spacing: 0.05em;
            text-decoration: none;
        }
        .nav-center {
            flex: 1;
            display: flex;
            align-items: center;
            gap: 1rem;
        }
        .nav-menu {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.15rem;
            list-style: none;
        }
        .nav-menu > li > a {
            color: var(--text);
            text-decoration: none;
            font-size: 0.8rem;
            font-weight: 600;
            letter-spacing: 0.03em;
            padding: 0.5rem 0.75rem;
            border-radius: 8px;
            position: relative;
            transition: color 0.2s ease, background 0.2s ease;
        }
        .nav-menu > li > a::after {
            content: '';
            position: absolute;
            bottom: 0.2rem;
            left: 0.75rem;
            right: 0.75rem;
            height: 2px;
            background: var(--accent);
            transform: scaleX(0);
            transition: transform 0.2s ease;
            border-radius: 1px;
        }
        .nav-menu > li > a:hover {
            color: #fff;
            background: rgba(255,255,255,0.04);
        }
        .nav-menu > li > a.active {
            color: var(--accent);
        }
        .nav-menu > li > a:hover::after,
        .nav-menu > li > a.active::after {
            transform: scaleX(1);
        }
        .nav-right {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            flex-shrink: 0;
        }
        .nav-social {
            display: flex;
            align-items: center;
            gap: 0.4rem;
        }
        .nav-social a {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.06);
            border: 1px solid rgba(255, 255, 255, 0.08);
            color: var(--text);
            transition: all 0.2s ease;
        }
        .nav-social a:hover {
            background: rgba(201, 42, 42, 0.25);
            border-color: rgba(201, 42, 42, 0.4);
            box-shadow: 0 0 14px rgba(201, 42, 42, 0.25);
            color: #fff;
        }
        .nav-social svg { width: 16px; height: 16px; }
        .navbar .header-social {
            display: flex; align-items: center; gap: 10px; flex-shrink: 0;
        }
        .navbar .header-social-icon {
            position: relative;
            display: inline-flex; align-items: center; justify-content: center;
            width: 40px; height: 40px; border-radius: 999px;
            background: rgba(15,19,25,0.6);
            border: 1px solid rgba(255,255,255,0.1);
            box-shadow: inset 0 1px 2px rgba(0,0,0,0.2), 0 1px 3px rgba(0,0,0,0.15);
            color: var(--text); text-decoration: none;
            transition: transform 0.25s ease, background 0.25s ease, border-color 0.25s ease, box-shadow 0.25s ease, color 0.25s ease;
        }
        .navbar .header-social-icon::before {
            content: ''; position: absolute; inset: -2px;
            border-radius: 999px;
            background: linear-gradient(135deg, var(--accent), transparent 50%, var(--accent));
            opacity: 0;
            z-index: -1;
            transition: opacity 0.25s ease;
        }
        .navbar .header-social-icon:hover {
            transform: translateY(-1px) scale(1.06);
            background: rgba(201,42,42,0.2);
            border-color: rgba(201,42,42,0.5);
            box-shadow: 0 0 20px rgba(201,42,42,0.35), 0 4px 12px rgba(0,0,0,0.2);
            color: #fff;
        }
        .navbar .header-social-icon:hover::before { opacity: 0.15; }
        .navbar .header-social-icon:focus-visible {
            outline: 2px solid var(--accent);
            outline-offset: 3px;
        }
        .navbar .header-social-icon i { font-size: 1.15rem; }
        .nav-dropdown {
            position: relative;
        }
        .nav-dropdown .arrow {
            font-size: 0.65em;
            opacity: 0.7;
            margin-left: 0.2em;
        }
        .nav-dropdown-menu {
            position: absolute;
            top: 100%;
            left: 0;
            min-width: 220px;
            background: #111827;
            border: 1px solid var(--border);
            border-radius: 12px;
            padding: 0.5rem;
            margin-top: 0.25rem;
            opacity: 0;
            visibility: hidden;
            transform: translateY(-8px);
            transition: opacity 0.2s, transform 0.2s, visibility 0.2s;
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.4);
        }
        .nav-dropdown:hover .nav-dropdown-menu {
            opacity: 1;
            visibility: visible;
            transform: translateY(0);
        }
        .nav-dropdown-menu a {
            display: block;
            color: #ffffff;
            text-decoration: none;
            padding: 12px 16px;
            border-radius: 8px;
            text-transform: none;
            position: relative;
            transition: all 0.2s ease;
        }
        .nav-dropdown-menu a::before {
            content: '';
            position: absolute;
            left: 8px;
            top: 50%;
            transform: translateY(-50%);
            height: 60%;
            width: 3px;
            background: var(--accent);
            border-radius: 0 2px 2px 0;
            opacity: 0;
            transition: opacity 0.2s ease;
        }
        .nav-dropdown-menu a:hover {
            background: rgba(201, 42, 42, 0.12);
            color: #fff;
            padding-left: 22px;
            box-shadow: inset 0 0 20px rgba(201, 42, 42, 0.08);
        }
        .nav-dropdown-menu a:hover::before {
            opacity: 1;
        }
        .nav-toggle {
            display: none;
            background: none;
            border: none;
            color: var(--text);
            font-size: 1.5rem;
            cursor: pointer;
            padding: 0.25rem;
        }
        body.nav-open { overflow: hidden; }
        .main-content {
            flex: 1;
            padding-bottom: 120px;
            min-width: 0;
        }
        .main-content h1, .main-content h2, .main-content h3,
        .main-content .hero-btn, .main-content a.btn,
        .main-content button {
            text-transform: none;
        }
        /* Legal footer - fixed at very bottom */
        .legal-footer {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            z-index: 999;
            background: rgba(5,7,12,0.85);
            backdrop-filter: blur(8px);
            -webkit-backdrop-filter: blur(8px);
            padding: 0 1rem;
        }
        .site-footer-bar {
            display: flex;
            align-items: center;
            justify-content: center;
            flex-wrap: wrap;
            gap: 12px;
            min-height: 56px;
            width: 100%;
        }
        .footer-social {
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .footer-social-icon,
        .footer-social a {
            width: 36px;
            height: 36px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 999px;
            background: rgba(255,255,255,0.06);
            border: 1px solid rgba(255,255,255,0.1);
            color: rgba(255,255,255,0.7);
            text-decoration: none;
            transition: all 0.2s ease;
        }
        .footer-social a:hover {
            background: rgba(201,42,42,0.2);
            border-color: rgba(201,42,42,0.4);
            color: #fff;
        }
        .footer-social svg { width: 16px; height: 16px; }
        .footer-legal {
            display: flex;
            align-items: center;
            flex-wrap: wrap;
            gap: 14px;
            line-height: 1.2;
            font-family: Arial, sans-serif;
            font-size: 13px;
            color: rgba(255,255,255,0.65);
        }
        .footer-legal a {
            color: rgba(255,255,255,0.65);
            text-decoration: none;
        }
        .footer-legal a:hover {
            color: #fff;
        }
        /* Fixed bottom player bar - above legal footer */
        .bottom-bar-player {
            position: fixed;
            bottom: 48px;
            left: 0;
            right: 0;
            height: 120px;
            z-index: 9999;
            font-family: Arial, sans-serif;
            background: rgba(10,12,20,0.85);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border-top: 1px solid rgba(255,0,0,0.35);
            box-shadow: 0 -4px 24px rgba(0,0,0,0.3);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 0 1.5rem;
            gap: 0;
        }
        .bottom-bar-player > * { pointer-events: auto; }
        .player-logo-wrap {
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .player-volume-group {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            margin-left: 12px;
        }
        .player-status-group {
            display: flex;
            flex-direction: column;
            align-items: flex-start;
            gap: 0.15rem;
            margin-left: 16px;
        }
        .player-status {
            display: flex;
            align-items: center;
            gap: 0.4rem;
            font-size: 0.75rem;
            font-weight: 700;
            color: #fff;
        }
        .player-status .dot {
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background: #22c55e;
            flex-shrink: 0;
        }
        .player-status.paused .dot { background: #94a3b8; }
        .player-status .dot.pulse { animation: statusPulse 1.5s ease-in-out infinite; }
        @keyframes statusPulse { 0%, 100% { opacity: 1; } 50% { opacity: 0.4; } }
        .player-now-playing { display: none; }
        .player-live-meta { margin-top: 6px; line-height: 1.2; }
        .player-track {
            font-size: 12px;
            font-weight: 700;
            color: rgba(255,255,255,0.9);
            max-width: 220px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        .player-listeners {
            font-size: 11px;
            color: rgba(255,255,255,0.65);
        }
        .logo-player {
            position: relative;
            bottom: auto;
            left: auto;
            transform: none;
        }
        .player-mute-btn {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background: rgba(255,255,255,0.06);
            border: 1px solid rgba(255,255,255,0.12);
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.2s ease;
        }
        .player-mute-btn:hover {
            background: rgba(201,42,42,0.25);
            border-color: rgba(201,42,42,0.5);
            box-shadow: 0 0 12px rgba(201,42,42,0.3);
        }
        .player-mute-btn.muted { color: #94a3b8; }
        .player-mute-btn svg { width: 18px; height: 18px; }
        .player-volume-wrap {
            display: flex;
            align-items: center;
            min-width: 80px;
        }
        .player-volume-wrap input[type="range"] {
            -webkit-appearance: none;
            width: 80px;
            height: 6px;
            background: rgba(255,255,255,0.15);
            border-radius: 3px;
            outline: none;
        }
        .player-volume-wrap input[type="range"]::-webkit-slider-thumb {
            -webkit-appearance: none;
            width: 14px;
            height: 14px;
            border-radius: 50%;
            background: var(--accent);
            cursor: pointer;
            box-shadow: 0 0 8px rgba(201,42,42,0.5);
            transition: transform 0.2s;
        }
        .player-volume-wrap input[type="range"]::-webkit-slider-thumb:hover { transform: scale(1.1); }
        .player-eq {
            width: 24px;
            height: 24px;
            display: flex;
            align-items: flex-end;
            gap: 2px;
            padding-bottom: 2px;
        }
        .player-eq span {
            width: 4px;
            background: rgba(255,255,255,0.5);
            border-radius: 2px;
            animation: eqBars 0.8s ease-in-out infinite;
        }
        .player-eq span:nth-child(1) { height: 8px; animation-delay: 0s; }
        .player-eq span:nth-child(2) { height: 14px; animation-delay: 0.1s; }
        .player-eq span:nth-child(3) { height: 12px; animation-delay: 0.2s; }
        .player-eq span:nth-child(4) { height: 18px; animation-delay: 0.3s; }
        .player-eq span:nth-child(5) { height: 10px; animation-delay: 0.4s; }
        body.playing .player-eq span { background: var(--accent); }
        @keyframes eqBars { 0%, 100% { transform: scaleY(0.6); } 50% { transform: scaleY(1); } }
        .player-eq { margin-left: 0.5rem; }
        .bottom-bar-logo-wrap {
            position: relative;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .bottom-bar-logo-wrap .disc-overlay {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-55%, -50%);
        }
        .bottom-bar-logo {
            height: 98px;
            width: auto;
            display: block;
        }
        @media (max-width: 992px) {
            .navbar { height: 72px; min-height: 72px; padding: 0 1rem; }
            .navbar.is-scrolled { height: 68px; min-height: 68px; }
            .nav-logo img { height: 56px; }
            .navbar.is-scrolled .nav-logo img { height: 52px; }
            .nav-center {
                position: fixed;
                top: 0;
                right: -300px;
                width: 300px;
                height: 100vh;
                background: linear-gradient(180deg, rgba(11,15,26,0.98) 0%, rgba(17,24,39,0.97) 100%);
                backdrop-filter: blur(16px);
                -webkit-backdrop-filter: blur(16px);
                flex: none;
                flex-direction: column;
                align-items: stretch;
                padding: 5rem 1.25rem 2rem;
                border-left: 1px solid var(--border);
                transition: right 0.3s ease;
                overflow-y: auto;
                z-index: 999;
                box-shadow: -10px 0 40px rgba(0,0,0,0.4);
            }
            .nav-center.is-open { right: 0; }
            .nav-menu {
                flex-direction: column;
                align-items: stretch;
                gap: 0.25rem;
            }
            .nav-menu > li > a { padding: 0.75rem 1rem; font-size: 0.9rem; }
            .nav-dropdown-menu {
                position: static;
                opacity: 1;
                visibility: visible;
                transform: none;
                margin: 0.5rem 0 0 1rem;
                box-shadow: none;
                border: none;
                padding-left: 0;
            }
            .nav-center .nav-right {
                display: flex;
                justify-content: center;
                flex-wrap: wrap;
                gap: 0.75rem;
                margin-top: 1.5rem;
                padding-top: 1.5rem;
                border-top: 1px solid var(--border);
            }
            .navbar .nav-center .nav-right .header-social-icon { width: 44px; height: 44px; }
            .navbar .nav-center .nav-right .header-social-icon i { font-size: 1.25rem; }
            .nav-center .nav-right .header-social { gap: 12px; }
            .nav-toggle { display: flex; align-items: center; justify-content: center; }
        }
        @media (max-width: 768px) {
            .nav-logo img { height: 70px; }
            .bottom-bar-player { padding: 0 1rem; gap: 0.5rem; }
            .player-status-group { font-size: 0.7rem; }
            .player-volume-wrap { min-width: 60px; }
            .player-volume-wrap input[type="range"] { width: 50px; }
            .player-eq { display: none; }
        }
        @media (min-width: 993px) {
            .nav-toggle { display: none; }
        }
        /* Footer Logo Player */
        .disc-overlay {
            position: absolute;
            width: 48px;
            height: 48px;
            border-radius: 50%;
            background: #ff2a2a;
            border: none;
            display: flex;
            justify-content: center;
            align-items: center;
            cursor: pointer;
            top: 50%;
            left: 50%;
            transform: translate(-55%, -50%);
        }
        .disc-overlay .icon {
            flex-shrink: 0;
            display: block;
        }
        .disc-overlay .icon.play {
            width: 0;
            height: 0;
            border-top: 8px solid transparent;
            border-bottom: 8px solid transparent;
            border-left: 14px solid #fff;
            margin-left: 4px;
        }
        .disc-overlay .icon.pause {
            width: 16px;
            height: 16px;
            position: relative;
            display: block;
        }
        .disc-overlay .icon.pause::before,
        .disc-overlay .icon.pause::after {
            content: '';
            position: absolute;
            top: 0;
            width: 5px;
            height: 16px;
            background: #fff;
        }
        .disc-overlay .icon.pause::before { left: 0; }
        .disc-overlay .icon.pause::after { right: 0; }
        @keyframes spinDisc {
            from { transform: translate(-55%, -50%) rotate(0deg); }
            to { transform: translate(-55%, -50%) rotate(360deg); }
        }
        body.playing .disc-overlay {
            animation: spinDisc 2.5s linear infinite;
        }
        @media (prefers-reduced-motion: reduce) {
            body.playing .disc-overlay { animation: none; }
        }
        @media (max-width: 768px) {
            .bottom-bar-logo { height: 78px; }
            .legal-footer { padding: 0 0.75rem; }
            .site-footer-bar { min-height: 48px; gap: 10px; }
            .footer-social a { width: 32px; height: 32px; }
            .footer-social svg { width: 14px; height: 14px; }
            .legal-pretext { font-size: 12px !important; margin-bottom: 8px !important; }
            .legal-links { font-size: 12px !important; }
            body { padding-bottom: 165px; }
            .disc-overlay { width: 40px; height: 40px; }
            .disc-overlay .icon.play { border-top-width: 6px; border-bottom-width: 6px; border-left-width: 10px; margin-left: 3px; }
            .disc-overlay .icon.pause { width: 14px; height: 14px; }
            .disc-overlay .icon.pause::before,
            .disc-overlay .icon.pause::after { width: 4px; height: 14px; }
        }
        /* Song request modal */
        .request-modal { position: fixed; inset: 0; z-index: 9999; display: flex; align-items: center; justify-content: center; padding: 1rem; opacity: 0; visibility: hidden; transition: opacity .25s, visibility .25s; }
        .request-modal.is-open { opacity: 1; visibility: visible; }
        .request-modal__backdrop { position: absolute; inset: 0; background: rgba(0,0,0,.7); cursor: pointer; }
        .request-modal__box { position: relative; background: var(--panel); border: 1px solid var(--border); border-radius: 12px; padding: 1.5rem; max-width: 420px; width: 100%; box-shadow: 0 20px 60px rgba(0,0,0,.5); }
        .request-modal__close { position: absolute; top: .75rem; right: .75rem; background: none; border: none; color: var(--muted); font-size: 1.5rem; cursor: pointer; line-height: 1; padding: 4px; }
        .request-modal__close:hover { color: var(--text); }
        .request-modal__title { margin-bottom: 1rem; font-size: 1.25rem; }
        .request-form__group { margin-bottom: 1rem; }
        .request-form__group label { display: block; margin-bottom: .35rem; font-size: .9rem; }
        .request-form__input { width: 100%; padding: .5rem .75rem; background: rgba(255,255,255,.06); border: 1px solid var(--border); border-radius: 6px; color: var(--text); font-size: 1rem; }
        .request-form__input:focus { outline: none; border-color: var(--accent); }
        .request-form__error { display: block; font-size: .8rem; color: #f87171; margin-top: .25rem; }
        .request-form__success { padding: .5rem; border-radius: 6px; margin-bottom: 1rem; }
        .request-form__actions { margin-top: 1rem; }
        .request-form__btn { padding: .75rem 1.5rem; background: var(--accent); color: #fff; border: none; border-radius: 6px; font-weight: 600; cursor: pointer; }
        .request-form__btn:hover { opacity: .9; }
    </style>
    @stack('styles')
</head>
<body class="{{ request()->is('/') ? 'page-home' : '' }}">
    <nav class="navbar" id="mainNavbar">
        <div class="navbar-inner">
            <a href="{{ url('/') }}" class="nav-logo">
                @php
                    $logoPath = $siteSettings['brand_logo_path'] ?? null;
                    $logoUrl = $logoPath ? asset('storage/' . $logoPath) : null;
                @endphp
                @if($logoUrl)
                    <img src="{{ $logoUrl }}" alt="{{ $siteName }}">
                @elseif(file_exists(public_path('logo.png')))
                    <img src="{{ asset('logo.png') }}" alt="{{ $siteName }}">
                @else
                    <span class="nav-logo-text">{{ $siteName }}</span>
                @endif
            </a>
            <div class="nav-center" id="navCenter">
                <ul class="nav-menu" id="navMenu">
                    <li><a href="{{ url('/') }}" class="{{ request()->is('/') ? 'active' : '' }}">Anasayfa</a></li>
                    <li><a href="{{ url('/programlar') }}" class="{{ request()->is('programlar') ? 'active' : '' }}">Programlar</a></li>
                    <li><a href="{{ url('/haberler') }}" class="{{ request()->is('haberler') ? 'active' : '' }}">Haberler</a></li>
                    <li><a href="{{ url('/videolar') }}" class="{{ request()->is('videolar') ? 'active' : '' }}">Video Galeri</a></li>
                    <li><a href="{{ url('/galeri') }}" class="{{ request()->is('galeri') ? 'active' : '' }}">Foto Galeri</a></li>
                    <li><a href="{{ url('/reklam') }}" class="{{ request()->is('reklam') ? 'active' : '' }}">Reklam & İşbirliği</a></li>
                    <li class="nav-dropdown">
                        <a href="{{ url('/hakkimizda/biz-kimiz') }}" class="{{ request()->is('hakkimizda/*') ? 'active' : '' }}">Hakkimizda<span class="arrow">▾</span></a>
                        <ul class="nav-dropdown-menu">
                            <li><a href="{{ url('/hakkimizda/biz-kimiz') }}">Biz Kimiz</a></li>
                            <li><a href="{{ url('/hakkimizda/misyon') }}">Misyon & Vizyon</a></li>
                            <li><a href="{{ url('/hakkimizda/politika') }}">Yayin Politikamiz</a></li>
                        </ul>
                    </li>
                    <li><a href="{{ url('/iletisim') }}" class="{{ request()->is('iletisim') ? 'active' : '' }}">İletişim</a></li>
                </ul>
                <div class="nav-right">
                <div class="header-social nav-social">
                    @php $social = $socialLinks ?? []; @endphp
                    @if(isset($social['whatsapp']) && ($social['whatsapp']['is_active'] ?? false) && !empty($social['whatsapp']['url'] ?? ''))
                    <a href="{{ $social['whatsapp']['url'] }}" class="header-social-icon" target="_blank" rel="noopener noreferrer" title="WhatsApp" aria-label="WhatsApp"><i class="bi bi-whatsapp"></i></a>
                    @endif
                    @if(isset($social['telegram']) && ($social['telegram']['is_active'] ?? false) && !empty($social['telegram']['url'] ?? ''))
                    <a href="{{ $social['telegram']['url'] }}" class="header-social-icon" target="_blank" rel="noopener noreferrer" title="Telegram" aria-label="Telegram"><i class="bi bi-telegram"></i></a>
                    @endif
                    @if(isset($social['instagram']) && ($social['instagram']['is_active'] ?? false) && !empty($social['instagram']['url'] ?? ''))
                    <a href="{{ $social['instagram']['url'] }}" class="header-social-icon" target="_blank" rel="noopener noreferrer" title="Instagram" aria-label="Instagram"><i class="bi bi-instagram"></i></a>
                    @endif
                    @if(isset($social['facebook']) && ($social['facebook']['is_active'] ?? false) && !empty($social['facebook']['url'] ?? ''))
                    <a href="{{ $social['facebook']['url'] }}" class="header-social-icon" target="_blank" rel="noopener noreferrer" title="Facebook" aria-label="Facebook"><i class="bi bi-facebook"></i></a>
                    @endif
                    @if(isset($social['tiktok']) && ($social['tiktok']['is_active'] ?? false) && !empty($social['tiktok']['url'] ?? ''))
                    <a href="{{ $social['tiktok']['url'] }}" class="header-social-icon" target="_blank" rel="noopener noreferrer" title="TikTok" aria-label="TikTok"><i class="bi bi-tiktok"></i></a>
                    @endif
                    @if(isset($social['youtube']) && ($social['youtube']['is_active'] ?? false) && !empty($social['youtube']['url'] ?? ''))
                    <a href="{{ $social['youtube']['url'] }}" class="header-social-icon" target="_blank" rel="noopener noreferrer" title="YouTube" aria-label="YouTube"><i class="bi bi-youtube"></i></a>
                    @endif
                    @if(isset($social['x']) && ($social['x']['is_active'] ?? false) && !empty($social['x']['url'] ?? ''))
                    <a href="{{ $social['x']['url'] }}" class="header-social-icon" target="_blank" rel="noopener noreferrer" title="X" aria-label="X"><i class="bi bi-twitter-x"></i></a>
                    @endif
                </div>
            </div>
            </div>
            <button class="nav-toggle" id="navToggle" type="button" aria-label="Menüyü aç">☰</button>
        </div>
    </nav>

    <main class="main-content">
        @yield('content')
    </main>

    <div class="bottom-bar-player">
        <div class="player-logo-wrap">
            <div class="logo-player bottom-bar-logo-wrap">
                @php $playerLogo = isset($siteSettings['brand_logo_path']) && $siteSettings['brand_logo_path'] ? asset('storage/' . $siteSettings['brand_logo_path']) : asset('assets/images/play.png'); @endphp
                <img src="{{ $playerLogo }}" class="bottom-bar-logo" alt="{{ $siteName }}">
                <button type="button" id="discBtn" class="disc-overlay" title="Oynat / Duraklat" aria-label="Oynat / Duraklat"><span class="icon play"></span></button>
            </div>
        </div>
        <div class="player-volume-group">
            <button type="button" class="player-mute-btn" id="playerMuteBtn" title="Sesi ac/kapat" aria-label="Sesi ac/kapat">
                <svg class="icon-unmuted" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 5L6 9H2v6h4l5 4V5z"/><path d="M19.07 4.93a10 10 0 010 14.14"/><path d="M15.54 8.46a5 5 0 010 7.07"/></svg>
                <svg class="icon-muted" style="display:none" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 5L6 9H2v6h4l5 4V5z"/><line x1="23" y1="9" x2="17" y2="15"/><line x1="17" y1="9" x2="23" y2="15"/></svg>
            </button>
            <div class="player-volume-wrap">
                <input type="range" id="playerVolume" min="0" max="100" value="70" title="Ses seviyesi">
            </div>
            <div class="player-eq" aria-hidden="true"><span></span><span></span><span></span><span></span><span></span></div>
        </div>
        <div class="player-status-group">
            <div class="player-status" id="playerStatus">
                <span class="dot pulse"></span>
                <span id="playerStatusText">Duraklatildi</span>
            </div>
            <div class="player-live-meta">
                <div class="player-track">
                    <span class="cc_streaminfo" data-type="tracktitle" data-username="radyoyol"></span>
                </div>
                <div class="player-listeners">
                    <span class="cc_streaminfo" data-type="listeners" data-username="radyoyol"></span> dinleyici
                </div>
            </div>
        </div>
    </div>

    <footer class="legal-footer">
        <div class="site-footer-bar">
            @php
                $footerText = $siteSettings['footer_legal_text'] ?? 'Radyoyol Tum Haklari Saklidir';
                $footerLinks = $siteSettings['footer_legal_links_json'] ?? [];
                if (!is_array($footerLinks)) $footerLinks = [];
                if (empty($footerLinks)) {
                    $footerLinks = [
                        ['label' => 'Gizlilik Politikasi', 'url' => '/gizlilik'],
                        ['label' => 'Cerez Politikasi', 'url' => '/cerez'],
                        ['label' => 'Kullanim Sartlari', 'url' => '/kullanim'],
                        ['label' => 'KVKK Aydinlatma Metni', 'url' => '/kvkk'],
                    ];
                }
            @endphp
            <div class="footer-social">
                @include('partials.social-icons')
            </div>
            <div class="footer-legal">
                | {{ $footerText }} |
                @foreach($footerLinks as $link)
                    @if(!empty($link['label']) && !empty($link['url']))
                        <a href="{{ url($link['url']) }}">{{ $link['label'] }}</a> |
                    @endif
                @endforeach
            </div>
        </div>
    </footer>
    @php
        $streamUrl = $radioSettings ? ($radioSettings->radio_stream_url ?? '') : '';
        $backupUrl = $radioSettings ? ($radioSettings->radio_backup_stream_url ?? '') : '';
        $autoPlay = $radioSettings ? ($radioSettings->radio_auto_play ?? false) : false;
        $defaultVolume = $radioSettings ? ($radioSettings->radio_default_volume ?? 0.8) : 0.8;
    @endphp
    <audio id="radioAudio" src="{{ $streamUrl }}" data-stream-url="{{ $streamUrl }}" data-backup-url="{{ $backupUrl }}" data-auto-play="{{ $autoPlay ? '1' : '0' }}" data-default-volume="{{ $defaultVolume }}" preload="none"></audio>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        (function() {
            var navbar = document.getElementById('mainNavbar');
            if (navbar) {
                function onScroll() {
                    navbar.classList.toggle('is-scrolled', window.scrollY > 20);
                }
                window.addEventListener('scroll', onScroll, { passive: true });
                onScroll();
            }
        })();
        (function() {
            var toggle = document.getElementById('navToggle');
            var center = document.getElementById('navCenter');
            if (toggle && center) {
                toggle.addEventListener('click', function() {
                    center.classList.toggle('is-open');
                    document.body.classList.toggle('nav-open', center.classList.contains('is-open'));
                });
                document.addEventListener('click', function(e) {
                    if (center.classList.contains('is-open') && !center.contains(e.target) && !toggle.contains(e.target)) {
                        center.classList.remove('is-open');
                        document.body.classList.remove('nav-open');
                    }
                });
            }
        })();
        (function() {
            var btn = document.getElementById('discBtn');
            var audio = document.getElementById('radioAudio');
            var icon = btn ? btn.querySelector('.icon') : null;
            var navLogo = document.querySelector('.nav-logo');
            var quickLive = document.getElementById('quickMenuLive');
            var statusEl = document.getElementById('playerStatus');
            var statusText = document.getElementById('playerStatusText');
            var nowPlayingEl = document.getElementById('playerNowPlaying');
            var muteBtn = document.getElementById('playerMuteBtn');
            var volumeSlider = document.getElementById('playerVolume');
            if (!audio || !btn) return;
            var defaultVol = parseFloat(audio.getAttribute('data-default-volume')) || 0.7;
            var volPct = Math.round(defaultVol * 100);
            if (volumeSlider) { volumeSlider.value = volPct; }
            audio.volume = defaultVol;
            var streamUrl = audio.getAttribute('data-stream-url') || '';
            var backupUrl = audio.getAttribute('data-backup-url') || '';
            var usedBackup = false;
            var savedVolume = defaultVol;
            function tryPlay() {
                if (!streamUrl && !backupUrl) return;
                var url = (usedBackup ? backupUrl : streamUrl) || backupUrl || streamUrl;
                if (!url) return;
                audio.src = url;
                audio.load();
                audio.play().catch(function() {});
            }
            function updateStatusUI() {
                if (!statusEl || !statusText) return;
                var playing = !audio.paused && !audio.ended;
                statusText.textContent = playing ? 'CANLI' : 'Duraklatildi';
                statusEl.classList.toggle('paused', !playing);
                statusEl.querySelector('.dot').classList.toggle('pulse', playing);
            }
            function fetchRadioStatus() {
                fetch('/api/radio/status').then(function(r) { return r.json(); }).then(function(d) {
                    if (nowPlayingEl) nowPlayingEl.textContent = d.song || '-';
                }).catch(function() {});
            }
            fetchRadioStatus();
            setInterval(fetchRadioStatus, 7000);
            var openLiveBtn = document.getElementById('openLivePlayer');
            if (openLiveBtn) {
                openLiveBtn.addEventListener('click', function(e) {
                    e.preventDefault();
                    var w = 420, h = 560;
                    var left = (screen.width - w) / 2;
                    var top = (screen.height - h) / 2;
                    window.open('{{ url("/canli-dinle") }}', 'RadyoYolPlayer', 'width=' + w + ',height=' + h + ',left=' + left + ',top=' + top + ',scrollbars=no,resizable=yes');
                    return false;
                });
            }
            btn.addEventListener('click', function() {
                if (audio.paused) tryPlay();
                else audio.pause();
            });
            if (navLogo) {
                navLogo.addEventListener('click', function(e) {
                    e.preventDefault();
                    if (audio.paused) tryPlay();
                    else audio.pause();
                    return false;
                });
            }
            audio.addEventListener('play', function() {
                document.body.classList.add('playing');
                if (icon) { icon.classList.remove('play'); icon.classList.add('pause'); }
                updateStatusUI();
            });
            audio.addEventListener('pause', function() {
                document.body.classList.remove('playing');
                if (icon) { icon.classList.remove('pause'); icon.classList.add('play'); }
                updateStatusUI();
            });
            audio.addEventListener('ended', function() {
                document.body.classList.remove('playing');
                if (icon) { icon.classList.remove('pause'); icon.classList.add('play'); }
                updateStatusUI();
            });
            if (audio.getAttribute('data-auto-play') === '1' && (streamUrl || backupUrl)) tryPlay();
            audio.addEventListener('error', function() {
                if (!usedBackup && backupUrl) {
                    usedBackup = true;
                    audio.src = backupUrl;
                    audio.load();
                    audio.play().catch(function() {
                        document.body.classList.remove('playing');
                        if (icon) { icon.classList.remove('pause'); icon.classList.add('play'); }
                        updateStatusUI();
                    });
                } else {
                    document.body.classList.remove('playing');
                    if (icon) { icon.classList.remove('pause'); icon.classList.add('play'); }
                    updateStatusUI();
                }
            });
            updateStatusUI();
            if (muteBtn) {
                muteBtn.addEventListener('click', function() {
                    if (audio.muted) {
                        audio.muted = false;
                        muteBtn.classList.remove('muted');
                        if (muteBtn.querySelector('.icon-unmuted')) muteBtn.querySelector('.icon-unmuted').style.display = '';
                        if (muteBtn.querySelector('.icon-muted')) muteBtn.querySelector('.icon-muted').style.display = 'none';
                    } else {
                        audio.muted = true;
                        muteBtn.classList.add('muted');
                        if (muteBtn.querySelector('.icon-unmuted')) muteBtn.querySelector('.icon-unmuted').style.display = 'none';
                        if (muteBtn.querySelector('.icon-muted')) muteBtn.querySelector('.icon-muted').style.display = '';
                    }
                });
            }
            if (volumeSlider) {
                volumeSlider.addEventListener('input', function() {
                    var v = parseInt(this.value, 10) / 100;
                    audio.volume = v;
                    if (audio.muted && v > 0) { audio.muted = false; if (muteBtn) { muteBtn.classList.remove('muted'); muteBtn.querySelector('.icon-unmuted').style.display = ''; muteBtn.querySelector('.icon-muted').style.display = 'none'; } }
                });
            }
        })();
    });
    </script>
    @include('partials.song-request-modal')
    @stack('scripts')
    <script src="https://r1.comcities.com/system/streaminfo.js"></script>
</body>
</html>
