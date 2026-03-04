@php
    $settings = $themeSettings ?? [];
    $vars = $settings['vars'] ?? [];
    $headerBg = $vars['header_bg'] ?? 'rgba(70,9,10,0.97)';
    $footerBg = $vars['footer_bg'] ?? 'rgba(70,9,10,0.97)';
    $barBg = $vars['bar_bg'] ?? 'rgba(70,9,10,0.97)';
    $btnBg = $settings['button_color'] ?? '#c92a2a';
    $btnHover = $settings['button_hover_color'] ?? '#dc2626';
    $scheduleBg = $settings['schedule_color'] ?? '#1e2430';
    $scheduleActive = $settings['schedule_active_color'] ?? '#c92a2a';
@endphp
{{-- STRICT COLOR SYSTEM: Theme=header/footer/player/istekler. Text=#fff. Buttons=config. --}}
<style id="theme-vars">
:root {
    --ry-header-bg: {{ $headerBg }};
    --ry-footer-bg: {{ $footerBg }};
    --ry-bar-bg: {{ $barBg }};
    --ry-istekler-bg: {{ $barBg }};

    /* Button colors - theme independent, from admin */
    --ry-btn-bg: {{ $btnBg }};
    --ry-btn-hover: {{ $btnHover }};

    /* Schedule colors - theme independent, from admin */
    --ry-schedule-bg: {{ $scheduleBg }};
    --ry-schedule-active: {{ $scheduleActive }};

    /* Fixed - never change */
    --ry-text: #ffffff;
    --ry-text-muted: rgba(255,255,255,.78);
    --ry-bg: {{ $settings['bg_color'] ?? '#0b0f16' }};
    --ry-surface: #111827;
    --ry-surface-2: #0f172a;
    --ry-border: rgba(255,255,255,.12);
    --ry-radius: 14px;
    --ry-overlay-color: {{ $settings['overlay_color'] ?? '#000000' }};
    --ry-overlay-opacity: {{ ($settings['overlay_opacity'] ?? 55) / 100 }};
    --bg: var(--ry-bg);
    --panel: var(--ry-surface);
    --text: var(--ry-text);
    --muted: var(--ry-text-muted);
    --border: var(--ry-border);
}
@if(($settings['bg_mode'] ?? 'color') === 'image' && !empty($settings['bg_image']))
body {
    background: var(--ry-bg) center center / cover no-repeat fixed;
    background-image: url('{{ asset('storage/' . $settings['bg_image']) }}');
    position: relative;
}
body::before {
    content: '';
    position: fixed;
    inset: 0;
    background: var(--ry-overlay-color);
    opacity: var(--ry-overlay-opacity);
    pointer-events: none;
    z-index: 1;
}
body > nav.navbar { z-index: 2000 !important; position: fixed !important; top: 0 !important; left: 0 !important; right: 0 !important; background: var(--ry-header-bg) !important; }
body > .bottom-bar-player { z-index: 1999 !important; background: var(--ry-bar-bg) !important; }
body > .legal-footer { z-index: 1998 !important; background: var(--ry-footer-bg) !important; }
body > main { position: relative; z-index: 2; }
@else
body { background: var(--ry-bg); }
@endif
</style>
