@extends('layouts.frontend')

@section('title', $pageTitle ?? 'İletişim')

@php
    $isLoggedIn = auth()->check() && auth()->user()->isApproved();
@endphp

@push('styles')
<style>
    .contact-page { max-width: 1200px; margin: 0 auto; padding: 2rem 1rem; }
    .contact-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 2rem; align-items: start; }
    @media (max-width: 900px) { .contact-grid { grid-template-columns: 1fr; } }
    .contact-left {
        background: color-mix(in srgb, var(--ry-bar-bg) 60%, #0b0f16);
        border: 1px solid var(--ry-border);
        border-radius: 16px;
        padding: 2rem;
    }
    .contact-right {
        background: var(--ry-surface);
        border: 1px solid var(--ry-border);
        border-radius: 16px;
        padding: 2rem;
        box-shadow: 0 4px 20px rgba(0,0,0,0.2);
    }
    .contact-title { font-size: 1.5rem; font-weight: 700; color: var(--ry-text); margin: 0 0 1.5rem 0; }
    .contact-info-list { display: flex; flex-direction: column; gap: 1.25rem; margin-bottom: 1.5rem; }
    .contact-info-item { display: flex; align-items: flex-start; gap: 1rem; }
    .contact-info-icon {
        width: 44px; height: 44px; min-width: 44px;
        border-radius: 12px;
        background: color-mix(in srgb, var(--ry-btn-bg) 25%, transparent);
        color: var(--ry-schedule-active);
        display: flex; align-items: center; justify-content: center;
        font-size: 1.15rem;
    }
    .contact-info-icon i { font-size: inherit; }
    .contact-info-text { flex: 1; }
    .contact-info-label { font-size: 0.8rem; color: var(--ry-text-muted); margin-bottom: 0.25rem; }
    .contact-info-value { font-size: 1rem; color: var(--ry-text); font-weight: 500; }
    .contact-info-value a { color: var(--ry-schedule-active); text-decoration: none; }
    .contact-info-value a:hover { text-decoration: underline; }
    .contact-map {
        border-radius: 12px;
        overflow: hidden;
        height: 280px;
        margin-top: 1.5rem;
        border: 1px solid var(--ry-border);
    }
    .contact-map iframe { width: 100%; height: 100%; border: none; }
    .form-group { margin-bottom: 1.25rem; }
    .form-group label { display: block; font-size: 0.9rem; font-weight: 600; color: var(--ry-text); margin-bottom: 0.5rem; }
    .form-input {
        width: 100%;
        padding: 0.75rem 1rem;
        background: rgba(255,255,255,0.06);
        border: 1px solid var(--ry-border);
        border-radius: 10px;
        font-size: 0.95rem;
        color: var(--ry-text);
        transition: border-color 0.2s;
    }
    .form-input:focus { outline: none; border-color: var(--ry-schedule-active); }
    .form-input::placeholder { color: var(--ry-text-muted); }
    .form-input:disabled { opacity: 0.6; cursor: not-allowed; }
    textarea.form-input { min-height: 120px; resize: vertical; }
    .form-hp { position: absolute; left: -9999px; }
    .btn-submit {
        width: 100%;
        padding: 0.9rem 1.5rem;
        font-size: 1rem;
        font-weight: 600;
        background: var(--ry-btn-bg);
        color: #fff;
        border: 1px solid var(--ry-btn-bg);
        border-radius: 10px;
        cursor: pointer;
        transition: opacity 0.2s;
    }
    .btn-submit:hover { opacity: 0.95; }
    .btn-submit:disabled { opacity: 0.5; cursor: not-allowed; }
    .contact-auth-msg {
        padding: 1rem 1.25rem;
        background: color-mix(in srgb, var(--ry-schedule-active) 15%, transparent);
        border: 1px solid color-mix(in srgb, var(--ry-schedule-active) 40%, transparent);
        border-radius: 10px;
        color: var(--ry-text);
        margin-bottom: 1.25rem;
        font-size: 0.95rem;
    }
    .contact-auth-msg a { color: var(--ry-schedule-active); text-decoration: none; font-weight: 600; }
    .contact-auth-msg a:hover { text-decoration: underline; }
    .alert-success {
        padding: 1rem;
        background: rgba(34,197,94,0.15);
        border: 1px solid rgba(34,197,94,0.4);
        border-radius: 10px;
        color: #86efac;
        margin-bottom: 1rem;
    }
    .alert-error {
        padding: 1rem;
        background: rgba(239,68,68,0.15);
        border: 1px solid rgba(239,68,68,0.4);
        border-radius: 10px;
        color: #fca5a5;
        margin-bottom: 1rem;
    }
    .form-error { font-size: 0.8rem; color: #f87171; margin-top: 0.25rem; }
    .page-hero { padding: 2rem 1.5rem; background: var(--ry-header-bg); border-bottom: 1px solid var(--ry-border); }
    .page-hero h1 { font-size: 1.75rem; font-weight: 700; color: #fff; margin: 0; }
</style>
@endpush

@section('content')
<section class="page-hero">
    <h1>{{ $pageTitle ?? 'İletişim' }}</h1>
</section>

<div class="contact-page">
    <div class="contact-grid">
        {{-- Sol: İletişim Bilgileri + Harita (herkese açık) --}}
        <div class="contact-left">
            <h2 class="contact-title">Bize Ulaşın</h2>
            <div class="contact-info-list">
                @if(!empty($contactMobile ?? $contactPhone))
                <div class="contact-info-item">
                    <span class="contact-info-icon"><i class="bi bi-phone"></i></span>
                    <div class="contact-info-text">
                        <div class="contact-info-label">Mobil Telefon</div>
                        <div class="contact-info-value"><a href="tel:{{ preg_replace('/[^0-9+]/', '', $contactMobile ?? $contactPhone) }}">{{ $contactMobile ?: $contactPhone }}</a></div>
                    </div>
                </div>
                @endif
                @if(!empty($contactPhone))
                <div class="contact-info-item">
                    <span class="contact-info-icon"><i class="bi bi-telephone"></i></span>
                    <div class="contact-info-text">
                        <div class="contact-info-label">Telefon</div>
                        <div class="contact-info-value"><a href="tel:{{ preg_replace('/[^0-9+]/', '', $contactPhone) }}">{{ $contactPhone }}</a></div>
                    </div>
                </div>
                @endif
                @if(!empty($contactEmail))
                <div class="contact-info-item">
                    <span class="contact-info-icon"><i class="bi bi-envelope"></i></span>
                    <div class="contact-info-text">
                        <div class="contact-info-label">E-posta</div>
                        <div class="contact-info-value"><a href="mailto:{{ $contactEmail }}">{{ $contactEmail }}</a></div>
                    </div>
                </div>
                @endif
                <div class="contact-info-item">
                    <span class="contact-info-icon"><i class="bi bi-geo-alt"></i></span>
                    <div class="contact-info-text">
                        <div class="contact-info-label">Adres</div>
                        <div class="contact-info-value">{{ !empty($addressText) ? $addressText : 'Bergischer Ring 38, 58095 Hagen, Almanya' }}</div>
                    </div>
                </div>
            </div>
            @if(!empty($mapEmbed))
            <div class="contact-map">
                {!! $mapEmbed !!}
            </div>
            @else
            <div class="contact-map">
                <iframe src="https://www.google.com/maps?q=Bergischer+Ring+38,+58095+Hagen,+Germany&output=embed" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade" title="Konum"></iframe>
            </div>
            @endif
        </div>

        {{-- Sağ: İletişim Formu --}}
        <div class="contact-right">
            <h2 class="contact-title">Mesaj Gönderin</h2>
            @if(session('success'))
                <div class="alert-success">{{ session('success') }}</div>
            @endif
            @if(session('error'))
                <div class="alert-error">{{ session('error') }}</div>
            @endif

            @if(!$isLoggedIn)
            <div class="contact-auth-msg">
                Mesaj göndermek için lütfen <a href="{{ route('login') }}">giriş yapın</a> veya <a href="{{ route('register') }}">üye olun</a>.
            </div>
            @endif

            <form method="POST" action="{{ route('public.contact.store') }}" id="contactForm">
                @csrf
                <div class="form-group form-hp" aria-hidden="true">
                    <label for="website">Website</label>
                    <input type="text" name="website" id="website" tabindex="-1" autocomplete="off">
                </div>
                <div class="form-group">
                    <label for="contact_name">Adı Soyadı *</label>
                    <input type="text" name="name" id="contact_name" class="form-input" value="{{ old('name', $prefillName ?? '') }}" placeholder="Adınız ve soyadınız" {{ $isLoggedIn ? '' : 'disabled' }} {{ $isLoggedIn ? 'required' : '' }}>
                    @error('name')<span class="form-error">{{ $message }}</span>@enderror
                </div>
                <div class="form-group">
                    <label for="contact_email">E-posta *</label>
                    <input type="email" name="email" id="contact_email" class="form-input" value="{{ old('email', $prefillEmail ?? '') }}" placeholder="ornek@email.com" {{ $isLoggedIn ? '' : 'disabled' }} {{ $isLoggedIn ? 'required' : '' }}>
                    @error('email')<span class="form-error">{{ $message }}</span>@enderror
                </div>
                <div class="form-group">
                    <label for="contact_phone">Telefon</label>
                    <input type="tel" name="phone" id="contact_phone" class="form-input" value="{{ old('phone') }}" placeholder="+90 555 123 4567" {{ $isLoggedIn ? '' : 'disabled' }}>
                    @error('phone')<span class="form-error">{{ $message }}</span>@enderror
                </div>
                <div class="form-group">
                    <label for="contact_subject">Konu *</label>
                    <input type="text" name="subject" id="contact_subject" class="form-input" value="{{ old('subject') }}" placeholder="Mesaj konusu" {{ $isLoggedIn ? '' : 'disabled' }} {{ $isLoggedIn ? 'required' : '' }}>
                    @error('subject')<span class="form-error">{{ $message }}</span>@enderror
                </div>
                <div class="form-group">
                    <label for="contact_message">Mesaj *</label>
                    <textarea name="message" id="contact_message" class="form-input" rows="5" maxlength="2000" placeholder="Mesajınızı buraya yazın (en az 20 karakter)" {{ $isLoggedIn ? '' : 'disabled' }} {{ $isLoggedIn ? 'required' : '' }}>{{ old('message') }}</textarea>
                    @error('message')<span class="form-error">{{ $message }}</span>@enderror
                </div>
                <div class="form-group">
                    <label for="captcha_answer">Güvenlik: 2 + 3 = ? *</label>
                    <input type="text" name="captcha_answer" id="captcha_answer" class="form-input" placeholder="Cevabı girin" {{ $isLoggedIn ? '' : 'disabled' }} {{ $isLoggedIn ? 'required' : '' }} autocomplete="off">
                    @error('captcha_answer')<span class="form-error">{{ $message }}</span>@enderror
                </div>
                <button type="submit" class="btn-submit" id="submitBtn" {{ $isLoggedIn ? '' : 'disabled' }}>Gönder</button>
            </form>
        </div>
    </div>
</div>

@if($isLoggedIn)
@push('scripts')
<script>
document.getElementById('contactForm')?.addEventListener('submit', function() {
    var btn = document.getElementById('submitBtn');
    if (btn) btn.disabled = true;
});
</script>
@endpush
@endif
@endsection
