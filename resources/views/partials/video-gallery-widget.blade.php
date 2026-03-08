@php
    $artistVideos = $artistVideos ?? collect();
@endphp

<section class="video-gallery-widget" aria-label="Video Galeri">
    <div class="video-gallery-widget__header">
        <h2 class="video-gallery-widget__title">Video Galeri</h2>
        <p class="video-gallery-widget__subtitle">Sanatçı Videoları</p>
    </div>
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
.video-gallery-widget{margin-top:1.25rem;background:color-mix(in srgb,var(--ry-bar-bg) 75%, #0b0f16);border:1px solid var(--border);border-top:1px solid var(--ry-line-color);border-bottom:1px solid var(--ry-line-color);border-radius:14px;padding:14px;box-shadow:0 6px 20px rgba(0,0,0,0.25);}
.video-gallery-widget__header{margin-bottom:10px;}
.video-gallery-widget__title{margin:0;font-size:1.1rem;font-weight:800;color:var(--text);}
.video-gallery-widget__subtitle{margin:4px 0 0;color:var(--muted);font-size:0.84rem;}
.video-gallery-swiper{padding:6px 2px 22px;}
.video-gallery-card{display:flex;flex-direction:column;height:100%;background:rgba(255,255,255,0.04);border:1px solid rgba(255,255,255,0.08);border-radius:12px;overflow:hidden;cursor:pointer;transition:transform .22s ease, box-shadow .22s ease, border-color .22s ease;}
.video-gallery-card:hover{transform:translateY(-4px);border-color:var(--ry-schedule-active);box-shadow:0 10px 24px rgba(0,0,0,0.35);}
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
.video-modal{position:fixed;inset:0;display:none;z-index:1300;}
.video-modal.is-open{display:block;}
.video-modal__backdrop{position:absolute;inset:0;background:rgba(4,6,10,.78);}
.video-modal__dialog{position:relative;max-width:min(980px,94vw);margin:5vh auto;background:#090c12;border:1px solid rgba(255,255,255,.12);border-radius:14px;overflow:hidden;}
.video-modal__close{position:absolute;right:10px;top:8px;z-index:2;background:rgba(0,0,0,.45);border:1px solid rgba(255,255,255,.25);color:#fff;width:34px;height:34px;border-radius:50%;font-size:22px;line-height:1;cursor:pointer;}
.video-modal__player{aspect-ratio:16/9;background:#000;}
.video-modal__player iframe,.video-modal__player video{width:100%;height:100%;border:none;display:block;}
@media (max-width: 768px){.video-gallery-card__title{font-size:.9rem;}.video-gallery-card__desc{font-size:.76rem;}}
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
            loop: swiperEl.querySelectorAll('.swiper-slide').length > 3,
            slidesPerView: 1.1,
            spaceBetween: 12,
            navigation: { nextEl: '.video-gallery-swiper-btn--next', prevEl: '.video-gallery-swiper-btn--prev' },
            pagination: { el: '.video-gallery-swiper-pagination', clickable: true },
            breakpoints: { 640: { slidesPerView: 1.8 }, 992: { slidesPerView: 2.3 } }
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
