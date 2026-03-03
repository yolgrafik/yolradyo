<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'RADYOYOL') - Radyo</title>
    <style>
        :root {
            --bg: #0f1319;
            --panel: #161c24;
            --text: #f0f2f5;
            --muted: #8b95a5;
            --border: rgba(255, 255, 255, 0.08);
            --accent: #c92a2a;
        }
        * { box-sizing: border-box; margin: 0; padding: 0; }
        html { font-family: Arial, sans-serif; }
        body {
            font-family: Arial, sans-serif;
            background: var(--bg);
            color: var(--text);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            padding-bottom: 96px;
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
        }
        .main-content h1, .main-content h2, .main-content h3,
        .main-content .hero-btn, .main-content a.btn,
        .main-content button {
            text-transform: none;
        }
        .footer {
            background: var(--panel);
            border-top: 1px solid var(--border);
            padding: 2.5rem 1.5rem 1rem;
            margin-top: auto;
        }
        .footer-inner {
            max-width: 1200px;
            margin: 0 auto;
        }
        .footer-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 2rem;
            margin-bottom: 2rem;
        }
        .footer-col h4 {
            font-size: 0.85rem;
            font-weight: 700;
            color: var(--accent);
            letter-spacing: 0.08em;
            margin-bottom: 1rem;
            text-transform: none;
        }
        .footer-col ul {
            list-style: none;
        }
        .footer-col a {
            color: var(--muted);
            text-decoration: none;
            text-transform: none;
            font-size: 0.85rem;
            display: block;
            padding: 0.35rem 0;
            transition: color 0.2s;
        }
        .footer-col a:hover { color: var(--text); }
        .footer-bottom {
            padding-top: 1rem;
            border-top: 1px solid var(--border);
            text-align: center;
            font-size: 0.8rem;
            color: var(--muted);
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
            .footer-grid { grid-template-columns: 1fr; }
        }
        @media (max-width: 768px) {
            .nav-logo img { height: 70px; }
        }
        @media (min-width: 993px) {
            .nav-toggle { display: none; }
        }
        /* Radio Player Bar */
        .radio-player {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            height: 80px;
            background: linear-gradient(180deg, #0b0f1a 0%, #111 100%);
            border-top: 1px solid rgba(201, 42, 42, 0.4);
            box-shadow: 0 -4px 24px rgba(0, 0, 0, 0.4);
            z-index: 999;
            display: flex;
            align-items: center;
            padding: 0 1.5rem;
            gap: 1.5rem;
        }
        .radio-player-left {
            display: flex;
            align-items: center;
            gap: 1.25rem;
            min-width: 0;
        }
        .player-logo-wrap {
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .player-logo-img {
            height: 78px;
            width: auto;
            display: block;
        }
        .player-logo-wrap .disc-btn {
            position: absolute;
            left: 50%;
            top: 50%;
            margin: -24px 0 0 -24px;
        }
        .disc-btn {
            width: 48px;
            height: 48px;
            border-radius: 50%;
            background: var(--accent);
            border: none;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            margin: 0 2px;
            flex-shrink: 0;
            transform-origin: center;
            transition: box-shadow 0.2s ease;
        }
        .disc-btn:hover {
            box-shadow: 0 0 16px rgba(201, 42, 42, 0.5);
        }
        .disc-btn .icon {
            flex-shrink: 0;
            display: block;
        }
        .disc-btn .icon.play {
            width: 0;
            height: 0;
            border-top: 8px solid transparent;
            border-bottom: 8px solid transparent;
            border-left: 14px solid #fff;
            margin-left: 4px;
        }
        .disc-btn .icon.pause {
            width: 14px;
            height: 14px;
            position: relative;
            display: block;
        }
        .disc-btn .icon.pause::before,
        .disc-btn .icon.pause::after {
            content: '';
            position: absolute;
            top: 0;
            width: 4px;
            height: 14px;
            background: #fff;
            border-radius: 2px;
        }
        .disc-btn .icon.pause::before { left: 0; }
        .disc-btn .icon.pause::after { right: 0; }
        .radio-player.is-playing .disc-btn {
            animation: spinDisc 2.5s linear infinite;
        }
        @media (prefers-reduced-motion: reduce) {
            .radio-player.is-playing .disc-btn { animation: none; }
        }
        .radio-player-btn {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            border: 1px solid rgba(255,255,255,0.2);
            background: rgba(255,255,255,0.06);
            color: var(--text);
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1rem;
            transition: all 0.2s ease;
        }
        .radio-player-btn:hover {
            background: rgba(201, 42, 42, 0.2);
            border-color: rgba(201, 42, 42, 0.4);
            color: #fff;
        }
        .radio-player-live {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            flex-shrink: 0;
        }
        .radio-player-live-dot {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background: var(--accent);
            box-shadow: 0 0 12px var(--accent);
            animation: pulse-dot 1.5s ease-in-out infinite;
        }
        @keyframes pulse-dot {
            0%, 100% { opacity: 1; box-shadow: 0 0 12px var(--accent); }
            50% { opacity: 0.7; box-shadow: 0 0 6px var(--accent); }
        }
        .radio-player-live span {
            font-size: 0.85rem;
            font-weight: 700;
            color: var(--accent);
        }
        .radio-player-center {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 1rem;
            min-width: 0;
        }
        .radio-player-title {
            font-size: 0.9rem;
            color: var(--muted);
            text-align: center;
        }
        .radio-player-right {
            display: flex;
            align-items: center;
            gap: 1rem;
            min-width: 0;
        }
        .radio-player-volume {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        .radio-player-volume button {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            border: 1px solid var(--border);
            background: transparent;
            color: var(--text);
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.2s ease;
        }
        .radio-player-volume button:hover {
            background: rgba(201, 42, 42, 0.15);
            color: #fff;
        }
        .radio-player-volume button svg { width: 18px; height: 18px; }
        .radio-player-volume input[type="range"] {
            width: 80px;
            height: 4px;
            -webkit-appearance: none;
            appearance: none;
            background: var(--border);
            border-radius: 2px;
            outline: none;
        }
        .radio-player-volume input[type="range"]::-webkit-slider-thumb {
            -webkit-appearance: none;
            width: 14px;
            height: 14px;
            border-radius: 50%;
            background: var(--accent);
            cursor: pointer;
            transition: transform 0.2s;
        }
        .radio-player-volume input[type="range"]::-webkit-slider-thumb:hover { transform: scale(1.1); }
        .radio-player-eq {
            display: flex;
            align-items: flex-end;
            gap: 3px;
            height: 24px;
        }
        .radio-player-eq span {
            width: 4px;
            background: var(--muted);
            border-radius: 2px;
            animation: eq-bars 0.5s ease-in-out infinite alternate;
        }
        .radio-player-eq span:nth-child(1) { height: 8px; animation-delay: 0s; }
        .radio-player-eq span:nth-child(2) { height: 14px; animation-delay: 0.1s; }
        .radio-player-eq span:nth-child(3) { height: 20px; animation-delay: 0.2s; }
        .radio-player-eq span:nth-child(4) { height: 12px; animation-delay: 0.3s; }
        .radio-player-eq span:nth-child(5) { height: 18px; animation-delay: 0.4s; }
        @keyframes eq-bars {
            from { opacity: 0.5; }
            to { opacity: 1; }
        }
        .radio-player.is-playing .radio-player-eq span { background: var(--accent); }
        @keyframes spinDisc {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }
        @media (max-width: 768px) {
            body { padding-bottom: 96px; }
            .radio-player { padding: 0 1rem; gap: 0.75rem; }
            .disc-btn { width: 42px; height: 42px; }
            .disc-btn .icon.play { border-top-width: 6px; border-bottom-width: 6px; border-left-width: 10px; margin-left: 3px; }
            .disc-btn .icon.pause { width: 10px; height: 10px; }
            .disc-btn .icon.pause::before,
            .disc-btn .icon.pause::after { width: 3px; height: 10px; }
            .player-logo-img { height: 68px; }
            .radio-player-volume input[type="range"] { width: 60px; }
        }
    </style>
    @stack('styles')
</head>
<body>
    <nav class="navbar">
        <div class="navbar-inner">
            <a href="{{ url('/') }}" class="nav-logo">
                @if(file_exists(public_path('logo.png')))
                    <img src="{{ asset('logo.png') }}" alt="RADYOYOL">
                @else
                    <span class="nav-logo-text">RADYOYOL</span>
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
                <a href="#" target="_blank" rel="noopener" aria-label="Instagram"><svg viewBox="0 0 24 24" fill="currentColor"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg></a>
                <a href="#" target="_blank" rel="noopener" aria-label="Facebook"><svg viewBox="0 0 24 24" fill="currentColor"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg></a>
                <a href="#" target="_blank" rel="noopener" aria-label="YouTube"><svg viewBox="0 0 24 24" fill="currentColor"><path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/></svg></a>
                <a href="#" target="_blank" rel="noopener" aria-label="TikTok"><svg viewBox="0 0 24 24" fill="currentColor"><path d="M19.59 6.69a4.83 4.83 0 0 1-3.77-4.25V2h-3.45v13.67a2.89 2.89 0 0 1-5.2 1.74 2.89 2.89 0 0 1 2.26-4.64 2.93 2.93 0 0 1 .88.13V9.4a6.84 6.84 0 0 0-1-.05A6.33 6.33 0 0 0 5 20.1a6.34 6.34 0 0 0 10.86-4.43v-7a8.16 8.16 0 0 0 4.77 1.52v-3.4a4.85 4.85 0 0 1-1-.1z"/></svg></a>
            </div>
            </div>
            <div class="nav-social">
                <a href="#" target="_blank" rel="noopener" aria-label="Instagram">
                    <svg viewBox="0 0 24 24" fill="currentColor"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>
                </a>
                <a href="#" target="_blank" rel="noopener" aria-label="Facebook">
                    <svg viewBox="0 0 24 24" fill="currentColor"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                </a>
                <a href="#" target="_blank" rel="noopener" aria-label="YouTube">
                    <svg viewBox="0 0 24 24" fill="currentColor"><path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/></svg>
                </a>
                <a href="#" target="_blank" rel="noopener" aria-label="TikTok">
                    <svg viewBox="0 0 24 24" fill="currentColor"><path d="M19.59 6.69a4.83 4.83 0 0 1-3.77-4.25V2h-3.45v13.67a2.89 2.89 0 0 1-5.2 1.74 2.89 2.89 0 0 1 2.26-4.64 2.93 2.93 0 0 1 .88.13V9.4a6.84 6.84 0 0 0-1-.05A6.33 6.33 0 0 0 5 20.1a6.34 6.34 0 0 0 10.86-4.43v-7a8.16 8.16 0 0 0 4.77 1.52v-3.4a4.85 4.85 0 0 1-1-.1z"/></svg>
                </a>
            </div>
            <button class="nav-toggle" id="navToggle" type="button" aria-label="Menu">☰</button>
        </div>
    </nav>

    <main class="main-content">
        @yield('content')
    </main>

    <footer class="footer">
        <div class="footer-inner">
            <div class="footer-grid">
                <div class="footer-col">
                    <h4>Hakkimizda</h4>
                    <ul>
                        <li><a href="{{ url('/hakkimizda/biz-kimiz') }}">Biz Kimiz</a></li>
                        <li><a href="{{ url('/hakkimizda/misyon') }}">Misyon & Vizyon</a></li>
                        <li><a href="{{ url('/hakkimizda/politika') }}">Yayin Politikamiz</a></li>
                    </ul>
                </div>
                <div class="footer-col">
                    <h4>Hizli Menu</h4>
                    <ul>
                        <li><a href="{{ url('/') }}">Anasayfa</a></li>
                        <li><a href="{{ url('/programlar') }}">Programlar</a></li>
                        <li><a href="{{ url('/haberler') }}">Haberler</a></li>
                        <li><a href="{{ url('/iletisim') }}">İletişim</a></li>
                    </ul>
                </div>
                <div class="footer-col">
                    <h4>Yasal</h4>
                    <ul>
                        <li><a href="{{ url('/gizlilik') }}">Gizlilik Politikasi</a></li>
                        <li><a href="{{ url('/cerez') }}">Cerez Politikasi</a></li>
                        <li><a href="{{ url('/kullanim') }}">Kullanim Sartlari</a></li>
                        <li><a href="{{ url('/kvkk') }}">KVKK Aydinlatma Metni</a></li>
                    </ul>
                </div>
            </div>
            <div class="footer-bottom">
                © {{ date('Y') }} RADYOYOL. Tum haklari saklidir.
            </div>
        </div>
    </footer>

    <div class="radio-player" id="radioPlayer">
        <audio id="radioStream" src="https://example.com/stream" preload="none"></audio>
        <div class="radio-player-left">
            <div class="radio-player-live">
                <span class="radio-player-live-dot"></span>
                <span>CANLI</span>
            </div>
        </div>
        <div class="radio-player-center">
            <div class="player-logo-wrap">
                @if(file_exists(public_path('assets/images/play.png')))
                    <img src="{{ asset('assets/images/play.png') }}" class="player-logo-img" alt="RADYOYOL">
                @elseif(file_exists(public_path('logo.png')))
                    <img src="{{ asset('logo.png') }}" class="player-logo-img" alt="RADYOYOL">
                @else
                    <span class="nav-logo-text" style="font-size:1.5rem;">RADYOYOL</span>
                @endif
                <button type="button" id="discBtn" class="disc-btn" title="Oynat / Duraklat" aria-label="Oynat / Duraklat"><span class="icon play"></span></button>
            </div>
            <div class="radio-player-title" id="radioTitle">Duraklatıldı</div>
        </div>
        <div class="radio-player-right">
            <div class="radio-player-volume">
                <button type="button" id="radioVolBtn" aria-label="Ses">🔊</button>
                <input type="range" id="radioVol" min="0" max="100" value="80" aria-label="Ses seviyesi">
            </div>
            <div class="radio-player-eq">
                <span></span><span></span><span></span><span></span><span></span>
            </div>
        </div>
    </div>

    <script>
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
            var audio = document.getElementById('radioStream');
            var player = document.getElementById('radioPlayer');
            var discBtn = document.getElementById('discBtn');
            var iconEl = discBtn ? discBtn.querySelector('.icon') : null;
            var titleEl = document.getElementById('radioTitle');
            var volInput = document.getElementById('radioVol');
            var volBtn = document.getElementById('radioVolBtn');
            var prevBtn = document.getElementById('radioPrev');
            var nextBtn = document.getElementById('radioNext');
            var navLogo = document.querySelector('.nav-logo');
            if (!audio || !discBtn) return;
            audio.volume = 0.8;
            if (volInput) volInput.value = 80;
            if (volInput && volBtn) {
                volInput.addEventListener('input', function() {
                    audio.volume = this.value / 100;
                    volBtn.textContent = this.value == 0 ? '🔇' : (this.value < 50 ? '🔉' : '🔊');
                });
            }
            function setPlaying(playing) {
                player.classList.toggle('is-playing', playing);
                if (iconEl) {
                    iconEl.classList.remove('play', 'pause');
                    iconEl.classList.add(playing ? 'pause' : 'play');
                }
                if (titleEl) titleEl.textContent = playing ? 'Canlı Yayın' : 'Duraklatıldı';
            }
            function togglePlay() {
                if (audio.paused) {
                    audio.play().catch(function() { if (titleEl) titleEl.textContent = 'Yayın başlatılamadı'; });
                } else {
                    audio.pause();
                }
            }
            discBtn.addEventListener('click', function(e) {
                e.preventDefault();
                togglePlay();
            });
            if (navLogo) {
                navLogo.addEventListener('click', function(e) {
                    e.preventDefault();
                    togglePlay();
                    return false;
                });
            }
            if (prevBtn) prevBtn.addEventListener('click', function() { audio.currentTime = 0; });
            if (nextBtn) nextBtn.addEventListener('click', function() { audio.currentTime = 0; });
            audio.addEventListener('playing', function() {
                setPlaying(true);
            });
            audio.addEventListener('pause', function() {
                setPlaying(false);
            });
            audio.addEventListener('ended', function() {
                setPlaying(false);
            });
            audio.addEventListener('error', function() {
                setPlaying(false);
                if (titleEl) titleEl.textContent = 'Yayın başlatılamadı';
            });
        })();
    </script>
    @stack('scripts')
</body>
</html>
