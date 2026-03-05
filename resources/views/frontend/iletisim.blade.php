@extends('layouts.frontend')

@section('title', $pageTitle ?? 'İletişim')

@push('styles')
<style>
    .page-hero {
        padding: 2.5rem 1.5rem;
        background: var(--ry-header-bg);
        border-bottom: 1px solid var(--ry-border);
    }
    .page-hero h1 {
        font-size: 1.75rem;
        font-weight: 700;
        color: #fff;
        text-transform: none;
        max-width: 1200px;
        margin: 0 auto;
    }
    .page-content {
        max-width: 1200px;
        margin: 0 auto;
        padding: 2rem 1.5rem;
    }
    .page-content p {
        color: var(--muted);
        line-height: 1.7;
        margin-bottom: 1rem;
    }
    .contact-form {
        background: var(--ry-bar-bg);
        border: 1px solid rgba(255,255,255,0.08);
        border-radius: 14px;
        padding: 1.5rem;
        margin-top: 1.5rem;
    }
    .contact-form h3 {
        font-size: 1.1rem;
        color: #fff;
        margin: 0 0 1rem 0;
    }
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
    .form-input[readonly] { opacity: 0.85; cursor: default; }
    .form-hp { position: absolute; left: -9999px; }
    .btn-submit {
        padding: 0.75rem 1.5rem;
        font-size: 0.95rem;
        font-weight: 600;
        background: linear-gradient(135deg, #c92a2a, #b30000);
        color: #fff;
        border: none;
        border-radius: 10px;
        cursor: pointer;
    }
    .btn-submit:hover { opacity: 0.9; }
    .btn-submit:disabled { opacity: 0.6; cursor: not-allowed; }
    .alert-success {
        padding: 0.75rem 1rem;
        background: rgba(34,197,94,0.2);
        border: 1px solid rgba(34,197,94,0.4);
        border-radius: 10px;
        color: #86efac;
        margin-bottom: 1rem;
    }
    .alert-error {
        padding: 0.75rem 1rem;
        background: rgba(239,68,68,0.2);
        border: 1px solid rgba(239,68,68,0.4);
        border-radius: 10px;
        color: #fca5a5;
        margin-bottom: 1rem;
    }
    .form-error { font-size: 0.8rem; color: #f87171; margin-top: 0.25rem; }
    .auth-required {
        padding: 1.5rem;
        text-align: center;
        color: var(--muted);
        margin-bottom: 1rem;
    }
    .auth-buttons { display: flex; gap: 0.75rem; justify-content: center; flex-wrap: wrap; margin-top: 1rem; }
    .auth-buttons a {
        padding: 0.6rem 1.25rem;
        font-size: 0.9rem;
        font-weight: 600;
        border-radius: 10px;
        text-decoration: none;
        transition: opacity 0.2s;
    }
    .auth-buttons a:hover { opacity: 0.9; }
    .btn-login { background: var(--ry-btn-bg); color: #fff; }
    .btn-register { background: rgba(255,255,255,0.1); color: #fff; border: 1px solid rgba(255,255,255,0.25); }
    .contact-info {
        background: var(--ry-bar-bg);
        border: 1px solid rgba(255,255,255,0.08);
        border-radius: 14px;
        padding: 1.5rem;
        margin-bottom: 1rem;
    }
    .contact-info-grid {
        display: flex;
        flex-direction: column;
        gap: 1.25rem;
    }
    .contact-info-item {
        display: flex;
        gap: 1rem;
        align-items: flex-start;
    }
    .contact-info-icon { font-size: 1.5rem; }
    .contact-info-item a:hover { text-decoration: underline; }
</style>
@endpush

@section('content')
<section class="page-hero">
    <h1>{{ $pageTitle ?? 'İletişim' }}</h1>
</section>
<div class="page-content">
    @if(!empty($contactEmail) || !empty($contactPhone) || !empty($addressText))
    <div class="contact-info">
        <h3 style="font-size:1.1rem;color:#fff;margin:0 0 1rem 0;">Radyo İletişim Bilgileri</h3>
        <div class="contact-info-grid">
            @if(!empty($addressText))
            <div class="contact-info-item">
                <span class="contact-info-icon">📍</span>
                <div>
                    <strong style="color:var(--muted);font-size:0.85rem;">Adres</strong>
                    <p style="margin:0.25rem 0 0;color:var(--text);line-height:1.5;">{{ $addressText }}</p>
                </div>
            </div>
            @endif
            @if(!empty($contactPhone))
            <div class="contact-info-item">
                <span class="contact-info-icon">📞</span>
                <div>
                    <strong style="color:var(--muted);font-size:0.85rem;">Telefon</strong>
                    <p style="margin:0.25rem 0 0;"><a href="tel:{{ preg_replace('/[^0-9+]/', '', $contactPhone) }}" style="color:var(--ry-schedule-active);text-decoration:none;">{{ $contactPhone }}</a></p>
                </div>
            </div>
            @endif
            @if(!empty($contactEmail))
            <div class="contact-info-item">
                <span class="contact-info-icon">✉️</span>
                <div>
                    <strong style="color:var(--muted);font-size:0.85rem;">E-posta</strong>
                    <p style="margin:0.25rem 0 0;"><a href="mailto:{{ $contactEmail }}" style="color:var(--ry-schedule-active);text-decoration:none;">{{ $contactEmail }}</a></p>
                </div>
            </div>
            @endif
        </div>
    </div>
    @endif
    <p style="margin-top:1.5rem;">Bizimle iletişime geçmek için aşağıdaki formu doldurun. En kısa sürede size dönüş yapacağız.</p>

    <div class="contact-form">
        <h3>Mesaj Gönderin</h3>
        @if(session('success'))
            <div class="alert-success">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="alert-error">{{ session('error') }}</div>
        @endif

        @guest
            <p class="auth-required">Mesaj göndermek için üye girişi yapmalısınız.</p>
            <div class="auth-buttons">
                <a href="{{ route('login') }}" class="btn-login">Giriş Yap</a>
                <a href="{{ route('register') }}" class="btn-register">Üye Ol</a>
            </div>
        @else
            @if(!auth()->user()->isApproved())
                <p class="auth-required">Mesaj gönderebilmek için hesabınızın onaylanması gerekiyor. Lütfen e-posta adresinizi kontrol edin veya yönetici ile iletişime geçin.</p>
            @else
            <form method="POST" action="{{ route('public.contact.store') }}" id="contactForm">
                @csrf
                <div class="form-group form-hp" aria-hidden="true">
                    <label for="website">Website</label>
                    <input type="text" name="website" id="website" tabindex="-1" autocomplete="off">
                </div>
                <div class="form-group">
                    <label for="contact_name">Ad Soyad</label>
                    <input type="text" name="name" id="contact_name" class="form-input" value="{{ auth()->user()->name }}" readonly>
                </div>
                <div class="form-group">
                    <label for="contact_email">E-posta</label>
                    <input type="email" name="email" id="contact_email" class="form-input" value="{{ auth()->user()->email }}" readonly>
                </div>
                <div class="form-group">
                    <label for="contact_message">Mesajınız *</label>
                    <textarea name="message" id="contact_message" class="form-input" rows="5" maxlength="2000"
                        placeholder="Mesajınızı buraya yazın (en az 20 karakter)">{{ old('message') }}</textarea>
                    @error('message')<span class="form-error">{{ $message }}</span>@enderror
                </div>
                <button type="submit" class="btn-submit" id="submitBtn">Gönder</button>
            </form>
            @endif
        @endguest
    </div>
</div>

@auth
@if(auth()->user()->isApproved())
@push('scripts')
<script>
document.getElementById('contactForm')?.addEventListener('submit', function() {
    var btn = document.getElementById('submitBtn');
    if (btn) btn.disabled = true;
});
</script>
@endpush
@endif
@endauth
@endsection
