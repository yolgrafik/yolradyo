<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
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
        body {
            font-family: Arial, sans-serif;
            background: var(--bg);
            color: var(--text);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }
        .navbar {
            position: sticky;
            top: 0;
            z-index: 1000;
            background: rgba(15, 19, 25, 0.95);
            backdrop-filter: blur(12px);
            border-bottom: 1px solid var(--border);
            padding: 0.75rem 1.5rem;
        }
        .navbar-inner {
            max-width: 1200px;
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
            height: 40px;
            width: auto;
        }
        .nav-logo-text {
            font-size: 1.4rem;
            font-weight: 700;
            color: var(--accent);
            letter-spacing: 0.05em;
            text-decoration: none;
        }
        .nav-menu {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            list-style: none;
        }
        .nav-menu a {
            color: var(--text);
            text-decoration: none;
            font-size: 0.9rem;
            font-weight: 500;
            padding: 0.5rem 0.9rem;
            border-radius: 8px;
            transition: background 0.2s, color 0.2s;
        }
        .nav-menu a:hover {
            background: rgba(255, 255, 255, 0.08);
            color: #fff;
        }
        .nav-dropdown {
            position: relative;
        }
        .nav-dropdown > a::after {
            content: ' ▾';
            font-size: 0.65em;
            opacity: 0.7;
        }
        .nav-dropdown-menu {
            position: absolute;
            top: 100%;
            left: 0;
            min-width: 200px;
            background: var(--panel);
            border: 1px solid var(--border);
            border-radius: 10px;
            padding: 0.5rem;
            margin-top: 0.25rem;
            opacity: 0;
            visibility: hidden;
            transform: translateY(-8px);
            transition: opacity 0.2s, transform 0.2s, visibility 0.2s;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.4);
        }
        .nav-dropdown:hover .nav-dropdown-menu {
            opacity: 1;
            visibility: visible;
            transform: translateY(0);
        }
        .nav-dropdown-menu a {
            display: block;
            padding: 0.6rem 1rem;
            border-radius: 6px;
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
        }
        .footer-col ul {
            list-style: none;
        }
        .footer-col a {
            color: var(--muted);
            text-decoration: none;
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
            .nav-menu {
                position: fixed;
                top: 0;
                right: -280px;
                width: 280px;
                height: 100vh;
                background: var(--panel);
                flex-direction: column;
                align-items: stretch;
                padding: 5rem 1rem 1rem;
                border-left: 1px solid var(--border);
                transition: right 0.3s ease;
                overflow-y: auto;
            }
            .nav-menu.is-open { right: 0; }
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
            .nav-dropdown:hover .nav-dropdown-menu { transform: none; }
            .nav-toggle { display: block; }
            .footer-grid { grid-template-columns: 1fr; }
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
            <button class="nav-toggle" id="navToggle" type="button" aria-label="Menu">☰</button>
            <ul class="nav-menu" id="navMenu">
                <li><a href="{{ url('/') }}">Anasayfa</a></li>
                <li><a href="{{ url('/programlar') }}">Programlar</a></li>
                <li><a href="{{ url('/haberler') }}">Haberler</a></li>
                <li><a href="{{ url('/videolar') }}">Video Galeri</a></li>
                <li><a href="{{ url('/galeri') }}">Foto Galeri</a></li>
                <li><a href="{{ url('/reklam') }}">Reklam & Isbirligi</a></li>
                <li class="nav-dropdown">
                    <a href="{{ url('/hakkimizda/biz-kimiz') }}">Hakkimizda</a>
                    <ul class="nav-dropdown-menu">
                        <li><a href="{{ url('/hakkimizda/biz-kimiz') }}">Biz Kimiz</a></li>
                        <li><a href="{{ url('/hakkimizda/misyon') }}">Misyon & Vizyon</a></li>
                        <li><a href="{{ url('/hakkimizda/politika') }}">Yayin Politikamiz</a></li>
                    </ul>
                </li>
                <li><a href="{{ url('/iletisim') }}">Iletisim</a></li>
            </ul>
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
                        <li><a href="{{ url('/iletisim') }}">Iletisim</a></li>
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

    <script>
        (function() {
            var toggle = document.getElementById('navToggle');
            var menu = document.getElementById('navMenu');
            if (toggle && menu) {
                toggle.addEventListener('click', function() {
                    menu.classList.toggle('is-open');
                });
            }
        })();
    </script>
    @stack('scripts')
</body>
</html>
