@extends('layouts.frontend')

@section('title', 'Foto Galeri')

@push('styles')
<style>
.gallery-page{max-width:1180px;margin:0 auto;padding:1.25rem 1rem 2rem;}
.gallery-page__head{padding:.75rem 1rem;border-radius:var(--ry-radius);background:color-mix(in srgb, var(--ry-bar-bg) 85%, transparent);border:1px solid var(--ry-border);border-top:1px solid var(--ry-line-color);border-bottom:1px solid var(--ry-line-color);margin-bottom:1rem;}
.gallery-page__title{margin:0;font-size:1.15rem;font-weight:700;color:var(--ry-text);}
.gallery-page__subtitle{margin:.25rem 0 0;color:var(--ry-text-muted);font-size:.85rem;}
.gallery-album{margin-top:1.2rem;}
.gallery-album__title{margin:0 0 .6rem 0;font-size:1rem;font-weight:800;color:var(--ry-text);}
.gallery-grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(220px,1fr));gap:12px;}
.gallery-card{background:color-mix(in srgb, var(--ry-bar-bg) 75%, #0b0f16);border:1px solid var(--border);border-radius:12px;overflow:hidden;border-top:1px solid var(--ry-line-color);border-bottom:1px solid var(--ry-line-color);}
.gallery-card img{width:100%;aspect-ratio:4/3;object-fit:cover;display:block;}
.gallery-card__body{padding:.6rem .7rem;}
.gallery-card__title{margin:0;font-size:.84rem;font-weight:700;color:var(--ry-text);line-height:1.35;}
.gallery-card__desc{margin:.3rem 0 0;font-size:.76rem;color:var(--ry-text-muted);line-height:1.4;}
.gallery-empty{padding:1rem;color:var(--ry-text-muted);}
</style>
@endpush

@section('content')
<section class="gallery-page">
    <div class="gallery-page__head">
        <h1 class="gallery-page__title">Foto Galeri</h1>
        <p class="gallery-page__subtitle">Albüm bazlı fotoğraflar</p>
    </div>

    @forelse($albums as $album)
        <article class="gallery-album">
            <h2 class="gallery-album__title">{{ $album->name }}</h2>
            <div class="gallery-grid">
                @foreach($album->photos as $photo)
                    <figure class="gallery-card">
                        <img src="{{ asset($photo->image_path) }}" alt="{{ $photo->title ?: $album->name }}">
                        <figcaption class="gallery-card__body">
                            <h3 class="gallery-card__title">{{ $photo->title ?: $album->name }}</h3>
                            @if(!empty($photo->short_description))
                                <p class="gallery-card__desc">{{ \Illuminate\Support\Str::limit($photo->short_description, 90) }}</p>
                            @endif
                        </figcaption>
                    </figure>
                @endforeach
            </div>
        </article>
    @empty
        <div class="gallery-empty">Henüz yayınlanmış fotoğraf bulunmuyor.</div>
    @endforelse
</section>
@endsection
