<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>RADYOYOL ADMIN PANEL</title>
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }
        body {
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
            background: #0f0f0f;
            color: #e5e5e5;
            min-height: 100vh;
        }
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1rem 1.5rem;
            background: #1a1a1a;
            border-bottom: 1px solid #2a2a2a;
        }
        .header-title {
            font-size: 1.25rem;
            font-weight: 700;
            letter-spacing: 0.05em;
            color: #dc2626;
        }
        .profile-box {
            display: flex;
            align-items: center;
            gap: 1rem;
        }
        .profile-info {
            text-align: right;
        }
        .profile-info .role {
            font-size: 0.875rem;
            font-weight: 600;
            color: #e5e5e5;
        }
        .profile-info .title {
            font-size: 0.75rem;
            color: #a3a3a3;
        }
        .btn-logout {
            padding: 0.5rem 1rem;
            font-size: 0.875rem;
            font-weight: 500;
            background: #dc2626;
            color: #fff;
            border: none;
            border-radius: 8px;
            text-decoration: none;
            cursor: pointer;
            transition: background 0.2s;
        }
        .btn-logout:hover {
            background: #b91c1c;
        }
        .content {
            padding: 2rem 1.5rem;
        }
        @media (max-width: 480px) {
            .header {
                flex-direction: column;
                gap: 1rem;
                align-items: flex-start;
            }
            .profile-box {
                width: 100%;
                justify-content: space-between;
            }
        }
    </style>
</head>
<body>
    <header class="header">
        <h1 class="header-title">RADYOYOL ADMIN PANEL</h1>
        <div class="profile-box">
            <div class="profile-info">
                <div class="role">Yetkili</div>
                <div class="title">Yonetici</div>
            </div>
            <a href="{{ route('admin.logout') }}" class="btn-logout">Cikis</a>
        </div>
    </header>
    <main class="content">
    </main>
</body>
</html>
