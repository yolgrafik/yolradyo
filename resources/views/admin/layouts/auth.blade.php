<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>RADYOYOL ADMIN PANEL - Giris</title>
    <style>
        :root {
            --bg: #0d0d14;
            --panel: #12121a;
            --card: rgba(30, 30, 45, 0.6);
            --text: #f5f5f5;
            --muted: #9ca3af;
            --border: rgba(255, 255, 255, 0.08);
            --accent: #dc2626;
        }
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }
        body {
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
            background: linear-gradient(180deg, #1a0a12 0%, #0d0d18 40%, #0a0a12 100%);
            color: var(--text);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1rem;
            position: relative;
            overflow-x: hidden;
            cursor: none;
        }
        @media (hover: hover) and (pointer: fine) {
            body.cursor-ready * { cursor: none; }
            body.cursor-ready input, body.cursor-ready textarea { cursor: text; }
            body.cursor-ready [disabled] { cursor: not-allowed; }
        }
        .custom-cursor {
            position: fixed;
            left: 0;
            top: 0;
            pointer-events: none;
            z-index: 99999;
            opacity: 0;
            transition: opacity 0.25s ease;
        }
        .custom-cursor.is-visible { opacity: 1; }
        .cursor-inner {
            position: fixed;
            width: 5px;
            height: 5px;
            border-radius: 50%;
            background: rgba(220, 50, 50, 0.95);
            transform: translate(-50%, -50%);
            box-shadow: 0 0 6px rgba(200, 40, 40, 0.35);
            animation: cursorPulseInner 4s ease-in-out infinite;
            pointer-events: none;
            z-index: 100000;
        }
        .cursor-outer {
            position: fixed;
            width: 14px;
            height: 14px;
            border-radius: 50%;
            border: 1px solid rgba(255, 70, 70, 0.3);
            background: transparent;
            transform: translate(-50%, -50%);
            box-shadow: 0 0 12px rgba(255, 50, 50, 0.18), inset 0 0 8px rgba(255, 50, 50, 0.06);
            animation: cursorPulseOuter 4s ease-in-out infinite;
            pointer-events: none;
            z-index: 99999;
        }
        .custom-cursor.is-button .cursor-inner { width: 6px; height: 6px; }
        .custom-cursor.is-button .cursor-outer { width: 16px; height: 16px; }
        .custom-cursor.is-link .cursor-outer {
            border-color: rgba(255, 90, 90, 0.45);
            box-shadow: 0 0 14px rgba(255, 60, 60, 0.28), inset 0 0 10px rgba(255, 60, 60, 0.1);
        }
        @keyframes cursorPulseInner {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.88; }
        }
        @keyframes cursorPulseOuter {
            0%, 100% { opacity: 0.9; box-shadow: 0 0 12px rgba(255, 50, 50, 0.18), inset 0 0 8px rgba(255, 50, 50, 0.06); }
            50% { opacity: 1; box-shadow: 0 0 16px rgba(255, 50, 50, 0.25), inset 0 0 10px rgba(255, 50, 50, 0.1); }
        }
        body::before {
            content: '';
            position: absolute;
            inset: 0;
            z-index: 0;
            background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 256 256' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='noise'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.9' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23noise)' opacity='0.04'/%3E%3C/svg%3E");
            pointer-events: none;
        }
        body::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 3px;
            z-index: 0;
            background: linear-gradient(90deg, transparent 0%, var(--accent) 25%, var(--accent) 75%, transparent 100%);
            opacity: 0.5;
            pointer-events: none;
        }
        .auth-card {
            position: relative;
            z-index: 1;
            width: 100%;
            max-width: 420px;
            background: var(--card);
            backdrop-filter: blur(24px);
            -webkit-backdrop-filter: blur(24px);
            border-radius: 20px;
            border: 1px solid var(--border);
            box-shadow: 0 4px 24px rgba(0, 0, 0, 0.35);
            padding: 2rem 2rem 2.5rem;
        }
        .auth-logo {
            text-align: center;
            margin-bottom: 0.5rem;
        }
        .auth-logo img {
            max-width: 150px;
            height: auto;
        }
        .auth-logo .logo-fallback {
            font-size: 1.5rem;
            font-weight: 700;
            letter-spacing: 0.08em;
            color: var(--accent);
        }
        .auth-subtitle {
            font-size: 0.7rem;
            letter-spacing: 0.2em;
            color: var(--muted);
            text-align: center;
            margin-bottom: 0.5rem;
        }
        .auth-title {
            font-size: 1.6rem;
            font-weight: 700;
            color: var(--text);
            text-align: center;
            margin-bottom: 1.5rem;
        }
        .auth-body {
            margin-top: 1.5rem;
        }
        .auth-footer {
            margin-top: 1.5rem;
            text-align: center;
            font-size: 0.75rem;
            color: var(--muted);
        }
        @media (max-width: 480px) {
            .auth-card {
                padding: 1.5rem 1.25rem 2rem;
            }
        }
    </style>
    @stack('styles')
</head>
<body>
    <div class="custom-cursor" id="customCursor" aria-hidden="true">
        <div class="cursor-outer" id="cursorOuter"></div>
        <div class="cursor-inner" id="cursorInner"></div>
    </div>
    <div class="auth-card {{ View::hasSection('hero') ? 'login-card' : '' }}">
        @hasSection('hero')
            @yield('hero')
        @else
        <div class="auth-logo">
            <img src="{{ asset('assets/brand/radyoyol-logo.png') }}" alt="RADYOYOL" onerror="this.style.display='none'; this.nextElementSibling.style.display='block';">
            <span class="logo-fallback" style="display:none">RADYOYOL</span>
        </div>
        <p class="auth-subtitle">ADMIN PANEL</p>
        <h1 class="auth-title">Hosgeldiniz</h1>
        @endif

        <div class="auth-body">
            @yield('content')
        </div>

        <div class="auth-footer">
            © 2026 RADYOYOL
        </div>
    </div>
    <script>
        (function() {
            var cursor = document.getElementById('customCursor');
            var inner = document.getElementById('cursorInner');
            var outer = document.getElementById('cursorOuter');
            if (!cursor || !inner || !outer || !window.matchMedia('(hover: hover) and (pointer: fine)').matches) return;
            document.body.classList.add('cursor-ready');
            var mx = 0, my = 0, ix = 0, iy = 0, ox = 0, oy = 0;
            function move() {
                ix += (mx - ix) * 0.22;
                iy += (my - iy) * 0.22;
                ox += (mx - ox) * 0.09;
                oy += (my - oy) * 0.09;
                inner.style.left = ix + 'px';
                inner.style.top = iy + 'px';
                outer.style.left = ox + 'px';
                outer.style.top = oy + 'px';
                requestAnimationFrame(move);
            }
            move();
            document.addEventListener('mousemove', function(e) {
                mx = e.clientX;
                my = e.clientY;
                cursor.classList.add('is-visible');
            });
            var linkSel = 'a, .forgot-link';
            var btnSel = 'button, [role="button"], .btn-login, .pw-toggle, input[type="submit"], label[for]';
            function updateCursor(el) {
                var overLink = el && el.closest && el.closest(linkSel);
                var overBtn = el && el.closest && el.closest(btnSel);
                cursor.classList.toggle('is-link', !!overLink);
                cursor.classList.toggle('is-button', !!overBtn && !overLink);
            }
            document.addEventListener('mouseover', function(e) { updateCursor(e.target); });
            document.addEventListener('mouseout', function(e) { updateCursor(e.relatedTarget); });
        })();
    </script>
    @stack('scripts')
</body>
</html>
