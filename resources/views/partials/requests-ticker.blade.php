@php
    $logoUrl = brand_logo_url();
@endphp
<div class="ticker-wrap">
    <div class="ticker" id="requestsTicker">
        <div class="ticker__label">
            <span class="ticker__icon">🎵</span>
            <span class="ticker__labelText">İstekler</span>
            <span class="ticker__slash">/</span>
        </div>
        <div class="ticker__viewport">
            <div class="ticker__track" id="tickerTrack">
                {{-- Content injected by JS --}}
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
.ticker-wrap { margin-top: calc(-1.25rem + 2%); min-width: 0; }
.ticker {
    height: 48px;
    border-radius: 12px;
    overflow: hidden;
    background: var(--ry-bar-bg);
    backdrop-filter: blur(10px);
    -webkit-backdrop-filter: blur(10px);
    border: 1px solid rgba(255, 255, 255, 0.08);
    border-top: 1px solid var(--ry-line-color);
    border-bottom: 1px solid var(--ry-line-color);
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2);
    position: relative;
    display: flex;
    align-items: center;
}
.ticker__label {
    flex: 0 0 auto;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 0 1rem;
    font-size: 0.9rem;
    font-weight: 600;
    color: var(--text);
}
.ticker__icon { font-size: 1.1em; line-height: 1; }
.ticker__slash { opacity: 0.7; margin-left: 6px; }
.ticker__viewport {
    overflow: hidden;
    flex: 1;
    min-width: 0;
    position: relative;
}
.ticker__viewport::before {
    content: '';
    position: absolute;
    left: 0;
    top: 0;
    bottom: 0;
    width: 32px;
    z-index: 2;
    pointer-events: none;
    background: linear-gradient(90deg, rgba(0, 0, 0, 0.5) 0%, transparent 100%);
}
.ticker::after {
    content: '';
    position: absolute;
    right: 0;
    top: 0;
    bottom: 0;
    width: 48px;
    z-index: 2;
    pointer-events: none;
    background: linear-gradient(270deg, rgba(0, 0, 0, 0.5) 0%, transparent 100%);
}
.ticker__track {
    display: inline-flex;
    align-items: center;
    flex-wrap: nowrap;
    height: 100%;
    white-space: nowrap;
    width: max-content;
    will-change: transform;
    transform: translate3d(0, 0, 0);
    animation: tickerMove var(--ticker-duration, 30s) linear infinite;
}
.ticker:hover .ticker__track { animation-play-state: paused; }
@keyframes tickerMove {
    from { transform: translate3d(0, 0, 0); }
    to { transform: translate3d(calc(-1 * var(--ticker-shift, 0px)), 0, 0); }
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
.ticker__group {
    display: inline-flex;
    align-items: center;
    flex-wrap: nowrap;
    flex-shrink: 0;
}
.ticker__empty {
    padding: 0 1rem;
    color: var(--muted);
    font-size: 0.9rem;
}
@media (max-width: 768px) {
    .ticker { height: 44px; }
    .ticker__label { padding: 0 0.75rem; font-size: 0.85rem; }
    .ticker__item { font-size: 0.85rem; padding: 0 0.5rem; }
    .ticker__logo { height: 18px; margin: 0 0.35rem; }
}
@media (prefers-reduced-motion: reduce) {
    .ticker__track {
        animation: none !important;
        transform: none !important;
    }
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
    var viewport = track.parentElement;
    var latestBaseHtml = '';

    var fallback = [
        { artist: 'Ahmet Kaya', song: 'Ben Beni', name: 'Ali Çelik' },
        { artist: 'İbrahim Tatlıses', song: 'Mavi Mavi', name: 'Ayşe Yılmaz' },
        { artist: 'Mahsun Kırmızıgül', song: 'Sevda', name: 'Mehmet Demir' },
    ];

    function getRequester(r) {
        return r.requester || r.requester_name || r.name || r.full_name || '';
    }

    function getArtist(r) {
        return r.artist || r.artist_name || '';
    }

    function getSong(r) {
        return r.song || r.song_name || '';
    }

    function formatItem(r) {
        return getRequester(r) + ' | ' + getArtist(r) + ' | ' + getSong(r);
    }

    function restartAnimation() {
        track.style.animation = 'none';
        // Force reflow before re-enabling animation.
        void track.offsetWidth;
        track.style.animation = '';
    }

    function buildBaseHtml(items) {
        var logo = '<img class="ticker__logo" src="' + logoUrl + '" alt="RADYOYOL" onerror="this.style.display=\'none\'">';
        var html = '';
        items.forEach(function(r) {
            html += '<span class="ticker__item">' + escapeHtml(formatItem(r)) + '</span>' + logo;
        });
        return html;
    }

    function setupInfiniteTrack(baseHtml) {
        latestBaseHtml = baseHtml;
        var viewportWidth = (viewport && viewport.offsetWidth) ? viewport.offsetWidth : 1;

        track.innerHTML = '<span class="ticker__group">' + baseHtml + '</span>';
        var measuredBaseWidth = (track.querySelector('.ticker__group') || { offsetWidth: 1 }).offsetWidth || 1;

        // Grow one cycle so it is always wider than viewport; avoids visible gaps on reset.
        var minCycleWidth = viewportWidth * 1.5;
        var repeatCount = Math.max(1, Math.ceil(minCycleWidth / measuredBaseWidth));
        var cycleHtml = new Array(repeatCount + 1).join(baseHtml);

        track.innerHTML =
            '<span class="ticker__group">' + cycleHtml + '</span>' +
            '<span class="ticker__group" aria-hidden="true">' + cycleHtml + '</span>';

        var firstGroup = track.querySelector('.ticker__group');
        var shift = (firstGroup && firstGroup.offsetWidth) ? firstGroup.offsetWidth : measuredBaseWidth;
        var pxPerSecond = 85;
        var duration = Math.max(12, shift / pxPerSecond);

        track.style.setProperty('--ticker-shift', shift + 'px');
        track.style.setProperty('--ticker-duration', duration + 's');
        restartAnimation();
    }

    function renderItems(items) {
        if (!items || items.length === 0) {
            track.innerHTML = '<span class="ticker__empty">Henüz onaylı istek yok.</span>';
            track.style.animation = 'none';
            return;
        }
        setupInfiniteTrack(buildBaseHtml(items));
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

    var resizeTimer = null;
    window.addEventListener('resize', function() {
        if (resizeTimer) clearTimeout(resizeTimer);
        resizeTimer = setTimeout(function() {
            if (!latestBaseHtml || track.querySelector('.ticker__empty')) return;
            setupInfiniteTrack(latestBaseHtml);
        }, 120);
    });
})();
</script>
@endpush
