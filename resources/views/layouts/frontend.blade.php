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
            min-height: 120px;
            display: flex;
            align-items: center;
            background: linear-gradient(180deg, #0b0f1a 0%, #111827 100%);
            box-shadow: 0 4px 24px rgba(0, 0, 0, 0.35);
            padding: 0 2rem;
        }
        .navbar-inner {
            max-width: 1280px;
            width: 100%;
            margin: 0 auto;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 2rem;
        }
        .nav-logo {
            flex-shrink: 0;
        }
        .nav-logo img {
            height: 120px;
            width: auto;
            object-fit: contain;
        }
        .nav-logo-text {
            font-size: 1.75rem;
            font-weight: 700;
            color: var(--accent);
            letter-spacing: 0.05em;
            text-decoration: none;
        }
        .nav-center {
            flex: 1;
            display: flex;
            justify-content: center;
        }
        .nav-menu {
            display: flex;
            align-items: center;
            gap: 0.25rem;
            list-style: none;
        }
        .nav-menu > li > a {
            color: var(--text);
            text-decoration: none;
            text-transform: none;
            font-size: 0.9rem;
            font-weight: 500;
            padding: 0.6rem 1rem;
            border-radius: 8px;
            position: relative;
            transition: color 0.2s ease;
        }
        .nav-menu > li > a::after {
            content: '';
            position: absolute;
            bottom: 0.25rem;
            left: 1rem;
            right: 1rem;
            height: 2px;
            background: var(--accent);
            transform: scaleX(0);
            transition: transform 0.2s ease;
            border-radius: 1px;
        }
        .nav-menu > li > a:hover,
        .nav-menu > li > a.active {
            color: #fff;
        }
        .nav-menu > li > a.active {
            color: var(--accent);
        }
        .nav-menu > li > a:hover::after,
        .nav-menu > li > a.active::after {
            transform: scaleX(1);
        }
        .nav-social {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            flex-shrink: 0;
        }
        .nav-social a {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.06);
            border: 1px solid rgba(255, 255, 255, 0.1);
            color: var(--text);
            transition: all 0.2s ease;
        }
        .nav-social a:hover {
            background: rgba(201, 42, 42, 0.2);
            border-color: rgba(201, 42, 42, 0.4);
            box-shadow: 0 0 16px rgba(201, 42, 42, 0.3);
            color: #fff;
        }
        .nav-social svg {
            width: 18px;
            height: 18px;
        }
        .nav-social-mobile {
            display: none;
        }
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
            padding: 14px 1rem;
        }
        .legal-line {
            width: 100%;
            text-align: center;
            font-family: Arial, sans-serif;
            font-size: 13px;
            color: rgba(255,255,255,0.65);
            padding: 12px 0;
        }
        .legal-line a {
            color: rgba(255,255,255,0.65);
            text-decoration: none;
            margin: 0 6px;
        }
        .legal-line a:hover {
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
            .navbar { min-height: 100px; padding: 0 1rem; }
            .nav-logo img { height: 70px; }
            .nav-center {
                position: fixed;
                top: 0;
                right: -280px;
                width: 280px;
                height: 100vh;
                background: linear-gradient(180deg, #0b0f1a 0%, #111827 100%);
                flex: none;
                padding: 5rem 1rem 1rem;
                border-left: 1px solid var(--border);
                transition: right 0.3s ease;
                overflow-y: auto;
                z-index: 999;
            }
            .nav-center.is-open { right: 0; }
            .nav-menu {
                flex-direction: column;
                align-items: stretch;
            }
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
            .nav-social { display: none; }
            .nav-social-mobile {
                display: flex;
                justify-content: center;
                gap: 0.75rem;
                margin-top: 2rem;
                padding-top: 1.5rem;
                border-top: 1px solid var(--border);
            }
            .nav-social-mobile a {
                width: 44px;
                height: 44px;
            }
            .nav-social-mobile svg { width: 22px; height: 22px; }
            .nav-toggle { display: block; }
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
            .legal-footer { padding: 12px 0.75rem; }
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
        /* Mobile fullscreen player overlay */
        .mp-overlay.hidden { display: none !important; }
        .mp-overlay {
            position: fixed; inset: 0;
            z-index: 99999;
            display: flex; flex-direction: column;
            padding: 14px;
            min-height: 100vh;
            min-height: 100dvh;
        }
        .mp-overlay__backdrop {
            position: absolute; inset: 0;
            background: linear-gradient(180deg, rgba(0,0,0,.88), rgba(0,0,0,.95));
            cursor: pointer;
        }
        .mp-overlay__content {
            position: relative; z-index: 1;
            flex: 1;
            display: flex; flex-direction: column;
            min-height: 0;
        }
        .mp-top { display: flex; justify-content: space-between; align-items: center; color: #fff; flex-shrink: 0; }
        .mp-title { font-weight: 900; letter-spacing: 1px; font-size: 1.1rem; }
        .mp-close { background: transparent; border: 0; color: #fff; font-size: 22px; cursor: pointer; padding: 8px; line-height: 1; }
        .mp-close:hover { opacity: .85; }
        .mp-center { flex: 1; display: flex; flex-direction: column; align-items: center; justify-content: center; gap: 12px; min-height: 0; }
        .mp-cover { width: min(320px, 78vw); height: auto; border-radius: 18px; box-shadow: 0 18px 50px rgba(0,0,0,.55); object-fit: contain; }
        .mp-track { color: #fff; font-weight: 800; text-align: center; max-width: 90vw; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; font-size: 1rem; }
        .mp-listeners { color: rgba(255,255,255,.7); font-size: 12px; }
        .mp-controls { margin-top: 8px; display: flex; gap: 8px; align-items: center; justify-content: center; }
        .mp-play, .mp-pause {
            width: 80px; height: 80px; border-radius: 22px;
            border: 0; cursor: pointer;
            background: #fff; color: #111; font-size: 28px; font-weight: 900;
            box-shadow: 0 10px 30px rgba(0,0,0,.45);
            display: flex; align-items: center; justify-content: center; padding: 0;
        }
        .mp-play:hover, .mp-pause:hover { opacity: .95; transform: scale(1.02); }
        .mp-play.hidden, .mp-pause.hidden { display: none !important; }
        .mp-vol { width: min(360px, 86vw); margin-top: 8px; accent-color: var(--accent); }
        .mp-actions { display: flex; gap: 12px; padding: 12px 0; justify-content: center; flex-shrink: 0; flex-wrap: wrap; }
        .mp-btn {
            flex: 1; min-width: 140px; max-width: 220px;
            padding: 12px 14px; border-radius: 14px;
            border: 0; text-align: center; font-weight: 900; font-size: 0.95rem;
            text-decoration: none; cursor: pointer;
        }
        .mp-wa { background: #25D366; color: #fff; }
        .mp-wa:hover { opacity: .9; }
        .mp-req { background: #ff2d2d; color: #fff; }
        .mp-req:hover { opacity: .9; }
    </style>
    @stack('styles')
</head>
<body class="{{ request()->is('/') ? 'page-home' : '' }}">
    <nav class="navbar">
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
            <div class="nav-center">
            <ul class="nav-menu" id="navMenu">
                <li><a href="{{ url('/') }}">Anasayfa</a></li>
                <li><a href="{{ url('/programlar') }}">Programlar</a></li>
                <li><a href="{{ url('/haberler') }}">Haberler</a></li>
                <li><a href="{{ url('/videolar') }}">Video Galeri</a></li>
                <li><a href="{{ url('/galeri') }}">Foto Galeri</a></li>
                <li><a href="{{ url('/reklam') }}">Reklam & İşbirliği</a></li>
                <li class="nav-dropdown">
                    <a href="{{ url('/hakkimizda/biz-kimiz') }}">Hakkimizda<span class="arrow">▾</span></a>
                    <ul class="nav-dropdown-menu">
                        <li><a href="{{ url('/hakkimizda/biz-kimiz') }}">Biz Kimiz</a></li>
                        <li><a href="{{ url('/hakkimizda/misyon') }}">Misyon & Vizyon</a></li>
                        <li><a href="{{ url('/hakkimizda/politika') }}">Yayin Politikamiz</a></li>
                    </ul>
                </li>
                <li><a href="{{ url('/iletisim') }}">İletişim</a></li>
            </ul>
            <div class="nav-social nav-social-mobile" aria-hidden="true">
                @php
                    $socialInstagram = $siteSettings['instagram_url'] ?? '';
                    $socialFacebook = $siteSettings['facebook_url'] ?? '';
                    $socialYoutube = $siteSettings['youtube_url'] ?? '';
                    $socialTiktok = $siteSettings['tiktok_url'] ?? '';
                    $socialX = $siteSettings['x_url'] ?? '';
                @endphp
                @if($socialInstagram)<a href="{{ $socialInstagram }}" target="_blank" rel="noopener" aria-label="Instagram"><svg viewBox="0 0 24 24" fill="currentColor"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg></a>@endif
                @if($socialFacebook)<a href="{{ $socialFacebook }}" target="_blank" rel="noopener" aria-label="Facebook"><svg viewBox="0 0 24 24" fill="currentColor"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg></a>@endif
                @if($socialYoutube)<a href="{{ $socialYoutube }}" target="_blank" rel="noopener" aria-label="YouTube"><svg viewBox="0 0 24 24" fill="currentColor"><path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/></svg></a>@endif
                @if($socialTiktok)<a href="{{ $socialTiktok }}" target="_blank" rel="noopener" aria-label="TikTok"><svg viewBox="0 0 24 24" fill="currentColor"><path d="M19.59 6.69a4.83 4.83 0 0 1-3.77-4.25V2h-3.45v13.67a2.89 2.89 0 0 1-5.2 1.74 2.89 2.89 0 0 1 2.26-4.64 2.93 2.93 0 0 1 .88.13V9.4a6.84 6.84 0 0 0-1-.05A6.33 6.33 0 0 0 5 20.1a6.34 6.34 0 0 0 10.86-4.43v-7a8.16 8.16 0 0 0 4.77 1.52v-3.4a4.85 4.85 0 0 1-1-.1z"/></svg></a>@endif
                @if($socialX)<a href="{{ $socialX }}" target="_blank" rel="noopener" aria-label="X"><svg viewBox="0 0 24 24" fill="currentColor"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg></a>@endif
            </div>
            </div>
            <div class="nav-social">
                @if($socialInstagram)<a href="{{ $socialInstagram }}" target="_blank" rel="noopener" aria-label="Instagram"><svg viewBox="0 0 24 24" fill="currentColor"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg></a>@endif
                @if($socialFacebook)<a href="{{ $socialFacebook }}" target="_blank" rel="noopener" aria-label="Facebook"><svg viewBox="0 0 24 24" fill="currentColor"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg></a>@endif
                @if($socialYoutube)<a href="{{ $socialYoutube }}" target="_blank" rel="noopener" aria-label="YouTube"><svg viewBox="0 0 24 24" fill="currentColor"><path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/></svg></a>@endif
                @if($socialTiktok)<a href="{{ $socialTiktok }}" target="_blank" rel="noopener" aria-label="TikTok"><svg viewBox="0 0 24 24" fill="currentColor"><path d="M19.59 6.69a4.83 4.83 0 0 1-3.77-4.25V2h-3.45v13.67a2.89 2.89 0 0 1-5.2 1.74 2.89 2.89 0 0 1 2.26-4.64 2.93 2.93 0 0 1 .88.13V9.4a6.84 6.84 0 0 0-1-.05A6.33 6.33 0 0 0 5 20.1a6.34 6.34 0 0 0 10.86-4.43v-7a8.16 8.16 0 0 0 4.77 1.52v-3.4a4.85 4.85 0 0 1-1-.1z"/></svg></a>@endif
                @if($socialX)<a href="{{ $socialX }}" target="_blank" rel="noopener" aria-label="X"><svg viewBox="0 0 24 24" fill="currentColor"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg></a>@endif
            </div>
            <button class="nav-toggle" id="navToggle" type="button" aria-label="Menu">☰</button>
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
        <div class="legal-line">
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
            | {{ $footerText }} |
            @foreach($footerLinks as $link)
                @if(!empty($link['label']) && !empty($link['url']))
                    <a href="{{ url($link['url']) }}">{{ $link['label'] }}</a> |
                @endif
            @endforeach
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
            var toggle = document.getElementById('navToggle');
            var center = document.querySelector('.nav-center');
            if (toggle && center) {
                toggle.addEventListener('click', function() {
                    center.classList.toggle('is-open');
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
                    if (typeof window.openMobilePlayerOverlay === 'function') window.openMobilePlayerOverlay();
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
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        var overlay = document.getElementById('mobilePlayerOverlay');
        var mpClose = document.getElementById('mpClose');
        var mpPlay = document.getElementById('mpPlay');
        var mpPause = document.getElementById('mpPause');
        var mpRequest = document.getElementById('mpRequest');
        var mpVol = document.getElementById('mpVol');
        var audio = document.getElementById('radioAudio');
        if (!overlay || !audio) return;
        var streamUrl = audio.getAttribute('data-stream-url') || '';
        var backupUrl = audio.getAttribute('data-backup-url') || '';
        function closeOverlay() {
            overlay.classList.add('hidden');
            overlay.setAttribute('aria-hidden', 'true');
            document.body.style.overflow = '';
        }
        function updatePlayPauseUI() {
            var playing = !audio.paused && !audio.ended;
            if (mpPlay) mpPlay.classList.toggle('hidden', playing);
            if (mpPause) mpPause.classList.toggle('hidden', !playing);
        }
        function openOverlay() {
            overlay.classList.remove('hidden');
            overlay.setAttribute('aria-hidden', 'false');
            document.body.style.overflow = 'hidden';
            updatePlayPauseUI();
            if (mpVol) mpVol.value = audio.volume;
        }
        window.openMobilePlayerOverlay = openOverlay;
        if (mpClose) mpClose.addEventListener('click', closeOverlay);
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' && overlay && !overlay.classList.contains('hidden')) closeOverlay();
        });
        if (mpPlay) {
            mpPlay.addEventListener('click', function() {
                var url = streamUrl || backupUrl;
                if (url && !audio.src) { audio.src = url; audio.load(); }
                audio.play().catch(function(){});
            });
        }
        if (mpPause) mpPause.addEventListener('click', function() { audio.pause(); });
        if (mpRequest) {
            mpRequest.addEventListener('click', function() {
                closeOverlay();
                if (typeof window.openSongRequestModal === 'function') window.openSongRequestModal();
            });
        }
        if (mpVol) {
            mpVol.addEventListener('input', function() { audio.volume = parseFloat(this.value); });
        }
        audio.addEventListener('play', updatePlayPauseUI);
        audio.addEventListener('pause', updatePlayPauseUI);
        audio.addEventListener('ended', updatePlayPauseUI);
        var backdrop = overlay ? overlay.querySelector('[data-close-overlay]') : null;
        if (backdrop) backdrop.addEventListener('click', closeOverlay);
    });
    </script>

    @php
        $mpCover = isset($siteSettings['brand_logo_path']) && $siteSettings['brand_logo_path']
            ? asset('storage/' . $siteSettings['brand_logo_path'])
            : asset('assets/images/play.png');
        $mpWhatsapp = !empty($siteSettings['whatsapp_url']) ? $siteSettings['whatsapp_url'] : 'javascript:void(0)';
    @endphp
    <div id="mobilePlayerOverlay" class="mp-overlay hidden" role="dialog" aria-modal="true" aria-label="Canlı dinle">
        <div class="mp-overlay__backdrop" data-close-overlay aria-hidden="true"></div>
        <div class="mp-overlay__content">
        <div class="mp-top">
            <div class="mp-title">{{ $siteName ?? 'RadyoYol' }}</div>
            <button type="button" id="mpClose" class="mp-close" aria-label="Kapat">✕</button>
        </div>
        <div class="mp-center">
            <img class="mp-cover" src="{{ $mpCover }}" alt="RadyoYol">
            <div class="mp-track">
                <span class="cc_streaminfo" data-type="tracktitle" data-username="radyoyol"></span>
            </div>
            <div class="mp-listeners">
                <span class="cc_streaminfo" data-type="listeners" data-username="radyoyol"></span> dinleyici
            </div>
            <div class="mp-controls">
                <button type="button" id="mpPlay" class="mp-play" aria-label="Oynat">▶</button>
                <button type="button" id="mpPause" class="mp-pause hidden" aria-label="Duraklat">⏸</button>
            </div>
            <input id="mpVol" class="mp-vol" type="range" min="0" max="1" step="0.01" value="0.8" aria-label="Ses seviyesi">
        </div>
        <div class="mp-actions">
            <a id="mpWhatsapp" class="mp-btn mp-wa" href="{{ $mpWhatsapp }}" target="_blank" rel="noopener">WhatsApp</a>
            <button type="button" id="mpRequest" class="mp-btn mp-req">İSTEK HATTI</button>
        </div>
        </div>
    </div>

    @stack('scripts')
    <script src="https://r1.comcities.com/system/streaminfo.js"></script>
</body>
</html>
