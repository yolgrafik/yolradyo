<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>RADYOYOL ADMIN PANEL</title>
    <style>
        :root {
            --bg: #1a1f2e;
            --panel: #212529;
            --card: #252b38;
            --text: #f5f5f5;
            --muted: #9ca3af;
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
            background: var(--bg);
            color: var(--text);
            min-height: 100vh;
        }
        .app-wrap {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }
        .topbar {
            background: linear-gradient(90deg, #8b1a1a 0%, #5c1010 50%, #2d0808 100%);
            padding: 0.75rem 1.25rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: relative;
        }
        .topbar::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 2px;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.15), transparent);
            opacity: 0.5;
        }
        .topbar-title {
            font-size: 1rem;
            font-weight: 700;
            letter-spacing: 0.08em;
            color: #fff;
        }
        .topbar-sub {
            font-size: 0.65rem;
            letter-spacing: 0.15em;
            color: rgba(255,255,255,0.7);
            margin-top: 0.1rem;
        }
        .user-box {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            background: rgba(0,0,0,0.25);
            padding: 0.4rem 0.75rem;
            border-radius: 10px;
        }
        .user-badge {
            font-size: 0.7rem;
            font-weight: 600;
            color: var(--accent);
        }
        .user-role {
            font-size: 0.75rem;
            color: var(--muted);
        }
        .btn-logout {
            padding: 0.35rem 0.65rem;
            font-size: 0.8rem;
            background: var(--accent);
            color: #fff;
            border: none;
            border-radius: 8px;
            text-decoration: none;
            cursor: pointer;
        }
        .btn-logout:hover {
            background: #b91c1c;
        }
        .main-row {
            display: flex;
            flex: 1;
        }
        .sidebar {
            width: 240px;
            background: var(--panel);
            padding: 1rem 0;
            flex-shrink: 0;
        }
        .sidebar-section {
            margin-bottom: 0.5rem;
        }
        .sidebar-section-title {
            font-size: 0.8rem;
            font-weight: 700;
            color: var(--text);
            padding: 0.5rem 1rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            text-decoration: none;
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
            padding: 0.35rem 1rem 0.35rem 1.75rem;
            display: flex;
            align-items: center;
            gap: 0.4rem;
        }
        .sidebar-item::before {
            content: '▸';
            font-size: 0.65rem;
        }
        .content-area {
            flex: 1;
            padding: 1.5rem;
            overflow-x: hidden;
        }
        .card-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(260px, 1fr));
            gap: 1.25rem;
        }
        .card {
            background: var(--card);
            border-radius: 12px;
            border: 1px solid var(--border);
            box-shadow: 0 2px 8px rgba(0,0,0,0.2);
            overflow: hidden;
        }
        .card-header {
            padding: 0.75rem 1rem;
            font-size: 0.9rem;
            font-weight: 600;
            color: #fff;
        }
        .card-header.accent { background: linear-gradient(135deg, var(--accent), #991b1b); }
        .card-body {
            padding: 1rem;
            font-size: 0.875rem;
            color: var(--muted);
        }
        .card-value {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--text);
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
            }
            .sidebar-section {
                flex: 0 1 auto;
                margin-bottom: 0;
            }
            .sidebar-section-title {
                padding: 0.4rem 0.75rem;
            }
            .sidebar-item {
                display: none;
            }
            .card-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
    @stack('styles')
</head>
<body>
    <div class="app-wrap">
        <header class="topbar">
            <div>
                <div class="topbar-title">RADYOYOL ADMIN PANEL</div>
                <div class="topbar-sub">TAM OZELLIK LISTESI</div>
            </div>
            <div class="user-box">
                <div>
                    <div class="user-badge">Yetkili</div>
                    <div class="user-role">Yonetici</div>
                </div>
                <a href="{{ route('admin.logout') }}" class="btn-logout">Cikis</a>
            </div>
        </header>

        <div class="main-row">
            <aside class="sidebar">
                <div class="sidebar-section active">
                    <a href="{{ route('admin.dashboard') }}" class="sidebar-section-title">Dashboard</a>
                    <div class="sidebar-item">Genel Bakis</div>
                    <div class="sidebar-item">Anlik Dinleyici</div>
                    <div class="sidebar-item">Yayin Durumu</div>
                    <div class="sidebar-item">Now Playing</div>
                </div>
                <div class="sidebar-section">
                    <div class="sidebar-section-title">Yayin Yonetimi</div>
                    <div class="sidebar-item">Stream Link Ayarlari</div>
                    <div class="sidebar-item">Online / Offline Kontrol</div>
                </div>
                <div class="sidebar-section">
                    <div class="sidebar-section-title">Haberler</div>
                    <div class="sidebar-item">Tum Haberler</div>
                </div>
                <div class="sidebar-section">
                    <div class="sidebar-section-title">Videolar</div>
                    <div class="sidebar-item">Tum Videolar</div>
                </div>
            </aside>

            <main class="content-area">
                @yield('content')
            </main>
        </div>
    </div>
    @stack('scripts')
</body>
</html>
