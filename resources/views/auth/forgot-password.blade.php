@extends('layouts.frontend')

@section('title', 'Şifremi Unuttum')

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
.alert-success { padding: 0.75rem 1rem; background: rgba(34,197,94,0.2); border: 1px solid rgba(34,197,94,0.4); border-radius: 10px; color: #86efac; margin-bottom: 1rem; }
.form-error { font-size: 0.8rem; color: #f87171; margin-top: 0.25rem; }
.help-text { font-size: 0.85rem; color: var(--muted); margin-top: 0.5rem; }
.page-hero { padding: 2rem 1rem; background: var(--ry-header-bg); border-top: 1px solid var(--ry-line-color); border-bottom: 1px solid var(--ry-line-color); }
.page-hero h1 { font-size: 1.5rem; font-weight: 700; color: #fff; margin: 0; text-align: center; }
</style>
@endpush

@section('content')
<section class="page-hero">
    <h1>Şifremi Unuttum</h1>
</section>
<div class="auth-page">
    <div class="auth-card">
        @if(session('status'))
            <div class="alert-success">{{ session('status') }}</div>
        @endif
        @if($errors->any())
            <div class="alert-error">{{ $errors->first() }}</div>
        @endif
        <p class="help-text" style="margin-bottom:1rem;">E-posta adresinizi girin, size şifre sıfırlama bağlantısı gönderelim.</p>
        <form method="POST" action="{{ route('password.email') }}">
            @csrf
            <div class="form-group">
                <label for="email">E-posta *</label>
                <input type="email" name="email" id="email" class="form-input" value="{{ old('email') }}" required autofocus>
                @error('email')<span class="form-error">{{ $message }}</span>@enderror
            </div>
            <button type="submit" class="btn-submit">Bağlantı Gönder</button>
        </form>
        <div class="auth-links">
            <a href="{{ route('login') }}">Giriş sayfasına dön</a>
        </div>
    </div>
</div>
@endsection
