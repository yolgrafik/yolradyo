@php
    $siteSettings = $siteSettings ?? [];
    $logoUrl = !empty($siteSettings['brand_logo_path'])
        ? asset('storage/' . $siteSettings['brand_logo_path'])
        : asset('logo.png');
@endphp
<div class="ticker-wrap">
    <div class="ticker" id="requestsTicker">
        <span class="ticker__label">İstekler</span>
        <div class="ticker__mask">
            <div class="ticker__track" id="tickerTrack">
                {{-- Content injected by JS --}}
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
.ticker-wrap { margin-top: -1.25rem; }
.ticker {
    height: 48px;
    border-radius: 12px;
    overflow: hidden;
    background: rgba(20, 25, 35, 0.6);
    backdrop-filter: blur(10px);
    -webkit-backdrop-filter: blur(10px);
    border: 1px solid rgba(255, 255, 255, 0.08);
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2), inset 0 1px 0 rgba(255, 255, 255, 0.06);
    position: relative;
    display: flex;
    align-items: center;
}
.ticker__label {
    flex-shrink: 0;
    height: 100%;
    display: inline-flex;
    align-items: center;
    padding: 0 1rem;
    margin-right: 0.5rem;
    font-size: 0.9rem;
    font-weight: 700;
    color: #fff;
    background: linear-gradient(135deg, rgba(201, 42, 42, 0.9), var(--accent));
    border-right: 1px solid rgba(255, 255, 255, 0.12);
    box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.15);
    letter-spacing: 0.03em;
    position: relative;
    z-index: 3;
    cursor: default;
    transition: filter 0.2s ease, box-shadow 0.2s ease;
}
.ticker__label:hover {
    filter: brightness(1.1);
    box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.2), 0 0 12px rgba(201, 42, 42, 0.3);
}
.ticker::before, .ticker::after {
    content: '';
    position: absolute;
    top: 0;
    bottom: 0;
    width: 48px;
    z-index: 2;
    pointer-events: none;
}
.ticker::before {
    left: 92px;
    background: linear-gradient(90deg, rgba(22, 28, 36, 0.95) 0%, transparent 100%);
}
.ticker::after {
    right: 0;
    background: linear-gradient(270deg, rgba(22, 28, 36, 0.95) 0%, transparent 100%);
}
.ticker__mask { overflow: hidden; height: 100%; flex: 1; min-width: 0; }
.ticker__track {
    display: flex;
    align-items: center;
    flex-wrap: nowrap;
    height: 100%;
    white-space: nowrap;
    animation: tickerMove 25s linear infinite;
}
.ticker:hover .ticker__track { animation-play-state: paused; }
@keyframes tickerMove {
    from { transform: translateX(100%); }
    to { transform: translateX(-100%); }
}
.ticker__item {
    display: inline-flex;
    align-items: center;
    flex-shrink: 0;
    padding: 0 0.75rem;
    font-size: 0.9rem;
    color: var(--text);
    opacity: 0.95;
}
.ticker__logo {
    height: 22px;
    width: auto;
    object-fit: contain;
    opacity: 0.85;
    flex-shrink: 0;
    margin: 0 0.5rem;
}
.ticker__empty {
    padding: 0 1rem;
    color: var(--muted);
    font-size: 0.9rem;
}
@media (max-width: 768px) {
    .ticker { height: 44px; }
    .ticker__label { padding: 0 0.75rem; font-size: 0.85rem; }
    .ticker::before { left: 78px; }
    .ticker__item { font-size: 0.85rem; padding: 0 0.5rem; }
    .ticker__logo { height: 18px; margin: 0 0.35rem; }
}
</style>
@endpush

@push('scripts')
<script>
(function() {
    var apiUrl = '{{ url("/api/requests/approved") }}';
    var logoUrl = '{{ $logoUrl }}';
    var track = document.getElementById('tickerTrack');
    if (!track) return;

    var fallback = [
        { artist: 'Ahmet Kaya', song: 'Ben Beni', name: 'Ali Çelik' },
        { artist: 'İbrahim Tatlıses', song: 'Mavi Mavi', name: 'Ayşe Yılmaz' },
        { artist: 'Mahsun Kırmızıgül', song: 'Sevda', name: 'Mehmet Demir' },
    ];

    function formatItem(r) {
        return (r.artist || '') + ' - ' + (r.song || '') + ' | ' + (r.name || '');
    }

    function renderItems(items) {
        if (!items || items.length === 0) {
            track.innerHTML = '<span class="ticker__empty">Henüz onaylı istek yok.</span>';
            track.style.animation = 'none';
            return;
        }
        var html = '';
        var logo = '<img class="ticker__logo" src="' + logoUrl + '" alt="RADYOYOL" onerror="this.style.display=\'none\'">';
        items.forEach(function(r) {
            html += '<span class="ticker__item">' + escapeHtml(formatItem(r)) + '</span>' + logo;
        });
        track.innerHTML = html + html;
        track.style.animation = '';
    }

    function escapeHtml(s) {
        var d = document.createElement('div');
        d.textContent = s;
        return d.innerHTML;
    }

    fetch(apiUrl)
        .then(function(r) { return r.json(); })
        .then(function(data) {
            renderItems(Array.isArray(data) && data.length > 0 ? data : fallback);
        })
        .catch(function() {
            renderItems(fallback);
        });
})();
</script>
@endpush
