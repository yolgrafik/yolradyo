@extends('layouts.frontend')

@section('title', $album->name . ' - Foto Galeri')

@push('styles')
<style>
.gallery-page{max-width:1180px;margin:0 auto;padding:1.25rem 1rem 2rem;}
.gallery-page__head{padding:.75rem 1rem;border-radius:var(--ry-radius);background:color-mix(in srgb, var(--ry-bar-bg) 85%, transparent);border:1px solid var(--ry-border);border-top:1px solid var(--ry-line-color);border-bottom:1px solid var(--ry-line-color);margin-bottom:1rem;}
.gallery-page__title{margin:0;font-size:1.15rem;font-weight:700;color:var(--ry-text);}
.gallery-page__subtitle{margin:.25rem 0 0;color:var(--ry-text-muted);font-size:.85rem;}
.gallery-breadcrumb{display:inline-flex;align-items:center;gap:.4rem;margin-bottom:.5rem;color:var(--ry-text-muted);font-size:.78rem;text-decoration:none;}
.gallery-breadcrumb:hover{color:var(--ry-text);}
.gallery-grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(220px,1fr));gap:12px;}
.gallery-card{background:color-mix(in srgb, var(--ry-bar-bg) 75%, #0b0f16);border:1px solid var(--border);border-radius:12px;overflow:hidden;border-top:1px solid var(--ry-line-color);border-bottom:1px solid var(--ry-line-color);}
.gallery-card__img-btn{display:block;width:100%;padding:0;border:none;background:none;cursor:zoom-in;}
.gallery-card img{width:100%;aspect-ratio:4/3;object-fit:cover;display:block;}
.gallery-card__body{padding:.6rem .7rem;}
.gallery-card__title{margin:0;font-size:.84rem;font-weight:700;color:var(--ry-text);line-height:1.35;}
.gallery-card__desc{margin:.3rem 0 0;font-size:.76rem;color:var(--ry-text-muted);line-height:1.4;}
.gallery-lightbox{position:fixed;inset:0;display:none;z-index:12000;}
.gallery-lightbox.is-open{display:block;}
.gallery-lightbox__backdrop{position:absolute;inset:0;background:rgba(0,0,0,.86);}
.gallery-lightbox__dialog{position:relative;max-width:min(1200px,94vw);max-height:90vh;margin:4vh auto;z-index:1;}
.gallery-lightbox__img{display:block;max-width:100%;max-height:90vh;margin:0 auto;border-radius:12px;border:1px solid rgba(255,255,255,.2);}
.gallery-lightbox__close,.gallery-lightbox__nav{position:absolute;width:38px;height:38px;border-radius:50%;border:1px solid rgba(255,255,255,.35);background:rgba(0,0,0,.55);color:#fff;cursor:pointer;z-index:2;}
.gallery-lightbox__close{top:8px;right:8px;font-size:22px;line-height:1;}
.gallery-lightbox__nav{top:50%;transform:translateY(-50%);font-size:26px;line-height:1;}
.gallery-lightbox__nav--prev{left:10px;}
.gallery-lightbox__nav--next{right:10px;}
.gallery-empty{padding:1rem;color:var(--ry-text-muted);}
</style>
@endpush

@section('content')
<section class="gallery-page">
    <a href="{{ route('gallery.index') }}" class="gallery-breadcrumb">← Foto Galeri</a>
    <div class="gallery-page__head">
        <h1 class="gallery-page__title">{{ $album->name }}</h1>
        @if(!empty($album->description))
            <p class="gallery-page__subtitle">{{ $album->description }}</p>
        @endif
    </div>

    @if($photos->isNotEmpty())
        <div class="gallery-grid">
            @foreach($photos as $index => $photo)
                <figure class="gallery-card">
                    <button
                        type="button"
                        class="gallery-card__img-btn js-gallery-open-lightbox"
                        data-index="{{ $index }}"
                        data-image-src="{{ asset($photo->image_path) }}"
                        data-image-alt="{{ $photo->title ?: $album->name }}"
                    >
                        <img src="{{ asset($photo->image_path) }}" alt="{{ $photo->title ?: $album->name }}">
                    </button>
                    <figcaption class="gallery-card__body">
                        <h3 class="gallery-card__title">{{ $photo->title ?: $album->name }}</h3>
                        @if(!empty($photo->short_description))
                            <p class="gallery-card__desc">{{ \Illuminate\Support\Str::limit($photo->short_description, 90) }}</p>
                        @endif
                    </figcaption>
                </figure>
            @endforeach
        </div>
    @else
        <div class="gallery-empty">Bu albümde henüz aktif fotoğraf bulunmuyor.</div>
    @endif
</section>

<div class="gallery-lightbox" id="galleryLightbox" aria-hidden="true">
    <div class="gallery-lightbox__backdrop" data-gallery-lightbox-close></div>
    <div class="gallery-lightbox__dialog">
        <button type="button" class="gallery-lightbox__close" data-gallery-lightbox-close aria-label="Kapat">×</button>
        <button type="button" class="gallery-lightbox__nav gallery-lightbox__nav--prev" id="galleryLightboxPrev" aria-label="Önceki">‹</button>
        <img class="gallery-lightbox__img" id="galleryLightboxImage" src="" alt="">
        <button type="button" class="gallery-lightbox__nav gallery-lightbox__nav--next" id="galleryLightboxNext" aria-label="Sonraki">›</button>
    </div>
</div>
@endsection

@push('scripts')
<script>
(function(){
    var items = Array.prototype.slice.call(document.querySelectorAll('.js-gallery-open-lightbox')).map(function(btn){
        return {
            src: btn.getAttribute('data-image-src'),
            alt: btn.getAttribute('data-image-alt') || 'Fotoğraf'
        };
    });

    var lightbox = document.getElementById('galleryLightbox');
    var image = document.getElementById('galleryLightboxImage');
    var prev = document.getElementById('galleryLightboxPrev');
    var next = document.getElementById('galleryLightboxNext');
    if (!lightbox || !image || !prev || !next || !items.length) return;

    var currentIndex = 0;

    function render(index) {
        currentIndex = (index + items.length) % items.length;
        image.src = items[currentIndex].src;
        image.alt = items[currentIndex].alt;
    }

    function open(index) {
        render(index);
        lightbox.classList.add('is-open');
        lightbox.setAttribute('aria-hidden', 'false');
        document.body.style.overflow = 'hidden';
    }

    function close() {
        lightbox.classList.remove('is-open');
        lightbox.setAttribute('aria-hidden', 'true');
        document.body.style.overflow = '';
    }

    document.querySelectorAll('.js-gallery-open-lightbox').forEach(function(btn){
        btn.addEventListener('click', function(){
            open(Number(btn.getAttribute('data-index') || 0));
        });
    });

    prev.addEventListener('click', function(){ render(currentIndex - 1); });
    next.addEventListener('click', function(){ render(currentIndex + 1); });

    document.querySelectorAll('[data-gallery-lightbox-close]').forEach(function(el){
        el.addEventListener('click', close);
    });

    document.addEventListener('keydown', function(e){
        if (!lightbox.classList.contains('is-open')) return;
        if (e.key === 'Escape') close();
        if (e.key === 'ArrowLeft') render(currentIndex - 1);
        if (e.key === 'ArrowRight') render(currentIndex + 1);
    });
})();
</script>
@endpush
