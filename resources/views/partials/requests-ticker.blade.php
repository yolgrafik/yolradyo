@php
    $siteSettings = $siteSettings ?? [];
    $logoUrl = !empty($siteSettings['brand_logo_path'])
        ? asset('storage/' . $siteSettings['brand_logo_path'])
        : asset('logo.png');
@endphp
<div class="ticker-wrap">
    <span class="ticker-btn"><span class="ticker-btn__icon">🎵</span> İstekler</span>
    <div class="ticker" id="requestsTicker">
        <div class="ticker__mask">
            <div class="ticker__track" id="tickerTrack">
                {{-- Content injected by JS --}}
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
.ticker-wrap { margin-top: -1.25rem; display: flex; flex-direction: column; gap: 0.5rem; }
.ticker-btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    padding: 8px 18px;
    background: linear-gradient(90deg, #ff4d4d, #ff7a18);
    color: #fff;
    font-weight: 600;
    font-size: 0.95rem;
    border-radius: 20px;
    border: none;
    cursor: default;
    box-shadow: 0 0 16px rgba(255, 77, 77, 0.35), 0 4px 12px rgba(0, 0, 0, 0.2);
    transition: transform 0.2s ease, box-shadow 0.2s ease;
    align-self: flex-start;
}
.ticker-btn:hover {
    transform: scale(1.05);
    box-shadow: 0 0 24px rgba(255, 77, 77, 0.5), 0 0 32px rgba(255, 122, 24, 0.3), 0 4px 16px rgba(0, 0, 0, 0.25);
}
.ticker-btn__icon { font-size: 1.1em; line-height: 1; }
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
    left: 0;
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
    .ticker-btn { padding: 6px 14px; font-size: 0.9rem; }
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
