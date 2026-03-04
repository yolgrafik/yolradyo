@php
    $settings = $themeSettings ?? [];
    $vars = $settings['vars'] ?? [];
    $primary = $vars['primary'] ?? '#ff0033';
    $primaryHover = $vars['primary_hover'] ?? '#ff3355';
    $accent = $vars['accent'] ?? '#ff0033';
    $glow = $vars['glow'] ?? '#ff0033';
    $link = $vars['link'] ?? '#60a5fa';
    $linkHover = $vars['link_hover'] ?? '#93c5fd';
    $headerBg = $vars['header_bg'] ?? 'linear-gradient(180deg, rgba(11,15,26,0.92) 0%, rgba(17,24,39,0.9) 100%)';
    $footerBg = $vars['footer_bg'] ?? 'rgba(5,7,12,0.92)';
@endphp
<style id="theme-vars">
:root {
    --ry-primary: {{ $primary }};
    --ry-primary-hover: {{ $primaryHover }};
    --ry-accent: {{ $accent }};
    --ry-glow: {{ $glow }};
    --ry-link: {{ $link }};
    --ry-link-hover: {{ $linkHover }};
    --ry-header-bg: {{ $headerBg }};
    --ry-footer-bg: {{ $footerBg }};
    --ry-footer-text: {{ $link }};
    --ry-footer-link: {{ $link }};
    --ry-footer-link-hover: {{ $linkHover }};
    --ry-text: #ffffff;
    --ry-text-muted: #a9b1c3;
    --ry-surface: #111827;
    --ry-surface-2: #0f172a;
    --ry-border: rgba(255,255,255,.12);
    --ry-radius: 14px;
    --ry-bg: {{ $settings['bg_color'] ?? '#0b0f16' }};
    --ry-bg-mode: {{ $settings['bg_mode'] ?? 'color' }};
    --ry-bg-image: {{ !empty($settings['bg_image']) ? "url('" . asset('storage/' . $settings['bg_image']) . "')" : 'none' }};
    --ry-overlay-color: {{ $settings['overlay_color'] ?? '#000000' }};
    --ry-overlay-opacity: {{ ($settings['overlay_opacity'] ?? 55) / 100 }};
    --ry-bg-blur: {{ $settings['bg_blur'] ?? 0 }}px;
    --bg: var(--ry-bg);
    --panel: var(--ry-surface);
    --text: var(--ry-text);
    --muted: var(--ry-text-muted);
    --border: var(--ry-border);
    --accent: var(--ry-accent);
    --glow: var(--ry-glow);
    --primary: var(--ry-primary);
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
    z-index: 0;
}
body > nav, body > main, body > .bottom-bar-player, body > .legal-footer { position: relative; z-index: 1; }
@else
body { background: var(--ry-bg); }
@endif
</style>
