@php
    $artistVideos = $artistVideos ?? collect();
@endphp

<section class="home-news-section video-gallery-section" aria-label="Video Galeri">
    <div class="home-news-section__header video-gallery-section__header">
        <div class="video-gallery-section__title-row">
            <h2 class="home-news-section__title video-gallery-section__title">Video Galeri</h2>
            <span class="video-gallery-section__sep" aria-hidden="true">|</span>
            <p class="video-gallery-section__subtitle">Sanatçı Videoları</p>
        </div>
    </div>
    <div class="video-gallery-widget">
    @if($artistVideos->isNotEmpty())
        <div class="video-gallery-swiper-wrap">
            <div class="swiper video-gallery-swiper" id="videoGallerySwiper">
                <div class="swiper-wrapper">
                    @foreach($artistVideos as $video)
                        <div class="swiper-slide">
                            <article
                                class="video-gallery-card js-gallery-video-card"
                                data-video-type="{{ $video->video_type }}"
                                data-mp4="{{ $video->mp4_path ? asset($video->mp4_path) : '' }}"
                                data-youtube="{{ $video->youtube_embed_url ?? '' }}"
                            >
                                <div class="video-gallery-card__cover">
                                    @if($video->cover_image_path)
                                        <img src="{{ asset($video->cover_image_path) }}" alt="{{ $video->title }}" loading="lazy">
                                    @else
                                        <div class="video-gallery-card__fallback">Video</div>
                                    @endif
                                    <span class="video-gallery-card__play">▶</span>
                                </div>
                                <div class="video-gallery-card__body">
                                    <h3 class="video-gallery-card__title">{{ $video->title }}</h3>
                                    @if($video->short_description)
                                        <p class="video-gallery-card__desc">{{ \Illuminate\Support\Str::limit($video->short_description, 90) }}</p>
                                    @endif
                                </div>
                            </article>
                        </div>
                    @endforeach
                </div>
                <div class="swiper-button-prev video-gallery-swiper-btn video-gallery-swiper-btn--prev"></div>
                <div class="swiper-button-next video-gallery-swiper-btn video-gallery-swiper-btn--next"></div>
                <div class="swiper-pagination video-gallery-swiper-pagination"></div>
            </div>
        </div>
    @else
        <div class="video-gallery-widget__empty">Henüz video eklenmedi.</div>
    @endif
    </div>
</section>

<div class="video-modal" id="videoGalleryModal" aria-hidden="true">
    <div class="video-modal__backdrop" data-close-video-modal></div>
    <div class="video-modal__dialog" role="dialog" aria-modal="true" aria-label="Video Oynatıcı">
        <button type="button" class="video-modal__close" data-close-video-modal aria-label="Kapat">×</button>
        <div class="video-modal__player" id="videoGalleryPlayer"></div>
    </div>
</div>

@push('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css">
<style>
.video-gallery-section__header{margin-bottom:1rem;}
.video-gallery-section__title{margin:0;}
.video-gallery-section__title-row{display:flex;align-items:center;gap:.5rem;flex-wrap:wrap;}
.video-gallery-section__sep{color:var(--ry-text-muted);font-size:.9rem;line-height:1;}
.video-gallery-section__subtitle{font-size:.74rem;color:var(--ry-text-muted);margin:0;line-height:1;}
.video-gallery-widget{position:relative;background:color-mix(in srgb,var(--ry-bar-bg) 75%, #0b0f16);border:1px solid var(--border);border-radius:14px;overflow:hidden;box-shadow:0 6px 20px rgba(0,0,0,0.25);border-top:1px solid var(--ry-line-color);}
.video-gallery-swiper-wrap{overflow:hidden;}
.video-gallery-swiper{padding:12px 12px 24px;overflow:hidden;}
.video-gallery-card{display:flex;flex-direction:column;height:100%;background:rgba(255,255,255,0.04);border:1px solid rgba(255,255,255,0.08);border-radius:12px;overflow:hidden;cursor:pointer;transition:transform .22s ease, box-shadow .22s ease, border-color .22s ease;}
.video-gallery-card:hover{transform:translateY(-2px);border-color:var(--ry-schedule-active);box-shadow:0 10px 24px rgba(0,0,0,0.35);}
.video-gallery-card__cover{position:relative;aspect-ratio:16/9;background:#10131a;overflow:hidden;}
.video-gallery-card__cover img{width:100%;height:100%;object-fit:cover;display:block;}
.video-gallery-card__fallback{width:100%;height:100%;display:grid;place-items:center;color:#d1d5db;font-weight:700;}
.video-gallery-card__play{position:absolute;left:50%;top:50%;transform:translate(-50%,-50%);width:52px;height:52px;border-radius:50%;display:grid;place-items:center;background:rgba(201,42,42,.92);color:#fff;font-size:22px;padding-left:3px;box-shadow:0 6px 18px rgba(0,0,0,.35);}
.video-gallery-card__body{padding:10px 12px;}
.video-gallery-card__title{margin:0;font-size:.95rem;font-weight:700;color:var(--text);line-height:1.35;}
.video-gallery-card__desc{margin:6px 0 0;font-size:.8rem;line-height:1.45;color:var(--ry-text-muted);}
.video-gallery-swiper-btn{width:32px;height:32px;border-radius:50%;background:color-mix(in srgb, var(--ry-bar-bg) 90%, transparent);border:1px solid var(--border);color:var(--ry-text);}
.video-gallery-swiper-btn::after{font-size:12px;font-weight:700;}
.video-gallery-swiper-pagination .swiper-pagination-bullet{background:rgba(255,255,255,.38);opacity:1;}
.video-gallery-swiper-pagination .swiper-pagination-bullet-active{background:var(--ry-schedule-active);}
.video-gallery-widget__empty{padding:.6rem 0;color:var(--muted);}
.home-right .video-gallery-section{display:flex;flex-direction:column;flex:1 1 auto;min-height:0;}
.home-right .video-gallery-widget{display:flex;flex-direction:column;flex:1 1 auto;min-height:100%;}
.video-modal{position:fixed;inset:0;display:none;z-index:1300;}
.video-modal.is-open{display:block;}
.video-modal__backdrop{position:absolute;inset:0;background:rgba(4,6,10,.78);}
.video-modal__dialog{position:relative;max-width:min(980px,94vw);margin:5vh auto;background:#090c12;border:1px solid rgba(255,255,255,.12);border-radius:14px;overflow:hidden;}
.video-modal__close{position:absolute;right:10px;top:8px;z-index:2;background:rgba(0,0,0,.45);border:1px solid rgba(255,255,255,.25);color:#fff;width:34px;height:34px;border-radius:50%;font-size:22px;line-height:1;cursor:pointer;}
.video-modal__player{aspect-ratio:16/9;background:#000;}
.video-modal__player iframe,.video-modal__player video{width:100%;height:100%;border:none;display:block;}
@media (max-width: 768px){.video-gallery-card__title{font-size:.9rem;}.video-gallery-card__desc{font-size:.76rem;}.video-gallery-section__subtitle{font-size:.7rem;}.home-right .video-gallery-section,.home-right .video-gallery-widget{flex:0 0 auto;min-height:auto;}}
</style>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
<script>
(function(){
    if (typeof Swiper === 'undefined') return;
    var swiperEl = document.getElementById('videoGallerySwiper');
    if (swiperEl) {
        new Swiper('#videoGallerySwiper', {
            loop: swiperEl.querySelectorAll('.swiper-slide').length > 1,
            slidesPerView: 1,
            spaceBetween: 0,
            speed: 450,
            autoplay: { delay: 4500, disableOnInteraction: false },
            navigation: { nextEl: '.video-gallery-swiper-btn--next', prevEl: '.video-gallery-swiper-btn--prev' },
            pagination: { el: '.video-gallery-swiper-pagination', clickable: true }
        });
    }

    var modal = document.getElementById('videoGalleryModal');
    var player = document.getElementById('videoGalleryPlayer');
    if (!modal || !player) return;

    function closeModal() {
        modal.classList.remove('is-open');
        modal.setAttribute('aria-hidden', 'true');
        player.innerHTML = '';
        document.body.style.overflow = '';
    }

    function openModal(card) {
        var type = card.getAttribute('data-video-type');
        var mp4 = card.getAttribute('data-mp4');
        var yt = card.getAttribute('data-youtube');
        if (type === 'mp4' && mp4) {
            player.innerHTML = '<video controls autoplay playsinline src="' + mp4 + '"></video>';
        } else if (type === 'youtube' && yt) {
            var embed = yt + (yt.indexOf('?') === -1 ? '?autoplay=1' : '&autoplay=1');
            player.innerHTML = '<iframe src="' + embed + '" allow="autoplay; encrypted-media; picture-in-picture" allowfullscreen></iframe>';
        } else {
            return;
        }
        modal.classList.add('is-open');
        modal.setAttribute('aria-hidden', 'false');
        document.body.style.overflow = 'hidden';
    }

    document.querySelectorAll('.js-gallery-video-card').forEach(function(card){
        card.addEventListener('click', function(){ openModal(card); });
    });
    document.querySelectorAll('[data-close-video-modal]').forEach(function(el){
        el.addEventListener('click', closeModal);
    });
    document.addEventListener('keydown', function(e){
        if (e.key === 'Escape' && modal.classList.contains('is-open')) closeModal();
    });
})();
</script>
@endpush
