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
        /* LOGIN CURSOR - remove this block to restore default cursor */
        @media (hover: hover) and (pointer: fine) {
            body.has-login-cursor { cursor: none; }
            body.has-login-cursor * { cursor: none; }
            body.has-login-cursor input, body.has-login-cursor textarea { cursor: text; }
            .login-cursor {
                position: fixed;
                left: 0;
                top: 0;
                width: 7px;
                height: 7px;
                background: #dc2626;
                border-radius: 50%;
                box-shadow: 0 0 8px rgba(220, 38, 38, 0.5);
                pointer-events: none;
                z-index: 99999;
                opacity: 0;
                transform: translate(-50%, -50%);
                transition: opacity 0.2s ease, transform 0.2s ease;
            }
            .login-cursor::before {
                content: '';
                position: absolute;
                inset: -4px;
                border: 1px solid rgba(220, 38, 38, 0.25);
                border-radius: 50%;
            }
            .login-cursor.is-visible { opacity: 1; }
            .login-cursor.is-hover {
                transform: translate(-50%, -50%) scale(1.15);
            }
        }
    </style>
    @stack('styles')
</head>
<body>
    <div class="login-cursor" id="loginCursor" aria-hidden="true"></div>
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
    /* LOGIN CURSOR - remove this block to restore default cursor */
    (function() {
        var c = document.getElementById('loginCursor');
        if (!c || !window.matchMedia('(hover: hover) and (pointer: fine)').matches) return;
        document.body.classList.add('has-login-cursor');
        var x = 0, y = 0, tx = 0, ty = 0;
        function tick() {
            tx += (x - tx) * 0.2;
            ty += (y - ty) * 0.2;
            c.style.left = tx + 'px';
            c.style.top = ty + 'px';
            requestAnimationFrame(tick);
        }
        tick();
        document.addEventListener('mousemove', function(e) {
            x = e.clientX;
            y = e.clientY;
            c.classList.add('is-visible');
        });
        var sel = 'a, button, .btn-login, .pw-toggle, .forgot-link, input[type="submit"], label[for]';
        function check(el) {
            c.classList.toggle('is-hover', !!(el && el.closest && el.closest(sel)));
        }
        document.addEventListener('mouseover', function(e) { check(e.target); });
        document.addEventListener('mouseout', function(e) { check(e.relatedTarget); });
    })();
    </script>
    @stack('scripts')
</body>
</html>
