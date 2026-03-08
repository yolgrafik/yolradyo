@extends('layouts.frontend')

@section('title', $video->title)

@push('styles')
<style>
.video-detail{max-width:980px;margin:0 auto;padding:1.2rem 1rem 2rem;}
.video-detail__player{border-radius:14px;overflow:hidden;background:#000;border:1px solid var(--border);border-top:1px solid var(--ry-line-color);border-bottom:1px solid var(--ry-line-color);}
.video-detail__player video,.video-detail__player iframe{width:100%;aspect-ratio:16/9;border:none;display:block;}
.video-detail__body{margin-top:1rem;background:color-mix(in srgb,var(--ry-bar-bg) 78%, #0b0f16);border:1px solid var(--border);border-radius:12px;padding:14px;}
.video-detail__title{margin:0;color:var(--text);font-size:1.35rem;font-weight:800;}
.video-detail__desc{margin:.55rem 0 0;color:var(--ry-text-muted);line-height:1.65;}
.news-detail__share{margin-top:1rem;display:flex;align-items:center;flex-wrap:wrap;gap:.55rem;}
.news-detail__share-label{font-size:.8rem;color:var(--ry-text-muted);margin-right:.2rem;}
.news-share-btn{display:inline-flex;align-items:center;justify-content:flex-start;gap:.45rem;min-height:36px;padding:.45rem .75rem;border-radius:999px;border:1px solid var(--ry-border);color:#fff;text-decoration:none;font-size:.8rem;font-weight:700;background:color-mix(in srgb, var(--ry-bar-bg) 72%, transparent);transition:transform .2s ease,border-color .2s ease,background .2s ease,box-shadow .2s ease;white-space:nowrap;cursor:pointer;}
.news-share-btn svg{width:16px;height:16px;display:block;flex-shrink:0;}
.news-share-btn:hover{transform:translateY(-1px);box-shadow:0 6px 16px rgba(0,0,0,.22);}
.news-share-btn--facebook{border-color:color-mix(in srgb, #1877F2 55%, var(--ry-border));}
.news-share-btn--facebook:hover{background:#1877F2;border-color:#1877F2;}
.news-share-btn--whatsapp{border-color:color-mix(in srgb, #25D366 55%, var(--ry-border));}
.news-share-btn--whatsapp:hover{background:#25D366;border-color:#25D366;}
.news-share-btn--telegram{border-color:color-mix(in srgb, #229ED9 55%, var(--ry-border));}
.news-share-btn--telegram:hover{background:#229ED9;border-color:#229ED9;}
.news-share-btn--messenger{border-color:color-mix(in srgb, #0084FF 55%, var(--ry-border));}
.news-share-btn--messenger:hover{background:#0084FF;border-color:#0084FF;}
.news-share-btn--copy{border-color:color-mix(in srgb, #9ca3af 45%, var(--ry-border));}
.news-share-btn--copy:hover{background:color-mix(in srgb, var(--ry-btn-bg) 45%, transparent);}
.news-share-toast{position:fixed;left:50%;bottom:18px;transform:translateX(-50%) translateY(8px);padding:.5rem .85rem;border-radius:999px;background:rgba(0,0,0,.82);color:#fff;font-size:.78rem;z-index:10000;opacity:0;pointer-events:none;transition:opacity .2s ease, transform .2s ease;}
.news-share-toast.is-visible{opacity:1;transform:translateX(-50%) translateY(0);}
</style>
@endpush

@section('content')
<div class="video-detail">
    <div class="video-detail__player">
        @if($video->video_type === 'mp4' && $video->mp4_path)
            <video controls autoplay playsinline src="{{ asset($video->mp4_path) }}"></video>
        @elseif($video->youtube_embed_url)
            <iframe src="{{ $video->youtube_embed_url }}?autoplay=1" allow="autoplay; encrypted-media; picture-in-picture" allowfullscreen></iframe>
        @endif
    </div>

    <div class="video-detail__body">
        <h1 class="video-detail__title">{{ $video->title }}</h1>
        @if($video->short_description)
            <p class="video-detail__desc">{{ $video->short_description }}</p>
        @endif

        @php
            $shareUrl = request()->fullUrl();
            $shareText = $video->title . ' - RadyoYol Video Galeri';
            $encodedUrl = urlencode($shareUrl);
            $encodedText = urlencode($shareText);
        @endphp
        <div class="news-detail__share" data-share-url="{{ $shareUrl }}">
            <span class="news-detail__share-label">Paylas:</span>
            <a class="news-share-btn news-share-btn--facebook" target="_blank" rel="noopener noreferrer" href="https://www.facebook.com/sharer/sharer.php?u={{ $encodedUrl }}" aria-label="Facebook">
                <svg viewBox="0 0 24 24" aria-hidden="true"><path fill="currentColor" d="M22.675 0H1.325C.593 0 0 .593 0 1.326v21.348C0 23.407.593 24 1.325 24h11.495v-9.294H9.692V11.08h3.128V8.413c0-3.1 1.894-4.788 4.659-4.788 1.325 0 2.463.099 2.795.143v3.24h-1.918c-1.505 0-1.796.715-1.796 1.764v2.31h3.588l-.467 3.625H16.56V24h6.115C23.407 24 24 23.407 24 22.674V1.326C24 .593 23.407 0 22.675 0z"/></svg>
                <span>Facebook</span>
            </a>
            <a class="news-share-btn news-share-btn--whatsapp" target="_blank" rel="noopener noreferrer" href="https://wa.me/?text={{ urlencode($shareText . ' ' . $shareUrl) }}" aria-label="WhatsApp">
                <svg viewBox="0 0 24 24" aria-hidden="true"><path fill="currentColor" d="M20.52 3.48A11.82 11.82 0 0 0 12.08 0C5.53 0 .18 5.36.18 11.93c0 2.1.55 4.15 1.6 5.95L0 24l6.3-1.65a11.83 11.83 0 0 0 5.78 1.48h.01c6.55 0 11.9-5.36 11.9-11.93 0-3.19-1.23-6.19-3.47-8.42zM12.1 21.82h-.01a9.84 9.84 0 0 1-5.01-1.37l-.36-.21-3.74.98 1-3.64-.24-.37a9.85 9.85 0 0 1-1.54-5.28c0-5.47 4.45-9.92 9.92-9.92 2.65 0 5.13 1.03 7 2.9a9.84 9.84 0 0 1 2.9 7c0 5.47-4.45 9.92-9.92 9.92zm5.44-7.43c-.3-.15-1.78-.88-2.06-.98-.27-.1-.47-.15-.66.15-.2.3-.76.98-.93 1.18-.17.2-.35.22-.65.07-.3-.15-1.26-.46-2.4-1.47-.89-.79-1.48-1.77-1.66-2.07-.17-.3-.02-.46.13-.61.13-.13.3-.35.45-.52.15-.17.2-.3.3-.5.1-.2.05-.37-.02-.52-.08-.15-.67-1.61-.92-2.2-.24-.58-.48-.5-.66-.5h-.56c-.2 0-.52.07-.79.37s-1.04 1.02-1.04 2.48c0 1.46 1.07 2.87 1.22 3.07.15.2 2.1 3.21 5.09 4.5.71.31 1.27.5 1.7.64.71.22 1.36.19 1.87.11.57-.08 1.78-.73 2.03-1.43.25-.7.25-1.3.17-1.43-.07-.13-.27-.2-.57-.35z"/></svg>
                <span>WhatsApp</span>
            </a>
            <a class="news-share-btn news-share-btn--telegram" target="_blank" rel="noopener noreferrer" href="https://t.me/share/url?url={{ $encodedUrl }}&text={{ $encodedText }}" aria-label="Telegram">
                <svg viewBox="0 0 24 24" aria-hidden="true"><path fill="currentColor" d="M9.78 17.57l-.4 5.63c.57 0 .81-.25 1.1-.54l2.64-2.52 5.48 4.01c1 .56 1.71.27 1.98-.92l3.6-16.86h.01c.31-1.45-.52-2.01-1.5-1.64L1.54 12.2C.12 12.75.14 13.54 1.3 13.9l5.44 1.7L19.37 7.4c.6-.4 1.15-.18.7.22L9.78 17.57z"/></svg>
                <span>Telegram</span>
            </a>
            <a class="news-share-btn news-share-btn--messenger" target="_blank" rel="noopener noreferrer" href="https://www.facebook.com/dialog/send?link={{ $encodedUrl }}&app_id=123456789&redirect_uri={{ $encodedUrl }}" aria-label="Messenger">
                <svg viewBox="0 0 24 24" aria-hidden="true"><path fill="currentColor" d="M12 2C6.48 2 2 6.15 2 11.27c0 2.92 1.46 5.53 3.75 7.23V22l3.18-1.74c.95.26 1.97.4 3.07.4 5.52 0 10-4.15 10-9.27S17.52 2 12 2zm1 12.48-2.55-2.72-4.83 2.72 5.31-5.62 2.63 2.72 4.75-2.72L13 14.48z"/></svg>
                <span>Messenger</span>
            </a>
            <button type="button" class="news-share-btn news-share-btn--copy js-copy-link" aria-label="Link kopyala">
                <svg viewBox="0 0 24 24" aria-hidden="true"><path fill="currentColor" d="M16 1H4a2 2 0 0 0-2 2v12h2V3h12V1zm3 4H8a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h11a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2zm0 16H8V7h11v14z"/></svg>
                <span>Link Kopyala</span>
            </button>
        </div>
    </div>
</div>
<div class="news-share-toast" id="videoShareToast">Link kopyalandi</div>
@endsection

@push('scripts')
<script>
(function(){
    var btn = document.querySelector('.js-copy-link');
    var toast = document.getElementById('videoShareToast');
    if (!btn || !toast) return;
    btn.addEventListener('click', function(){
        navigator.clipboard.writeText(window.location.href).then(function(){
            toast.classList.add('is-visible');
            setTimeout(function(){ toast.classList.remove('is-visible'); }, 1500);
        });
    });
})();
</script>
@endpush
