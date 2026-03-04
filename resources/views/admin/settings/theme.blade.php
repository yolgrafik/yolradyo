@extends('admin.layouts.app')

@php
    $presets = $presets ?? [];
    $settings = $settings ?? [];
    $themeId = (int) ($settings['theme_id'] ?? 1);
@endphp

@section('content')
<div class="theme-page">
    @if(session('success'))
        <div class="settings-success">{{ session('success') }}</div>
    @endif

    <form method="POST" action="{{ route('admin.settings.theme') }}" enctype="multipart/form-data">
        @csrf

        {{-- Theme Presets --}}
        <section class="theme-section">
            <h2 class="theme-section__title">Tema Presetleri</h2>
            <p class="theme-section__desc">20 hazır temadan birini seçin.</p>
            <div class="theme-presets-grid">
                @foreach($presets as $id => $preset)
                <label class="theme-preset-card {{ $themeId === (int)$id ? 'is-selected' : '' }}">
                    <input type="radio" name="theme_id" value="{{ $id }}" {{ $themeId === (int)$id ? 'checked' : '' }} class="theme-preset-radio">
                    <div class="theme-preset-preview" style="--preview-primary: {{ $preset['primary'] ?? '#ff0033' }}; --preview-accent: {{ $preset['accent'] ?? '#ff0033' }};">
                        <div class="preview-header-strip"></div>
                        <div class="preview-btn"></div>
                        <div class="preview-link"></div>
                    </div>
                    <span class="theme-preset-name">Tema {{ $id }}</span>
                    <span class="theme-preset-label">{{ $preset['name'] ?? '' }}</span>
                </label>
                @endforeach
            </div>
        </section>

        {{-- Background Settings --}}
        <section class="theme-section">
            <h2 class="theme-section__title">Arka Plan Ayarları</h2>

            <div class="bg-mode-options">
                <label class="bg-mode-option">
                    <input type="radio" name="bg_mode" value="color" {{ ($settings['bg_mode'] ?? 'color') === 'color' ? 'checked' : '' }}>
                    <span>Düz Renk</span>
                </label>
                <label class="bg-mode-option">
                    <input type="radio" name="bg_mode" value="image" {{ ($settings['bg_mode'] ?? '') === 'image' ? 'checked' : '' }}>
                    <span>Arka Plan Görseli</span>
                </label>
            </div>

            <div class="bg-color-wrap" id="bgColorWrap">
                <div class="form-group">
                    <label for="bg_color">Arka Plan Rengi</label>
                    <div class="color-input-wrap">
                        <input type="color" id="bg_color_picker" value="{{ $settings['bg_color'] ?? '#0b0f16' }}">
                        <input type="text" name="bg_color" id="bg_color" value="{{ old('bg_color', $settings['bg_color'] ?? '#0b0f16') }}" maxlength="16">
                    </div>
                </div>
            </div>

            <div class="bg-image-wrap" id="bgImageWrap" style="display:none;">
                <div class="form-group">
                    <label for="bg_image">Görsel Yükle</label>
                    <input type="file" name="bg_image" id="bg_image" accept="image/*">
                    @if(!empty($settings['bg_image']))
                    <p class="current-image">Mevcut: {{ basename($settings['bg_image']) }}</p>
                    @endif
                </div>
                <div class="form-group">
                    <button type="button" class="btn-remove-bg" id="removeBgImage">Arka plan görselini kaldır</button>
                    <input type="hidden" name="remove_bg_image" id="removeBgImageFlag" value="0">
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label for="overlay_opacity">Overlay Opaklık (0-80%)</label>
                        <input type="number" name="overlay_opacity" id="overlay_opacity" min="0" max="80" value="{{ old('overlay_opacity', $settings['overlay_opacity'] ?? 55) }}">
                    </div>
                    <div class="form-group">
                        <label for="overlay_color">Overlay Rengi</label>
                        <div class="color-input-wrap">
                            <input type="color" id="overlay_color_picker" value="{{ $settings['overlay_color'] ?? '#000000' }}">
                            <input type="text" name="overlay_color" id="overlay_color" value="{{ old('overlay_color', $settings['overlay_color'] ?? '#000000') }}" maxlength="16">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="bg_blur">Blur (0-12px)</label>
                        <input type="number" name="bg_blur" id="bg_blur" min="0" max="12" value="{{ old('bg_blur', $settings['bg_blur'] ?? 0) }}">
                    </div>
                </div>
            </div>
        </section>

        <div class="form-actions">
            <button type="submit" class="btn-save">Kaydet</button>
        </div>
    </form>
</div>

@push('styles')
<style>
.theme-page { max-width: 900px; }
.settings-success { padding: 0.75rem 1rem; background: rgba(34,197,94,0.2); border: 1px solid rgba(34,197,94,0.4); border-radius: 10px; color: #86efac; margin-bottom: 1.5rem; }
.theme-section { margin-bottom: 2rem; padding: 1.5rem; background: rgba(255,255,255,0.03); border: 1px solid rgba(255,255,255,0.08); border-radius: 12px; }
.theme-section__title { font-size: 1.25rem; font-weight: 700; color: #e5e7eb; margin-bottom: 0.25rem; }
.theme-section__desc { font-size: 0.9rem; color: #9ca3af; margin-bottom: 1rem; }
.theme-presets-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(140px, 1fr)); gap: 1rem; }
.theme-preset-card { display: flex; flex-direction: column; align-items: center; padding: 1rem; background: rgba(255,255,255,0.04); border: 2px solid rgba(255,255,255,0.1); border-radius: 12px; cursor: pointer; transition: all 0.2s; }
.theme-preset-card:hover { border-color: rgba(255,255,255,0.2); background: rgba(255,255,255,0.06); }
.theme-preset-card.is-selected { border-color: #3b82f6; background: rgba(59,130,246,0.15); box-shadow: 0 0 0 1px #3b82f6; }
.theme-preset-radio { position: absolute; opacity: 0; }
.theme-preset-preview { width: 100%; height: 72px; border-radius: 8px; overflow: hidden; margin-bottom: 0.5rem; display: flex; flex-direction: column; }
.preview-header-strip { height: 20px; background: var(--preview-primary); }
.preview-btn { width: 60%; height: 18px; margin: 6px auto 4px; background: var(--preview-primary); border-radius: 6px; }
.preview-link { width: 50%; height: 4px; margin: 0 auto; background: var(--preview-accent); border-radius: 2px; opacity: 0.8; }
.theme-preset-name { font-size: 0.75rem; font-weight: 700; color: #9ca3af; }
.theme-preset-label { font-size: 0.8rem; color: #d1d5db; }
.bg-mode-options { display: flex; gap: 1rem; margin-bottom: 1rem; }
.bg-mode-option { display: flex; align-items: center; gap: 0.5rem; cursor: pointer; color: #e5e7eb; }
.bg-mode-option input { cursor: pointer; }
.form-group { margin-bottom: 1rem; }
.form-group label { display: block; font-size: 0.9rem; font-weight: 600; color: #d1d5db; margin-bottom: 0.4rem; }
.color-input-wrap { display: flex; gap: 0.5rem; align-items: center; }
.color-input-wrap input[type="color"] { width: 44px; height: 36px; padding: 2px; border-radius: 8px; cursor: pointer; border: 1px solid rgba(255,255,255,0.2); }
.color-input-wrap input[type="text"] { width: 100px; padding: 0.5rem; background: rgba(255,255,255,0.06); border: 1px solid rgba(255,255,255,0.15); border-radius: 8px; color: #e5e7eb; font-family: monospace; }
.form-group input[type="number"] { width: 80px; padding: 0.5rem; background: rgba(255,255,255,0.06); border: 1px solid rgba(255,255,255,0.15); border-radius: 8px; color: #e5e7eb; }
.form-group input[type="file"] { width: 100%; padding: 0.5rem; background: rgba(255,255,255,0.06); border: 1px solid rgba(255,255,255,0.15); border-radius: 8px; color: #e5e7eb; }
.form-row { display: flex; flex-wrap: wrap; gap: 1rem; }
.btn-remove-bg { padding: 0.5rem 1rem; background: rgba(239,68,68,0.2); border: 1px solid rgba(239,68,68,0.4); border-radius: 8px; color: #fca5a5; cursor: pointer; font-size: 0.9rem; }
.btn-remove-bg:hover { background: rgba(239,68,68,0.3); }
.current-image { font-size: 0.85rem; color: #9ca3af; margin-top: 0.25rem; }
.form-actions { margin-top: 1.5rem; }
.btn-save { padding: 0.65rem 1.25rem; font-size: 0.9rem; font-weight: 600; background: linear-gradient(135deg, #dc2626, #c92a2a); color: #fff; border: none; border-radius: 10px; cursor: pointer; }
</style>
@endpush
@push('scripts')
<script>
(function() {
    var bgModeColor = document.querySelector('input[name="bg_mode"][value="color"]');
    var bgModeImage = document.querySelector('input[name="bg_mode"][value="image"]');
    var bgColorWrap = document.getElementById('bgColorWrap');
    var bgImageWrap = document.getElementById('bgImageWrap');

    function toggleBgSections() {
        var isImage = bgModeImage && bgModeImage.checked;
        if (bgColorWrap) bgColorWrap.style.display = isImage ? 'none' : 'block';
        if (bgImageWrap) bgImageWrap.style.display = isImage ? 'block' : 'none';
    }
    [bgModeColor, bgModeImage].forEach(function(r) {
        if (r) r.addEventListener('change', toggleBgSections);
    });
    toggleBgSections();

    document.querySelectorAll('.color-input-wrap').forEach(function(wrap) {
        var picker = wrap.querySelector('input[type="color"]');
        var text = wrap.querySelector('input[type="text"]');
        if (!picker || !text) return;
        picker.addEventListener('input', function() { text.value = picker.value; });
        text.addEventListener('input', function() {
            if (/^#[0-9A-Fa-f]{6}$/.test(text.value.trim())) picker.value = text.value;
        });
    });

    var removeBtn = document.getElementById('removeBgImage');
    var removeFlag = document.getElementById('removeBgImageFlag');
    if (removeBtn && removeFlag) {
        removeBtn.addEventListener('click', function() {
            removeFlag.value = '1';
            var fileInput = document.getElementById('bg_image');
            if (fileInput) fileInput.value = '';
        });
    }

    document.querySelectorAll('.theme-preset-card').forEach(function(card) {
        card.addEventListener('click', function() {
            document.querySelectorAll('.theme-preset-card').forEach(function(c) { c.classList.remove('is-selected'); });
            card.classList.add('is-selected');
            var radio = card.querySelector('.theme-preset-radio');
            if (radio) radio.checked = true;
        });
    });
})();
</script>
@endpush
@endsection
