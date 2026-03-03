<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>RADYOYOL ADMIN PANEL</title>
    <style>
        :root {
            --bg: #151a24;
            --panel: #1c2128;
            --card: #1e2530;
            --text: #f0f2f5;
            --muted: #8b95a5;
            --border: rgba(255, 255, 255, 0.06);
            --accent: #dc2626;
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
            background: linear-gradient(90deg, #b91c1c 0%, #991b1b 35%, #7f1d1d 70%, #450a0a 100%);
            padding: 1rem 1.5rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            min-height: 68px;
        }
        .topbar-brand {
            display: flex;
            flex-direction: column;
            gap: 0.2rem;
        }
        .topbar-title {
            font-size: 1.15rem;
            font-weight: 700;
            letter-spacing: 0.06em;
            color: #fff;
        }
        .topbar-sub {
            font-size: 0.7rem;
            letter-spacing: 0.2em;
            color: rgba(255,255,255,0.85);
        }
        .user-box {
            display: flex;
            align-items: center;
            gap: 1rem;
            background: rgba(0,0,0,0.3);
            padding: 0.6rem 1rem;
            border-radius: 10px;
            border: 1px solid rgba(255,255,255,0.08);
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
            transition: background 0.15s;
        }
        .btn-logout:hover {
            background: #b91c1c;
        }
        .main-row {
            display: flex;
            flex: 1;
        }
        .sidebar {
            width: 270px;
            background: var(--panel);
            padding: 1rem 0;
            flex-shrink: 0;
            border-right: 1px solid var(--border);
        }
        .sidebar-section {
            margin-bottom: 0;
        }
        .sidebar-section + .sidebar-section {
            margin-top: 0.5rem;
            padding-top: 0.5rem;
            border-top: 1px solid var(--border);
        }
        .sidebar-section-title {
            font-size: 0.83rem;
            font-weight: 700;
            color: var(--text);
            padding: 0.65rem 1rem;
            display: flex;
            align-items: center;
            gap: 0.6rem;
            text-decoration: none;
            transition: background 0.2s;
            cursor: default;
        }
        a.sidebar-section-title {
            cursor: pointer;
        }
        .sidebar-section-title .icon {
            width: 18px;
            height: 18px;
            flex-shrink: 0;
            opacity: 0.9;
        }
        .sidebar-section-title:hover {
            background: rgba(220, 38, 38, 0.2);
        }
        .sidebar-section.active .sidebar-section-title {
            background: var(--accent);
            color: #fff;
        }
        .sidebar-item {
            font-size: 0.8rem;
            color: var(--muted);
            padding: 0.45rem 1rem 0.45rem 2.25rem;
            display: flex;
            align-items: center;
            gap: 0.4rem;
            transition: color 0.15s, background 0.15s;
        }
        .sidebar-item:hover {
            color: var(--text);
            background: rgba(255,255,255,0.03);
        }
        .sidebar-item::before {
            content: '▸';
            font-size: 0.6rem;
            opacity: 0.7;
        }
        .content-area {
            flex: 1;
            padding: 28px 32px;
            overflow-x: hidden;
            min-width: 0;
        }
        .content-inner {
            width: 100%;
            max-width: 1400px;
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
            box-shadow: 0 2px 8px rgba(0,0,0,0.2);
            overflow: hidden;
        }
        .card-header {
            padding: 13px 1.25rem;
            font-size: 0.95rem;
            font-weight: 700;
            color: #fff;
            background: linear-gradient(135deg, var(--accent), #991b1b);
            letter-spacing: 0.02em;
        }
        .card-body {
            padding: 1.5rem 1.25rem;
        }
        .card-value {
            font-size: 32px;
            font-weight: 700;
            color: var(--text);
            line-height: 1.2;
        }
        .card-value-muted {
            font-size: 1.5rem;
            font-weight: 400;
            color: var(--muted);
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
                display: flex;
                flex-wrap: wrap;
                gap: 0.25rem;
                border-right: none;
                border-bottom: 1px solid var(--border);
            }
            .sidebar-section {
                flex: 0 1 auto;
                margin-bottom: 0;
            }
            .sidebar-section + .sidebar-section {
                margin-top: 0;
                padding-top: 0;
                border-top: none;
            }
            .sidebar-section-title {
                padding: 0.5rem 0.75rem;
            }
            .sidebar-item {
                display: none;
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
        }
    </style>
    @stack('styles')
</head>
<body>
    <div class="app-wrap">
        <header class="topbar">
            <div class="topbar-brand">
                <div class="topbar-title">RADYOYOL ADMIN PANEL</div>
                <div class="topbar-sub">TAM OZELLIK LISTESI</div>
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
                <div class="sidebar-section active">
                    <a href="{{ route('admin.dashboard') }}" class="sidebar-section-title">
                        <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/></svg>
                        Dashboard
                    </a>
                    <div class="sidebar-item">Genel Bakis</div>
                    <div class="sidebar-item">Anlik Dinleyici</div>
                    <div class="sidebar-item">Yayin Durumu</div>
                    <div class="sidebar-item">Now Playing</div>
                </div>
                <div class="sidebar-section">
                    <div class="sidebar-section-title">
                        <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 2a3 3 0 0 0-3 3v7a3 3 0 0 0 6 0V5a3 3 0 0 0-3-3z"/><path d="M19 10v2a7 7 0 0 1-14 0v-2"/><line x1="12" y1="19" x2="12" y2="22"/></svg>
                        Yayin Yonetimi (Shoutcast)
                    </div>
                    <div class="sidebar-item">Stream Link Ayarlari</div>
                    <div class="sidebar-item">Online / Offline Kontrol</div>
                    <div class="sidebar-item">Now Playing Kontrol</div>
                    <div class="sidebar-item">Yedek Stream</div>
                    <div class="sidebar-item">Web Player Yonetimi</div>
                </div>
                <div class="sidebar-section">
                    <div class="sidebar-section-title">
                        <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 22h16a2 2 0 0 0 2-2V4a2 2 0 0 0-2-2H4a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2z"/><line x1="7" y1="8" x2="17" y2="8"/><line x1="7" y1="12" x2="17" y2="12"/></svg>
                        Haberler
                    </div>
                    <div class="sidebar-item">Tum Haberler (liste + arama)</div>
                    <div class="sidebar-item">Haber Ekle</div>
                    <div class="sidebar-item">Haber Duzenle</div>
                    <div class="sidebar-item">Haber Sil</div>
                    <div class="sidebar-item">Kategori Yonetimi</div>
                    <div class="sidebar-item">One Cikan Ayari</div>
                    <div class="sidebar-item">Yayin Tarihi Planlama</div>
                </div>
                <div class="sidebar-section">
                    <div class="sidebar-section-title">
                        <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polygon points="23 7 16 12 23 17 23 7"/><rect x="1" y="5" width="15" height="14" rx="2" ry="2"/></svg>
                        Videolar
                    </div>
                    <div class="sidebar-item">Tum Videolar</div>
                    <div class="sidebar-item">Video Ekle</div>
                    <div class="sidebar-item">Video Duzenle</div>
                    <div class="sidebar-item">Video Sil</div>
                    <div class="sidebar-item">One Cikan Video</div>
                </div>
                <div class="sidebar-section">
                    <div class="sidebar-section-title">
                        <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
                        Foto Galeri
                    </div>
                    <div class="sidebar-item">Albumler</div>
                    <div class="sidebar-item">Foto Ekle</div>
                    <div class="sidebar-item">Toplu Foto Yukleme</div>
                    <div class="sidebar-item">Foto Duzenle</div>
                    <div class="sidebar-item">Foto Sil</div>
                </div>
                <div class="sidebar-section">
                    <div class="sidebar-section-title">
                        <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 2a3 3 0 0 0-3 3v7a3 3 0 0 0 6 0V5a3 3 0 0 0-3-3z"/><path d="M19 10v2a7 7 0 0 1-14 0v-2"/></svg>
                        Program & DJ
                    </div>
                    <div class="sidebar-item">Program Listesi</div>
                    <div class="sidebar-item">Program Ekle</div>
                    <div class="sidebar-item">Program Duzenle</div>
                    <div class="sidebar-item">Program Sil</div>
                    <div class="sidebar-item">DJ Profilleri</div>
                    <div class="sidebar-item">Yayin Takvimi</div>
                </div>
                <div class="sidebar-section">
                    <div class="sidebar-section-title">
                        <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V7a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/><line x1="7" y1="10" x2="7.01" y2="10"/><line x1="11" y1="10" x2="13" y2="10"/></svg>
                        Reklam Yonetimi
                    </div>
                    <div class="sidebar-item">Banner Alanlari</div>
                    <div class="sidebar-item">Popup Reklam</div>
                    <div class="sidebar-item">Sponsor Yonetimi</div>
                    <div class="sidebar-item">Kampanya Takibi</div>
                </div>
                <div class="sidebar-section">
                    <div class="sidebar-section-title">
                        <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
                        Mesaj & Istek
                    </div>
                    <div class="sidebar-item">Gelen Mesajlar</div>
                    <div class="sidebar-item">Sarki Istekleri</div>
                    <div class="sidebar-item">Moderasyon</div>
                    <div class="sidebar-item">Kara Liste</div>
                </div>
                <div class="sidebar-section">
                    <div class="sidebar-section-title">
                        <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="3"/><path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z"/></svg>
                        Ayarlar
                    </div>
                    <div class="sidebar-item">Genel Site Ayarlari</div>
                    <div class="sidebar-item">Logo & Favicon</div>
                    <div class="sidebar-item">SEO Ayarlari</div>
                    <div class="sidebar-item">Sosyal Medya Linkleri</div>
                    <div class="sidebar-item">Footer Yonetimi</div>
                    <div class="sidebar-item">Tema & Renk Ayarlari</div>
                </div>
                <div class="sidebar-section">
                    <div class="sidebar-section-title">
                        <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                        Kullanici Yonetimi
                    </div>
                    <div class="sidebar-item">Yonetici Hesaplari</div>
                    <div class="sidebar-item">Rol & Yetkiler</div>
                    <div class="sidebar-item">Aktivite Loglari</div>
                    <div class="sidebar-item">2FA Guvenlik</div>
                </div>
            </aside>

            <main class="content-area">
                <div class="content-inner">
                    @yield('content')
                </div>
            </main>
        </div>
    </div>
    @stack('scripts')
</body>
</html>
