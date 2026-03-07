@extends('layouts.frontend')

@section('title', $newsItem->title)

@push('styles')
<style>
    .news-detail {
        max-width: 1100px;
        margin: 0 auto;
        padding: 2rem 1.5rem;
    }
    .news-detail__main {
        max-width: 860px;
    }
    .news-detail__back {
        margin-bottom: 1.25rem;
        display: inline-flex;
        text-decoration: none;
        font-size: 0.85rem;
    }
    .news-detail__title {
        margin: 0;
        font-size: clamp(1.7rem, 3vw, 2.35rem);
        font-weight: 800;
        color: #fff;
        line-height: 1.2;
    }
    .news-detail__meta-row {
        margin-top: 0.9rem;
        display: flex;
        align-items: center;
        flex-wrap: wrap;
        gap: 0.55rem;
    }
    .news-detail__meta-pill {
        display: inline-flex;
        align-items: center;
        gap: 0.35rem;
        padding: 0.3rem 0.6rem;
        border-radius: 999px;
        border: 1px solid var(--ry-border);
        border-top: 1px solid var(--ry-line-color);
        border-bottom: 1px solid var(--ry-line-color);
        background: color-mix(in srgb, var(--ry-bar-bg) 70%, transparent);
        font-size: 0.85rem;
        color: var(--ry-text-muted);
    }
    .news-detail__share {
        margin-top: 1rem;
        display: flex;
        align-items: center;
        flex-wrap: wrap;
        gap: 0.5rem;
    }
    .news-detail__share-label {
        font-size: 0.8rem;
        color: var(--ry-text-muted);
        margin-right: 0.2rem;
    }
    .news-share-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 34px;
        height: 34px;
        border-radius: 999px;
        border: 1px solid var(--ry-border);
        color: #fff;
        text-decoration: none;
        font-size: 0.85rem;
        background: color-mix(in srgb, var(--ry-bar-bg) 68%, transparent);
        transition: transform 0.2s ease, border-color 0.2s ease, background 0.2s ease;
    }
    .news-share-btn:hover {
        transform: translateY(-1px);
        border-color: var(--ry-line-color);
        background: color-mix(in srgb, var(--ry-btn-bg) 45%, transparent);
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
        max-height: 520px;
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
        line-height: 1.9;
        font-size: 1rem;
        max-width: 78ch;
    }
    .news-detail__content p {
        margin-bottom: 1rem;
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
    .news-detail__section-title {
        margin-top: 1.8rem;
        margin-bottom: 0.8rem;
        font-size: 1.05rem;
        font-weight: 700;
        color: var(--ry-text);
    }
    .news-related {
        margin-top: 2.25rem;
    }
    .news-related__title {
        margin: 0 0 0.9rem;
        font-size: 1.2rem;
        font-weight: 700;
        color: var(--ry-text);
    }
    .news-related__grid {
        display: grid;
        grid-template-columns: repeat(4, minmax(0, 1fr));
        gap: 1rem;
    }
    .news-related__card {
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
    .news-related__img-wrap {
        width: 100%;
        aspect-ratio: 16/10;
        background: var(--ry-schedule-bg);
        overflow: hidden;
    }
    .news-related__img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    .news-related__body {
        padding: 0.85rem;
        display: flex;
        flex-direction: column;
        gap: 0.45rem;
        flex: 1;
    }
    .news-related__item-title {
        margin: 0;
        font-size: 0.95rem;
        line-height: 1.35;
        color: var(--ry-text);
        font-weight: 700;
    }
    .news-related__excerpt {
        margin: 0;
        color: var(--ry-text-muted);
        font-size: 0.82rem;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    .news-related__link {
        margin-top: auto;
        font-size: 0.78rem;
        font-weight: 700;
        text-decoration: none;
    }
    @media (max-width: 768px) {
        .news-detail {
            padding: 1.25rem 1rem;
        }
        .news-detail__gallery {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }
        .news-related__grid {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }
    }
    @media (max-width: 540px) {
        .news-detail__gallery {
            grid-template-columns: 1fr;
        }
        .news-related__grid {
            grid-template-columns: 1fr;
        }
    }
</style>
@endpush

@section('content')
<article class="news-detail">
    @php
        $categoryName = $newsItem->category ?? 'Genel';
        $readCount = $newsItem->read_count ?? null;
        $shareUrl = route('news.show', $newsItem->slug);
        $shareText = $newsItem->title;
        $encodedUrl = urlencode($shareUrl);
        $encodedText = urlencode($shareText);
    @endphp

    <div class="news-detail__main">
        <a href="{{ route('news.index') }}" class="news-detail__back ry-btn ry-btn-primary">Tum Haberler</a>
        <h1 class="news-detail__title">{{ $newsItem->title }}</h1>

        <div class="news-detail__meta-row">
            <span class="news-detail__meta-pill">Kategori: {{ $categoryName }}</span>
            <span class="news-detail__meta-pill">Yayin: {{ $newsItem->created_at?->format('d.m.Y H:i') }}</span>
            <span class="news-detail__meta-pill">Okunma: {{ $readCount !== null ? number_format((int) $readCount) : '-' }}</span>
        </div>

        <div class="news-detail__share" data-share-url="{{ $shareUrl }}">
            <span class="news-detail__share-label">Paylas:</span>
            <a class="news-share-btn" target="_blank" rel="noopener noreferrer" href="https://www.facebook.com/sharer/sharer.php?u={{ $encodedUrl }}" aria-label="Facebook">f</a>
            <a class="news-share-btn" target="_blank" rel="noopener noreferrer" href="https://wa.me/?text={{ urlencode($shareText . ' ' . $shareUrl) }}" aria-label="WhatsApp">wa</a>
            <a class="news-share-btn" target="_blank" rel="noopener noreferrer" href="https://t.me/share/url?url={{ $encodedUrl }}&text={{ $encodedText }}" aria-label="Telegram">tg</a>
            <a class="news-share-btn" target="_blank" rel="noopener noreferrer" href="https://twitter.com/intent/tweet?url={{ $encodedUrl }}&text={{ $encodedText }}" aria-label="X">x</a>
            <button type="button" class="news-share-btn js-copy-link" aria-label="Link kopyala">⧉</button>
        </div>

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
        <h2 class="news-detail__section-title">Foto Galeri</h2>
        <div class="news-detail__gallery">
            @foreach($galleryMedia as $media)
                <div class="news-detail__gallery-item">
                    <img src="{{ asset($media->file_path) }}" alt="{{ $newsItem->title }}">
                </div>
            @endforeach
        </div>
        @endif

        @if(!empty($newsItem->youtube_embed_url))
        <h2 class="news-detail__section-title">Video</h2>
        <div class="news-detail__video">
            <div class="news-detail__video-frame">
                <iframe src="{{ $newsItem->youtube_embed_url }}" title="{{ $newsItem->title }}" loading="lazy" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
            </div>
        </div>
        @endif

        <div class="news-detail__share" data-share-url="{{ $shareUrl }}">
            <span class="news-detail__share-label">Haberi paylas:</span>
            <a class="news-share-btn" target="_blank" rel="noopener noreferrer" href="https://www.facebook.com/sharer/sharer.php?u={{ $encodedUrl }}" aria-label="Facebook">f</a>
            <a class="news-share-btn" target="_blank" rel="noopener noreferrer" href="https://wa.me/?text={{ urlencode($shareText . ' ' . $shareUrl) }}" aria-label="WhatsApp">wa</a>
            <a class="news-share-btn" target="_blank" rel="noopener noreferrer" href="https://t.me/share/url?url={{ $encodedUrl }}&text={{ $encodedText }}" aria-label="Telegram">tg</a>
            <a class="news-share-btn" target="_blank" rel="noopener noreferrer" href="https://twitter.com/intent/tweet?url={{ $encodedUrl }}&text={{ $encodedText }}" aria-label="X">x</a>
            <button type="button" class="news-share-btn js-copy-link" aria-label="Link kopyala">⧉</button>
        </div>
    </div>

    @if(($relatedNews ?? collect())->isNotEmpty())
    <section class="news-related">
        <h2 class="news-related__title">Diger Haberler</h2>
        <div class="news-related__grid">
            @foreach($relatedNews as $item)
            <article class="news-related__card">
                <a href="{{ route('news.show', $item->slug) }}" class="news-related__img-wrap">
                    @if($item->cover_image)
                        <img src="{{ asset($item->cover_image) }}" alt="{{ $item->title }}" class="news-related__img">
                    @endif
                </a>
                <div class="news-related__body">
                    <h3 class="news-related__item-title">{{ $item->title }}</h3>
                    <p class="news-related__excerpt">{{ \Illuminate\Support\Str::limit($item->excerpt ?: '', 95) }}</p>
                    <a href="{{ route('news.show', $item->slug) }}" class="news-related__link ry-btn ry-btn-primary">Devamini Oku</a>
                </div>
            </article>
            @endforeach
        </div>
    </section>
    @endif
</article>
@endsection

@push('scripts')
<script>
(function() {
    var copyButtons = document.querySelectorAll('.js-copy-link');
    if (!copyButtons.length) return;

    copyButtons.forEach(function(btn) {
        btn.addEventListener('click', function() {
            var parent = btn.closest('[data-share-url]');
            var link = parent ? parent.getAttribute('data-share-url') : window.location.href;
            if (!link) return;
            if (navigator.clipboard && navigator.clipboard.writeText) {
                navigator.clipboard.writeText(link).then(function() {
                    btn.textContent = '✓';
                    setTimeout(function() { btn.textContent = '⧉'; }, 1200);
                }).catch(function() {});
            }
        });
    });
})();
</script>
@endpush
