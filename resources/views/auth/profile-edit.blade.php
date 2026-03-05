@extends('layouts.frontend')

@section('title', 'Profilim')

@push('styles')
<style>
.profile-page { max-width: 480px; margin: 0 auto; padding: 2rem 1rem; }
.profile-card {
    background: var(--ry-bar-bg);
    border: 1px solid rgba(255,255,255,0.08);
    border-top: 1px solid var(--ry-line-color);
    border-bottom: 1px solid var(--ry-line-color);
    border-radius: 14px;
    padding: 2rem;
}
.profile-card h1 { font-size: 1.5rem; font-weight: 700; color: #fff; margin: 0 0 1.5rem 0; }
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
.form-hint { font-size: 0.9rem; color: var(--muted); margin-top: 0.25rem; }
.form-error { font-size: 0.8rem; color: #f87171; margin-top: 0.25rem; }
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
.alert-success { padding: 0.75rem 1rem; background: rgba(34,197,94,0.2); border: 1px solid rgba(34,197,94,0.4); border-radius: 10px; color: #86efac; margin-bottom: 1rem; }
.alert-error { padding: 0.75rem 1rem; background: rgba(239,68,68,0.2); border: 1px solid rgba(239,68,68,0.4); border-radius: 10px; color: #fca5a5; margin-bottom: 1rem; }
.profile-links { margin-top: 1.5rem; text-align: center; }
.profile-links a { color: var(--ry-schedule-active); text-decoration: none; font-weight: 600; }
.profile-links a:hover { text-decoration: underline; }
.page-hero { padding: 2rem 1rem; background: var(--ry-header-bg); border-top: 1px solid var(--ry-line-color); border-bottom: 1px solid var(--ry-line-color); }
.page-hero h1 { font-size: 1.5rem; font-weight: 700; color: #fff; margin: 0; text-align: center; }
</style>
@endpush

@section('content')
<section class="page-hero">
    <h1>Profilim</h1>
</section>
<div class="profile-page">
    <div class="profile-card">
        @if(session('success'))
            <div class="alert-success">{{ session('success') }}</div>
        @endif
        @if($errors->any())
            <div class="alert-error">{{ $errors->first() }}</div>
        @endif
        <h1>Profil Bilgilerini Düzenle</h1>
        <form method="POST" action="{{ route('profile.update') }}">
            @csrf
            <div class="form-group">
                <label for="name">Ad Soyad *</label>
                <input type="text" name="name" id="name" required value="{{ old('name', $user->name) }}" class="form-input" maxlength="255">
                @error('name')<span class="form-error">{{ $message }}</span>@enderror
            </div>
            <div class="form-group">
                <label for="email">E-posta *</label>
                <input type="email" name="email" id="email" required value="{{ old('email', $user->email) }}" class="form-input">
                @error('email')<span class="form-error">{{ $message }}</span>@enderror
            </div>
            <div class="form-group">
                <label for="password">Yeni Şifre</label>
                <input type="password" name="password" id="password" class="form-input" autocomplete="new-password">
                <span class="form-hint">Şifreyi değiştirmek istemiyorsanız boş bırakın.</span>
                @error('password')<span class="form-error">{{ $message }}</span>@enderror
            </div>
            <div class="form-group">
                <label for="password_confirmation">Şifre Tekrar</label>
                <input type="password" name="password_confirmation" id="password_confirmation" class="form-input" autocomplete="new-password">
            </div>
            <button type="submit" class="btn-submit">Güncelle</button>
        </form>
        <div class="profile-links">
            <a href="{{ route('profile') }}">← Hesabıma dön</a>
        </div>
    </div>
</div>
@endsection
