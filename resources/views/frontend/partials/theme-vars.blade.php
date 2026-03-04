@php
    $settings = $themeSettings ?? [];
    $vars = $settings['vars'] ?? [];
    $primary = $vars['primary'] ?? '#ff0033';
    $primaryHover = $vars['primary_hover'] ?? '#ff3355';
    $accent = $vars['accent'] ?? '#ff0033';
    $glow = $vars['glow'] ?? '#ff0033';
    $headerBg = $vars['header_bg'] ?? 'linear-gradient(180deg, rgba(11,15,26,0.95) 0%, rgba(17,24,39,0.93) 100%)';
    $footerBg = $vars['footer_bg'] ?? 'rgba(5,7,12,0.95)';
@endphp
<style id="theme-vars">
:root {
    --ry-primary: {{ $primary }};
    --ry-primary-hover: {{ $primaryHover }};
    --ry-accent: {{ $accent }};
    --ry-glow: {{ $glow }};
    --ry-header-bg: {{ $headerBg }};
    --ry-footer-bg: {{ $footerBg }};
    --ry-text: #ffffff;
    --ry-text-muted: rgba(255,255,255,.78);
    --ry-bg: {{ $settings['bg_color'] ?? '#0b0f16' }};
    --ry-surface: #111827;
    --ry-surface-2: #0f172a;
    --ry-border: rgba(255,255,255,.12);
    --ry-radius: 14px;
    --ry-btn-text: #ffffff;
    --ry-btn-border: var(--ry-accent);
    --ry-focus: var(--ry-accent);
    --ry-footer-text: var(--ry-text);
    --ry-footer-link: var(--ry-text);
    --ry-footer-link-hover: var(--ry-primary-hover);
    --ry-overlay-color: {{ $settings['overlay_color'] ?? '#000000' }};
    --ry-overlay-opacity: {{ ($settings['overlay_opacity'] ?? 55) / 100 }};
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
    z-index: 1;
}
body > nav.navbar { z-index: 2000 !important; position: sticky !important; top: 0 !important; background: var(--ry-header-bg) !important; }
body > .bottom-bar-player { z-index: 1999 !important; background: var(--ry-surface) !important; }
body > .legal-footer { z-index: 1998 !important; background: var(--ry-footer-bg) !important; }
body > main { position: relative; z-index: 2; }
@else
body { background: var(--ry-bg); }
@endif
.ry-btn { display: inline-flex; align-items: center; justify-content: center; padding: 0.75rem 1.25rem; font-weight: 700; font-size: 0.9rem; border-radius: var(--ry-radius); cursor: pointer; text-decoration: none; transition: all 0.25s ease; border: 1px solid; font-family: inherit; }
.ry-btn-primary { background: var(--ry-primary); border-color: var(--ry-btn-border); color: var(--ry-btn-text); }
.ry-btn-primary:hover { background: var(--ry-primary-hover); box-shadow: 0 0 18px color-mix(in srgb, var(--ry-glow) 55%, transparent); }
</style>
