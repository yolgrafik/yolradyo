@extends('admin.layouts.auth')

@section('hero')
<div class="login-hero login-header">
    <div class="login-hero-overlay"></div>
    <div class="login-hero-content">
        <img src="{{ asset('logo.png') }}" class="login-logo" alt="RADYOYOL">
        <h1>RADYOYOL ADMIN PANEL</h1>
        <p>TAM OZELLIK LISTESI</p>
    </div>
</div>
@endsection

@push('styles')
<style>
    body{
        background:
            radial-gradient(circle at 20% 30%, rgba(200,0,0,.35), transparent 40%),
            radial-gradient(circle at 80% 70%, rgba(255,80,0,.25), transparent 40%),
            linear-gradient(135deg, #0b0f1a, #111827 60%, #1a0f14);
        min-height:100vh;
    }
    .login-card{
        background: rgba(20, 24, 38, .65);
        backdrop-filter: blur(18px);
        -webkit-backdrop-filter: blur(18px);
        border: 1px solid rgba(255,255,255,.08);
        box-shadow:
            0 0 60px rgba(255,0,0,.15),
            0 25px 60px rgba(0,0,0,.65);
        border-radius: 18px;
        overflow: hidden;
    }
    .login-header{
        background: linear-gradient(135deg,#7a0f14,#c1121f,#ff2e2e);
        position:relative;
    }
    .login-header::after{
        content:"";
        position:absolute;
        inset:0;
        background: linear-gradient(90deg,
            rgba(255,255,255,0) 0%,
            rgba(255,255,255,.15) 50%,
            rgba(255,255,255,0) 100%);
        mix-blend-mode:overlay;
    }
    .alert-error {
        background: rgba(185, 28, 28, 0.3);
        color: #fecaca;
        padding: 0.75rem 1rem;
        border-radius: 10px;
        font-size: 0.875rem;
        margin-bottom: 1.25rem;
        border: 1px solid rgba(220, 38, 38, 0.3);
    }
    .form-group {
        margin-bottom: 1rem;
    }
    .form-group label {
        display: block;
        font-size: 0.875rem;
        font-weight: 500;
        margin-bottom: 0.5rem;
        color: var(--text);
    }
    .input-wrap {
        position: relative;
        display: flex;
        align-items: center;
    }
    .input-wrap input {
        width: 100%;
        padding: 0.75rem 1rem;
        padding-right: 2.75rem;
        font-size: 1rem;
        background: rgba(38, 38, 50, 0.8);
        border: 1px solid var(--border);
        border-radius: 10px;
        color: var(--text);
        transition: border-color 0.15s;
    }
    .input-wrap input:focus {
        outline: none;
        border-color: var(--accent);
    }
    .input-wrap input::placeholder {
        color: var(--muted);
    }
    .input-wrap.email-wrap input {
        padding-right: 1rem;
    }
    .pw-toggle {
        position: absolute;
        right: 0.75rem;
        background: none;
        border: none;
        color: var(--muted);
        font-size: 0.8rem;
        cursor: pointer;
        padding: 0.25rem;
    }
    .pw-toggle:hover {
        color: var(--text);
    }
    .form-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1.25rem;
        gap: 0.5rem;
        flex-wrap: wrap;
    }
    .checkbox-wrap {
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    .checkbox-wrap input {
        width: 1rem;
        height: 1rem;
        accent-color: var(--accent);
    }
    .checkbox-wrap span {
        font-size: 0.875rem;
        color: var(--muted);
    }
    .forgot-link {
        font-size: 0.875rem;
        color: var(--muted);
        text-decoration: none;
    }
    .forgot-link:hover {
        color: var(--accent);
    }
    .btn-login {
        width: 100%;
        padding: 0.875rem 1rem;
        font-size: 1rem;
        font-weight: 600;
        background: linear-gradient(90deg,#c1121f,#ff2e2e);
        color: #fff;
        border: none;
        border-radius: 10px;
        cursor: pointer;
        box-shadow: 0 0 15px rgba(255,0,0,.5);
        transition: .3s ease;
    }
    .btn-login:hover {
        box-shadow: 0 0 25px rgba(255,0,0,.8);
        transform: translateY(-2px);
    }
    .error-text {
        font-size: 0.75rem;
        color: #f87171;
        margin-top: 0.35rem;
    }
    .login-hero{
        position:relative;
        height:240px;
        margin: -2rem -2rem 1.5rem -2rem;
        display:flex;
        align-items:center;
        justify-content:center;
        text-align:center;
        overflow:hidden;
        border-radius: 18px 18px 0 0;
    }
    .login-hero-overlay{
        position:absolute;
        inset:0;
        background:linear-gradient(135deg, rgba(0,0,0,.75), rgba(180,30,30,.65));
    }
    .login-hero-content{
        position:relative;
        z-index:2;
        color:#fff;
    }
    .login-logo{
        height:115px;
        margin-bottom:10px;
        filter:
            drop-shadow(0 0 15px rgba(255,0,0,.6))
            drop-shadow(0 0 35px rgba(255,60,60,.4));
    }
    .login-hero h1{
        font-size:28px;
        letter-spacing:2px;
        margin:0;
    }
    .login-hero p{
        font-size:14px;
        letter-spacing:3px;
        opacity:.85;
    }
    .auth-body form{
        margin-top: 0;
    }
    @media (max-width: 480px) {
        .login-hero{
            margin: -1.5rem -1.25rem 1.25rem -1.25rem;
        }
    }
</style>
@endpush

@section('content')
    @if (session('error'))
        <div class="alert-error">{{ session('error') }}</div>
    @endif

    <form method="POST" action="{{ route('admin.login') }}">
        @csrf

        <div class="form-group">
            <label for="email">E-posta</label>
            <div class="input-wrap email-wrap">
                <input type="email" id="email" name="email" value="{{ old('email') }}" placeholder="Email adresinizi giriniz" required autofocus>
            </div>
            @error('email')
                <p class="error-text">{{ $message }}</p>
            @enderror
        </div>

        <div class="form-group">
            <label for="password">Sifre</label>
            <div class="input-wrap">
                <input type="password" id="password" name="password" placeholder="Sifrenizi giriniz" required>
                <button type="button" class="pw-toggle" id="pwToggle" aria-label="Sifreyi goster">Goster</button>
            </div>
            @error('password')
                <p class="error-text">{{ $message }}</p>
            @enderror
        </div>

        <div class="form-row">
            <label class="checkbox-wrap">
                <input type="checkbox" name="remember">
                <span>Beni Hatirla</span>
            </label>
            <a href="#" class="forgot-link">Sifremi Unuttum</a>
        </div>

        <button type="submit" class="btn-login">Giris Yap</button>
    </form>

    <script>
        (function() {
            var pw = document.getElementById('password');
            var btn = document.getElementById('pwToggle');
            if (pw && btn) {
                btn.addEventListener('click', function() {
                    if (pw.type === 'password') {
                        pw.type = 'text';
                        btn.textContent = 'Gizle';
                    } else {
                        pw.type = 'password';
                        btn.textContent = 'Goster';
                    }
                });
            }
        })();
    </script>
@endsection
