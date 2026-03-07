@extends('layouts.frontend')

@section('title', 'Haberler')

@push('styles')
<style>
    .news-page {
        max-width: 1200px;
        margin: 0 auto;
        padding: 2rem 1.5rem;
    }
    .news-page__header {
        margin-bottom: 1.25rem;
        padding: 0.9rem 1rem;
        border-radius: var(--ry-radius);
        border: 1px solid var(--ry-border);
        border-top: 1px solid var(--ry-line-color);
        border-bottom: 1px solid var(--ry-line-color);
        background: color-mix(in srgb, var(--ry-bar-bg) 86%, transparent);
    }
    .news-page__heading {
        display: flex;
        align-items: center;
        gap: 0.55rem;
    }
    .news-page__icon {
        width: 28px;
        height: 28px;
        border-radius: 8px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        background: color-mix(in srgb, var(--ry-btn-bg) 30%, transparent);
        border: 1px solid color-mix(in srgb, var(--ry-line-color) 80%, transparent);
        color: #fff;
        font-size: 0.92rem;
        flex-shrink: 0;
    }
    .news-page__title {
        font-size: clamp(1.4rem, 2.6vw, 1.95rem);
        font-weight: 800;
        color: #fff;
        margin: 0;
        letter-spacing: 0.01em;
    }
    .news-page__subtitle {
        margin: 0.35rem 0 0;
        color: var(--ry-text-muted);
        font-size: 0.88rem;
        line-height: 1.45;
    }
    .news-page__divider {
        margin-top: 0.55rem;
        height: 1px;
        width: min(220px, 48%);
        background: linear-gradient(90deg, var(--ry-line-color), transparent);
    }
    .news-page__grid {
        display: grid;
        grid-template-columns: repeat(4, minmax(0, 1fr));
        gap: 1.1rem;
    }
    .news-page__card {
        background: color-mix(in srgb, var(--ry-bar-bg) 75%, transparent);
        border: 1px solid var(--ry-border);
        border-top: 1px solid var(--ry-line-color);
        border-bottom: 1px solid var(--ry-line-color);
        border-radius: var(--ry-radius);
        overflow: hidden;
        display: flex;
        flex-direction: column;
        min-height: 100%;
    }
    .news-page__img-wrap {
        width: 100%;
        aspect-ratio: 16 / 10;
        background: var(--ry-schedule-bg);
        overflow: hidden;
    }
    .news-page__img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    .news-page__body {
        padding: 0.9rem;
        display: flex;
        flex-direction: column;
        gap: 0.45rem;
        flex: 1;
    }
    .news-page__card-title {
        margin: 0;
        color: var(--ry-text);
        font-size: 1rem;
        font-weight: 700;
        line-height: 1.35;
    }
    .news-page__excerpt {
        margin: 0;
        color: var(--ry-text-muted);
        font-size: 0.88rem;
        line-height: 1.45;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    .news-page__meta {
        margin-top: auto;
        font-size: 0.78rem;
        color: var(--ry-text-muted);
    }
    .news-page__link {
        margin-top: 0.55rem;
        align-self: flex-start;
        font-size: 0.8rem;
        font-weight: 700;
        text-decoration: none;
    }
    .news-page__empty {
        color: var(--ry-text-muted);
        font-size: 0.95rem;
        padding: 1rem 0;
    }
    @media (max-width: 1024px) {
        .news-page__grid { grid-template-columns: repeat(2, minmax(0, 1fr)); }
    }
    @media (max-width: 640px) {
        .news-page { padding: 1.1rem 1rem; }
        .news-page__grid { grid-template-columns: 1fr; }
        .news-page__header { padding: 0.8rem 0.85rem; }
        .news-page__subtitle { font-size: 0.84rem; }
    }
</style>
@endpush

@section('content')
<section class="news-page">
    <header class="news-page__header">
        <div class="news-page__heading">
            <span class="news-page__icon" aria-hidden="true">📰</span>
            <h1 class="news-page__title">Tum Haberler</h1>
        </div>
        <p class="news-page__subtitle">Guncel gelismeler, duyurular ve onemli paylasimlar.</p>
        <div class="news-page__divider" aria-hidden="true"></div>
    </header>

    @if($news->isEmpty())
        <p class="news-page__empty">Henüz aktif haber bulunmuyor.</p>
    @else
        <div class="news-page__grid">
            @foreach($news as $item)
            <article class="news-page__card">
                <a href="{{ route('news.show', $item->slug) }}" class="news-page__img-wrap">
                    @if($item->cover_image)
                        <img src="{{ asset($item->cover_image) }}" alt="{{ $item->title }}" class="news-page__img">
                    @endif
                </a>
                <div class="news-page__body">
                    <h2 class="news-page__card-title">{{ $item->title }}</h2>
                    <p class="news-page__excerpt">{{ \Illuminate\Support\Str::limit($item->excerpt ?: '', 140) }}</p>
                    <span class="news-page__meta">{{ $item->created_at?->format('d.m.Y H:i') }}</span>
                    <a href="{{ route('news.show', $item->slug) }}" class="news-page__link ry-btn ry-btn-primary">Devamını Oku</a>
                </div>
            </article>
            @endforeach
        </div>
    @endif
</section>
@endsection
