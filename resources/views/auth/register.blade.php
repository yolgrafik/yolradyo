@extends('layouts.frontend')

@section('title', 'Üyelik Kaydı')

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
.form-check { display: flex; align-items: flex-start; gap: 0.5rem; }
.form-check input { margin-top: 0.25rem; flex-shrink: 0; accent-color: var(--ry-btn-bg); }
.form-check label { margin: 0; font-weight: 500; font-size: 0.9rem; line-height: 1.4; }
.form-check a { color: var(--ry-schedule-active); text-decoration: underline; }
.form-check a:hover { color: var(--ry-schedule-active); opacity: 0.9; }
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
.help-text { font-size: 0.8rem; color: var(--muted); margin-top: 0.25rem; }
.page-hero { padding: 2rem 1rem; background: var(--ry-header-bg); border-top: 1px solid var(--ry-line-color); border-bottom: 1px solid var(--ry-line-color); }
.page-hero h1 { font-size: 1.5rem; font-weight: 700; color: #fff; margin: 0; text-align: center; }
</style>
@endpush

@section('content')
<section class="page-hero">
    <h1>Üyelik Kaydı</h1>
</section>
<div class="auth-page">
    <div class="auth-card">
        @if($errors->any())
            <div class="alert-error">{{ $errors->first() }}</div>
        @endif
        @if(session('success'))
            <div class="alert-success">{{ session('success') }}</div>
        @endif
        <form method="POST" action="{{ route('register') }}">
            @csrf
            <div class="form-group">
                <label for="name">Ad Soyad <span class="required">*</span></label>
                <input type="text" name="name" id="name" class="form-input" value="{{ old('name') }}" placeholder="Adınız ve soyadınızı giriniz" maxlength="60" required>
                <span class="help-text">İki kelime, yalnızca harf; her kelime en az 3 karakter olmalıdır</span>
                @error('name')<span class="form-error">{{ $message }}</span>@enderror
            </div>
            <div class="form-group">
                <label for="email">E-posta Adresi <span class="required">*</span></label>
                <input type="email" name="email" id="email" class="form-input" value="{{ old('email') }}" placeholder="ornek@eposta.com" required>
                @error('email')<span class="form-error">{{ $message }}</span>@enderror
            </div>
            <div class="form-group">
                <label for="password">Şifre <span class="required">*</span></label>
                <input type="password" name="password" id="password" class="form-input" placeholder="En az 8 karakter" required minlength="8">
                @error('password')<span class="form-error">{{ $message }}</span>@enderror
            </div>
            <div class="form-group">
                <label for="password_confirmation">Şifre Tekrar <span class="required">*</span></label>
                <input type="password" name="password_confirmation" id="password_confirmation" class="form-input" placeholder="Şifrenizi tekrar giriniz" required>
            </div>
            <div class="form-group form-check">
                <input type="checkbox" name="terms_accepted" id="terms_accepted" value="1" {{ old('terms_accepted') ? 'checked' : '' }} required>
                <label for="terms_accepted">
                    <a href="{{ url('/kullanim') }}" target="_blank" rel="noopener">Kullanım şartlarını</a> okudum ve kabul ediyorum <span class="required">*</span>
                </label>
            </div>
            <div class="form-group form-check">
                <input type="checkbox" name="privacy_accepted" id="privacy_accepted" value="1" {{ old('privacy_accepted') ? 'checked' : '' }} required>
                <label for="privacy_accepted">
                    <a href="{{ url('/gizlilik') }}" target="_blank" rel="noopener">Gizlilik politikasını</a> ve <a href="{{ url('/kvkk') }}" target="_blank" rel="noopener">KVKK aydınlatma metnini</a> okudum ve kabul ediyorum <span class="required">*</span>
                </label>
            </div>
            <button type="submit" class="btn-submit">Kayıt Oluştur</button>
        </form>
        <div class="auth-links">
            <a href="{{ route('login') }}">Hesabınız var mı? Giriş Yap</a>
        </div>
    </div>
</div>
@endsection
