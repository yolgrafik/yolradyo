@php
    $galleryPhotos = $galleryPhotos ?? collect();
@endphp

<section class="home-news-section photo-gallery-announcement-section" aria-label="Foto Galeri Duyuru">
    <div class="home-news-section__header photo-gallery-announcement-section__header">
        <div class="photo-gallery-announcement-section__title-row">
            <h2 class="home-news-section__title photo-gallery-announcement-section__title">Foto Galeri</h2>
            <span class="photo-gallery-announcement-section__sep" aria-hidden="true">|</span>
            <p class="photo-gallery-announcement-section__subtitle">DUYURU</p>
        </div>
    </div>
    <div class="photo-gallery-announcement-widget">
        @if($galleryPhotos->isNotEmpty())
            <div class="photo-gallery-announcement-grid">
                @foreach($galleryPhotos->take(4) as $photo)
                    <article class="photo-gallery-announcement-card">
                        <img src="{{ asset($photo->image_path) }}" alt="{{ $photo->title ?: 'Fotoğraf' }}">
                        <div class="photo-gallery-announcement-card__body">
                            <h3>{{ $photo->title ?: 'Fotoğraf' }}</h3>
                            @if(!empty($photo->short_description))
                                <p>{{ \Illuminate\Support\Str::limit($photo->short_description, 70) }}</p>
                            @endif
                        </div>
                    </article>
                @endforeach
            </div>
        @else
            <div class="photo-gallery-announcement-widget__body">
                Henüz fotoğraf eklenmedi.
            </div>
        @endif
    </div>
</section>

@push('styles')
<style>
.photo-gallery-announcement-section{margin-top:1rem;}
.photo-gallery-announcement-section__header{margin-bottom:1rem;}
.photo-gallery-announcement-section__title{margin:0;}
.photo-gallery-announcement-section__title-row{display:flex;align-items:center;gap:.5rem;flex-wrap:wrap;}
.photo-gallery-announcement-section__sep{color:var(--ry-text-muted);font-size:.9rem;line-height:1;}
.photo-gallery-announcement-section__subtitle{font-size:.74rem;color:var(--ry-text-muted);margin:0;line-height:1;}
.photo-gallery-announcement-widget{position:relative;background:color-mix(in srgb,var(--ry-bar-bg) 75%, #0b0f16);border:1px solid var(--border);border-radius:14px;overflow:hidden;box-shadow:0 6px 20px rgba(0,0,0,0.25);border-top:1px solid var(--ry-line-color);border-bottom:1px solid var(--ry-line-color);}
.photo-gallery-announcement-widget__body{padding:14px;color:var(--ry-text-muted);font-size:.85rem;line-height:1.5;}
.photo-gallery-announcement-grid{display:grid;grid-template-columns:repeat(2,minmax(0,1fr));gap:10px;padding:10px;}
.photo-gallery-announcement-card{border:1px solid var(--border);border-radius:10px;overflow:hidden;background:rgba(255,255,255,.03);}
.photo-gallery-announcement-card img{display:block;width:100%;aspect-ratio:4/3;object-fit:cover;}
.photo-gallery-announcement-card__body{padding:8px;}
.photo-gallery-announcement-card__body h3{margin:0;font-size:.8rem;color:var(--ry-text);line-height:1.35;}
.photo-gallery-announcement-card__body p{margin:.35rem 0 0;font-size:.72rem;color:var(--ry-text-muted);line-height:1.4;}
@media (max-width: 768px){.photo-gallery-announcement-section__subtitle{font-size:.7rem;}}
</style>
@endpush
