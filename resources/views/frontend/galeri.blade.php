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
    @else
        <div class="gallery-empty">Henüz yayınlanmış fotoğraf bulunmuyor.</div>
    @endif
</section>
@endsection
