@extends('admin.layouts.app')

@section('content')
<div class="general-settings-page">
    <div class="settings-page-header">
        <h1 class="settings-page-title">Genel Site Ayarları</h1>
        <p class="settings-page-desc">Site adı, slogan ve iletişim bilgilerini yönetin.</p>
    </div>

    @if(session('success'))
        <div class="settings-success">
            <span class="settings-success-icon">✓</span>
            {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div class="settings-error">
            <span class="settings-error-icon">!</span>
            Lütfen formdaki hataları düzeltin.
        </div>
    @endif

    <form method="POST" action="{{ route('admin.settings.general') }}" class="general-settings-form">
        @csrf

        {{-- Site Kimliği --}}
        <section class="settings-section">
            <div class="settings-section-header">
                <h2 class="settings-section-title">Site Kimliği</h2>
                <p class="settings-section-desc">Ziyaretçilere görünen temel bilgiler</p>
            </div>
            <div class="settings-section-body">
                <div class="form-group">
                    <label for="site_name">Site Adı <span class="required">*</span></label>
                    <input type="text" name="site_name" id="site_name" required
                        value="{{ old('site_name', $site_name ?? '') }}"
                        placeholder="RADYOYOL"
                        class="form-input">
                    @error('site_name')<span class="form-error">{{ $message }}</span>@enderror
                </div>
                <div class="form-group">
                    <label for="site_slogan">Slogan</label>
                    <input type="text" name="site_slogan" id="site_slogan"
                        value="{{ old('site_slogan', $site_slogan ?? '') }}"
                        placeholder="Canlı Radyo"
                        class="form-input">
                    @error('site_slogan')<span class="form-error">{{ $message }}</span>@enderror
                </div>
            </div>
        </section>

        {{-- İletişim Bilgileri --}}
        <section class="settings-section">
            <div class="settings-section-header">
                <h2 class="settings-section-title">İletişim Bilgileri</h2>
                <p class="settings-section-desc">Footer ve iletişim sayfalarında kullanılır</p>
            </div>
            <div class="settings-section-body">
                <div class="form-row form-row-2">
                    <div class="form-group">
                        <label for="contact_email">E-posta</label>
                        <input type="email" name="contact_email" id="contact_email"
                            value="{{ old('contact_email', $contact_email ?? '') }}"
                            placeholder="info@radyoyol.com"
                            class="form-input">
                        @error('contact_email')<span class="form-error">{{ $message }}</span>@enderror
                    </div>
                    <div class="form-group">
                        <label for="contact_phone">Telefon</label>
                        <input type="text" name="contact_phone" id="contact_phone"
                            value="{{ old('contact_phone', $contact_phone ?? '') }}"
                            placeholder="+90 555 123 4567"
                            class="form-input">
                        @error('contact_phone')<span class="form-error">{{ $message }}</span>@enderror
                    </div>
                </div>
                <div class="form-group">
                    <label for="address_text">Adres</label>
                    <textarea name="address_text" id="address_text" rows="3"
                        placeholder="Fiziksel adres bilgisi"
                        class="form-input form-textarea">{{ old('address_text', $address_text ?? '') }}</textarea>
                    @error('address_text')<span class="form-error">{{ $message }}</span>@enderror
                </div>
            </div>
        </section>

        {{-- Sistem --}}
        <section class="settings-section settings-section--warning">
            <div class="settings-section-header">
                <h2 class="settings-section-title">Sistem</h2>
                <p class="settings-section-desc">Bakım modu etkinleştirildiğinde site ziyaretçilere kapatılır</p>
            </div>
            <div class="settings-section-body">
                <label class="settings-toggle">
                    <input type="checkbox" name="maintenance_mode" value="1"
                        {{ old('maintenance_mode', $maintenance_mode ?? false) ? 'checked' : '' }}
                        class="settings-toggle-input">
                    <span class="settings-toggle-slider"></span>
                    <span class="settings-toggle-label">Bakım modu</span>
                </label>
            </div>
        </section>

        <div class="form-actions">
            <button type="submit" class="btn-save">
                <span class="btn-save-icon">✓</span>
                Değişiklikleri Kaydet
            </button>
        </div>
    </form>
</div>

@push('styles')
<style>
.general-settings-page { max-width: 720px; }
.settings-page-header { margin-bottom: 1.75rem; }
.settings-page-title { font-size: 1.5rem; font-weight: 700; color: #f0f2f5; margin-bottom: 0.35rem; letter-spacing: -0.02em; }
.settings-page-desc { font-size: 0.95rem; color: #8b95a5; }
.settings-success { display: flex; align-items: center; gap: 0.75rem; padding: 1rem 1.25rem; background: rgba(34,197,94,0.15); border: 1px solid rgba(34,197,94,0.35); border-radius: 12px; color: #86efac; font-size: 0.9rem; margin-bottom: 1.5rem; }
.settings-success-icon { width: 24px; height: 24px; display: flex; align-items: center; justify-content: center; background: rgba(34,197,94,0.4); border-radius: 50%; font-size: 0.75rem; font-weight: 700; }
.settings-error { display: flex; align-items: center; gap: 0.75rem; padding: 1rem 1.25rem; background: rgba(239,68,68,0.15); border: 1px solid rgba(239,68,68,0.35); border-radius: 12px; color: #fca5a5; font-size: 0.9rem; margin-bottom: 1.5rem; }
.settings-error-icon { width: 24px; height: 24px; display: flex; align-items: center; justify-content: center; background: rgba(239,68,68,0.4); border-radius: 50%; font-size: 0.75rem; font-weight: 700; }
.settings-section { margin-bottom: 1.5rem; padding: 1.5rem; background: rgba(255,255,255,0.03); border: 1px solid rgba(255,255,255,0.08); border-radius: 14px; }
.settings-section--warning { border-color: rgba(234,179,8,0.2); background: rgba(234,179,8,0.04); }
.settings-section-header { margin-bottom: 1.25rem; }
.settings-section-title { font-size: 1.1rem; font-weight: 700; color: #e5e7eb; margin-bottom: 0.25rem; }
.settings-section-desc { font-size: 0.85rem; color: #8b95a5; }
.settings-section-body { display: flex; flex-direction: column; gap: 1.25rem; }
.form-row { display: grid; gap: 1.25rem; }
.form-row-2 { grid-template-columns: 1fr 1fr; }
@media (max-width: 600px) { .form-row-2 { grid-template-columns: 1fr; } }
.form-group { margin: 0; }
.form-group label { display: block; font-size: 0.9rem; font-weight: 600; color: #d1d5db; margin-bottom: 0.5rem; }
.form-group .required { color: var(--accent); }
.form-input { width: 100%; padding: 0.7rem 1rem; font-size: 0.95rem; background: rgba(255,255,255,0.06); border: 1px solid rgba(255,255,255,0.12); border-radius: 10px; color: #f0f2f5; transition: border-color 0.2s, box-shadow 0.2s; }
.form-input:focus { outline: none; border-color: var(--accent); box-shadow: 0 0 0 3px rgba(201,42,42,0.2); }
.form-input::placeholder { color: #6b7280; }
.form-textarea { resize: vertical; min-height: 88px; }
.form-error { font-size: 0.8rem; color: #f87171; margin-top: 0.4rem; display: block; }
.settings-toggle { display: flex; align-items: center; gap: 1rem; cursor: pointer; }
.settings-toggle-input { position: absolute; opacity: 0; width: 0; height: 0; }
.settings-toggle-slider { position: relative; width: 48px; height: 26px; background: rgba(255,255,255,0.1); border-radius: 13px; transition: background 0.2s; flex-shrink: 0; }
.settings-toggle-slider::before { content: ''; position: absolute; width: 20px; height: 20px; left: 3px; top: 3px; background: #9ca3af; border-radius: 50%; transition: transform 0.2s; }
.settings-toggle-input:checked + .settings-toggle-slider { background: rgba(234,179,8,0.4); }
.settings-toggle-input:checked + .settings-toggle-slider::before { transform: translateX(22px); background: #fbbf24; }
.settings-toggle-label { font-size: 0.95rem; font-weight: 600; color: #e5e7eb; }
.form-actions { margin-top: 1.75rem; padding-top: 1.5rem; border-top: 1px solid rgba(255,255,255,0.08); }
.btn-save { display: inline-flex; align-items: center; gap: 0.5rem; padding: 0.75rem 1.5rem; font-size: 0.95rem; font-weight: 600; background: linear-gradient(135deg, #dc2626, var(--accent)); color: #fff; border: none; border-radius: 10px; cursor: pointer; transition: opacity 0.2s, transform 0.1s; }
.btn-save:hover { opacity: 0.95; }
.btn-save:active { transform: scale(0.98); }
.btn-save-icon { font-size: 1rem; }
</style>
@endpush
@endsection
