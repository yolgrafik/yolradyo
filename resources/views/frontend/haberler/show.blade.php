@extends('layouts.frontend')

@section('title', $newsItem->title)

@push('styles')
<style>
    .news-detail {
        max-width: 900px;
        margin: 0 auto;
        padding: 2rem 1.5rem;
    }
    .news-detail__back {
        margin-bottom: 1rem;
        display: inline-flex;
        text-decoration: none;
        font-size: 0.85rem;
    }
    .news-detail__title {
        margin: 0;
        font-size: 2rem;
        font-weight: 800;
        color: #fff;
        line-height: 1.25;
    }
    .news-detail__meta {
        margin-top: 0.7rem;
        font-size: 0.85rem;
        color: var(--ry-text-muted);
    }
    .news-detail__image-wrap {
        margin-top: 1rem;
        border-radius: var(--ry-radius);
        overflow: hidden;
        border: 1px solid var(--ry-border);
        border-top: 1px solid var(--ry-line-color);
        border-bottom: 1px solid var(--ry-line-color);
    }
    .news-detail__image {
        width: 100%;
        max-height: 420px;
        object-fit: cover;
        display: block;
    }
    .news-detail__excerpt {
        margin-top: 1rem;
        color: var(--ry-text);
        font-weight: 600;
        line-height: 1.6;
    }
    .news-detail__content {
        margin-top: 1rem;
        color: var(--ry-text-muted);
        line-height: 1.75;
    }
    .news-detail__gallery {
        margin-top: 1.5rem;
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: 0.8rem;
    }
    .news-detail__gallery-item {
        border-radius: 10px;
        overflow: hidden;
        border: 1px solid var(--ry-border);
        border-top: 1px solid var(--ry-line-color);
        border-bottom: 1px solid var(--ry-line-color);
        aspect-ratio: 16 / 10;
    }
    .news-detail__gallery-item img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
    }
    .news-detail__video {
        margin-top: 1.5rem;
    }
    .news-detail__video-frame {
        width: 100%;
        aspect-ratio: 16 / 9;
        border: 1px solid var(--ry-border);
        border-top: 1px solid var(--ry-line-color);
        border-bottom: 1px solid var(--ry-line-color);
        border-radius: var(--ry-radius);
        overflow: hidden;
    }
    .news-detail__video-frame iframe {
        width: 100%;
        height: 100%;
        border: 0;
    }
    @media (max-width: 768px) {
        .news-detail__gallery {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }
    }
    @media (max-width: 540px) {
        .news-detail__gallery {
            grid-template-columns: 1fr;
        }
    }
</style>
@endpush

@section('content')
<article class="news-detail">
    <a href="{{ route('news.index') }}" class="news-detail__back ry-btn ry-btn-primary">Tum Haberler</a>
    <h1 class="news-detail__title">{{ $newsItem->title }}</h1>
    <div class="news-detail__meta">{{ $newsItem->created_at?->format('d.m.Y H:i') }}</div>

    @if($newsItem->cover_image)
    <div class="news-detail__image-wrap">
        <img src="{{ asset($newsItem->cover_image) }}" alt="{{ $newsItem->title }}" class="news-detail__image">
    </div>
    @endif

    @if(!empty($newsItem->excerpt))
        <p class="news-detail__excerpt">{{ $newsItem->excerpt }}</p>
    @endif

    <div class="news-detail__content">
        {!! nl2br(e($newsItem->content ?? '')) !!}
    </div>

    @php
        $galleryMedia = $newsItem->media->where('type', 'image')->values();
    @endphp
    @if($galleryMedia->isNotEmpty())
    <div class="news-detail__gallery">
        @foreach($galleryMedia as $media)
            <div class="news-detail__gallery-item">
                <img src="{{ asset($media->file_path) }}" alt="{{ $newsItem->title }}">
            </div>
        @endforeach
    </div>
    @endif

    @if(!empty($newsItem->youtube_embed_url))
    <div class="news-detail__video">
        <div class="news-detail__video-frame">
            <iframe src="{{ $newsItem->youtube_embed_url }}" title="{{ $newsItem->title }}" loading="lazy" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
        </div>
    </div>
    @endif
</article>
@endsection
