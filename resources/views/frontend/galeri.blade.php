@extends('layouts.frontend')

@section('title', 'Foto Galeri')

@push('styles')
<style>
.gallery-page{max-width:1180px;margin:0 auto;padding:1.25rem 1rem 2rem;}
.gallery-page__head{padding:.75rem 1rem;border-radius:var(--ry-radius);background:color-mix(in srgb, var(--ry-bar-bg) 85%, transparent);border:1px solid var(--ry-border);border-top:1px solid var(--ry-line-color);border-bottom:1px solid var(--ry-line-color);margin-bottom:1rem;}
.gallery-page__title{margin:0;font-size:1.15rem;font-weight:700;color:var(--ry-text);}
.gallery-page__subtitle{margin:.25rem 0 0;color:var(--ry-text-muted);font-size:.85rem;}
.gallery-albums-grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(260px,1fr));gap:14px;}
.gallery-album-card{display:block;text-decoration:none;background:color-mix(in srgb, var(--ry-bar-bg) 75%, #0b0f16);border:1px solid var(--border);border-radius:12px;overflow:hidden;border-top:1px solid var(--ry-line-color);border-bottom:1px solid var(--ry-line-color);transition:transform .2s ease, box-shadow .2s ease,border-color .2s ease;}
.gallery-album-card:hover{transform:translateY(-3px);border-color:var(--ry-schedule-active);box-shadow:0 8px 20px rgba(0,0,0,.28);}
.gallery-album-card__cover{width:100%;aspect-ratio:16/10;object-fit:cover;display:block;background:#121826;}
.gallery-album-card__body{padding:.8rem;}
.gallery-album-card__title{margin:0;font-size:.92rem;font-weight:800;color:var(--ry-text);}
.gallery-album-card__desc{margin:.4rem 0 0;font-size:.78rem;color:var(--ry-text-muted);line-height:1.45;min-height:2.6em;}
.gallery-album-card__meta{margin-top:.45rem;font-size:.72rem;color:var(--muted);}
.gallery-section-title{margin:1.4rem 0 .7rem;font-size:.95rem;font-weight:800;color:var(--ry-text);}
.gallery-plain-grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(220px,1fr));gap:12px;}
.gallery-photo-card{background:color-mix(in srgb, var(--ry-bar-bg) 75%, #0b0f16);border:1px solid var(--border);border-radius:12px;overflow:hidden;border-top:1px solid var(--ry-line-color);border-bottom:1px solid var(--ry-line-color);}
.gallery-photo-card img{width:100%;aspect-ratio:4/3;object-fit:cover;display:block;}
.gallery-photo-card__body{padding:.6rem .7rem;}
.gallery-photo-card__title{margin:0;font-size:.84rem;font-weight:700;color:var(--ry-text);line-height:1.35;}
.gallery-photo-card__desc{margin:.3rem 0 0;font-size:.76rem;color:var(--ry-text-muted);line-height:1.4;}
.gallery-empty{padding:1rem;color:var(--ry-text-muted);}
</style>
@endpush

@section('content')
<section class="gallery-page">
    <div class="gallery-page__head">
        <h1 class="gallery-page__title">Foto Galeri</h1>
        <p class="gallery-page__subtitle">Albüm bazlı fotoğraflar</p>
    </div>

    @if(($albums ?? collect())->isNotEmpty())
        <div class="gallery-albums-grid">
            @foreach($albums as $album)
                @php
                    $cover = $album->cover_image_path ?: optional($album->photos->first())->image_path;
                @endphp
                <a href="{{ route('gallery.show', $album->slug) }}" class="gallery-album-card">
                    @if($cover)
                        <img src="{{ asset($cover) }}" alt="{{ $album->name }}" class="gallery-album-card__cover">
                    @else
                        <div class="gallery-album-card__cover"></div>
                    @endif
                    <div class="gallery-album-card__body">
                        <h2 class="gallery-album-card__title">{{ $album->name }}</h2>
                        <p class="gallery-album-card__desc">{{ \Illuminate\Support\Str::limit($album->description ?: 'Albüm fotoğraflarını görüntüleyin.', 90) }}</p>
                        <div class="gallery-album-card__meta">{{ (int) ($album->active_photos_count ?? 0) }} fotoğraf</div>
                    </div>
                </a>
            @endforeach
        </div>
    @endif

    @if(($unassignedPhotos ?? collect())->isNotEmpty())
        <h2 class="gallery-section-title">Albümsüz Fotoğraflar</h2>
        <div class="gallery-plain-grid">
            @foreach($unassignedPhotos as $photo)
                <article class="gallery-photo-card">
                    <img src="{{ asset($photo->image_path) }}" alt="{{ $photo->title ?: 'Albümsüz Fotoğraf' }}">
                    <div class="gallery-photo-card__body">
                        <h3 class="gallery-photo-card__title">{{ $photo->title ?: 'Albümsüz Fotoğraf' }}</h3>
                        @if(!empty($photo->short_description))
                            <p class="gallery-photo-card__desc">{{ \Illuminate\Support\Str::limit($photo->short_description, 90) }}</p>
                        @endif
                    </div>
                </article>
            @endforeach
        </div>
    @endif

    @if(($albums ?? collect())->isEmpty() && ($unassignedPhotos ?? collect())->isEmpty())
        <div class="gallery-empty">Henüz yayınlanmış fotoğraf bulunmuyor.</div>
    @endif
</section>
@endsection
