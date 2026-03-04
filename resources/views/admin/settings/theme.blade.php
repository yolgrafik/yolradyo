@extends('admin.layouts.app')

@php
    $theme = $theme ?? [];
@endphp

@section('content')
<div class="theme-settings-wrap">
    <div class="theme-settings-main">
        @if(session('success'))
            <div class="settings-success">{{ session('success') }}</div>
        @endif

        <form method="POST" action="{{ route('admin.settings.theme') }}" id="themeForm">
            @csrf

            {{-- A) Brand --}}
            <section class="theme-section">
                <h3 class="theme-section__title">Marka Renkleri</h3>
                <div class="theme-section__grid">
                    @include('admin.settings.partials.theme-color', ['key' => 'primary', 'label' => 'Primary (CTA / Ana buton)', 'theme' => $theme])
                    @include('admin.settings.partials.theme-color', ['key' => 'primary_hover', 'label' => 'Primary Hover'])
                    @include('admin.settings.partials.theme-color', ['key' => 'accent', 'label' => 'Accent (Vurgu)'])
                    @include('admin.settings.partials.theme-color', ['key' => 'glow', 'label' => 'Glow / Parlaklık'])
                </div>
            </section>

            {{-- B) Backgrounds --}}
            <section class="theme-section">
                <h3 class="theme-section__title">Arka Planlar</h3>
                <div class="theme-section__grid">
                    @include('admin.settings.partials.theme-color', ['key' => 'background', 'label' => 'Sayfa Arka Planı'])
                    @include('admin.settings.partials.theme-color', ['key' => 'surface', 'label' => 'Kart / Panel'])
                    @include('admin.settings.partials.theme-color', ['key' => 'surface_2', 'label' => 'Alternatif Yüzey'])
                </div>
            </section>

            {{-- C) Text --}}
            <section class="theme-section">
                <h3 class="theme-section__title">Metin Renkleri</h3>
                <div class="theme-section__grid">
                    @include('admin.settings.partials.theme-color', ['key' => 'text', 'label' => 'Ana Metin'])
                    @include('admin.settings.partials.theme-color', ['key' => 'text_muted', 'label' => 'Soluk Metin'])
                </div>
            </section>

            {{-- D) Header --}}
            <section class="theme-section">
                <h3 class="theme-section__title">Header</h3>
                <div class="theme-section__grid">
                    @include('admin.settings.partials.theme-color', ['key' => 'header_bg', 'label' => 'Header Arka Plan (boş: varsayılan)'])
                    @include('admin.settings.partials.theme-color', ['key' => 'header_text', 'label' => 'Menü Metni'])
                    @include('admin.settings.partials.theme-color', ['key' => 'header_active', 'label' => 'Aktif Menü Altı'])
                </div>
            </section>

            {{-- E) Footer --}}
            <section class="theme-section">
                <h3 class="theme-section__title">Footer</h3>
                <div class="theme-section__grid">
                    @include('admin.settings.partials.theme-color', ['key' => 'footer_bg', 'label' => 'Footer Arka Plan'])
                    @include('admin.settings.partials.theme-color', ['key' => 'footer_text', 'label' => 'Footer Metni'])
                    @include('admin.settings.partials.theme-color', ['key' => 'footer_link', 'label' => 'Footer Link'])
                    @include('admin.settings.partials.theme-color', ['key' => 'footer_link_hover', 'label' => 'Footer Link Hover'])
                </div>
            </section>

            {{-- F) Links --}}
            <section class="theme-section">
                <h3 class="theme-section__title">Genel Linkler</h3>
                <div class="theme-section__grid">
                    @include('admin.settings.partials.theme-color', ['key' => 'link', 'label' => 'Link Renk'])
                    @include('admin.settings.partials.theme-color', ['key' => 'link_hover', 'label' => 'Link Hover'])
                </div>
            </section>

            {{-- G) Forms --}}
            <section class="theme-section">
                <h3 class="theme-section__title">Form Alanları</h3>
                <div class="theme-section__grid">
                    @include('admin.settings.partials.theme-color', ['key' => 'input_bg', 'label' => 'Input Arka Plan'])
                    @include('admin.settings.partials.theme-color', ['key' => 'input_text', 'label' => 'Input Metin'])
                    @include('admin.settings.partials.theme-color', ['key' => 'focus_ring', 'label' => 'Focus Ring'])
                </div>
            </section>

            {{-- H) Border & Radius --}}
            <section class="theme-section">
                <h3 class="theme-section__title">Kenarlık & Köşe</h3>
                <div class="theme-section__grid">
                    @include('admin.settings.partials.theme-color', ['key' => 'border', 'label' => 'Kenarlık'])
                    <div class="form-group">
                        <label for="radius">Köşe Yuvarlaklığı (px)</label>
                        <input type="number" name="radius" id="radius" min="0" max="32" step="1"
                            value="{{ old('radius', $theme['radius'] ?? 14) }}">
                        @error('radius')<span class="form-error">{{ $message }}</span>@enderror
                    </div>
                </div>
            </section>

            {{-- Secondary buttons --}}
            <section class="theme-section">
                <h3 class="theme-section__title">İkincil Butonlar</h3>
                <div class="theme-section__grid">
                    @include('admin.settings.partials.theme-color', ['key' => 'secondary', 'label' => 'Secondary'])
                    @include('admin.settings.partials.theme-color', ['key' => 'secondary_hover', 'label' => 'Secondary Hover'])
                </div>
            </section>

            <div class="form-actions">
                <button type="submit" class="btn-save">Kaydet</button>
            </div>
        </form>
    </div>

    <div class="theme-preview-card">
        <h3 class="theme-preview__title">Önizleme</h3>
        <div class="theme-preview__demo" id="themePreview">
            <div class="preview-header">Header</div>
            <div class="preview-body">
                <p class="preview-text">Ana metin rengi</p>
                <p class="preview-muted">Soluk metin</p>
                <a href="#" class="preview-link">Link örneği</a>
                <div class="preview-buttons">
                    <button type="button" class="preview-btn-primary">Primary</button>
                    <button type="button" class="preview-btn-secondary">Secondary</button>
                </div>
                <div class="preview-card">Kart / Panel</div>
            </div>
            <div class="preview-footer">Footer</div>
        </div>
    </div>
</div>

@push('styles')
<style>
.theme-settings-wrap { display: flex; gap: 2rem; flex-wrap: wrap; max-width: 1200px; }
.theme-settings-main { flex: 1; min-width: 320px; }
.settings-success { padding: 0.75rem 1rem; background: rgba(34,197,94,0.2); border: 1px solid rgba(34,197,94,0.4); border-radius: 10px; color: #86efac; font-size: 0.9rem; margin-bottom: 1.25rem; }
.theme-section { margin-bottom: 2rem; padding: 1.25rem; background: rgba(255,255,255,0.03); border: 1px solid rgba(255,255,255,0.08); border-radius: 12px; }
.theme-section__title { font-size: 1rem; font-weight: 700; color: #e5e7eb; margin-bottom: 1rem; }
.theme-section__grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(200px, 1fr)); gap: 1rem; }
.form-group { margin-bottom: 0; }
.form-group label { display: block; font-size: 0.85rem; font-weight: 600; color: #d1d5db; margin-bottom: 0.4rem; }
.color-input-wrap { display: flex; align-items: center; gap: 0.5rem; }
.color-input-wrap input[type="color"] { width: 44px; height: 36px; padding: 2px; border: 1px solid rgba(255,255,255,0.2); border-radius: 8px; cursor: pointer; background: transparent; }
.color-input-wrap .color-hex { width: 90px; padding: 0.4rem 0.6rem; font-size: 0.85rem; background: rgba(255,255,255,0.06); border: 1px solid rgba(255,255,255,0.15); border-radius: 8px; color: #e5e7eb; font-family: monospace; }
.form-group input[type="number"] { width: 100%; padding: 0.5rem 0.75rem; background: rgba(255,255,255,0.06); border: 1px solid rgba(255,255,255,0.15); border-radius: 8px; color: #e5e7eb; font-size: 0.9rem; }
.form-error { font-size: 0.75rem; color: #f87171; margin-top: 0.25rem; display: block; }
.form-actions { margin-top: 1.5rem; }
.btn-save { padding: 0.65rem 1.25rem; font-size: 0.9rem; font-weight: 600; background: linear-gradient(135deg, #dc2626, #c92a2a); color: #fff; border: none; border-radius: 10px; cursor: pointer; }
.theme-preview-card { width: 280px; flex-shrink: 0; position: sticky; top: 1rem; }
.theme-preview__title { font-size: 1rem; font-weight: 700; color: #e5e7eb; margin-bottom: 0.75rem; }
.theme-preview__demo { background: #0b0f16; border: 1px solid rgba(255,255,255,0.1); border-radius: 12px; overflow: hidden; }
.preview-header { padding: 0.8rem 1rem; background: linear-gradient(180deg, rgba(11,15,26,0.92), rgba(17,24,39,0.9)); color: #fff; font-size: 0.85rem; font-weight: 600; }
.preview-body { padding: 1rem; }
.preview-text { color: #fff; font-size: 0.9rem; margin-bottom: 0.4rem; }
.preview-muted { color: #a9b1c3; font-size: 0.8rem; margin-bottom: 0.4rem; }
.preview-link { color: #60a5fa; font-size: 0.85rem; display: block; margin-bottom: 0.4rem; }
.preview-buttons { display: flex; gap: 0.5rem; margin-bottom: 0.75rem; }
.preview-btn-primary { padding: 0.4rem 0.8rem; background: #ff0033; color: #fff; border: none; border-radius: 8px; font-size: 0.8rem; cursor: pointer; }
.preview-btn-secondary { padding: 0.4rem 0.8rem; background: #374151; color: #fff; border: none; border-radius: 8px; font-size: 0.8rem; cursor: pointer; }
.preview-card { padding: 0.6rem 0.8rem; background: #111827; border: 1px solid rgba(255,255,255,0.1); border-radius: 8px; font-size: 0.8rem; color: #e5e7eb; }
.preview-footer { padding: 0.6rem 1rem; background: rgba(5,7,12,0.85); color: rgba(255,255,255,0.65); font-size: 0.75rem; }
</style>
@endpush
@push('scripts')
<script>
(function() {
    document.querySelectorAll('.color-input-wrap').forEach(function(wrap) {
        var colorInput = wrap.querySelector('input[type="color"]');
        var hexInput = wrap.querySelector('.color-hex');
        if (!colorInput || !hexInput) return;
        colorInput.addEventListener('input', function() {
            hexInput.value = colorInput.value;
        });
        hexInput.addEventListener('input', function() {
            var v = hexInput.value.trim();
            if (/^#[0-9A-Fa-f]{6}$/.test(v)) colorInput.value = v;
        });
    });
})();
</script>
@endpush
@endsection
