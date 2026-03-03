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
            background: linear-gradient(90deg, #5c1010 0%, #7f1d1d 30%, #991b1b 55%, #8b1a1a 80%, #6b1515 100%);
            padding: 1rem 1.5rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            min-height: 72px;
            position: relative;
        }
        .topbar::before {
            content: '';
            position: absolute;
            inset: 0;
            background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 256 256' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='n'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.8' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23n)' opacity='0.04'/%3E%3C/svg%3E");
            pointer-events: none;
        }
        .topbar::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 1px;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
            pointer-events: none;
        }
        .topbar-brand {
            display: flex;
            align-items: center;
            gap: 1rem;
            position: relative;
            z-index: 1;
        }
        .topbar-logo {
            height: 38px;
            width: auto;
            object-fit: contain;
        }
        .topbar-brand-text {
            display: flex;
            flex-direction: column;
            gap: 0.15rem;
        }
        .topbar-title {
            font-size: 1.1rem;
            font-weight: 700;
            letter-spacing: 0.06em;
            color: #fff;
        }
        .topbar-sub {
            font-size: 0.68rem;
            letter-spacing: 0.22em;
            color: rgba(255,255,255,0.8);
        }
        .user-box {
            display: flex;
            align-items: center;
            gap: 1rem;
            background: rgba(0,0,0,0.2);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            padding: 0.6rem 1rem;
            border-radius: 12px;
            border: 1px solid rgba(255,255,255,0.15);
            box-shadow: 0 4px 20px rgba(0,0,0,0.25);
            position: relative;
            z-index: 1;
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
            padding: 1rem 1rem 0.75rem;
            border-bottom: 1px solid var(--border);
            margin-bottom: 0.5rem;
        }
        .sidebar-brand-inner {
            display: flex;
            align-items: center;
            gap: 0.6rem;
        }
        .sidebar-brand-logo {
            height: 28px;
            width: auto;
            object-fit: contain;
        }
        .sidebar-brand-text {
            font-size: 0.95rem;
            font-weight: 700;
            letter-spacing: 0.08em;
            color: var(--accent);
        }
        .sidebar-brand .logo-fallback {
            font-size: 0.9rem;
            font-weight: 700;
            letter-spacing: 0.08em;
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
            background: rgba(255, 255, 255, 0.09);
        }
        .nav-section.is-open .nav-section__toggle {
            background: rgba(255, 255, 255, 0.08);
            border-left: 3px solid var(--accent);
            padding-left: 11px;
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
            border-left: 3px solid transparent;
            transition: background 0.18s, color 0.18s, border-color 0.18s, box-shadow 0.18s;
        }
        .nav-item:hover {
            background: rgba(255, 255, 255, 0.06);
            color: var(--text);
            border-left-color: var(--accent);
            box-shadow: inset 0 0 20px rgba(201, 42, 42, 0.08);
        }
        .nav-item.is-active {
            background: var(--accent);
            color: #fff;
            border-left-color: rgba(255, 255, 255, 0.3);
        }
        .content-area {
            flex: 1;
            padding: 28px 32px;
            overflow-x: hidden;
            min-width: 0;
            position: relative;
            background: linear-gradient(180deg, #0a0d12 0%, #0f1319 35%, #131820 70%, #0d1015 100%);
        }
        .content-area::before {
            content: '';
            position: absolute;
            inset: 0;
            pointer-events: none;
            background: radial-gradient(ellipse 100% 80% at 50% 20%, rgba(201, 42, 42, 0.04) 0%, transparent 50%);
        }
        .content-area::after {
            content: '';
            position: absolute;
            inset: 0;
            pointer-events: none;
            background: radial-gradient(ellipse 120% 100% at 50% 50%, transparent 40%, rgba(0,0,0,0.4) 100%);
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
            box-shadow: 0 4px 16px rgba(0,0,0,0.3);
            overflow: hidden;
            position: relative;
        }
        .card::before {
            content: '';
            position: absolute;
            inset: 0;
            background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 256 256' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='n'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.9' numOctaves='3' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23n)' opacity='0.02'/%3E%3C/svg%3E");
            pointer-events: none;
        }
        .card-header {
            padding: 13px 1.25rem;
            font-size: 0.95rem;
            font-weight: 700;
            color: #fff;
            background: linear-gradient(135deg, var(--accent) 0%, #a61f1f 50%, #8b1a1a 100%);
            letter-spacing: 0.02em;
            position: relative;
            border-bottom: 1px solid rgba(255,255,255,0.1);
        }
        .card-body {
            padding: 1.5rem 1.35rem;
            background: linear-gradient(180deg, rgba(255,255,255,0.02) 0%, transparent 100%);
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
                padding: 0.5rem;
                border-right: none;
                border-bottom: 1px solid var(--border);
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
    </style>
    @stack('styles')
</head>
<body>
    <div class="app-wrap">
        <header class="topbar">
            <div class="topbar-brand">
                <div class="topbar-logo-wrap">
                    <img src="{{ asset('assets/brand/radyoyol-logo.png') }}" alt="RADYOYOL" class="topbar-logo" onerror="this.style.display='none'; this.nextElementSibling.style.display='block';">
                    <span class="topbar-logo-fallback" style="display:none">RADYOYOL</span>
                </div>
                <div class="topbar-brand-text">
                    <div class="topbar-title">RADYOYOL ADMIN PANEL</div>
                    <div class="topbar-sub">TAM OZELLIK LISTESI</div>
                </div>
            </div>
            <div class="user-box">
                <div class="user-info">
                    <span class="user-badge">Yetkili</span>
                    <span class="user-role">Yonetici</span>
                </div>
                <a href="{{ route('admin.logout') }}" class="btn-logout">Cikis</a>
            </div>
        </header>

        <div class="main-row">
            <aside class="sidebar">
                <div class="sidebar-brand">
                    <div class="sidebar-brand-inner">
                        <img src="{{ asset('assets/brand/radyoyol-logo.png') }}" alt="RADYOYOL" class="sidebar-brand-logo" onerror="this.style.display='none'; this.nextElementSibling.style.display='inline';">
                        <span class="logo-fallback" style="display:none">RADYOYOL</span>
                        <span class="sidebar-brand-text">RADYOYOL</span>
                    </div>
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
