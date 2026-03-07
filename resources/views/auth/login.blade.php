@extends('layouts.frontend')

@section('title', 'Giriş Yap')

@push('styles')
<style>
.auth-page { max-width: 420px; margin: 0 auto; padding: 2rem 1rem; }
.auth-card {
    background: var(--ry-bar-bg);
    border: 1px solid rgba(255,255,255,0.08);
    border-top: 1px solid var(--ry-line-color);
    border-bottom: 1px solid var(--ry-line-color);
    border-radius: 14px;
    padding: 2rem;
}
.auth-card h1 { font-size: 1.5rem; font-weight: 700; color: #fff; margin: 0 0 1.5rem 0; }
.form-group { margin-bottom: 1rem; }
.form-group label { display: block; font-size: 0.9rem; font-weight: 600; color: var(--text); margin-bottom: 0.35rem; }
.form-input {
    width: 100%;
    padding: 0.75rem 1rem;
    background: rgba(255,255,255,0.06);
    border: 1px solid rgba(255,255,255,0.15);
    border-radius: 10px;
    color: var(--text);
    font-size: 0.95rem;
}
.form-input:focus { outline: none; border-color: var(--ry-schedule-active); }
.form-check { display: flex; align-items: center; gap: 0.5rem; }
.form-check input { accent-color: var(--ry-btn-bg); }
.form-check label { margin: 0; font-weight: 500; }
.btn-submit {
    width: 100%;
    padding: 0.75rem 1.5rem;
    font-size: 0.95rem;
    font-weight: 600;
    background: var(--ry-btn-bg);
    color: #fff;
    border: none;
    border-radius: 10px;
    cursor: pointer;
    margin-top: 0.5rem;
}
.btn-submit:hover { background: var(--ry-btn-hover); opacity: 0.95; }
.auth-links { margin-top: 1.5rem; text-align: center; }
.auth-links a { color: var(--ry-schedule-active); text-decoration: none; font-weight: 600; }
.auth-links a:hover { text-decoration: underline; }
.alert-error { padding: 0.75rem 1rem; background: rgba(239,68,68,0.2); border: 1px solid rgba(239,68,68,0.4); border-radius: 10px; color: #fca5a5; margin-bottom: 1rem; }
.form-error { font-size: 0.8rem; color: #f87171; margin-top: 0.25rem; }
.page-hero { padding: 2rem 1rem; background: var(--ry-header-bg); border-top: 1px solid var(--ry-line-color); border-bottom: 1px solid var(--ry-line-color); }
.page-hero h1 { font-size: 1.5rem; font-weight: 700; color: #fff; margin: 0; text-align: center; }
</style>
@endpush

@section('content')
<section class="page-hero">
    <h1>Giriş Yap</h1>
</section>
<div class="auth-page">
    <div class="auth-card">
        @if(session('message'))
            <div class="alert-info" style="padding:0.75rem 1rem;background:rgba(59,130,246,0.2);border:1px solid rgba(59,130,246,0.4);border-radius:10px;color:#93c5fd;margin-bottom:1rem;">{{ session('message') }}</div>
        @endif
        @if($errors->any())
            <div class="alert-error">{{ $errors->first() }}</div>
        @endif
        <form method="POST" action="{{ route('login') }}">
            @csrf
            <div class="form-group">
                <label for="email">E-posta *</label>
                <input type="email" name="email" id="email" class="form-input" value="{{ old('email') }}" required autofocus>
                @error('email')<span class="form-error">{{ $message }}</span>@enderror
            </div>
            <div class="form-group">
                <label for="password">Şifre *</label>
                <input type="password" name="password" id="password" class="form-input" required>
                @error('password')<span class="form-error">{{ $message }}</span>@enderror
            </div>
            <div class="form-group form-check">
                <input type="checkbox" name="remember" id="remember">
                <label for="remember">Beni hatırla</label>
            </div>
            <button type="submit" class="btn-submit">Giriş Yap</button>
        </form>
        <div class="auth-links">
            <a href="{{ route('password.request') }}">Şifremi unuttum</a>
            <span style="margin:0 0.5rem;color:var(--muted);">|</span>
            <a href="{{ route('register') }}">Hesabınız yok mu? Üye Ol</a>
        </div>
    </div>
</div>
@endsection
