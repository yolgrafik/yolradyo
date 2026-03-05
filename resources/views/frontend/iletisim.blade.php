@extends('layouts.frontend')

@section('title', $pageTitle ?? 'İletişim')

@push('styles')
<style>
    .contact-page { max-width: 1200px; margin: 0 auto; padding: 2rem 1rem; }
    .contact-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 2rem; align-items: start; }
    @media (max-width: 900px) { .contact-grid { grid-template-columns: 1fr; } }
    .contact-left { background: #f8f9fa; border-radius: 16px; padding: 2rem; }
    .contact-right { background: #fff; border-radius: 16px; padding: 2rem; box-shadow: 0 4px 20px rgba(0,0,0,0.08); }
    .contact-title { font-size: 1.5rem; font-weight: 700; color: #1a1a2e; margin: 0 0 1.5rem 0; }
    .contact-info-list { display: flex; flex-direction: column; gap: 1.25rem; margin-bottom: 1.5rem; }
    .contact-info-item { display: flex; align-items: flex-start; gap: 1rem; }
    .contact-info-icon { width: 44px; height: 44px; min-width: 44px; border-radius: 12px; background: rgba(201,42,42,0.1); color: #c92a2a; display: flex; align-items: center; justify-content: center; font-size: 1.25rem; }
    .contact-info-text { flex: 1; }
    .contact-info-label { font-size: 0.8rem; color: #6b7280; margin-bottom: 0.25rem; }
    .contact-info-value { font-size: 1rem; color: #1a1a2e; font-weight: 500; }
    .contact-info-value a { color: #c92a2a; text-decoration: none; }
    .contact-info-value a:hover { text-decoration: underline; }
    .contact-map { border-radius: 12px; overflow: hidden; height: 280px; margin-top: 1.5rem; border: 1px solid #e5e7eb; }
    .contact-map iframe { width: 100%; height: 100%; border: none; }
    .form-group { margin-bottom: 1.25rem; }
    .form-group label { display: block; font-size: 0.9rem; font-weight: 600; color: #374151; margin-bottom: 0.5rem; }
    .form-input {
        width: 100%;
        padding: 0.75rem 1rem;
        background: #f9fafb;
        border: 1px solid #e5e7eb;
        border-radius: 10px;
        font-size: 0.95rem;
        color: #1a1a2e;
        transition: border-color 0.2s;
    }
    .form-input:focus { outline: none; border-color: #c92a2a; background: #fff; }
    .form-input::placeholder { color: #9ca3af; }
    textarea.form-input { min-height: 120px; resize: vertical; }
    .form-checkbox-group { display: flex; flex-wrap: wrap; gap: 1rem; margin-top: 0.5rem; }
    .form-checkbox-item { display: flex; align-items: center; gap: 0.5rem; cursor: pointer; }
    .form-checkbox-item input { accent-color: #c92a2a; width: 18px; height: 18px; }
    .form-checkbox-item span { font-size: 0.95rem; color: #374151; }
    .form-hp { position: absolute; left: -9999px; }
    .btn-submit {
        width: 100%;
        padding: 0.9rem 1.5rem;
        font-size: 1rem;
        font-weight: 600;
        background: linear-gradient(135deg, #c92a2a, #b30000);
        color: #fff;
        border: none;
        border-radius: 10px;
        cursor: pointer;
        transition: opacity 0.2s;
    }
    .btn-submit:hover { opacity: 0.95; }
    .btn-submit:disabled { opacity: 0.6; cursor: not-allowed; }
    .alert-success { padding: 1rem; background: #dcfce7; border: 1px solid #86efac; border-radius: 10px; color: #166534; margin-bottom: 1rem; }
    .alert-error { padding: 1rem; background: #fee2e2; border: 1px solid #fca5a5; border-radius: 10px; color: #991b1b; margin-bottom: 1rem; }
    .form-error { font-size: 0.8rem; color: #dc2626; margin-top: 0.25rem; }
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
        {{-- Sol: İletişim Bilgileri + Harita --}}
        <div class="contact-left">
            <h2 class="contact-title">Bize Ulaşın</h2>
            <div class="contact-info-list">
                @if(!empty($contactMobile ?? $contactPhone))
                <div class="contact-info-item">
                    <span class="contact-info-icon">📱</span>
                    <div class="contact-info-text">
                        <div class="contact-info-label">Mobil Telefon</div>
                        <div class="contact-info-value"><a href="tel:{{ preg_replace('/[^0-9+]/', '', $contactMobile ?? $contactPhone) }}">{{ $contactMobile ?: $contactPhone }}</a></div>
                    </div>
                </div>
                @endif
                @if(!empty($contactPhone))
                <div class="contact-info-item">
                    <span class="contact-info-icon">📞</span>
                    <div class="contact-info-text">
                        <div class="contact-info-label">Telefon</div>
                        <div class="contact-info-value"><a href="tel:{{ preg_replace('/[^0-9+]/', '', $contactPhone) }}">{{ $contactPhone }}</a></div>
                    </div>
                </div>
                @endif
                @if(!empty($contactEmail))
                <div class="contact-info-item">
                    <span class="contact-info-icon">✉️</span>
                    <div class="contact-info-text">
                        <div class="contact-info-label">E-posta</div>
                        <div class="contact-info-value"><a href="mailto:{{ $contactEmail }}">{{ $contactEmail }}</a></div>
                    </div>
                </div>
                @endif
                @if(!empty($contactFax))
                <div class="contact-info-item">
                    <span class="contact-info-icon">📠</span>
                    <div class="contact-info-text">
                        <div class="contact-info-label">Faks</div>
                        <div class="contact-info-value">{{ $contactFax }}</div>
                    </div>
                </div>
                @endif
                @if(!empty($addressText))
                <div class="contact-info-item">
                    <span class="contact-info-icon">📍</span>
                    <div class="contact-info-text">
                        <div class="contact-info-label">Adres</div>
                        <div class="contact-info-value">{{ $addressText }}</div>
                    </div>
                </div>
                @endif
            </div>
            <div class="contact-map">
                <iframe src="https://www.google.com/maps?q=Bergischer+Ring+38,+58095+Hagen,+Germany&output=embed" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade" title="Konum"></iframe>
            </div>
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

            <form method="POST" action="{{ route('public.contact.store') }}" id="contactForm">
                @csrf
                <div class="form-group form-hp" aria-hidden="true">
                    <label for="website">Website</label>
                    <input type="text" name="website" id="website" tabindex="-1" autocomplete="off">
                </div>
                <div class="form-group">
                    <label for="contact_name">Adı Soyadı *</label>
                    <input type="text" name="name" id="contact_name" class="form-input" value="{{ old('name', $prefillName ?? '') }}" placeholder="Adınız ve soyadınız" required>
                    @error('name')<span class="form-error">{{ $message }}</span>@enderror
                </div>
                <div class="form-group">
                    <label for="contact_email">E-posta *</label>
                    <input type="email" name="email" id="contact_email" class="form-input" value="{{ old('email', $prefillEmail ?? '') }}" placeholder="ornek@email.com" required>
                    @error('email')<span class="form-error">{{ $message }}</span>@enderror
                </div>
                <div class="form-group">
                    <label for="contact_phone">Telefon</label>
                    <input type="tel" name="phone" id="contact_phone" class="form-input" value="{{ old('phone') }}" placeholder="+90 555 123 4567">
                    @error('phone')<span class="form-error">{{ $message }}</span>@enderror
                </div>
                <div class="form-group">
                    <label>Bizi nereden buldunuz?</label>
                    <div class="form-checkbox-group">
                        <label class="form-checkbox-item">
                            <input type="checkbox" name="where_found[]" value="google" {{ in_array('google', old('where_found', [])) ? 'checked' : '' }}>
                            <span>Google</span>
                        </label>
                        <label class="form-checkbox-item">
                            <input type="checkbox" name="where_found[]" value="facebook" {{ in_array('facebook', old('where_found', [])) ? 'checked' : '' }}>
                            <span>Facebook</span>
                        </label>
                        <label class="form-checkbox-item">
                            <input type="checkbox" name="where_found[]" value="other" {{ in_array('other', old('where_found', [])) ? 'checked' : '' }}>
                            <span>Diğer</span>
                        </label>
                    </div>
                </div>
                <div class="form-group">
                    <label for="contact_subject">Konu *</label>
                    <input type="text" name="subject" id="contact_subject" class="form-input" value="{{ old('subject') }}" placeholder="Mesaj konusu" required>
                    @error('subject')<span class="form-error">{{ $message }}</span>@enderror
                </div>
                <div class="form-group">
                    <label for="contact_message">Mesaj / Açıklama *</label>
                    <textarea name="message" id="contact_message" class="form-input" rows="5" maxlength="2000" placeholder="Mesajınızı buraya yazın (en az 20 karakter)" required>{{ old('message') }}</textarea>
                    @error('message')<span class="form-error">{{ $message }}</span>@enderror
                </div>
                <div class="form-group">
                    <label for="captcha_answer">Güvenlik: 2 + 3 = ? *</label>
                    <input type="text" name="captcha_answer" id="captcha_answer" class="form-input" placeholder="Cevabı girin" required autocomplete="off">
                    @error('captcha_answer')<span class="form-error">{{ $message }}</span>@enderror
                </div>
                <button type="submit" class="btn-submit" id="submitBtn">Gönder</button>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.getElementById('contactForm')?.addEventListener('submit', function() {
    var btn = document.getElementById('submitBtn');
    if (btn) btn.disabled = true;
});
</script>
@endpush
@endsection
