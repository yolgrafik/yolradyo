@php
    $theme = $themeSettings ?? get_theme_settings();
    $radius = (int) ($theme['radius'] ?? 14);
@endphp
<style id="theme-vars">
:root {
    --ry-primary: {{ $theme['primary'] ?? '#ff0033' }};
    --ry-primary-hover: {{ $theme['primary_hover'] ?? '#ff3355' }};
    --ry-secondary: {{ $theme['secondary'] ?? '#374151' }};
    --ry-secondary-hover: {{ $theme['secondary_hover'] ?? '#4b5563' }};
    --ry-accent: {{ $theme['accent'] ?? '#c92a2a' }};
    --ry-glow: {{ $theme['glow'] ?? '#c92a2a' }};
    --ry-bg: {{ $theme['background'] ?? '#0b0f16' }};
    --ry-surface: {{ $theme['surface'] ?? '#111827' }};
    --ry-surface-2: {{ $theme['surface_2'] ?? '#0f172a' }};
    --ry-border: {{ $theme['border'] ?? 'rgba(255,255,255,0.12)' }};
    --ry-text: {{ $theme['text'] ?? '#ffffff' }};
    --ry-text-muted: {{ $theme['text_muted'] ?? '#a9b1c3' }};
    --ry-link: {{ $theme['link'] ?? '#60a5fa' }};
    --ry-link-hover: {{ $theme['link_hover'] ?? '#93c5fd' }};
    --ry-header-bg: {{ $theme['header_bg'] ?? 'linear-gradient(180deg, rgba(11,15,26,0.92) 0%, rgba(17,24,39,0.9) 100%)' }};
    --ry-header-text: {{ $theme['header_text'] ?? '#ffffff' }};
    --ry-header-active: {{ $theme['header_active'] ?? '#c92a2a' }};
    --ry-footer-bg: {{ $theme['footer_bg'] ?? 'rgba(5,7,12,0.85)' }};
    --ry-footer-text: {{ $theme['footer_text'] ?? '#a9b1c3' }};
    --ry-footer-link: {{ $theme['footer_link'] ?? '#a9b1c3' }};
    --ry-footer-link-hover: {{ $theme['footer_link_hover'] ?? '#ffffff' }};
    --ry-input-bg: {{ $theme['input_bg'] ?? 'rgba(255,255,255,0.06)' }};
    --ry-input-text: {{ $theme['input_text'] ?? '#f0f2f5' }};
    --ry-focus: {{ $theme['focus_ring'] ?? '#c92a2a' }};
    --ry-radius: {{ $radius }}px;
    /* Aliases for backward compatibility */
    --bg: var(--ry-bg);
    --panel: var(--ry-surface);
    --text: var(--ry-text);
    --muted: var(--ry-text-muted);
    --border: var(--ry-border);
    --accent: var(--ry-accent);
    --glow: var(--ry-glow);
    --primary: var(--ry-primary);
}
</style>
