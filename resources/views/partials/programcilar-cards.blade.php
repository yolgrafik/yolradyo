@php
    $programcilar = $programcilar ?? collect();
@endphp
@if($programcilar->isNotEmpty())
<section class="programcilar-section">
    <div class="programcilar-section__header">
        <h2 class="programcilar-section__title">Programcılar</h2>
    </div>
    <div class="programcilar-swiper-wrap">
        <div class="swiper programcilar-swiper" id="programcilarSwiper">
            <div class="swiper-wrapper">
                @foreach($programcilar as $p)
                <div class="swiper-slide">
                    <div class="programci-card">
                        <a href="{{ route('public.programcilar.show', $p->slug) }}" class="programci-card__link">
                            <div class="programci-card__img-wrap">
                                @if($p->avatar_path)
                                    <img src="{{ $p->avatar_url }}" alt="{{ $p->ad }}" class="programci-card__img">
                                @else
                                    <div class="programci-card__img-placeholder">{{ $p->display_initials }}</div>
                                @endif
                            </div>
                            <div class="programci-card__body">
                                <h3 class="programci-card__name" title="{{ $p->ad }}">{{ $p->ad }}</h3>
                                @if($p->kisa_aciklama)
                                    <p class="programci-card__slogan" title="{{ $p->kisa_aciklama }}">{{ $p->kisa_aciklama }}</p>
                                @endif
                            </div>
                        </a>
                        @php $hasSocial = $p->instagram || $p->facebook || $p->tiktok || $p->youtube; @endphp
                        @if($hasSocial)
                        <div class="programci-card__social">
                            @if($p->facebook)
                                <a href="{{ Str::startsWith($p->facebook, 'http') ? $p->facebook : 'https://' . $p->facebook }}" target="_blank" rel="noopener noreferrer" class="programci-card__social-btn programci-card__social-btn--fb" title="Facebook" aria-label="Facebook">
                                    <svg viewBox="0 0 24 24" width="18" height="18"><path fill="currentColor" d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                                </a>
                            @endif
                            @if($p->instagram)
                                <a href="{{ Str::startsWith($p->instagram, 'http') ? $p->instagram : 'https://' . $p->instagram }}" target="_blank" rel="noopener noreferrer" class="programci-card__social-btn programci-card__social-btn--ig" title="Instagram" aria-label="Instagram">
                                    <svg viewBox="0 0 24 24" width="18" height="18"><path fill="currentColor" d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>
                                </a>
                            @endif
                            @if($p->tiktok)
                                <a href="{{ Str::startsWith($p->tiktok, 'http') ? $p->tiktok : 'https://' . $p->tiktok }}" target="_blank" rel="noopener noreferrer" class="programci-card__social-btn programci-card__social-btn--tt" title="TikTok" aria-label="TikTok">
                                    <svg viewBox="0 0 24 24" width="18" height="18"><path fill="currentColor" d="M19.59 6.69a4.83 4.83 0 0 1-3.77-4.25V2h-3.45v13.67a2.89 2.89 0 0 1-5.2 1.74 2.89 2.89 0 0 1 2.31-4.64 2.93 2.93 0 0 1 .88.13V9.4a6.84 6.84 0 0 0-1-.05A6.33 6.33 0 0 0 5 20.1a6.34 6.34 0 0 0 10.86-4.43v-7a8.16 8.16 0 0 0 4.77 1.52v-3.4a4.85 4.85 0 0 1-1-.1z"/></svg>
                                </a>
                            @endif
                            @if($p->youtube)
                                <a href="{{ Str::startsWith($p->youtube, 'http') ? $p->youtube : 'https://' . $p->youtube }}" target="_blank" rel="noopener noreferrer" class="programci-card__social-btn programci-card__social-btn--yt" title="YouTube" aria-label="YouTube">
                                    <svg viewBox="0 0 24 24" width="18" height="18"><path fill="currentColor" d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/></svg>
                                </a>
                            @endif
                        </div>
                        @endif
                    </div>
                </div>
                @endforeach
            </div>
            @if($programcilar->count() > 1)
            <div class="swiper-button-prev programcilar-swiper-btn programcilar-swiper-btn--prev" aria-label="Önceki"></div>
            <div class="swiper-button-next programcilar-swiper-btn programcilar-swiper-btn--next" aria-label="Sonraki"></div>
            @endif
        </div>
    </div>
</section>

@push('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css">
<style>
.programcilar-section { margin-top: calc(1.5rem - 3%); padding: 0; }
.programcilar-section__header { padding: 0.75rem 1rem; border-radius: var(--ry-radius); background: color-mix(in srgb, var(--ry-bar-bg) 85%, transparent); border: 1px solid var(--ry-border); border-top: 1px solid var(--ry-line-color); border-bottom: 1px solid var(--ry-line-color); margin-bottom: 1rem; }
.programcilar-section__title { font-size: 1.1rem; font-weight: 700; color: var(--ry-text); margin: 0; font-family: inherit; }
.programcilar-swiper-wrap { position: relative; width: 100%; overflow: hidden; }
.programcilar-swiper { overflow: visible; padding: 0 2px; }
.programcilar-swiper .swiper-wrapper { align-items: stretch; }
.programcilar-swiper .swiper-slide { height: auto; display: flex; }
.programci-card { width: 100%; display: flex; flex-direction: column; background: color-mix(in srgb, var(--ry-bar-bg) 75%, transparent); backdrop-filter: blur(10px); -webkit-backdrop-filter: blur(10px); border: 1px solid var(--ry-border); border-top: 1px solid var(--ry-line-color); border-bottom: 1px solid var(--ry-line-color); border-radius: var(--ry-radius); overflow: hidden; color: inherit; transition: all 0.2s; }
.programci-card:hover { transform: translateY(-3px); border-color: var(--ry-schedule-active); box-shadow: 0 8px 24px rgba(0,0,0,0.3); }
.programci-card__link { display: flex; flex-direction: column; flex: 1; text-decoration: none; color: inherit; min-width: 0; cursor: pointer; }
.programci-card__img-wrap { width: 100%; aspect-ratio: 1; background: var(--ry-schedule-bg); overflow: hidden; flex-shrink: 0; }
.programci-card__img { width: 100%; height: 100%; object-fit: cover; }
.programci-card__img-placeholder { width: 100%; height: 100%; background: var(--ry-schedule-active); color: #fff; display: flex; align-items: center; justify-content: center; font-size: 1.75rem; font-weight: 800; font-family: inherit; }
.programci-card__body { padding: 1rem; display: flex; flex-direction: column; align-items: center; gap: 0.5rem; flex: 1; min-width: 0; }
.programci-card__name { font-size: 1rem; font-weight: 700; color: var(--ry-text); margin: 0; font-family: inherit; text-align: center; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; max-width: 100%; }
.programci-card__slogan { font-size: 0.85rem; color: var(--ry-text-muted); margin: 0; font-family: inherit; text-align: center; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; max-width: 100%; }
.programci-card__social { display: flex; flex-direction: row; align-items: center; justify-content: center; gap: 0.5rem; flex-wrap: wrap; padding: 0 1rem 1rem; }
.programci-card__social-btn { width: 28px; height: 28px; border-radius: 50%; display: flex; align-items: center; justify-content: center; box-shadow: 0 2px 6px rgba(0,0,0,0.3); transition: transform 0.2s; flex-shrink: 0; text-decoration: none; }
.programci-card__social-btn svg { width: 14px; height: 14px; }
.programci-card__social-btn:hover { transform: scale(1.1); }
.programci-card__social-btn--fb { background: #1877f2; color: #fff; }
.programci-card__social-btn--ig { background: linear-gradient(45deg, #f09433, #e6683c, #dc2743, #cc2366, #bc1888); color: #fff; }
.programci-card__social-btn--tt { background: #000; color: #fff; }
.programci-card__social-btn--yt { background: #ff0000; color: #fff; }
/* Overlay arrows on first/last card */
.programcilar-swiper .programcilar-swiper-btn { position: absolute; top: 50%; transform: translateY(-50%); width: 40px; height: 40px; margin: 0; border-radius: 50%; background: color-mix(in srgb, var(--ry-bar-bg) 90%, transparent); border: 1px solid var(--ry-border); color: var(--ry-text); z-index: 10; transition: all 0.2s; }
.programcilar-swiper .programcilar-swiper-btn::after { font-size: 18px; font-weight: 700; }
.programcilar-swiper .programcilar-swiper-btn:hover { background: rgba(255,255,255,0.2); border-color: var(--ry-line-color); }
.programcilar-swiper .programcilar-swiper-btn--prev { left: 12px; }
.programcilar-swiper .programcilar-swiper-btn--next { right: 12px; }
.programcilar-swiper .swiper-button-disabled { opacity: 0.35; pointer-events: none; }
</style>
@endpush
@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
<script>
(function(){
    var el = document.getElementById('programcilarSwiper');
    if (!el) return;
    var slideCount = el.querySelectorAll('.swiper-slide').length;
    new Swiper('#programcilarSwiper', {
        loop: slideCount > 1,
        slidesPerView: 4,
        slidesPerGroup: 1,
        spaceBetween: 20,
        speed: 350,
        centeredSlides: false,
        watchOverflow: false,
        navigation: {
            nextEl: '.programcilar-swiper-btn--next',
            prevEl: '.programcilar-swiper-btn--prev',
        },
        breakpoints: {
            320: { slidesPerView: 1 },
            601: { slidesPerView: 2 },
            1025: { slidesPerView: 4 }
        }
    });
})();
</script>
@endpush
@endif
