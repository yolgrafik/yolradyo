@extends('admin.layouts.app')

@section('content')
<div class="card" style="max-width: 700px;">
    <div class="card-header">Tema & Renk Ayarlari</div>
    <div class="card-body">
        @if(session('success'))
            <div class="settings-success">{{ session('success') }}</div>
        @endif

        <form method="POST" action="{{ route('admin.settings.theme') }}">
            @csrf

            <div class="form-group">
                <label for="theme_primary">Primary (Arka plan)</label>
                <div class="color-input-wrap">
                    <input type="color" name="theme_primary" id="theme_primary"
                        value="{{ old('theme_primary', $theme_primary ?? '#0f1319') }}">
                    <input type="text" class="color-hex" value="{{ old('theme_primary', $theme_primary ?? '#0f1319') }}" maxlength="7">
                </div>
                @error('theme_primary')<span class="form-error">{{ $message }}</span>@enderror
            </div>

            <div class="form-group">
                <label for="theme_accent">Accent (Vurgu)</label>
                <div class="color-input-wrap">
                    <input type="color" name="theme_accent" id="theme_accent"
                        value="{{ old('theme_accent', $theme_accent ?? '#c92a2a') }}">
                    <input type="text" class="color-hex" value="{{ old('theme_accent', $theme_accent ?? '#c92a2a') }}" maxlength="7">
                </div>
                @error('theme_accent')<span class="form-error">{{ $message }}</span>@enderror
            </div>

            <div class="form-group">
                <label for="theme_bg">Arka Plan</label>
                <div class="color-input-wrap">
                    <input type="color" name="theme_bg" id="theme_bg"
                        value="{{ old('theme_bg', $theme_bg ?? '#0f1319') }}">
                    <input type="text" class="color-hex" value="{{ old('theme_bg', $theme_bg ?? '#0f1319') }}" maxlength="7">
                </div>
                @error('theme_bg')<span class="form-error">{{ $message }}</span>@enderror
            </div>

            <div class="form-group">
                <label for="theme_text">Metin Rengi</label>
                <div class="color-input-wrap">
                    <input type="color" name="theme_text" id="theme_text"
                        value="{{ old('theme_text', $theme_text ?? '#f0f2f5') }}">
                    <input type="text" class="color-hex" value="{{ old('theme_text', $theme_text ?? '#f0f2f5') }}" maxlength="7">
                </div>
                @error('theme_text')<span class="form-error">{{ $message }}</span>@enderror
            </div>

            <div class="form-group">
                <label for="theme_glow">Glow / Parlaklik</label>
                <div class="color-input-wrap">
                    <input type="color" name="theme_glow" id="theme_glow"
                        value="{{ old('theme_glow', $theme_glow ?? '#c92a2a') }}">
                    <input type="text" class="color-hex" value="{{ old('theme_glow', $theme_glow ?? '#c92a2a') }}" maxlength="7">
                </div>
                @error('theme_glow')<span class="form-error">{{ $message }}</span>@enderror
            </div>

            <div class="form-actions">
                <button type="submit" class="btn-save">Kaydet</button>
            </div>
        </form>
    </div>
</div>

@push('styles')
<style>
.settings-success { padding: 0.75rem 1rem; background: rgba(34,197,94,0.2); border: 1px solid rgba(34,197,94,0.4); border-radius: 10px; color: #86efac; font-size: 0.9rem; margin-bottom: 1.25rem; }
.form-group { margin-bottom: 1.25rem; }
.form-group label { display: block; font-size: 0.9rem; font-weight: 600; color: var(--text); margin-bottom: 0.5rem; }
.color-input-wrap { display: flex; align-items: center; gap: 0.75rem; }
.color-input-wrap input[type="color"] { width: 48px; height: 40px; padding: 2px; border: 1px solid var(--border); border-radius: 8px; cursor: pointer; background: transparent; }
.color-input-wrap .color-hex { width: 100px; padding: 0.5rem 0.75rem; font-size: 0.9rem; background: rgba(255,255,255,0.06); border: 1px solid var(--border); border-radius: 8px; color: var(--text); font-family: monospace; }
.form-error { font-size: 0.8rem; color: #f87171; margin-top: 0.35rem; display: block; }
.form-actions { margin-top: 1.5rem; }
.btn-save { padding: 0.65rem 1.25rem; font-size: 0.9rem; font-weight: 600; background: linear-gradient(135deg, #dc2626, var(--accent)); color: #fff; border: none; border-radius: 10px; cursor: pointer; }
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
            var v = hexInput.value;
            if (/^#[0-9A-Fa-f]{6}$/.test(v)) colorInput.value = v;
        });
    });
})();
</script>
@endpush
@endsection
