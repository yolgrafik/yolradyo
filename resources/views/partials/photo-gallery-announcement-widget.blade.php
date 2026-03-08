@php
    $galleryPhotos = $galleryPhotos ?? collect();
@endphp

<section class="home-news-section photo-gallery-announcement-section" aria-label="Foto Galeri">
    <div class="home-news-section__header photo-gallery-announcement-section__header">
        <h2 class="home-news-section__title photo-gallery-announcement-section__title">Foto Galeri &amp; DUYURU</h2>
    </div>
    <div class="photo-gallery-announcement-widget">
        @if($galleryPhotos->isNotEmpty())
            <div class="photo-gallery-announcement-slider" data-photo-gallery-slider>
                @foreach($galleryPhotos as $index => $photo)
                    <article class="photo-gallery-announcement-card {{ $index === 0 ? 'is-active' : '' }}" data-photo-gallery-slide>
                        <button
                            type="button"
                            class="photo-gallery-announcement-card__image-btn"
                            data-photo-gallery-open
                            data-image-src="{{ asset($photo->image_path) }}"
                            data-image-alt="{{ $photo->title ?: 'Fotoğraf' }}"
                        >
                            <img src="{{ asset($photo->image_path) }}" alt="{{ $photo->title ?: 'Fotoğraf' }}">
                        </button>
                        <div class="photo-gallery-announcement-card__body">
                            <h3>{{ $photo->title ?: 'Fotoğraf' }}</h3>
                            @if(!empty($photo->short_description))
                                <p>{{ \Illuminate\Support\Str::limit($photo->short_description, 90) }}</p>
                            @endif
                        </div>
                    </article>
                @endforeach
                @if($galleryPhotos->count() > 1)
                    <button type="button" class="photo-gallery-slider-btn photo-gallery-slider-btn--prev" data-photo-gallery-prev aria-label="Önceki fotoğraf">‹</button>
                    <button type="button" class="photo-gallery-slider-btn photo-gallery-slider-btn--next" data-photo-gallery-next aria-label="Sonraki fotoğraf">›</button>
                @endif
            </div>
        @else
            <div class="photo-gallery-announcement-widget__body">
                Henüz fotoğraf eklenmedi.
            </div>
        @endif
    </div>
</section>

<div class="photo-gallery-lightbox" id="photoGalleryHomeLightbox" aria-hidden="true">
    <div class="photo-gallery-lightbox__backdrop" data-photo-gallery-close></div>
    <div class="photo-gallery-lightbox__dialog">
        <button type="button" class="photo-gallery-lightbox__close" data-photo-gallery-close aria-label="Kapat">×</button>
        <img id="photoGalleryHomeLightboxImage" class="photo-gallery-lightbox__image" src="" alt="">
    </div>
</div>

@push('styles')
<style>
.photo-gallery-announcement-section{margin-top:1rem;}
.photo-gallery-announcement-section__header{margin-bottom:1rem;}
.photo-gallery-announcement-section__title{margin:0;}
.photo-gallery-announcement-widget{position:relative;background:color-mix(in srgb,var(--ry-bar-bg) 75%, #0b0f16);border:1px solid var(--border);border-radius:14px;overflow:hidden;box-shadow:0 6px 20px rgba(0,0,0,0.25);border-top:1px solid var(--ry-line-color);border-bottom:1px solid var(--ry-line-color);}
.photo-gallery-announcement-widget__body{padding:14px;color:var(--ry-text-muted);font-size:.85rem;line-height:1.5;}
.photo-gallery-announcement-slider{position:relative;padding:10px;min-height:325px;}
.photo-gallery-announcement-card{display:none;border:1px solid var(--border);border-radius:10px;overflow:hidden;background:rgba(255,255,255,.03);height:100%;grid-template-rows:auto 96px;}
.photo-gallery-announcement-card.is-active{display:grid;}
.photo-gallery-announcement-card__image-btn{display:block;width:100%;padding:0;border:none;background:none;cursor:zoom-in;aspect-ratio:16/10;height:auto;overflow:hidden;}
.photo-gallery-announcement-card img{display:block;width:100%;height:100%;object-fit:cover;}
.photo-gallery-announcement-card__body{padding:8px;min-height:96px;max-height:96px;overflow:hidden;}
.photo-gallery-announcement-card__body h3{margin:0;font-size:.8rem;color:var(--ry-text);line-height:1.35;display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;overflow:hidden;min-height:2.7em;}
.photo-gallery-announcement-card__body p{margin:.35rem 0 0;font-size:.72rem;color:var(--ry-text-muted);line-height:1.4;display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;overflow:hidden;}
.photo-gallery-slider-btn{position:absolute;top:50%;transform:translateY(-50%);width:30px;height:30px;border-radius:50%;border:1px solid var(--border);background:color-mix(in srgb,var(--ry-bar-bg) 90%, transparent);color:var(--ry-text);cursor:pointer;display:flex;align-items:center;justify-content:center;z-index:2;}
.photo-gallery-slider-btn--prev{left:16px;}
.photo-gallery-slider-btn--next{right:16px;}
.photo-gallery-lightbox{position:fixed;inset:0;display:none;z-index:12000;}
.photo-gallery-lightbox.is-open{display:block;}
.photo-gallery-lightbox__backdrop{position:absolute;inset:0;background:rgba(0,0,0,.86);}
.photo-gallery-lightbox__dialog{position:relative;max-width:min(1000px,94vw);max-height:90vh;margin:4vh auto;z-index:1;}
.photo-gallery-lightbox__image{display:block;max-width:100%;max-height:90vh;margin:0 auto;border-radius:12px;border:1px solid rgba(255,255,255,.2);}
.photo-gallery-lightbox__close{position:absolute;top:8px;right:8px;width:36px;height:36px;border-radius:50%;border:1px solid rgba(255,255,255,.35);background:rgba(0,0,0,.55);color:#fff;font-size:22px;line-height:1;cursor:pointer;z-index:2;}
@media (max-width: 600px){
    .photo-gallery-announcement-slider{min-height:300px;}
    .photo-gallery-announcement-card__image-btn{aspect-ratio:4/3;}
}
</style>
@endpush

@push('scripts')
<script>
(function(){
    var slider = document.querySelector('[data-photo-gallery-slider]');
    if (!slider) return;

    var slides = Array.prototype.slice.call(slider.querySelectorAll('[data-photo-gallery-slide]'));
    var prevBtn = slider.querySelector('[data-photo-gallery-prev]');
    var nextBtn = slider.querySelector('[data-photo-gallery-next]');
    var current = 0;
    var timer = null;

    function show(index) {
        if (!slides.length) return;
        current = (index + slides.length) % slides.length;
        slides.forEach(function(slide, i){ slide.classList.toggle('is-active', i === current); });
    }

    function start() {
        if (slides.length <= 1) return;
        stop();
        timer = setInterval(function(){ show(current + 1); }, 5000);
    }

    function stop() {
        if (timer) {
            clearInterval(timer);
            timer = null;
        }
    }

    if (prevBtn) prevBtn.addEventListener('click', function(){ show(current - 1); start(); });
    if (nextBtn) nextBtn.addEventListener('click', function(){ show(current + 1); start(); });
    slider.addEventListener('mouseenter', stop);
    slider.addEventListener('mouseleave', start);
    start();

    var lightbox = document.getElementById('photoGalleryHomeLightbox');
    var lightboxImg = document.getElementById('photoGalleryHomeLightboxImage');
    if (!lightbox || !lightboxImg) return;

    function closeLightbox() {
        lightbox.classList.remove('is-open');
        lightbox.setAttribute('aria-hidden', 'true');
        lightboxImg.src = '';
        lightboxImg.alt = '';
        document.body.style.overflow = '';
    }

    slider.querySelectorAll('[data-photo-gallery-open]').forEach(function(btn){
        btn.addEventListener('click', function(){
            var src = btn.getAttribute('data-image-src');
            var alt = btn.getAttribute('data-image-alt') || 'Fotoğraf';
            if (!src) return;
            lightboxImg.src = src;
            lightboxImg.alt = alt;
            lightbox.classList.add('is-open');
            lightbox.setAttribute('aria-hidden', 'false');
            document.body.style.overflow = 'hidden';
        });
    });

    lightbox.querySelectorAll('[data-photo-gallery-close]').forEach(function(el){
        el.addEventListener('click', closeLightbox);
    });

    document.addEventListener('keydown', function(e){
        if (e.key === 'Escape' && lightbox.classList.contains('is-open')) closeLightbox();
    });
})();
</script>
@endpush
