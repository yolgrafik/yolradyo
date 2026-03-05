@php
    $programcilar = $programcilar ?? collect();
@endphp
@if($programcilar->isNotEmpty())
<section class="programcilar-section">
    <div class="programcilar-section__header">
        <h2 class="programcilar-section__title">Programcılar</h2>
        @if($programcilar->count() > 4)
        <div class="programcilar-nav">
            <button type="button" class="programcilar-nav__btn programcilar-nav__btn--prev" aria-label="Önceki" title="Önceki">
                <svg viewBox="0 0 24 24" width="20" height="20"><path fill="currentColor" d="M15.41 7.41L14 6l-6 6 6 6 1.41-1.41L10.83 12z"/></svg>
            </button>
            <button type="button" class="programcilar-nav__btn programcilar-nav__btn--next" aria-label="Sonraki" title="Sonraki">
                <svg viewBox="0 0 24 24" width="20" height="20"><path fill="currentColor" d="M10 6L8.59 7.41 13.17 12l-4.58 4.59L10 18l6-6z"/></svg>
            </button>
        </div>
        @endif
    </div>
    <div class="programcilar-carousel">
        <div class="programcilar-track" id="programcilarTrack">
        @foreach($programcilar as $p)
        <a href="{{ route('public.programcilar.show', $p->slug) }}" class="programci-card">
            <div class="programci-card__img-wrap">
                @if($p->avatar_path)
                    <img src="{{ $p->avatar_url }}" alt="{{ $p->ad }}" class="programci-card__img">
                @else
                    <div class="programci-card__img-placeholder">{{ $p->display_initials }}</div>
                @endif
            </div>
            <div class="programci-card__divider"></div>
            <div class="programci-card__body">
                <h3 class="programci-card__name">{{ $p->ad }}</h3>
                @php $hasSocial = $p->instagram || $p->facebook || $p->tiktok; @endphp
                @if($hasSocial)
                <div class="programci-card__social">
                    @if($p->facebook)
                        <a href="{{ Str::startsWith($p->facebook, 'http') ? $p->facebook : 'https://' . $p->facebook }}" target="_blank" rel="noopener noreferrer" class="programci-card__social-btn programci-card__social-btn--fb" title="Facebook" aria-label="Facebook">
                            <svg viewBox="0 0 24 24" width="20" height="20"><path fill="currentColor" d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                        </a>
                    @endif
                    @if($p->instagram)
                        <a href="{{ Str::startsWith($p->instagram, 'http') ? $p->instagram : 'https://' . $p->instagram }}" target="_blank" rel="noopener noreferrer" class="programci-card__social-btn programci-card__social-btn--ig" title="Instagram" aria-label="Instagram">
                            <svg viewBox="0 0 24 24" width="20" height="20"><path fill="currentColor" d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>
                        </a>
                    @endif
                    @if($p->tiktok)
                        <a href="{{ Str::startsWith($p->tiktok, 'http') ? $p->tiktok : 'https://' . $p->tiktok }}" target="_blank" rel="noopener noreferrer" class="programci-card__social-btn programci-card__social-btn--tt" title="TikTok" aria-label="TikTok">
                            <svg viewBox="0 0 24 24" width="20" height="20"><path fill="currentColor" d="M19.59 6.69a4.83 4.83 0 0 1-3.77-4.25V2h-3.45v13.67a2.89 2.89 0 0 1-5.2 1.74 2.89 2.89 0 0 1 2.31-4.64 2.93 2.93 0 0 1 .88.13V9.4a6.84 6.84 0 0 0-1-.05A6.33 6.33 0 0 0 5 20.1a6.34 6.34 0 0 0 10.86-4.43v-7a8.16 8.16 0 0 0 4.77 1.52v-3.4a4.85 4.85 0 0 1-1-.1z"/></svg>
                        </a>
                    @endif
                </div>
                @endif
            </div>
        </a>
        @endforeach
        </div>
    </div>
</section>

@push('styles')
<style>
.programcilar-section { margin-top: 1.5rem; padding: 1.25rem; background: var(--ry-bar-bg); border-radius: var(--ry-radius); border: 1px solid var(--ry-border); }
.programcilar-section__header { display: flex; align-items: center; justify-content: space-between; gap: 1rem; margin-bottom: 1rem; }
.programcilar-section__title { font-size: 1.1rem; font-weight: 700; color: var(--ry-text); margin: 0; font-family: inherit; }
.programcilar-nav { display: flex; gap: 0.5rem; }
.programcilar-nav__btn { width: 36px; height: 36px; border-radius: 10px; border: 1px solid var(--ry-border); background: rgba(255,255,255,0.08); color: var(--ry-text); cursor: pointer; display: flex; align-items: center; justify-content: center; transition: all 0.2s; }
.programcilar-nav__btn:hover { background: rgba(255,255,255,0.15); border-color: var(--ry-line-color); }
.programcilar-carousel { overflow: hidden; }
.programcilar-track { display: flex; gap: 1rem; transition: transform 0.3s ease; }
.programci-card { flex: 0 0 calc(25% - 0.75rem); min-width: 0; display: flex; flex-direction: column; background: var(--ry-theme); border-radius: var(--ry-radius); overflow: hidden; text-decoration: none; color: inherit; transition: all 0.2s; border: 2px solid var(--ry-theme); }
.programci-card:hover { transform: translateY(-4px); box-shadow: 0 8px 32px rgba(0,0,0,0.3); }
.programci-card__img-wrap { width: 100%; aspect-ratio: 1; background: var(--ry-schedule-bg); overflow: hidden; }
.programci-card__img { width: 100%; height: 100%; object-fit: cover; }
.programci-card__img-placeholder { width: 100%; height: 100%; background: var(--ry-schedule-active); color: #fff; display: flex; align-items: center; justify-content: center; font-size: 2rem; font-weight: 800; font-family: inherit; }
.programci-card__divider { width: 100%; height: 2px; background: rgba(255,255,255,0.9); flex-shrink: 0; }
.programci-card__body { padding: 1rem; text-align: center; background: var(--ry-theme); flex: 1; display: flex; flex-direction: column; align-items: center; gap: 0.75rem; }
.programci-card__name { font-size: 1.05rem; font-weight: 700; color: var(--ry-text); margin: 0; font-family: inherit; }
.programci-card__social { display: flex; gap: 0.5rem; justify-content: center; flex-wrap: wrap; }
.programci-card__social-btn { width: 40px; height: 40px; border-radius: 50%; display: flex; align-items: center; justify-content: center; box-shadow: 0 2px 8px rgba(0,0,0,0.3); transition: transform 0.2s; }
.programci-card__social-btn:hover { transform: scale(1.1); }
.programci-card__social-btn--fb { background: #1877f2; color: #fff; }
.programci-card__social-btn--ig { background: linear-gradient(45deg, #f09433, #e6683c, #dc2743, #cc2366, #bc1888); color: #fff; }
.programci-card__social-btn--tt { background: #000; color: #fff; }
@media (max-width: 1024px) { .programci-card { flex: 0 0 calc(50% - 0.5rem); } }
@media (max-width: 600px) { .programci-card { flex: 0 0 100%; } .programcilar-nav { display: none; } }
</style>
@endpush
@push('scripts')
<script>
(function(){
    var carousel = document.querySelector('.programcilar-carousel');
    var track = document.getElementById('programcilarTrack');
    var prevBtn = document.querySelector('.programcilar-nav__btn--prev');
    var nextBtn = document.querySelector('.programcilar-nav__btn--next');
    if (!carousel || !track || !prevBtn || !nextBtn) return;
    var cards = track.querySelectorAll('.programci-card');
    var cardCount = cards.length;
    if (cardCount <= 4) return;
    var gap = 16;
    var current = 0;
    function getStep() {
        if (!cards[0]) return 0;
        var cw = carousel.offsetWidth;
        var cardWidth = (cw - gap * 3) / 4;
        return (cardWidth + gap) * 4;
    }
    function getMaxScroll() {
        if (!cards[0]) return 0;
        var cw = carousel.offsetWidth;
        var cardWidth = (cw - gap * 3) / 4;
        return (cardWidth + gap) * Math.max(0, cardCount - 4);
    }
    function updateScroll() {
        var maxScroll = getMaxScroll();
        current = Math.max(0, Math.min(current, maxScroll));
        track.style.transform = 'translateX(-' + current + 'px)';
        prevBtn.style.opacity = current <= 0 ? '0.4' : '1';
        prevBtn.style.pointerEvents = current <= 0 ? 'none' : 'auto';
        nextBtn.style.opacity = current >= maxScroll ? '0.4' : '1';
        nextBtn.style.pointerEvents = current >= maxScroll ? 'none' : 'auto';
    }
    prevBtn.addEventListener('click', function() {
        current -= getStep();
        updateScroll();
    });
    nextBtn.addEventListener('click', function() {
        current += getStep();
        updateScroll();
    });
    window.addEventListener('resize', function() {
        current = Math.min(current, getMaxScroll());
        updateScroll();
    });
    updateScroll();
})();
</script>
@endpush
@endif
