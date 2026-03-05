<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
    @php
        $siteSettings = $siteSettings ?? [];
        $siteName = $siteSettings['site_name'] ?? 'RADYOYOL';
        $siteSlogan = $siteSettings['site_slogan'] ?? '';
        $metaTitle = $siteSettings['seo_meta_title'] ?? $siteName;
        $faviconPath = isset($siteSettings['brand_favicon_path']) && $siteSettings['brand_favicon_path']
            ? asset('storage/' . $siteSettings['brand_favicon_path']) : asset('favicon.ico');
    @endphp
    <link rel="icon" href="{{ $faviconPath }}" type="image/x-icon">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>@yield('title', $metaTitle) - Radyo</title>
    @include('partials.seo-meta')
    @stack('meta')
    @include('frontend.partials.theme-vars')
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        html, body { overflow-x: hidden; }
        html { font-family: Arial, sans-serif; }
        body {
            font-family: Arial, sans-serif;
            color: var(--ry-text);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            padding-top: 80px;
            padding-bottom: 175px;
        }
        .navbar {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 2000;
            height: 80px;
            min-height: 80px;
            display: flex;
            align-items: center;
            background: var(--ry-header-bg);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            box-shadow: 0 2px 20px rgba(0,0,0,0.2);
            padding: 0 1.5rem;
            transition: height 0.25s ease, box-shadow 0.25s ease, background 0.25s ease;
        }
        .navbar { border-bottom: 1px solid var(--ry-line-color); }
        .navbar.is-scrolled {
            height: 68px;
            min-height: 68px;
            background: var(--ry-header-bg);
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
            flex-shrink: 1;
            min-width: 0;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            text-decoration: none;
            max-width: 260px;
        }
        .nav-logo img {
            height: 72px;
            width: auto;
            flex-shrink: 0;
            object-fit: contain;
            transition: height 0.25s ease;
        }
        .navbar.is-scrolled .nav-logo img { height: 56px; }
        .nav-logo-text {
            font-size: 1.5rem;
            font-weight: 700;
            color: #ffffff;
            letter-spacing: 0.05em;
            line-height: 1.2;
        }
        .nav-logo-slogan-wrap {
            flex-shrink: 1;
            min-width: 0;
            padding: 0.25rem 0.4rem;
            max-width: 140px;
        }
        .nav-logo-slogan {
            font-size: clamp(0.52rem, 1.5vw, 0.68rem);
            font-weight: 600;
            letter-spacing: 0.04em;
            text-transform: uppercase;
            line-height: 1.2;
            color: #fff;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
            text-overflow: ellipsis;
            word-break: break-word;
        }
        .nav-logo-slogan {
            color: #fff;
            background: linear-gradient(90deg, #fff 0%, rgba(255,255,255,0.6) 50%, #fff 100%);
            background-size: 200% auto;
            -webkit-background-clip: text;
            background-clip: text;
            -webkit-text-fill-color: transparent;
            animation: slogan-shimmer 2.5s ease-in-out infinite;
        }
        @keyframes slogan-shimmer {
            0%, 100% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
        }
        .nav-center {
            flex: 1;
            min-width: 0;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 0.75rem;
        }
        .nav-menu {
            flex: 1 1 auto;
            min-width: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.15rem;
            list-style: none;
            flex-wrap: nowrap;
        }
        .nav-menu > li > a {
            color: #ffffff;
            text-decoration: none;
            font-size: 0.8rem;
            font-weight: 600;
            letter-spacing: 0.03em;
            padding: 0.5rem 0.75rem;
            border-radius: 8px;
            position: relative;
            transition: color 0.2s ease, background 0.2s ease;
            white-space: nowrap;
            -webkit-tap-highlight-color: transparent;
            touch-action: manipulation;
        }
        .nav-menu > li > a::after {
            content: '';
            position: absolute;
            bottom: 0.2rem;
            left: 0.75rem;
            right: 0.75rem;
            height: 2px;
            background: rgba(255,255,255,0.6);
            transform: scaleX(0);
            transition: transform 0.2s ease;
            border-radius: 1px;
        }
        .nav-menu > li > a:hover {
            color: #ffffff;
            background: rgba(255,255,255,0.04);
        }
        .nav-menu > li > a.active {
            color: #ffffff;
        }
        .nav-menu > li > a:hover::after,
        .nav-menu > li > a.active::after {
            transform: scaleX(1);
        }
        .nav-right {
            display: flex;
            align-items: center;
            justify-content: flex-end;
            gap: 0.5rem;
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
            border: 1px solid var(--ry-border);
            color: #ffffff;
            transition: all 0.2s ease;
        }
        .nav-social a:hover {
            background: rgba(255,255,255,0.12);
            border-color: rgba(255,255,255,0.25);
            color: #ffffff;
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
            color: #ffffff; text-decoration: none;
            transition: transform 0.25s ease, background 0.25s ease, border-color 0.25s ease, box-shadow 0.25s ease, color 0.25s ease;
        }
        .navbar .header-social-icon::before {
            content: ''; position: absolute; inset: -2px;
            border-radius: 999px;
            background: linear-gradient(135deg, rgba(255,255,255,0.3), transparent 50%, rgba(255,255,255,0.3));
            opacity: 0;
            z-index: -1;
            transition: opacity 0.25s ease;
        }
        .navbar .header-social-icon:hover {
            transform: translateY(-1px) scale(1.06);
            background: rgba(255,255,255,0.12);
            border-color: rgba(255,255,255,0.25);
            color: #ffffff;
        }
        .navbar .header-social-icon:hover::before { opacity: 0.15; }
        .navbar .header-social-icon:focus-visible {
            outline: 2px solid rgba(255,255,255,0.5);
            outline-offset: 3px;
        }
        .navbar .header-social-icon i { font-size: 1.15rem; }
        /* Header auth: social + auth next to each other */
        .header-social-auth { display: flex; align-items: center; gap: 10px; flex-shrink: 0; }
        .header-auth { display: flex; gap: 10px; align-items: center; flex-shrink: 0; }
        .header-auth-btn {
            display: inline-flex; align-items: center; justify-content: center;
            min-height: 44px; padding: 0.4rem 0.75rem;
            font-size: 0.8rem; font-weight: 600; color: #fff; text-decoration: none;
            border-radius: 8px; border: none; cursor: pointer;
            background: rgba(255,255,255,0.1); transition: all 0.2s ease;
            -webkit-tap-highlight-color: transparent;
            touch-action: manipulation;
        }
        .header-auth-btn:hover { background: rgba(255,255,255,0.18); color: #fff; }
        .header-auth-register { background: var(--ry-btn-bg); }
        .header-auth-register:hover { background: var(--ry-btn-hover, rgba(255,255,255,0.2)); }
        .header-auth-login { border: 1px solid rgba(255,255,255,0.25); }
        .header-auth-profile { border: 1px solid rgba(255,255,255,0.25); }
        .header-auth-logout { background: none; color: var(--ry-schedule-active); }
        .header-auth-logout:hover { background: rgba(255,255,255,0.08); }
        .header-auth-logout-form { display: inline; margin: 0; }
        /* Mobil header bar: logo ile hamburger arasındaki alanda auth butonları */
        .header-bar-auth {
            display: none;
            align-items: center;
            justify-content: flex-end;
            gap: 0.5rem;
            flex: 1;
            min-width: 0;
            padding: 0 0.5rem;
        }
        .header-bar-auth-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-height: 36px;
            padding: 0.35rem 0.65rem;
            font-size: 0.8rem;
            font-weight: 600;
            color: #fff;
            text-decoration: none;
            border-radius: 8px;
            border: none;
            cursor: pointer;
            white-space: nowrap;
            -webkit-tap-highlight-color: transparent;
            touch-action: manipulation;
        }
        .header-bar-auth-register { background: var(--ry-btn-bg); }
        .header-bar-auth-register:hover { opacity: 0.95; color: #fff; }
        .header-bar-auth-login { background: rgba(255,255,255,0.15); border: 1px solid rgba(255,255,255,0.35); }
        .header-bar-auth-login:hover { background: rgba(255,255,255,0.25); color: #fff; }
        .header-bar-auth-profile { background: rgba(255,255,255,0.1); border: 1px solid rgba(255,255,255,0.25); }
        .header-bar-auth-profile:hover { background: rgba(255,255,255,0.2); color: #fff; }
        .header-bar-auth-logout { background: none; color: var(--ry-schedule-active); }
        .header-bar-auth-logout:hover { background: rgba(255,255,255,0.1); }
        .header-bar-auth-form { display: inline; margin: 0; }
        /* Mobile: auth in slide-out (yedek) */
        .header-auth-mobile { display: none; gap: 0.75rem; align-items: stretch; flex: 1; min-width: 0; }
        .header-auth-mobile .header-auth-btn { flex: 1; min-width: 120px; justify-content: center; min-height: 48px; font-size: 0.95rem; padding: 0.6rem 1rem; }
        /* Mobile: social dropdown */
        .header-more-wrap { display: none; position: relative; }
        .header-more-btn {
            display: flex; align-items: center; justify-content: center;
            min-width: 44px; min-height: 44px;
            background: rgba(15,19,25,0.6); border: 1px solid rgba(255,255,255,0.1);
            border-radius: 999px; color: #fff; cursor: pointer;
            transition: all 0.2s ease;
            -webkit-tap-highlight-color: transparent;
            touch-action: manipulation;
        }
        .header-more-btn:hover { background: rgba(255,255,255,0.12); color: #fff; }
        .header-more-btn i { font-size: 1.25rem; }
        .header-more-dropdown {
            position: absolute; top: 100%; right: 0; margin-top: 0.5rem;
            min-width: 200px; padding: 1rem;
            background: var(--ry-surface); border: 1px solid var(--ry-border);
            border-radius: 12px; box-shadow: 0 10px 40px rgba(0,0,0,0.4);
            opacity: 0; visibility: hidden; transform: translateY(-8px);
            transition: opacity 0.2s, visibility 0.2s, transform 0.2s;
            z-index: 100;
        }
        .header-more-dropdown.is-open { opacity: 1; visibility: visible; transform: translateY(0); }
        .header-more-social { display: flex; flex-wrap: wrap; gap: 0.5rem; }
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
            background: var(--ry-surface);
            border: 1px solid var(--ry-border);
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
            background: rgba(255,255,255,0.5);
            border-radius: 0 2px 2px 0;
            opacity: 0;
            transition: opacity 0.2s ease;
        }
        .nav-dropdown-menu a:hover {
            background: rgba(255,255,255,0.08);
            color: #ffffff;
            padding-left: 22px;
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
            background: var(--ry-footer-bg);
            backdrop-filter: blur(8px);
            -webkit-backdrop-filter: blur(8px);
            padding: 0 1rem;
            border-top: 1px solid var(--ry-line-color);
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
            border: 1px solid var(--ry-border);
            color: #ffffff;
            text-decoration: none;
            transition: all 0.2s ease;
        }
        .footer-social a:hover {
            background: rgba(255,255,255,0.12);
            border-color: rgba(255,255,255,0.25);
            color: #ffffff;
        }
        .footer-social svg { width: 16px; height: 16px; }
        .footer-social i { font-size: 16px; }
        .footer-legal {
            display: flex;
            align-items: center;
            flex-wrap: wrap;
            gap: 14px;
            line-height: 1.2;
            font-family: Arial, sans-serif;
            font-size: 13px;
            color: #ffffff;
        }
        .footer-legal a {
            color: #ffffff;
            text-decoration: none;
        }
        .footer-legal a:hover {
            color: rgba(255,255,255,0.9);
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
            background: var(--ry-bar-bg);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border-top: 1px solid var(--ry-line-color);
            border-bottom: 1px solid var(--ry-line-color);
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
            background: #ffffff;
            flex-shrink: 0;
        }
        .player-status.paused .dot { background: rgba(255,255,255,0.5); }
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
            background: rgba(255,255,255,0.12);
            border-color: rgba(255,255,255,0.25);
        }
        .player-mute-btn.muted { color: rgba(255,255,255,0.5); }
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
            background: #ffffff;
            cursor: pointer;
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
        body.playing .player-eq span { background: #ffffff; }
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
            .nav-logo { flex-direction: row; max-width: 240px; }
            .nav-logo img { height: 52px; }
            .navbar.is-scrolled .nav-logo img { height: 46px; }
            .nav-logo-slogan-wrap { padding: 0.2rem 0.4rem; max-width: 110px; min-width: 60px; }
            .nav-logo-slogan { font-size: clamp(0.5rem, 2.5vw, 0.6rem); letter-spacing: 0.02em; }
            .nav-center {
                position: fixed;
                top: 0;
                right: -300px;
                width: 300px;
                height: 100vh;
                background: var(--ry-header-bg);
                backdrop-filter: blur(16px);
                -webkit-backdrop-filter: blur(16px);
                flex: none;
                flex-direction: column;
                align-items: stretch;
                padding: 5rem 1.25rem 2rem;
                border-left: 1px solid var(--ry-border);
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
            .nav-menu > li > a { padding: 0.75rem 1rem; font-size: 0.9rem; white-space: normal; min-height: 44px; display: flex; align-items: center; }
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
                justify-content: flex-end;
                flex-wrap: wrap;
                gap: 0.75rem;
                margin-top: 1.5rem;
                padding-top: 1.5rem;
                border-top: 1px solid var(--ry-border);
            }
            .navbar .nav-center .nav-right .header-social-icon { width: 44px; height: 44px; }
            .navbar .nav-center .nav-right .header-social-icon i { font-size: 1.25rem; }
            .nav-center .nav-right .header-social { gap: 12px; }
            .header-social-auth-inline { display: none !important; }
            .header-bar-auth { display: flex !important; }
            .header-auth-mobile { display: flex !important; }
            .header-more-wrap { display: block !important; }
            .nav-center .nav-right { flex-direction: row; align-items: center; justify-content: flex-start; flex-wrap: wrap; gap: 1rem; }
            .header-auth-mobile .header-auth-logout-form { flex: 1; min-width: 120px; }
            .header-auth-mobile .header-auth-logout-form .header-auth-btn { width: 100%; }
            .nav-toggle { display: flex; align-items: center; justify-content: center; }
        }
        @media (max-width: 768px) {
            .nav-logo { max-width: 220px; }
            .nav-logo img { height: 50px; }
            .navbar.is-scrolled .nav-logo img { height: 44px; }
            .nav-logo-slogan-wrap { max-width: 100px; min-width: 50px; }
            .nav-logo-slogan { font-size: clamp(0.48rem, 2.8vw, 0.58rem); }
            .bottom-bar-player { padding: 0 1rem; gap: 0.5rem; }
            .player-status-group { font-size: 0.7rem; }
            .player-volume-wrap { min-width: 60px; }
            .player-volume-wrap input[type="range"] { width: 50px; }
            .player-eq { display: none; }
        }
        @media (max-width: 480px) {
            .nav-logo { max-width: 200px; }
            .nav-logo-slogan-wrap { max-width: 90px; padding: 0.15rem 0.3rem; }
            .nav-logo-slogan { font-size: clamp(0.45rem, 3vw, 0.55rem); }
            .nav-center { width: min(300px, 100vw - 2rem); }
            .header-more-dropdown { min-width: 180px; right: 0; left: auto; }
            .header-auth-btn { min-height: 44px; }
            .header-bar-auth-btn { min-height: 40px; padding: 0.3rem 0.5rem; font-size: 0.75rem; }
        }
        @media (min-width: 993px) and (max-width: 1200px) {
            .nav-menu > li > a { font-size: 0.75rem; padding: 0.45rem 0.6rem; }
            .header-auth-btn { font-size: 0.75rem; padding: 0.35rem 0.6rem; min-height: 40px; }
            .navbar .header-social-icon { width: 36px; height: 36px; }
            .navbar .header-social-icon i { font-size: 1rem; }
        }
        @media (min-width: 993px) {
            .nav-toggle { display: none; }
            .header-social-auth-inline { display: flex !important; }
            .header-bar-auth { display: none !important; }
            .header-auth-mobile { display: none !important; }
            .header-more-wrap { display: none !important; }
        }
        /* Footer Logo Player */
        .disc-overlay {
            position: absolute;
            width: 48px;
            height: 48px;
            border-radius: 50%;
            background: var(--ry-btn-bg);
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
            border-left: 14px solid var(--ry-text);
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
            background: var(--ry-text);
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
            .footer-social i { font-size: 14px; }
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
        .request-modal__box { position: relative; background: var(--ry-surface); border: 1px solid var(--ry-border); border-top: 1px solid var(--ry-line-color); border-bottom: 1px solid var(--ry-line-color); border-radius: var(--ry-radius); padding: 1.5rem; max-width: 420px; width: 100%; box-shadow: 0 20px 60px rgba(0,0,0,.5); }
        .request-modal__close { position: absolute; top: .75rem; right: .75rem; background: none; border: none; color: var(--ry-text-muted); font-size: 1.5rem; cursor: pointer; line-height: 1; padding: 4px; }
        .request-modal__close:hover { color: var(--ry-text); }
        .request-modal__title { margin-bottom: 1rem; font-size: 1.25rem; }
        .request-form__group { margin-bottom: 1rem; }
        .request-form__group label { display: block; margin-bottom: .35rem; font-size: .9rem; }
        .request-form__input { width: 100%; padding: .5rem .75rem; background: rgba(15,23,42,0.8); border: 1px solid var(--ry-border); border-radius: calc(var(--ry-radius) - 2px); color: #fff; font-size: 1rem; }
        .request-form__input:focus { outline: none; border-color: rgba(255,255,255,0.4); }
        .request-form__error { display: block; font-size: .8rem; color: rgba(255,255,255,0.9); margin-top: .25rem; }
        .request-form__success { padding: .5rem; border-radius: 6px; margin-bottom: 1rem; }
        .request-form__actions { margin-top: 1rem; }
        .request-form__btn { padding: .75rem 1.5rem; background: var(--ry-btn-bg); color: #fff; border: none; border-radius: calc(var(--ry-radius) - 2px); font-weight: 600; cursor: pointer; }
        .request-form__btn:hover { opacity: .9; }
    </style>
    @stack('styles')
    <style id="fixed-button-styles">
        .btn-primary, .btn-live, .btn-request, .btn-whatsapp-istek, .home-slider__btn, .glass-btn, .btn-istek, .share-btn, .ry-btn-primary { background: var(--ry-btn-bg) !important; border-color: var(--ry-btn-bg) !important; color: #fff !important; }
        .btn-primary:hover, .btn-live:hover, .btn-request:hover, .btn-whatsapp-istek:hover:not(.btn-whatsapp-disabled), .home-slider__btn:hover, .glass-btn:hover, .btn-istek:hover, .share-btn:hover, .ry-btn-primary:hover { background: var(--ry-btn-hover) !important; border-color: var(--ry-btn-hover) !important; box-shadow: 0 0 18px color-mix(in srgb, var(--ry-btn-hover) 50%, transparent) !important; }
        .btn-request-group { box-shadow: 0 4px 20px color-mix(in srgb, var(--ry-btn-bg) 35%, transparent) !important; }
        .btn-request-group:hover { box-shadow: 0 6px 24px color-mix(in srgb, var(--ry-btn-hover) 40%, transparent) !important; }
    </style>
    <style id="glass-btn-styles">
        .glass-btn,
        a.glass-btn,
        button.glass-btn {
            position: relative !important;
            display: inline-flex !important;
            align-items: center !important;
            justify-content: center !important;
            background: var(--ry-btn-bg) !important;
            backdrop-filter: blur(12px) !important;
            -webkit-backdrop-filter: blur(12px) !important;
            border: 1px solid var(--ry-btn-bg) !important;
            border-radius: var(--ry-radius) !important;
            padding: 10px 22px !important;
            color: #fff !important;
            font-weight: 600 !important;
            letter-spacing: .4px !important;
            text-decoration: none !important;
            cursor: pointer !important;
            transition: all .35s ease !important;
            box-shadow: 0 6px 20px rgba(0,0,0,0.35) !important;
        }
        .glass-btn::before,
        a.glass-btn::before,
        button.glass-btn::before {
            content: "" !important;
            position: absolute !important;
            inset: 0 !important;
            border-radius: var(--ry-radius) !important;
            background: linear-gradient(120deg, rgba(255,255,255,0.2), rgba(255,255,255,0)) !important;
            opacity: .4 !important;
            pointer-events: none !important;
        }
        .glass-btn:hover,
        a.glass-btn:hover,
        button.glass-btn:hover {
            transform: translateY(-3px) scale(1.05) !important;
            box-shadow: 0 0 20px color-mix(in srgb, var(--ry-btn-hover) 50%, transparent), 0 8px 25px rgba(0,0,0,0.45) !important;
            background: var(--ry-btn-hover) !important;
        }
        .glass-btn:active,
        a.glass-btn:active,
        button.glass-btn:active {
            transform: scale(.97) !important;
        }
        .glass-btn:focus-visible,
        a.glass-btn:focus-visible,
        button.glass-btn:focus-visible {
            outline: 2px solid var(--ry-btn-hover) !important;
            outline-offset: 3px !important;
        }
    </style>
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
                @endif
                @if($logoUrl || file_exists(public_path('logo.png')))
                    @if($siteSlogan)
                        <span class="nav-logo-slogan-wrap"><span class="nav-logo-slogan">{{ $siteSlogan }}</span></span>
                    @endif
                @else
                    <span class="nav-logo-text">{{ $siteName }}</span>
                @endif
            </a>
            <div class="nav-center" id="navCenter">
                <ul class="nav-menu" id="navMenu">
                    @php $headerMenu = $headerMenu ?? collect(); @endphp
                    @if($headerMenu->isNotEmpty())
                        @foreach($headerMenu as $m)
                            @php $path = ltrim($m->url ?? '', '/'); $isActive = ($path === '' || $path === '/') ? request()->is('/') : request()->is($path, $path.'/*'); @endphp
                            @if($m->children->isNotEmpty())
                                <li class="nav-dropdown">
                                    <a href="{{ $m->href }}" class="{{ $isActive ? 'active' : '' }}" @if($m->target_blank) target="_blank" rel="noopener noreferrer" @endif>{{ $m->title }}<span class="arrow">▾</span></a>
                                    <ul class="nav-dropdown-menu">
                                        @foreach($m->children as $c)
                                            <li><a href="{{ $c->href }}" @if($c->target_blank) target="_blank" rel="noopener noreferrer" @endif>{{ $c->title }}</a></li>
                                        @endforeach
                                    </ul>
                                </li>
                            @else
                                <li><a href="{{ $m->href }}" class="{{ $isActive ? 'active' : '' }}" @if($m->target_blank) target="_blank" rel="noopener noreferrer" @endif>{{ $m->title }}</a></li>
                            @endif
                        @endforeach
                        @auth
                        <li><a href="{{ route('forum.index') }}" class="{{ request()->is('forum', 'forum/*') ? 'active' : '' }}">Forum</a></li>
                        @endauth
                    @else
                        {{-- Fallback: hardcoded menu --}}
                        <li><a href="{{ url('/') }}" class="{{ request()->is('/') ? 'active' : '' }}">Anasayfa</a></li>
                        <li><a href="{{ url('/programlar') }}" class="{{ request()->is('programlar') ? 'active' : '' }}">Programlar</a></li>
                        <li><a href="{{ url('/haberler') }}" class="{{ request()->is('haberler') ? 'active' : '' }}">Haberler</a></li>
                        <li class="nav-dropdown">
                            <a href="{{ url('/videolar') }}" class="{{ request()->is('videolar', 'galeri') ? 'active' : '' }}">Medya<span class="arrow">▾</span></a>
                            <ul class="nav-dropdown-menu">
                                <li><a href="{{ url('/videolar') }}" class="{{ request()->is('videolar') ? 'active' : '' }}">Video Galeri</a></li>
                                <li><a href="{{ url('/galeri') }}" class="{{ request()->is('galeri') ? 'active' : '' }}">Foto Galeri</a></li>
                            </ul>
                        </li>
                        <li><a href="{{ url('/reklam') }}" class="{{ request()->is('reklam') ? 'active' : '' }}">Sponsorlar</a></li>
                        <li class="nav-dropdown">
                            <a href="{{ url('/hakkimizda/biz-kimiz') }}" class="{{ request()->is('hakkimizda/*') ? 'active' : '' }}">Hakkımızda<span class="arrow">▾</span></a>
                            <ul class="nav-dropdown-menu">
                                <li><a href="{{ url('/hakkimizda/biz-kimiz') }}">Biz Kimiz</a></li>
                                <li><a href="{{ url('/hakkimizda/misyon') }}">Misyon & Vizyon</a></li>
                                <li><a href="{{ url('/hakkimizda/politika') }}">Yayın Politikamız</a></li>
                            </ul>
                        </li>
                        <li><a href="{{ url('/iletisim') }}" class="{{ request()->is('iletisim') ? 'active' : '' }}">İletişim</a></li>
                        @auth
                        <li><a href="{{ route('forum.index') }}" class="{{ request()->is('forum', 'forum/*') ? 'active' : '' }}">Forum</a></li>
                        @endauth
                    @endif
                </ul>
                <div class="nav-right">
                {{-- Desktop: social + auth inline --}}
                <div class="header-social-auth header-social-auth-inline">
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
                    <div class="header-auth">
                        @guest
                            <a href="{{ route('register') }}" class="header-auth-btn header-auth-register">Üye Ol</a>
                            <a href="{{ route('login') }}" class="header-auth-btn header-auth-login">Giriş Yap</a>
                        @else
                            <a href="{{ route('profile') }}" class="header-auth-btn header-auth-profile">Hesabım</a>
                            <form method="POST" action="{{ route('logout') }}" class="header-auth-logout-form">
                                @csrf
                                <button type="submit" class="header-auth-btn header-auth-logout">Çıkış</button>
                            </form>
                        @endguest
                    </div>
                </div>
                {{-- Mobile: auth buttons always visible + social in dropdown --}}
                <div class="header-auth-mobile">
                    @guest
                        <a href="{{ route('register') }}" class="header-auth-btn header-auth-register">Üye Ol</a>
                        <a href="{{ route('login') }}" class="header-auth-btn header-auth-login">Giriş Yap</a>
                    @else
                        <a href="{{ route('profile') }}" class="header-auth-btn header-auth-profile">Hesabım</a>
                        <form method="POST" action="{{ route('logout') }}" class="header-auth-logout-form">
                            @csrf
                            <button type="submit" class="header-auth-btn header-auth-logout">Çıkış</button>
                        </form>
                    @endguest
                </div>
                <div class="header-more-wrap">
                    <button type="button" class="header-more-btn" id="headerMoreBtn" aria-label="Sosyal medya" aria-expanded="false">
                        <i class="bi bi-share"></i>
                    </button>
                    <div class="header-more-dropdown" id="headerMoreDropdown" aria-hidden="true">
                        <div class="header-social nav-social header-more-social">
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
            </div>
            </div>
            {{-- Mobil header bar: logo ile hamburger arasında Üye Ol / Giriş Yap --}}
            <div class="header-bar-auth">
                @guest
                    <a href="{{ route('register') }}" class="header-bar-auth-btn header-bar-auth-register">Üye Ol</a>
                    <a href="{{ route('login') }}" class="header-bar-auth-btn header-bar-auth-login">Giriş Yap</a>
                @else
                    <a href="{{ route('profile') }}" class="header-bar-auth-btn header-bar-auth-profile">Hesabım</a>
                    <form method="POST" action="{{ route('logout') }}" class="header-bar-auth-form">
                        @csrf
                        <button type="submit" class="header-bar-auth-btn header-bar-auth-logout">Çıkış</button>
                    </form>
                @endguest
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
                $footerMenu = $footerMenu ?? collect();
                $footerLinks = [];
                if ($footerMenu->isEmpty()) {
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
                }
            @endphp
            <div class="footer-social">
                @include('partials.social-icons')
            </div>
            <div class="footer-legal">
                | {{ $footerText }} |
                @if($footerMenu->isNotEmpty())
                    @foreach($footerMenu as $m)
                        <a href="{{ $m->href }}" @if($m->target_blank) target="_blank" rel="noopener noreferrer" @endif>{{ $m->title }}</a> |
                    @endforeach
                @else
                    @foreach($footerLinks as $link)
                        @if(!empty($link['label']) && !empty($link['url']))
                            <a href="{{ url($link['url']) }}">{{ $link['label'] }}</a> |
                        @endif
                    @endforeach
                @endif
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
            var moreBtn = document.getElementById('headerMoreBtn');
            var moreDropdown = document.getElementById('headerMoreDropdown');
            if (moreBtn && moreDropdown) {
                moreBtn.addEventListener('click', function(e) {
                    e.stopPropagation();
                    var isOpen = moreDropdown.classList.toggle('is-open');
                    moreBtn.setAttribute('aria-expanded', isOpen);
                    moreDropdown.setAttribute('aria-hidden', !isOpen);
                });
                document.addEventListener('click', function(e) {
                    if (!moreBtn.contains(e.target) && !moreDropdown.contains(e.target)) {
                        moreDropdown.classList.remove('is-open');
                        moreBtn.setAttribute('aria-expanded', 'false');
                        moreDropdown.setAttribute('aria-hidden', 'true');
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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
    <script src="https://r1.comcities.com/system/streaminfo.js"></script>
</body>
</html>
