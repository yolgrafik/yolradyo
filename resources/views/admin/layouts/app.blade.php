<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>RADYOYOL ADMIN PANEL</title>
    <style>
        :root {
            --bg: #0f1319;
            --panel: #161c24;
            --card: #1a2029;
            --text: #f0f2f5;
            --muted: #8b95a5;
            --border: rgba(255, 255, 255, 0.06);
            --accent: #c92a2a;
        }
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }
        body {
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
            background: linear-gradient(180deg, #0d1017 0%, #151a24 50%, #12161f 100%);
            color: var(--text);
            min-height: 100vh;
        }
        .app-wrap {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }
        .topbar {
            background-image: url("{{ asset('assets/images/admin-hero.png') }}");
            background-size: cover;
            background-position: center top;
            background-repeat: no-repeat;
            padding: 1.25rem 1.5rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            min-height: 140px;
            position: relative;
            overflow: hidden;
        }
        .topbar::before {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(90deg, rgba(50, 18, 18, 0.65) 0%, rgba(40, 22, 22, 0.58) 45%, rgba(25, 22, 28, 0.52) 100%);
            pointer-events: none;
        }
        .topbar::after {
            content: '';
            position: absolute;
            inset: 0;
            background: radial-gradient(ellipse 80% 80% at 50% 50%, transparent 30%, rgba(0,0,0,0.2) 100%);
            pointer-events: none;
        }
        .topbar-inner {
            display: flex;
            align-items: center;
            width: 100%;
            position: relative;
            z-index: 1;
        }
        .topbar-spacer {
            flex: 1;
        }
        .topbar-spacer--right {
            display: flex;
            justify-content: flex-end;
        }
        .topbar-top-line {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 1px;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.5), transparent);
            pointer-events: none;
            z-index: 2;
        }
        .topbar-bottom-line {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            height: 2px;
            background: linear-gradient(90deg, transparent 5%, var(--accent) 25%, rgba(255,255,255,0.7) 50%, var(--accent) 75%, transparent 95%);
            box-shadow: 0 0 12px rgba(201, 42, 42, 0.8), 0 0 24px rgba(201, 42, 42, 0.4);
            pointer-events: none;
            z-index: 2;
        }
        .topbar-brand {
            display: flex;
            align-items: center;
            gap: 1.25rem;
            flex: 0 0 auto;
            position: relative;
        }
        .topbar-brand::before {
            content: '';
            position: absolute;
            left: 50%;
            top: 50%;
            transform: translate(-50%, -50%);
            width: 200%;
            height: 220%;
            background: radial-gradient(ellipse 45% 45% at 50% 50%, rgba(255,255,255,0.18) 0%, rgba(255,255,255,0.05) 50%, transparent 75%);
            filter: blur(24px);
            pointer-events: none;
            z-index: 0;
        }
        .topbar-brand > * {
            position: relative;
            z-index: 1;
        }
        .topbar-logo-wrap {
            height: 42px;
            display: flex;
            align-items: center;
        }
        .topbar-logo {
            height: 42px;
            width: auto;
            object-fit: contain;
        }
        .topbar-logo-fallback {
            font-size: 1.2rem;
            font-weight: 700;
            letter-spacing: 0.08em;
            color: #fff;
        }
        .topbar-brand-text {
            display: flex;
            flex-direction: column;
            gap: 0.25rem;
            align-items: center;
            text-align: center;
        }
        .topbar-title {
            font-size: 1.75rem;
            font-weight: 700;
            letter-spacing: 0.12em;
            color: #fff;
            text-shadow: 0 0 20px rgba(255,255,255,0.4), 0 1px 3px rgba(0,0,0,0.3);
        }
        .topbar-sub {
            font-size: 1.0625rem;
            font-weight: 700;
            letter-spacing: 0.28em;
            color: #fff;
            text-shadow: 0 0 16px rgba(255,255,255,0.35), 0 1px 2px rgba(0,0,0,0.25);
        }
        .user-box {
            display: flex;
            align-items: center;
            gap: 1rem;
            background: rgba(0,0,0,0.15);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            padding: 0.6rem 1rem;
            border-radius: 12px;
            border: 1px solid rgba(255,255,255,0.2);
            box-shadow: 0 2px 12px rgba(0,0,0,0.2);
            position: relative;
            z-index: 1;
            transition: box-shadow 0.2s, border-color 0.2s;
        }
        .user-box:hover {
            border-color: rgba(255,255,255,0.35);
            box-shadow: 0 0 20px rgba(255,255,255,0.08);
        }
        .user-info {
            display: flex;
            flex-direction: column;
            align-items: flex-end;
            gap: 0.15rem;
        }
        .user-badge {
            font-size: 0.7rem;
            font-weight: 700;
            color: var(--accent);
            letter-spacing: 0.05em;
        }
        .user-role {
            font-size: 0.8rem;
            color: rgba(255,255,255,0.9);
        }
        .btn-logout {
            padding: 0.5rem 1rem;
            font-size: 0.85rem;
            font-weight: 600;
            background: var(--accent);
            color: #fff;
            border: none;
            border-radius: 8px;
            text-decoration: none;
            cursor: pointer;
            transition: background 0.18s, box-shadow 0.18s;
        }
        .btn-logout:hover {
            background: #e63939;
            box-shadow: 0 2px 12px rgba(201, 42, 42, 0.5);
        }
        .main-row {
            display: flex;
            flex: 1;
        }
        .sidebar {
            width: 270px;
            background: var(--panel);
            padding: 0;
            flex-shrink: 0;
            border-right: 1px solid var(--border);
        }
        .sidebar-brand {
            padding: 0.85rem 1rem;
            border-bottom: 1px solid var(--border);
            margin-bottom: 0.5rem;
        }
        .sidebar-brand-text {
            font-size: 0.8rem;
            font-weight: 700;
            letter-spacing: 0.12em;
            color: var(--accent);
        }
        .nav-accordion {
            padding: 0 1rem 1rem;
        }
        .nav-accordion {
            list-style: none;
        }
        .nav-section {
            margin-bottom: 0.35rem;
        }
        .nav-section + .nav-section {
            margin-top: 0.35rem;
            padding-top: 0.35rem;
            border-top: 1px solid var(--border);
        }
        .nav-section__toggle {
            width: 100%;
            padding: 12px 14px;
            font-size: 0.85rem;
            font-weight: 700;
            color: var(--text);
            background: transparent;
            border: none;
            border-radius: 10px;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 0.6rem;
            text-align: left;
            transition: background 0.18s;
        }
        .nav-section__toggle:hover {
            background: rgba(255, 255, 255, 0.08);
            box-shadow: inset 0 1px 3px rgba(0,0,0,0.15);
        }
        .nav-section.is-open .nav-section__toggle {
            background: rgba(255, 255, 255, 0.06);
            border-left: 4px solid var(--accent);
            padding-left: 10px;
        }
        .nav-section.is-open .nav-section__items {
            background: rgba(255, 255, 255, 0.04);
        }
        .nav-section__toggle .icon {
            width: 20px;
            height: 20px;
            flex-shrink: 0;
            opacity: 0.92;
        }
        .nav-section__chevron {
            margin-left: auto;
            font-size: 0.65rem;
            opacity: 0.7;
            transition: transform 0.2s;
        }
        .nav-section.is-open .nav-section__chevron {
            transform: rotate(180deg);
        }
        .nav-section__items {
            list-style: none;
            margin: 0;
            padding: 0;
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.2s ease-out;
        }
        .nav-section.is-open .nav-section__items {
            max-height: 400px;
        }
        .nav-item {
            display: block;
            padding: 10px 12px 10px 28px;
            font-size: 0.8rem;
            color: var(--muted);
            text-decoration: none;
            border-left: 4px solid transparent;
            transition: background 0.18s, color 0.18s, border-color 0.18s, box-shadow 0.18s;
        }
        .nav-item:hover {
            background: rgba(255, 255, 255, 0.05);
            color: var(--text);
            border-left-color: var(--accent);
            box-shadow: inset 0 1px 4px rgba(0,0,0,0.12);
        }
        .nav-item.is-active {
            background: linear-gradient(90deg, rgba(201, 42, 42, 0.95), var(--accent));
            color: #fff;
            border-left-color: rgba(255, 255, 255, 0.4);
        }
        .content-area {
            flex: 1;
            padding: 28px 32px;
            overflow-x: hidden;
            min-width: 0;
            position: relative;
            background: linear-gradient(180deg, #0c0f14 0%, #0f1319 30%, #12161e 60%, #080a0d 100%);
        }
        .content-area::before {
            content: '';
            position: absolute;
            inset: 0;
            pointer-events: none;
            background: radial-gradient(ellipse 90% 70% at 50% 30%, rgba(201, 42, 42, 0.05) 0%, transparent 55%);
        }
        .content-area::after {
            content: '';
            position: absolute;
            inset: 0;
            pointer-events: none;
            z-index: 0;
            background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 256 256' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='n'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.85' numOctaves='3' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23n)' opacity='0.035'/%3E%3C/svg%3E");
        }
        .content-area .content-bg-vignette {
            position: absolute;
            inset: 0;
            pointer-events: none;
            z-index: 0;
            background: radial-gradient(ellipse 110% 90% at 50% 50%, transparent 35%, rgba(0,0,0,0.45) 100%);
        }
        .content-area .waveform-line {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 2px;
            background: linear-gradient(90deg, transparent 0%, rgba(201, 42, 42, 0.15) 20%, rgba(201, 42, 42, 0.25) 50%, rgba(201, 42, 42, 0.15) 80%, transparent 100%);
            pointer-events: none;
        }
        .content-inner {
            width: 100%;
            max-width: 1400px;
            position: relative;
            z-index: 1;
        }
        .card-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
        }
        .card {
            background: var(--card);
            border-radius: 15px;
            border: 1px solid var(--border);
            box-shadow: 0 4px 16px rgba(0,0,0,0.25), 0 8px 32px rgba(201, 42, 42, 0.04);
            overflow: hidden;
            position: relative;
        }
        .card::before {
            content: '';
            position: absolute;
            inset: 0;
            background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 256 256' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='n'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.9' numOctaves='3' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23n)' opacity='0.025'/%3E%3C/svg%3E");
            pointer-events: none;
        }
        .card-header {
            padding: 13px 1.25rem;
            font-size: 0.95rem;
            font-weight: 700;
            color: #fff;
            background: linear-gradient(135deg, #dc2626 0%, var(--accent) 40%, #a61f1f 100%);
            letter-spacing: 0.02em;
            position: relative;
            border-bottom: 1px solid rgba(255,255,255,0.12);
        }
        .card-body {
            padding: 1.5rem 1.35rem;
            background: linear-gradient(180deg, rgba(255,255,255,0.03) 0%, rgba(255,255,255,0.01) 40%, transparent 100%);
            position: relative;
        }
        .card-value {
            font-size: 32px;
            font-weight: 700;
            color: var(--text);
            line-height: 1.25;
            letter-spacing: -0.02em;
        }
        .card-value-muted {
            font-size: 1.5rem;
            font-weight: 400;
            color: var(--muted);
        }
        .dash-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            margin-top: 24px;
        }
        .dash-box {
            background: var(--card);
            border-radius: 14px;
            border: 1px solid var(--border);
            box-shadow: 0 2px 12px rgba(0,0,0,0.2);
            padding: 1.25rem 1.5rem;
        }
        .dash-box__title {
            font-size: 0.9rem;
            font-weight: 700;
            color: var(--text);
            margin-bottom: 1rem;
            letter-spacing: 0.02em;
        }
        .quick-actions {
            display: flex;
            flex-wrap: wrap;
            gap: 0.6rem;
        }
        .quick-btn {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.6rem 1rem;
            font-size: 0.82rem;
            font-weight: 600;
            color: var(--text);
            background: rgba(255,255,255,0.04);
            border: 1px solid var(--border);
            border-radius: 10px;
            text-decoration: none;
            cursor: pointer;
            transition: background 0.18s, border-color 0.18s, color 0.18s;
        }
        .quick-btn:hover {
            background: rgba(201, 42, 42, 0.18);
            border-color: rgba(201, 42, 42, 0.4);
            color: #fff;
        }
        .activity-list {
            list-style: none;
            margin: 0;
            padding: 0;
        }
        .activity-item {
            padding: 0.65rem 0;
            border-bottom: 1px solid var(--border);
            font-size: 0.85rem;
            color: var(--muted);
        }
        .activity-item:last-child {
            border-bottom: none;
        }
        .activity-item strong {
            color: var(--text);
            font-weight: 600;
        }
        @media (max-width: 1024px) {
            .card-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }
        @media (max-width: 768px) {
            .main-row {
                flex-direction: column;
            }
            .sidebar {
                width: 100%;
                padding: 0;
                border-right: none;
                border-bottom: 1px solid var(--border);
            }
            .sidebar-brand {
                padding: 0.75rem 1rem;
            }
            .topbar-logo-wrap {
                height: 32px;
            }
            .topbar-logo {
                height: 32px;
            }
            .topbar-title {
                font-size: 1.25rem;
                letter-spacing: 0.08em;
            }
            .topbar-sub {
                font-size: 0.9375rem;
                letter-spacing: 0.18em;
            }
            .nav-section + .nav-section {
                margin-top: 0.25rem;
                padding-top: 0.25rem;
            }
            .nav-section__toggle {
                padding: 10px 12px;
            }
            .nav-section.is-open .nav-section__items {
                max-height: 350px;
            }
            .content-area {
                padding: 20px 24px;
            }
            .card-grid {
                grid-template-columns: 1fr;
                gap: 18px;
            }
            .card-value {
                font-size: 28px;
            }
            .dash-row {
                grid-template-columns: 1fr;
                margin-top: 20px;
            }
        }
        .admin-topbar{
          min-height:140px !important;
          position:relative;
        }
        .admin-topbar:not(.admin-hero){
          overflow:hidden;
        }
        .admin-topbar::before{
          content:"";
          position:absolute;
          inset:0;
          background: linear-gradient(90deg, rgba(10,10,14,.75) 0%, rgba(180,30,30,.45) 45%, rgba(10,10,14,.55) 100%);
          pointer-events:none;
        }
        .admin-topbar::after{
          content:"";
          position:absolute;
          left:0;
          right:0;
          bottom:0;
          height:2px;
          background: rgba(220,38,38,.8);
        }
        .admin-hero{
          height: 160px !important;
          min-height: 160px !important;
          overflow: visible !important;
          position: relative !important;
        }
        .topbar.admin-hero{
          height: 170px !important;
          min-height: 170px !important;
          padding: 25px 40px !important;
          display:flex !important;
          align-items:center !important;
          justify-content:space-between !important;
          overflow: visible !important;
        }
    </style>
    @stack('styles')
</head>
<body>
    <div class="app-wrap">
        <header class="topbar admin-topbar admin-hero" style="background-image:url('{{ asset('assets/images/admin-hero.png') }}'); background-size:cover; background-position:center top; background-repeat:no-repeat;">
            <div class="topbar-top-line"></div>
            <div class="topbar-bottom-line"></div>
            <div class="topbar-inner">
                <div class="topbar-spacer"></div>
                <div class="topbar-brand">
                    <div class="topbar-logo-wrap">
                        <img src="{{ asset('logo.png') }}" alt="RADYOYOL" class="topbar-logo" onerror="this.style.display='none'; this.nextElementSibling.style.display='block';">
                        <span class="topbar-logo-fallback" style="display:none">RADYOYOL</span>
                    </div>
                    <div class="topbar-brand-text">
                        <div class="topbar-title">RADYOYOL ADMIN PANEL</div>
                        <div class="topbar-sub">TAM OZELLIK LISTESI</div>
                    </div>
                </div>
                <div class="topbar-spacer topbar-spacer--right">
                <div class="user-box">
                <div class="user-info">
                    <span class="user-badge">Yetkili</span>
                    <span class="user-role">Yonetici</span>
                </div>
                <a href="{{ route('admin.logout') }}" class="btn-logout">Cikis</a>
                </div>
                </div>
            </div>
        </header>

        <div class="main-row">
            <aside class="sidebar">
                <div class="sidebar-brand">
                    <span class="sidebar-brand-text">RADYOYOL</span>
                </div>
                <nav class="nav-accordion" id="navAccordion">
                    <div class="nav-section is-open" data-section="dashboard">
                        <button class="nav-section__toggle" type="button" aria-expanded="true">
                            <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/></svg>
                            <span>Dashboard</span>
                            <span class="nav-section__chevron">&#9660;</span>
                        </button>
                        <ul class="nav-section__items">
                            <li><a href="{{ route('admin.dashboard') }}" class="nav-item {{ request()->routeIs('admin.dashboard') ? 'is-active' : '' }}">Genel Bakis</a></li>
                            <li><a href="#" class="nav-item">Anlik Dinleyici</a></li>
                            <li><a href="#" class="nav-item">Yayin Durumu</a></li>
                            <li><a href="#" class="nav-item">Now Playing</a></li>
                        </ul>
                    </div>
                    <div class="nav-section" data-section="yayin">
                        <button class="nav-section__toggle" type="button" aria-expanded="false">
                            <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 2a3 3 0 0 0-3 3v7a3 3 0 0 0 6 0V5a3 3 0 0 0-3-3z"/><path d="M19 10v2a7 7 0 0 1-14 0v-2"/><line x1="12" y1="19" x2="12" y2="22"/></svg>
                            <span>Yayin Yonetimi (Shoutcast)</span>
                            <span class="nav-section__chevron">&#9660;</span>
                        </button>
                        <ul class="nav-section__items">
                            <li><a href="#" class="nav-item">Stream Link Ayarlari</a></li>
                            <li><a href="#" class="nav-item">Online / Offline Kontrol</a></li>
                            <li><a href="#" class="nav-item">Now Playing Kontrol</a></li>
                            <li><a href="#" class="nav-item">Yedek Stream</a></li>
                            <li><a href="#" class="nav-item">Web Player Yonetimi</a></li>
                        </ul>
                    </div>
                    <div class="nav-section" data-section="haberler">
                        <button class="nav-section__toggle" type="button" aria-expanded="false">
                            <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 22h16a2 2 0 0 0 2-2V4a2 2 0 0 0-2-2H4a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2z"/><line x1="7" y1="8" x2="17" y2="8"/><line x1="7" y1="12" x2="17" y2="12"/></svg>
                            <span>Haberler</span>
                            <span class="nav-section__chevron">&#9660;</span>
                        </button>
                        <ul class="nav-section__items">
                            <li><a href="#" class="nav-item">Tum Haberler (liste + arama)</a></li>
                            <li><a href="#" class="nav-item">Haber Ekle</a></li>
                            <li><a href="#" class="nav-item">Haber Duzenle</a></li>
                            <li><a href="#" class="nav-item">Haber Sil</a></li>
                            <li><a href="#" class="nav-item">Kategori Yonetimi</a></li>
                            <li><a href="#" class="nav-item">One Cikan Ayari</a></li>
                            <li><a href="#" class="nav-item">Yayin Tarihi Planlama</a></li>
                        </ul>
                    </div>
                    <div class="nav-section" data-section="videolar">
                        <button class="nav-section__toggle" type="button" aria-expanded="false">
                            <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polygon points="23 7 16 12 23 17 23 7"/><rect x="1" y="5" width="15" height="14" rx="2" ry="2"/></svg>
                            <span>Videolar</span>
                            <span class="nav-section__chevron">&#9660;</span>
                        </button>
                        <ul class="nav-section__items">
                            <li><a href="#" class="nav-item">Tum Videolar</a></li>
                            <li><a href="#" class="nav-item">Video Ekle</a></li>
                            <li><a href="#" class="nav-item">Video Duzenle</a></li>
                            <li><a href="#" class="nav-item">Video Sil</a></li>
                            <li><a href="#" class="nav-item">One Cikan Video</a></li>
                        </ul>
                    </div>
                    <div class="nav-section" data-section="foto">
                        <button class="nav-section__toggle" type="button" aria-expanded="false">
                            <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
                            <span>Foto Galeri</span>
                            <span class="nav-section__chevron">&#9660;</span>
                        </button>
                        <ul class="nav-section__items">
                            <li><a href="#" class="nav-item">Albumler</a></li>
                            <li><a href="#" class="nav-item">Foto Ekle</a></li>
                            <li><a href="#" class="nav-item">Toplu Foto Yukleme</a></li>
                            <li><a href="#" class="nav-item">Foto Duzenle</a></li>
                            <li><a href="#" class="nav-item">Foto Sil</a></li>
                        </ul>
                    </div>
                    <div class="nav-section" data-section="program">
                        <button class="nav-section__toggle" type="button" aria-expanded="false">
                            <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 2a3 3 0 0 0-3 3v7a3 3 0 0 0 6 0V5a3 3 0 0 0-3-3z"/><path d="M19 10v2a7 7 0 0 1-14 0v-2"/></svg>
                            <span>Program & DJ</span>
                            <span class="nav-section__chevron">&#9660;</span>
                        </button>
                        <ul class="nav-section__items">
                            <li><a href="#" class="nav-item">Program Listesi</a></li>
                            <li><a href="#" class="nav-item">Program Ekle</a></li>
                            <li><a href="#" class="nav-item">Program Duzenle</a></li>
                            <li><a href="#" class="nav-item">Program Sil</a></li>
                            <li><a href="#" class="nav-item">DJ Profilleri</a></li>
                            <li><a href="#" class="nav-item">Yayin Takvimi</a></li>
                        </ul>
                    </div>
                    <div class="nav-section" data-section="reklam">
                        <button class="nav-section__toggle" type="button" aria-expanded="false">
                            <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V7a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/><line x1="7" y1="10" x2="7.01" y2="10"/><line x1="11" y1="10" x2="13" y2="10"/></svg>
                            <span>Reklam Yonetimi</span>
                            <span class="nav-section__chevron">&#9660;</span>
                        </button>
                        <ul class="nav-section__items">
                            <li><a href="#" class="nav-item">Banner Alanlari</a></li>
                            <li><a href="#" class="nav-item">Popup Reklam</a></li>
                            <li><a href="#" class="nav-item">Sponsor Yonetimi</a></li>
                            <li><a href="#" class="nav-item">Kampanya Takibi</a></li>
                        </ul>
                    </div>
                    <div class="nav-section" data-section="mesaj">
                        <button class="nav-section__toggle" type="button" aria-expanded="false">
                            <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
                            <span>Mesaj & Istek</span>
                            <span class="nav-section__chevron">&#9660;</span>
                        </button>
                        <ul class="nav-section__items">
                            <li><a href="#" class="nav-item">Gelen Mesajlar</a></li>
                            <li><a href="#" class="nav-item">Sarki Istekleri</a></li>
                            <li><a href="#" class="nav-item">Moderasyon</a></li>
                            <li><a href="#" class="nav-item">Kara Liste</a></li>
                        </ul>
                    </div>
                    <div class="nav-section" data-section="ayarlar">
                        <button class="nav-section__toggle" type="button" aria-expanded="false">
                            <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="3"/><path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z"/></svg>
                            <span>Ayarlar</span>
                            <span class="nav-section__chevron">&#9660;</span>
                        </button>
                        <ul class="nav-section__items">
                            <li><a href="#" class="nav-item">Genel Site Ayarlari</a></li>
                            <li><a href="#" class="nav-item">Logo & Favicon</a></li>
                            <li><a href="#" class="nav-item">SEO Ayarlari</a></li>
                            <li><a href="#" class="nav-item">Sosyal Medya Linkleri</a></li>
                            <li><a href="#" class="nav-item">Footer Yonetimi</a></li>
                            <li><a href="#" class="nav-item">Tema & Renk Ayarlari</a></li>
                        </ul>
                    </div>
                    <div class="nav-section" data-section="kullanici">
                        <button class="nav-section__toggle" type="button" aria-expanded="false">
                            <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                            <span>Kullanici Yonetimi</span>
                            <span class="nav-section__chevron">&#9660;</span>
                        </button>
                        <ul class="nav-section__items">
                            <li><a href="#" class="nav-item">Yonetici Hesaplari</a></li>
                            <li><a href="#" class="nav-item">Rol & Yetkiler</a></li>
                            <li><a href="#" class="nav-item">Aktivite Loglari</a></li>
                            <li><a href="#" class="nav-item">2FA Guvenlik</a></li>
                        </ul>
                    </div>
                </nav>
            </aside>

            <main class="content-area">
                <div class="waveform-line"></div>
                <div class="content-bg-vignette"></div>
                <div class="content-inner">
                    @yield('content')
                </div>
            </main>
        </div>
    </div>
    <script>
        (function() {
            var accordion = document.getElementById('navAccordion');
            if (!accordion) return;

            var sections = accordion.querySelectorAll('.nav-section');
            var toggles = accordion.querySelectorAll('.nav-section__toggle');

            function closeAllExcept(openSection) {
                sections.forEach(function(section) {
                    if (section !== openSection) {
                        section.classList.remove('is-open');
                        var btn = section.querySelector('.nav-section__toggle');
                        if (btn) btn.setAttribute('aria-expanded', 'false');
                    }
                });
            }

            toggles.forEach(function(toggle) {
                toggle.addEventListener('click', function() {
                    var section = toggle.closest('.nav-section');
                    var isOpen = section.classList.contains('is-open');

                    closeAllExcept(isOpen ? null : section);

                    if (isOpen) {
                        section.classList.remove('is-open');
                        toggle.setAttribute('aria-expanded', 'false');
                    } else {
                        section.classList.add('is-open');
                        toggle.setAttribute('aria-expanded', 'true');
                    }
                });
            });
        })();
    </script>
    @stack('scripts')
</body>
</html>
