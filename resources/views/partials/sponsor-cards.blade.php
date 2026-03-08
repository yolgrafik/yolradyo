@php
    $sponsors = $sponsors ?? collect();
@endphp
@if($sponsors->isNotEmpty())
<section class="home-news-section home-sponsors-section" aria-label="Sponsorlar" id="sponsors">
    <div class="home-news-section__header">
        <h2 class="home-news-section__title">Sponsorlar</h2>
    </div>
    <div class="home-sponsors-widget">
    <div class="home-sponsors-swiper-wrap">
        <div class="swiper home-sponsors-swiper" id="homeSponsorsSwiper">
            <div class="swiper-wrapper">
                @foreach($sponsors as $sponsor)
                <div class="swiper-slide">
                    <article class="home-sponsor-card">
                        <div class="home-sponsor-card__inner">
                            <div class="home-sponsor-card__media">
                                    @if($sponsor->hasVideo())
                                    @php
                                        $vid = $sponsor->getYouTubeVideoId();
                                        $poster = $sponsor->getVideoPosterUrl();
                                    @endphp
                                    <div class="home-sponsor-card__video-wrap" data-video-type="{{ $sponsor->video_type ?? '' }}" data-video-id="{{ $vid ?? '' }}" data-video-src="{{ ($sponsor->video_type ?? '') === 'mp4' ? asset($sponsor->video_path ?? '') : '' }}" data-sponsor-id="{{ $sponsor->id }}">
                                        <div class="home-sponsor-card__video-preview">
                                            @if($poster)
                                                <img src="{{ $poster }}" alt="" class="home-sponsor-card__video-thumb">
                                            @else
                                                <div class="home-sponsor-card__video-fallback"></div>
                                            @endif
                                            <button type="button" class="home-sponsor-card__video-play-btn" aria-label="Video oynat"><i class="bi bi-play-circle-fill"></i></button>
                                        </div>
                                        <div class="home-sponsor-card__video-player" style="display:none;">
                                            @if(($sponsor->video_type ?? '') === 'youtube' && $vid)
                                                <iframe allow="accelerometer;autoplay;clipboard-write;encrypted-media;gyroscope;picture-in-picture" allowfullscreen></iframe>
                                                <button type="button" class="home-sponsor-card__video-close" aria-label="Kapat"><i class="bi bi-x-lg"></i></button>
                                            @elseif(($sponsor->video_type ?? '') === 'mp4' && !empty($sponsor->video_path))
                                                <video playsinline controls></video>
                                                <button type="button" class="home-sponsor-card__video-close" aria-label="Kapat"><i class="bi bi-x-lg"></i></button>
                                            @endif
                                        </div>
                                    </div>
                                @elseif($sponsor->getFirstImagePath())
                                    @php $firstImg = $sponsor->getFirstImagePath(); @endphp
                                    <button type="button" class="home-sponsor-card__img-btn" onclick="sponsorLightboxOpen('{{ asset($firstImg) }}', '{{ addslashes($sponsor->title ?? '') }}')" aria-label="Görseli büyüt">
                                        <img src="{{ asset($firstImg) }}" alt="{{ $sponsor->title ?? '' }}" class="home-sponsor-card__img">
                                    </button>
                                @else
                                    <div class="home-sponsor-card__img-placeholder">{{ mb_substr($sponsor->title ?? '', 0, 1) }}</div>
                                @endif
                            </div>
                            <div class="home-sponsor-card__body">
                                <h3 class="home-sponsor-card__title">{{ $sponsor->title ?? 'Sponsor' }}</h3>
                                @if(!empty($sponsor->short_description))
                                    <p class="home-sponsor-card__desc">{{ \Illuminate\Support\Str::limit($sponsor->short_description, 120) }}</p>
                                @endif
                                <div class="home-sponsor-card__footer">
                                    @if($sponsor->slug ?? null)
                                        <a href="{{ route('sponsor.show', $sponsor) }}" class="home-sponsor-card__detail-btn">Sponsor Detayı</a>
                                    @endif
                                    <div class="home-sponsor-card__links">
                                    @if(!empty($sponsor->website_url))<a class="home-sponsor-social-btn home-sponsor-social-btn--web" href="{{ $sponsor->website_url }}" target="_blank" rel="noopener noreferrer" title="Web Sitesi" aria-label="Web Sitesi"><i class="bi bi-globe"></i></a>@endif
                                    @if(!empty($sponsor->facebook_url))<a class="home-sponsor-social-btn home-sponsor-social-btn--fb" href="{{ $sponsor->facebook_url }}" target="_blank" rel="noopener noreferrer" title="Facebook" aria-label="Facebook"><svg viewBox="0 0 24 24" width="18" height="18"><path fill="currentColor" d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg></a>@endif
                                    @if(!empty($sponsor->instagram_url))<a class="home-sponsor-social-btn home-sponsor-social-btn--ig" href="{{ $sponsor->instagram_url }}" target="_blank" rel="noopener noreferrer" title="Instagram" aria-label="Instagram"><svg viewBox="0 0 24 24" width="18" height="18"><path fill="currentColor" d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg></a>@endif
                                    @if(!empty($sponsor->x_url))<a class="home-sponsor-social-btn home-sponsor-social-btn--x" href="{{ $sponsor->x_url }}" target="_blank" rel="noopener noreferrer" title="X" aria-label="X"><svg viewBox="0 0 24 24" width="18" height="18"><path fill="currentColor" d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg></a>@endif
                                    @if(!empty($sponsor->youtube_url))<a class="home-sponsor-social-btn home-sponsor-social-btn--yt" href="{{ $sponsor->youtube_url }}" target="_blank" rel="noopener noreferrer" title="YouTube" aria-label="YouTube"><svg viewBox="0 0 24 24" width="18" height="18"><path fill="currentColor" d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/></svg></a>@endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </article>
                </div>
                @endforeach
            </div>
            @if($sponsors->count() > 1)
            <div class="swiper-button-prev home-sponsors-swiper-btn home-sponsors-swiper-btn--prev" aria-label="Önceki"><i class="bi bi-chevron-left"></i></div>
            <div class="swiper-button-next home-sponsors-swiper-btn home-sponsors-swiper-btn--next" aria-label="Sonraki"><i class="bi bi-chevron-right"></i></div>
            @endif
        </div>
    </div>
    </div>
</section>

<div id="sponsorLightbox" class="sponsor-lightbox" role="dialog" aria-modal="true" aria-label="Sponsor görseli" style="display:none;">
    <div class="sponsor-lightbox__backdrop"></div>
    <div class="sponsor-lightbox__content">
        <button type="button" class="sponsor-lightbox__close" aria-label="Kapat"><i class="bi bi-x-lg"></i></button>
        <img src="" alt="" class="sponsor-lightbox__img">
    </div>
</div>

@push('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css">
<style>
.home-sponsors-section { margin-top: 1rem; }
.home-sponsors-widget { position: relative; background: color-mix(in srgb, var(--ry-bar-bg) 75%, #0b0f16); border: 1px solid var(--border); border-radius: 14px; overflow: hidden; box-shadow: 0 6px 20px rgba(0,0,0,0.25); border-top: 1px solid var(--ry-line-color); border-bottom: 1px solid var(--ry-line-color); min-height: 345px; }
.home-sponsors-swiper-wrap { position: relative; overflow: hidden; padding: 10px; min-height: 325px; }
.home-sponsors-swiper { overflow: visible; padding: 2px; }
.home-sponsors-swiper .swiper-wrapper { align-items: stretch; }
.home-sponsors-swiper .swiper-slide { height: auto; display: flex; }
.home-sponsor-card { width: 100%; min-width: 0; height: 100%; min-height: 305px; display: flex; flex-direction: column; background: rgba(255,255,255,.03); border: 1px solid var(--ry-border); border-radius: 10px; overflow: hidden; transition: all 0.2s; }
.home-sponsor-card:hover { border-color: color-mix(in srgb, var(--ry-schedule-active) 60%, var(--ry-border)); box-shadow: 0 6px 16px rgba(0,0,0,.25); }
.home-sponsor-card__inner { display: grid; grid-template-rows: 1fr minmax(72px, auto); flex: 1; min-height: 0; height: 100%; }
.home-sponsor-card__media { position: relative; width: 100%; min-height: 0; background: #111827; overflow: hidden; }
.home-sponsor-card__img-btn { all: unset; cursor: pointer; display: block; width: 100%; height: 100%; line-height: 0; }
.home-sponsor-card__img { width: 100%; height: 100%; object-fit: cover; object-position: center; display: block; }
.home-sponsor-card__img-placeholder { width: 100%; height: 100%; min-height: 100px; display: flex; align-items: center; justify-content: center; font-size: 2rem; font-weight: 800; color: var(--ry-schedule-active); background: #111827; }
.home-sponsor-card__video-wrap { position: absolute; inset: 0; width: 100%; height: 100%; }
.home-sponsor-card__video-preview { position: absolute; inset: 0; cursor: pointer; display: flex; align-items: center; justify-content: center; }
.home-sponsor-card__video-thumb { width: 100%; height: 100%; object-fit: cover; display: block; }
.home-sponsor-card__video-fallback { position: absolute; inset: 0; background: linear-gradient(135deg, #1a1a2e, #16213e); }
.home-sponsor-card__video-play-btn { position: absolute; inset: 0; margin: auto; width: 56px; height: 56px; border: none; background: rgba(0,0,0,.6); color: #fff; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 28px; cursor: pointer; transition: transform 0.2s, background 0.2s; z-index: 2; }
.home-sponsor-card__video-play-btn:hover { transform: scale(1.1); background: rgba(0,0,0,.8); }
.home-sponsor-card__video-player { position: absolute; inset: 0; width: 100%; height: 100%; z-index: 3; background: #000; }
.home-sponsor-card__video-player iframe, .home-sponsor-card__video-player video { width: 100%; height: 100%; object-fit: contain; display: block; }
.home-sponsor-card__video-close { position: absolute; top: 4px; right: 4px; width: 28px; height: 28px; border: none; background: rgba(0,0,0,.7); color: #fff; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 12px; cursor: pointer; z-index: 4; transition: background 0.2s; }
.home-sponsor-card__video-close:hover { background: rgba(0,0,0,.9); }
.home-sponsor-card__body { padding: 8px 10px; display: flex; flex-direction: column; gap: 4px; flex: 0 0 auto; min-height: 72px; overflow: hidden; background: linear-gradient(to top, rgba(7,10,16,.92), rgba(7,10,16,.2)); min-width: 0; justify-content: flex-start; }
.home-sponsor-card__title { margin: 0; font-size: .74rem; font-weight: 700; color: var(--ry-text); line-height: 1.25; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; }
.home-sponsor-card__desc { margin: 0; font-size: .66rem; color: var(--ry-text-muted); line-height: 1.3; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; }
.home-sponsor-card__footer { display: flex; align-items: center; justify-content: space-between; gap: 6px; margin-top: 6px; min-height: 26px; }
.home-sponsor-card__detail-btn { display: inline-flex; align-items: center; justify-content: center; padding: 4px 10px; font-size: .65rem; font-weight: 700; line-height: 1.2; background: var(--ry-schedule-active); color: #fff; border-radius: 5px; text-decoration: none; transition: opacity 0.2s; flex-shrink: 0; }
.home-sponsor-card__detail-btn:hover { opacity: 0.9; color: #fff; }
.home-sponsor-card__links { display: flex; flex-wrap: wrap; gap: 4px; align-items: center; margin-left: auto; }
.home-sponsor-social-btn { display: inline-flex; align-items: center; justify-content: center; width: 28px; height: 28px; border-radius: 50%; box-shadow: 0 2px 6px rgba(0,0,0,0.3); cursor: pointer; transition: transform 0.2s; flex-shrink: 0; text-decoration: none; }
.home-sponsor-social-btn:hover { transform: scale(1.1); }
.home-sponsor-social-btn svg { width: 14px; height: 14px; }
.home-sponsor-social-btn i { font-size: 14px; }
.home-sponsor-social-btn--web { background: rgba(255,255,255,0.15); color: var(--ry-text); }
.home-sponsor-social-btn--web:hover { color: #fff; }
.home-sponsor-social-btn--fb { background: #1877f2; color: #fff; }
.home-sponsor-social-btn--ig { background: linear-gradient(45deg, #f09433, #e6683c, #dc2743, #cc2366, #bc1888); color: #fff; }
.home-sponsor-social-btn--x { background: #000; color: #fff; }
.home-sponsor-social-btn--yt { background: #ff0000; color: #fff; }
.home-sponsors-swiper .home-sponsors-swiper-btn { position: absolute; top: 50%; transform: translateY(-50%); width: 40px; height: 40px; margin: 0; border-radius: 50%; background: color-mix(in srgb, var(--ry-bar-bg) 90%, transparent); border: 1px solid var(--ry-border); color: var(--ry-text); z-index: 10; transition: all 0.2s; display: flex; align-items: center; justify-content: center; font-size: 1.25rem; cursor: pointer; }
.home-sponsors-swiper .home-sponsors-swiper-btn::after { display: none; }
.home-sponsors-swiper .home-sponsors-swiper-btn:hover { background: rgba(255,255,255,0.2); border-color: var(--ry-line-color); }
.home-sponsors-swiper .home-sponsors-swiper-btn--prev { left: 12px; }
.home-sponsors-swiper .home-sponsors-swiper-btn--next { right: 12px; }
.home-sponsors-swiper .home-sponsors-swiper-btn.swiper-button-disabled { opacity: 0.35; pointer-events: none; }
.sponsor-lightbox { position: fixed; inset: 0; z-index: 9999; display: flex; align-items: center; justify-content: center; padding: 2rem; }
.sponsor-lightbox__backdrop { position: absolute; inset: 0; background: rgba(0,0,0,.85); cursor: pointer; }
.sponsor-lightbox__content { position: relative; max-width: 90vw; max-height: 90vh; }
.sponsor-lightbox__close { position: absolute; top: -40px; right: 0; width: 36px; height: 36px; border: none; background: rgba(255,255,255,.2); color: #fff; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 18px; cursor: pointer; z-index: 10; transition: background 0.2s; }
.sponsor-lightbox__close:hover { background: rgba(255,255,255,.35); }
.sponsor-lightbox__img { max-width: 100%; max-height: 85vh; object-fit: contain; border-radius: 8px; box-shadow: 0 8px 32px rgba(0,0,0,.5); }
@media (max-width: 992px) {
    .home-sponsors-swiper .home-sponsors-swiper-btn--prev { left: 4px; }
    .home-sponsors-swiper .home-sponsors-swiper-btn--next { right: 4px; }
}
@media (max-width: 600px) {
    .home-sponsors-widget { min-height: 312px; }
    .home-sponsors-swiper-wrap { min-height: 292px; }
    .home-sponsor-card { min-height: 272px; }
    .home-sponsor-card__media { min-height: 120px; }
    .home-sponsor-card__body { min-height: 78px; max-height: 78px; }
    .home-sponsor-card__title { font-size: .72rem; }
    .home-sponsor-card__desc { font-size: .66rem; }
}
</style>
@endpush
@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
<script>
(function(){
    var swiperEl = document.getElementById('homeSponsorsSwiper');
    if (swiperEl) {
        var slideCount = swiperEl.querySelectorAll('.swiper-slide').length;
        new Swiper('#homeSponsorsSwiper', {
            loop: slideCount > 1,
            slidesPerView: 3,
            slidesPerGroup: 1,
            spaceBetween: 14,
            speed: 350,
            navigation: { nextEl: '.home-sponsors-swiper-btn--next', prevEl: '.home-sponsors-swiper-btn--prev' },
            breakpoints: { 320: { slidesPerView: 1 }, 601: { slidesPerView: 2 }, 1025: { slidesPerView: 3 } }
        });
    }
    document.querySelectorAll('.home-sponsor-card__video-wrap').forEach(function(wrap){
        var preview = wrap.querySelector('.home-sponsor-card__video-preview');
        var player = wrap.querySelector('.home-sponsor-card__video-player');
        var playBtn = wrap.querySelector('.home-sponsor-card__video-play-btn');
        var closeBtn = wrap.querySelector('.home-sponsor-card__video-close');
        var type = wrap.getAttribute('data-video-type');
        var id = wrap.getAttribute('data-video-id');
        var src = wrap.getAttribute('data-video-src');
        function showPlayer(){
            if (!player) return;
            preview.style.display = 'none';
            player.style.display = 'block';
            if (type === 'youtube' && id) {
                var iframe = player.querySelector('iframe');
                if (iframe) iframe.src = 'https://www.youtube.com/embed/' + id + '?autoplay=1';
            } else if (type === 'mp4' && src) {
                var video = player.querySelector('video');
                if (video) { video.src = src; video.play(); }
            }
        }
        function hidePlayer(){
            if (!player) return;
            player.style.display = 'none';
            preview.style.display = 'flex';
            var iframe = player.querySelector('iframe');
            if (iframe) iframe.src = '';
            var video = player.querySelector('video');
            if (video) { video.pause(); video.src = ''; }
        }
        if (playBtn) playBtn.addEventListener('click', showPlayer);
        if (closeBtn) closeBtn.addEventListener('click', hidePlayer);
    });
    window.sponsorLightboxOpen = function(url, alt){
        var lb = document.getElementById('sponsorLightbox');
        if (!lb) return;
        var img = lb.querySelector('.sponsor-lightbox__img');
        if (img) { img.src = url; img.alt = alt || ''; }
        lb.style.display = 'flex';
        document.body.style.overflow = 'hidden';
    };
    (function(){
        var lb = document.getElementById('sponsorLightbox');
        if (!lb) return;
        var close = function(){
            lb.style.display = 'none';
            document.body.style.overflow = '';
        };
        lb.querySelector('.sponsor-lightbox__close').addEventListener('click', close);
        lb.querySelector('.sponsor-lightbox__backdrop').addEventListener('click', close);
        document.addEventListener('keydown', function(e){
            if (e.key === 'Escape' && lb.style.display === 'flex') close();
        });
    })();
})();
</script>
@endpush
@endif
