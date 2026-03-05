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
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.12) 0%, rgba(255, 255, 255, 0.06) 100%);
            backdrop-filter: blur(24px);
            -webkit-backdrop-filter: blur(24px);
            padding: 0.6rem 1.25rem 0.6rem 0.65rem;
            border-radius: 16px;
            border: 1px solid rgba(255, 255, 255, 0.2);
            box-shadow: 0 6px 28px rgba(0, 0, 0, 0.35), 0 0 0 1px rgba(255, 255, 255, 0.08) inset, 0 0 20px rgba(201, 42, 42, 0.08);
            position: relative;
            z-index: 1;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            font-family: Arial, sans-serif;
        }
        .user-box:hover {
            border-color: rgba(255, 255, 255, 0.3);
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.4), 0 0 32px rgba(201, 42, 42, 0.15), 0 0 0 1px rgba(255, 255, 255, 0.1) inset;
            transform: translateY(-2px);
        }
        .user-avatar {
            width: 44px;
            height: 44px;
            border-radius: 50%;
            background: linear-gradient(135deg, rgba(201, 42, 42, 0.95), rgba(180, 30, 30, 1));
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1rem;
            font-weight: 700;
            color: #fff;
            letter-spacing: 0;
            flex-shrink: 0;
            box-shadow: 0 0 16px rgba(201, 42, 42, 0.5), 0 3px 12px rgba(0, 0, 0, 0.3), 0 0 0 2px rgba(255, 255, 255, 0.15);
            transition: transform 0.25s ease, box-shadow 0.25s ease;
        }
        .user-avatar-img {
            object-fit: cover;
            background: linear-gradient(135deg, rgba(201, 42, 42, 0.5), rgba(180, 30, 30, 0.6));
            border: 2px solid rgba(255, 255, 255, 0.2);
        }
        .user-box:hover .user-avatar {
            box-shadow: 0 0 24px rgba(201, 42, 42, 0.6), 0 4px 16px rgba(0, 0, 0, 0.3);
            transform: scale(1.06);
        }
        .user-info {
            display: flex;
            flex-direction: column;
            align-items: flex-start;
            gap: 0.25rem;
            min-width: 0;
        }
        .user-badge {
            display: inline-block;
            font-size: 0.7rem;
            font-weight: 800;
            color: #fff;
            letter-spacing: 0.12em;
            text-transform: uppercase;
            line-height: 1.2;
            background: linear-gradient(135deg, rgba(201, 42, 42, 0.9), var(--accent));
            padding: 0.2rem 0.6rem;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(201, 42, 42, 0.4);
            border: 1px solid rgba(255, 255, 255, 0.25);
        }
        .user-role {
            font-size: 0.95rem;
            font-weight: 700;
            color: #fff;
            line-height: 1.2;
            text-shadow: 0 1px 2px rgba(0, 0, 0, 0.3);
        }
        .btn-logout {
            padding: 0.55rem 1.15rem;
            font-size: 0.85rem;
            font-weight: 700;
            background: linear-gradient(135deg, #dc2626, var(--accent));
            color: #fff;
            border: 1px solid rgba(255, 255, 255, 0.25);
            border-radius: 12px;
            text-decoration: none;
            cursor: pointer;
            transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow: 0 3px 12px rgba(201, 42, 42, 0.4);
        }
        .btn-logout:hover {
            background: linear-gradient(135deg, #ef4444, #dc2626);
            box-shadow: 0 5px 20px rgba(201, 42, 42, 0.5);
            transform: translateY(-2px);
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
        select, select.form-input, select[class*="select"], .filter-select {
            background: #1a2029 !important;
            color: #f0f2f5 !important;
            border: 1px solid rgba(255,255,255,0.15) !important;
            border-radius: 10px;
            padding: 10px 12px;
            font-weight: 500;
        }
        select:focus, select.form-input:focus, select[class*="select"]:focus, .filter-select:focus {
            outline: none;
            border-color: var(--accent) !important;
            box-shadow: 0 0 0 2px rgba(201,42,42,0.2) !important;
        }
        select option, select.form-input option, select[class*="select"] option, .filter-select option {
            background: #1a2029 !important;
            color: #f0f2f5 !important;
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
            .user-box {
                padding: 0.5rem 1rem 0.5rem 0.5rem;
                gap: 0.75rem;
            }
            .user-avatar {
                width: 38px;
                height: 38px;
                font-size: 0.9rem;
            }
            .user-badge { font-size: 0.6rem; padding: 0.15rem 0.5rem; }
            .user-role { font-size: 0.85rem; }
            .btn-logout { padding: 0.5rem 1rem; font-size: 0.8rem; }
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
          overflow: visible !important;
          position: relative !important;
        }
        .topbar.admin-hero{
          background:
            linear-gradient(135deg, #3b0008 0%, #6e0d14 35%, #c1121f 70%, #ff2b2b 100%),
            url("{{ asset('assets/images/admin-hero.png') }}");
          background-blend-mode: overlay;
          background-size: cover;
          background-position: center 30%;
          height: 170px !important;
          min-height: 170px !important;
          padding: 25px 40px !important;
          display:flex !important;
          align-items:center !important;
          justify-content:space-between !important;
          overflow: visible !important;
        }
        .topbar-title{
          position: relative;
          display:inline-block;
          text-transform: uppercase;
        }
        .topbar-title .shine{
          position: relative;
          display:inline-block;
          color: rgba(255,255,255,.95);
          text-shadow:
            0 0 10px rgba(255,255,255,.12),
            0 0 22px rgba(220,38,38,.18);
        }
        .topbar-title .shine::after{
          content:"";
          position:absolute;
          top:-20%;
          left:-40%;
          width:45%;
          height:140%;
          background: linear-gradient(120deg,
            rgba(255,255,255,0) 0%,
            rgba(255,255,255,.35) 45%,
            rgba(255,255,255,0) 85%
          );
          transform: skewX(-18deg);
          filter: blur(1px);
          opacity:.55;
          animation: titleShine 7s ease-in-out infinite;
          pointer-events:none;
          mix-blend-mode: screen;
        }
        @keyframes titleShine{
          0%   { transform: translateX(-140%) skewX(-18deg); opacity:0; }
          12%  { opacity:.55; }
          35%  { transform: translateX(260%) skewX(-18deg); opacity:0; }
          100% { transform: translateX(260%) skewX(-18deg); opacity:0; }
        }
        .logo img{
          height: 110px !important;
          width: auto !important;
          filter: drop-shadow(0 0 15px rgba(255,60,60,.7));
          transition: transform .3s ease;
        }
        .logo img:hover{
          transform: scale(1.1);
        }
        .topbar.admin-hero .topbar-title{
          font-size: 36px;
          font-weight: 800;
          letter-spacing: 3px;
          text-shadow:
            0 0 15px rgba(255,255,255,.25),
            0 0 30px rgba(255,60,60,.45),
            0 0 60px rgba(255,0,0,.35);
        }
        .topbar-subtitle{
          font-size: 16px;
          letter-spacing: 4px;
          color: rgba(255,255,255,.9);
        }
        .menu-glow{
          position: relative;
          display:inline-block;
          color: #fff;
          font-weight:700;
          text-shadow:
            0 0 8px rgba(255,255,255,.25),
            0 0 18px rgba(255,60,60,.35);
        }
        .menu-glow::after{
          content:"";
          position:absolute;
          top:-20%;
          left:-50%;
          width:40%;
          height:140%;
          background: linear-gradient(120deg,
            rgba(255,255,255,0) 0%,
            rgba(255,255,255,.35) 45%,
            rgba(255,255,255,0) 85%
          );
          transform: skewX(-20deg);
          opacity:.5;
          animation: menuShine 6s ease-in-out infinite;
          pointer-events:none;
          mix-blend-mode: screen;
        }
        @keyframes menuShine{
          0%   { transform: translateX(-150%) skewX(-20deg); opacity:0; }
          15%  { opacity:.5; }
          40%  { transform: translateX(250%) skewX(-20deg); opacity:0; }
          100% { transform: translateX(250%) skewX(-20deg); opacity:0; }
        }
    </style>
    @stack('styles')
</head>
<body>
    <div class="app-wrap">
        <header class="topbar admin-topbar admin-hero">
            <div class="topbar-top-line"></div>
            <div class="topbar-bottom-line"></div>
            <div class="topbar-inner">
                <div class="topbar-spacer"></div>
                <div class="topbar-brand">
                    <div class="topbar-logo-wrap logo">
                        <img src="{{ asset('logo.png') }}" alt="RADYOYOL" class="topbar-logo" onerror="this.style.display='none'; this.nextElementSibling.style.display='block';">
                        <span class="topbar-logo-fallback" style="display:none">RADYOYOL</span>
                    </div>
                    <div class="topbar-brand-text">
                        <div class="topbar-title"><span class="shine">RADYOYOL ADMIN PANEL</span></div>
                        <div class="topbar-sub topbar-subtitle">TAM OZELLIK LISTESI</div>
                    </div>
                </div>
                <div class="topbar-spacer topbar-spacer--right">
                <div class="user-box">
                    @php $admin = $currentAdmin ?? null; @endphp
                    @if($admin)
                    <img src="{{ $admin->avatarUrl() }}" alt="" class="user-avatar user-avatar-img" aria-hidden="true">
                    <div class="user-info">
                        <span class="user-badge">YETKİLİ</span>
                        <span class="user-role">{{ $admin->name }}</span>
                    </div>
                    @else
                    <div class="user-avatar" aria-hidden="true">Y</div>
                    <div class="user-info">
                        <span class="user-badge">YETKİLİ</span>
                        <span class="user-role">Yonetici</span>
                    </div>
                    @endif
                    <a href="{{ route('admin.logout') }}" class="btn-logout">Çıkış</a>
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
                    <div class="nav-section {{ request()->routeIs('admin.dashboard') || request()->routeIs('admin.schedule.*') || request()->routeIs('admin.messages.*') || request()->routeIs('admin.settings.*') || request()->routeIs('admin.menu.*') || request()->routeIs('admin.users.*') ? 'is-open' : '' }}" data-section="dashboard">
                        <button class="nav-section__toggle" type="button" aria-expanded="{{ request()->routeIs('admin.dashboard') || request()->routeIs('admin.schedule.*') || request()->routeIs('admin.messages.*') || request()->routeIs('admin.settings.*') || request()->routeIs('admin.menu.*') || request()->routeIs('admin.users.*') ? 'true' : 'false' }}">
                            <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/></svg>
                            <span>Kontrol Paneli</span>
                            <span class="nav-section__chevron">&#9660;</span>
                        </button>
                        <ul class="nav-section__items">
                            <li><a href="{{ route('admin.dashboard') }}" class="nav-item {{ request()->routeIs('admin.dashboard') ? 'is-active' : '' }}">Genel Bakış</a></li>
                            <li><a href="{{ route('admin.schedule.index') }}" class="nav-item {{ request()->routeIs('admin.schedule.*') ? 'is-active' : '' }}">Program & DJ</a></li>
                            <li><a href="{{ route('admin.messages.index') }}" class="nav-item {{ request()->routeIs('admin.messages.*') ? 'is-active' : '' }}">Mesaj & İstek</a></li>
                            <li><a href="{{ route('admin.dashboard') }}" class="nav-item">Canlı Yayın Bilgisi</a></li>
                            <li><a href="{{ route('admin.settings.general') }}" class="nav-item {{ request()->routeIs('admin.settings.*') ? 'is-active' : '' }}">Ayarlar</a></li>
                            <li><a href="{{ route('admin.users.index') }}" class="nav-item {{ request()->routeIs('admin.users.*') ? 'is-active' : '' }}">Kullanıcı Yönetimi</a></li>
                        </ul>
                    </div>
                    <div class="nav-section {{ request()->routeIs('admin.shoutcast.*') ? 'is-open' : '' }}" data-section="yayin">
                        <button class="nav-section__toggle" type="button" aria-expanded="{{ request()->routeIs('admin.shoutcast.*') ? 'true' : 'false' }}">
                            <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 2a3 3 0 0 0-3 3v7a3 3 0 0 0 6 0V5a3 3 0 0 0-3-3z"/><path d="M19 10v2a7 7 0 0 1-14 0v-2"/><line x1="12" y1="19" x2="12" y2="22"/></svg>
                            <span>Yayın Yönetimi (Shoutcast)</span>
                            <span class="nav-section__chevron">&#9660;</span>
                        </button>
                        <ul class="nav-section__items">
                            <li><a href="{{ route('admin.shoutcast.stream') }}" class="nav-item {{ request()->routeIs('admin.shoutcast.stream') ? 'is-active' : '' }}">Stream Link Ayarları</a></li>
                            <li><a href="{{ route('admin.shoutcast.status') }}" class="nav-item {{ request()->routeIs('admin.shoutcast.status') ? 'is-active' : '' }}">Online / Offline Kontrol</a></li>
                            <li><a href="{{ route('admin.shoutcast.nowplaying') }}" class="nav-item {{ request()->routeIs('admin.shoutcast.nowplaying') ? 'is-active' : '' }}">Now Playing Kontrol</a></li>
                            <li><a href="{{ route('admin.shoutcast.backup') }}" class="nav-item {{ request()->routeIs('admin.shoutcast.backup') ? 'is-active' : '' }}">Yedek Stream</a></li>
                            <li><a href="{{ route('admin.shoutcast.player.index') }}" class="nav-item {{ request()->routeIs('admin.shoutcast.player.*') ? 'is-active' : '' }}">Web Player Yönetimi</a></li>
                        </ul>
                    </div>
                    <div class="nav-section {{ request()->routeIs('admin.sliders.*') ? 'is-open' : '' }}" data-section="icerik">
                        <button class="nav-section__toggle" type="button" aria-expanded="{{ request()->routeIs('admin.sliders.*') ? 'true' : 'false' }}">
                            <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="18" height="18" rx="2"/><line x1="3" y1="9" x2="21" y2="9"/><line x1="9" y1="21" x2="9" y2="9"/></svg>
                            <span>Icerik Yonetimi</span>
                            <span class="nav-section__chevron">&#9660;</span>
                        </button>
                        <ul class="nav-section__items">
                            <li><a href="{{ route('admin.sliders.index') }}" class="nav-item {{ request()->routeIs('admin.sliders.*') ? 'is-active' : '' }}">Slider Yonetimi</a></li>
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
                    <div class="nav-section {{ request()->routeIs('admin.schedule.*') || request()->routeIs('admin.djs.*') || request()->routeIs('admin.programcilar.*') ? 'is-open' : '' }}" data-section="program">
                        <button class="nav-section__toggle" type="button" aria-expanded="{{ request()->routeIs('admin.schedule.*') || request()->routeIs('admin.djs.*') || request()->routeIs('admin.programcilar.*') ? 'true' : 'false' }}">
                            <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 2a3 3 0 0 0-3 3v7a3 3 0 0 0 6 0V5a3 3 0 0 0-3-3z"/><path d="M19 10v2a7 7 0 0 1-14 0v-2"/></svg>
                            <span>Program & DJ</span>
                            <span class="nav-section__chevron">&#9660;</span>
                        </button>
                        <ul class="nav-section__items">
                            <li><a href="{{ route('admin.schedule.index') }}" class="nav-item {{ request()->routeIs('admin.schedule.index') && !request()->get('programci') ? 'is-active' : '' }}">Yayın Takvimi</a></li>
                            @if(isset($programcilar) && $programcilar->isNotEmpty())
                                @foreach($programcilar as $p)
                                <li style="padding-left:1rem;"><a href="{{ route('admin.schedule.by-programci', $p) }}" class="nav-item {{ (int)request()->get('programci') === $p->id ? 'is-active' : '' }}" style="font-size:0.9rem;">{{ $p->ad }}</a></li>
                                @endforeach
                            @endif
                            <li><a href="{{ route('admin.programcilar.index') }}" class="nav-item {{ request()->routeIs('admin.programcilar.*') ? 'is-active' : '' }}">Programcı Listesi</a></li>
                            <li><a href="{{ route('admin.djs.index') }}" class="nav-item {{ request()->routeIs('admin.djs.*') ? 'is-active' : '' }}">DJ Profilleri</a></li>
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
                    <div class="nav-section {{ request()->routeIs('admin.song-requests.*', 'admin.messages.*', 'admin.moderation.*', 'admin.blacklist.*') ? 'is-open' : '' }}" data-section="mesaj">
                        <button class="nav-section__toggle" type="button" aria-expanded="{{ request()->routeIs('admin.song-requests.*', 'admin.messages.*', 'admin.moderation.*', 'admin.blacklist.*') ? 'true' : 'false' }}">
                            <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
                            <span>Mesaj ve İstek</span>
                            <span class="nav-section__chevron">&#9660;</span>
                        </button>
                        <ul class="nav-section__items">
                            <li><a href="{{ route('admin.song-requests.index') }}" class="nav-item {{ request()->routeIs('admin.song-requests.*') ? 'is-active' : '' }}">Şarkı İstekleri</a></li>
                            <li><a href="{{ route('admin.messages.index') }}" class="nav-item {{ request()->routeIs('admin.messages.*') ? 'is-active' : '' }}">Gelen Mesajlar</a></li>
                            <li><a href="{{ route('admin.moderation.index') }}" class="nav-item {{ request()->routeIs('admin.moderation.*') ? 'is-active' : '' }}">Moderasyon</a></li>
                            <li><a href="{{ route('admin.blacklist.index') }}" class="nav-item {{ request()->routeIs('admin.blacklist.*') ? 'is-active' : '' }}">Kara Liste</a></li>
                        </ul>
                    </div>
                    <div class="nav-section {{ request()->routeIs('admin.settings.*', 'admin.menu.*') ? 'is-open' : '' }}" data-section="ayarlar">
                        <button class="nav-section__toggle" type="button" aria-expanded="{{ request()->routeIs('admin.settings.*') ? 'true' : 'false' }}">
                            <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="3"/><path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z"/></svg>
                            <span>Ayarlar</span>
                            <span class="nav-section__chevron">&#9660;</span>
                        </button>
                        <ul class="nav-section__items">
                            <li><a href="{{ route('admin.settings.general') }}" class="nav-item {{ request()->routeIs('admin.settings.general') ? 'is-active' : '' }}">Genel Site Ayarları</a></li>
                            <li><a href="{{ route('admin.settings.branding') }}" class="nav-item {{ request()->routeIs('admin.settings.branding') ? 'is-active' : '' }}">Logo & Favicon</a></li>
                            <li><a href="{{ route('admin.settings.seo') }}" class="nav-item {{ request()->routeIs('admin.settings.seo') ? 'is-active' : '' }}">SEO Ayarlari</a></li>
                            <li><a href="{{ route('admin.settings.social') }}" class="nav-item {{ request()->routeIs('admin.settings.social') ? 'is-active' : '' }}">Sosyal Medya Linkleri</a></li>
                            <li><a href="{{ route('admin.settings.footer') }}" class="nav-item {{ request()->routeIs('admin.settings.footer') ? 'is-active' : '' }}">Footer Yonetimi</a></li>
                            <li><a href="{{ route('admin.menu.index') }}" class="nav-item {{ request()->routeIs('admin.menu.*') ? 'is-active' : '' }}">Menu Yonetimi</a></li>
                            <li><a href="{{ route('admin.settings.theme') }}" class="nav-item {{ request()->routeIs('admin.settings.theme') ? 'is-active' : '' }}">Tema & Renk Ayarlari</a></li>
                        </ul>
                    </div>
                    <div class="nav-section {{ request()->routeIs('admin.users.*', 'admin.roles.*', 'admin.activity-logs.*', 'admin.security.*') ? 'is-open' : '' }}" data-section="kullanici">
                        <button class="nav-section__toggle" type="button" aria-expanded="{{ request()->routeIs('admin.users.*', 'admin.roles.*', 'admin.activity-logs.*', 'admin.security.*') ? 'true' : 'false' }}">
                            <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                            <span>Kullanici Yonetimi</span>
                            <span class="nav-section__chevron">&#9660;</span>
                        </button>
                        <ul class="nav-section__items">
                            <li><a href="{{ route('admin.users.index') }}" class="nav-item {{ request()->routeIs('admin.users.*') ? 'is-active' : '' }}">Yonetici Hesaplari</a></li>
                            <li><a href="{{ route('admin.roles.index') }}" class="nav-item {{ request()->routeIs('admin.roles.*') ? 'is-active' : '' }}">Rol & Yetkiler</a></li>
                            <li><a href="{{ route('admin.activity-logs.index') }}" class="nav-item {{ request()->routeIs('admin.activity-logs.*') ? 'is-active' : '' }}">Aktivite Loglari</a></li>
                            <li><a href="{{ route('admin.security.2fa') }}" class="nav-item {{ request()->routeIs('admin.security.*') ? 'is-active' : '' }}">2FA Guvenlik</a></li>
                        </ul>
                    </div>
                </nav>
            </aside>

            <main class="content-area">
                <div class="waveform-line"></div>
                <div class="content-bg-vignette"></div>
                <div class="content-inner {{ request()->routeIs('admin.dashboard') ? 'content-inner--dashboard' : '' }}">
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
    <div id="adminToast" class="admin-toast" role="alert" aria-live="polite" style="display:none;">Yeni şarkı isteği geldi</div>
    <script>
    (function(){
        var STORAGE_KEY='admin_pending_last_count';
        var SOUND_ACTIVE_KEY='admin_sound_active';
        var POLL_INTERVAL=10000;
        var toastEl=document.getElementById('adminToast');
        function getLastCount(){try{var v=localStorage.getItem(STORAGE_KEY);return v!==null?parseInt(v,10):null;}catch(e){return null;}}
        function setLastCount(n){try{localStorage.setItem(STORAGE_KEY,String(n));}catch(e){}}
        function isSoundActive(){try{return localStorage.getItem(SOUND_ACTIVE_KEY)==='1';}catch(e){return false;}}
        function setSoundActive(){try{localStorage.setItem(SOUND_ACTIVE_KEY,'1');}catch(e){}}
        function playDing(){
            if(!isSoundActive())return;
            try{
                var ctx=new(window.AudioContext||window.webkitAudioContext)();
                var osc=ctx.createOscillator();
                var gain=ctx.createGain();
                osc.connect(gain);
                gain.connect(ctx.destination);
                osc.frequency.value=880;
                osc.type='sine';
                gain.gain.setValueAtTime(0.15,ctx.currentTime);
                gain.gain.exponentialRampToValueAtTime(0.01,ctx.currentTime+0.15);
                osc.start(ctx.currentTime);
                osc.stop(ctx.currentTime+0.15);
            }catch(e){}
        }
        function showToast(){
            if(!toastEl)return;
            toastEl.style.display='block';
            toastEl.classList.add('admin-toast--show');
            setTimeout(function(){toastEl.classList.remove('admin-toast--show');setTimeout(function(){toastEl.style.display='none';},300);},3500);
        }
        function poll(){
            fetch('{{ route("admin.notifications.pending-count") }}',{headers:{'Accept':'application/json','X-Requested-With':'XMLHttpRequest'}})
                .then(function(r){return r.json();})
                .then(function(data){
                    var count=typeof data.count==='number'?data.count:0;
                    var last=getLastCount();
                    if(last!==null&&count>last){playDing();showToast();}
                    setLastCount(count);
                })
                .catch(function(){});
        }
        document.addEventListener('click',function initSound(){
            if(!isSoundActive()){setSoundActive();}
            document.removeEventListener('click',initSound);
        },{once:true});
        if(toastEl){setInterval(poll,POLL_INTERVAL);poll();}
    })();
    </script>
    <style>
    .admin-toast{position:fixed;top:16px;left:50%;transform:translateX(-50%) translateY(-120%);background:linear-gradient(135deg,#dc2626,var(--accent));color:#fff;padding:12px 24px;border-radius:12px;font-size:0.9rem;font-weight:600;box-shadow:0 8px 24px rgba(201,42,42,0.4);z-index:9999;transition:transform 0.3s ease;}
    .admin-toast.admin-toast--show{transform:translateX(-50%) translateY(0);}
    </style>
    @stack('scripts')
</body>
</html>
