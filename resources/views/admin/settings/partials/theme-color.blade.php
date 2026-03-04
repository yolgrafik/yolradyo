@php
    $key = $key ?? 'primary';
    $label = $label ?? $key;
    $theme = $theme ?? [];
    $value = old($key, $theme[$key] ?? '#000000');
    $colorValue = preg_match('/^#[0-9A-Fa-f]{6}$/', $value) ? $value : (str_starts_with($value, '#') ? $value : '#000000');
@endphp
<div class="form-group">
    <label for="theme_{{ $key }}">{{ $label }}</label>
    <div class="color-input-wrap">
        <input type="color" id="theme_{{ $key }}_picker" value="{{ $colorValue }}" data-sync-to="theme_{{ $key }}" aria-label="{{ $label }}">
        <input type="text" class="color-hex" name="{{ $key }}" id="theme_{{ $key }}"
            value="{{ $value }}" maxlength="50" placeholder="#hex veya rgba()">
    </div>
    @error($key)<span class="form-error">{{ $message }}</span>@enderror
</div>
