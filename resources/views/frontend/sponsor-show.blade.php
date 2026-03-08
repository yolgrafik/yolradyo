@extends('layouts.frontend')

@section('title', $sponsor->title ?? 'Sponsor')

@push('styles')
<style>
.sponsor-detail { max-width: 900px; margin: 0 auto; padding: 2rem 1rem; }
.sponsor-detail__image-wrap { width: 100%; margin-bottom: 1.5rem; border-radius: 14px; overflow: hidden; border: 1px solid var(--ry-border); border-top: 1px solid var(--ry-line-color); border-bottom: 1px solid var(--ry-line-color); background: rgba(255,255,255,0.03); }
.sponsor-detail__image-wrap img { width: 100%; max-height: 480px; object-fit: contain; object-position: center; display: block; }
.sponsor-detail__image-placeholder { width: 100%; aspect-ratio: 16/9; max-height: 320px; display: flex; align-items: center; justify-content: center; font-size: 4rem; font-weight: 800; color: var(--ry-schedule-active); background: rgba(255,255,255,0.04); }
.sponsor-name { font-size: 1.75rem; font-weight: 700; color: #fff; margin: 0 0 0.5rem 0; }
.sponsor-short { font-size: 1.05rem; color: var(--ry-text-muted); margin: 0 0 1rem 0; line-height: 1.6; }
.sponsor-social { display: flex; gap: 0.5rem; flex-wrap: wrap; align-items: center; margin-top: 1rem; }
.sponsor-social-link { display: inline-flex; align-items: center; justify-content: center; width: 40px; height: 40px; border-radius: 50%; box-shadow: 0 2px 6px rgba(0,0,0,0.3); text-decoration: none; transition: transform 0.2s; }
.sponsor-social-link:hover { transform: scale(1.1); }
.sponsor-social-link svg { width: 20px; height: 20px; }
.sponsor-social-link i { font-size: 1.25rem; }
.sponsor-social-link--web { background: rgba(255,255,255,0.15); color: var(--ry-text); }
.sponsor-social-link--web:hover { color: #fff; }
.sponsor-social-link--fb { background: #1877f2; color: #fff; }
.sponsor-social-link--ig { background: linear-gradient(45deg, #f09433, #e6683c, #dc2743, #cc2366, #bc1888); color: #fff; }
.sponsor-social-link--x { background: #000; color: #fff; }
.sponsor-social-link--yt { background: #ff0000; color: #fff; }
.sponsor-content { background: color-mix(in srgb, var(--ry-bar-bg) 75%, #0b0f16); border: 1px solid var(--ry-border); border-radius: 14px; padding: 1.5rem; margin-bottom: 2rem; }
.sponsor-content h3 { font-size: 1.1rem; color: #fff; margin: 0 0 1rem 0; }
.sponsor-description { color: var(--ry-text-muted); line-height: 1.7; white-space: pre-wrap; }
.sponsor-back { display: inline-flex; align-items: center; gap: 0.4rem; padding: 0.4rem 0.8rem; border-radius: 999px; border: 1px solid var(--ry-border); background: color-mix(in srgb, var(--ry-bar-bg) 76%, transparent); color: var(--ry-text); text-decoration: none; font-size: 0.85rem; font-weight: 700; margin-bottom: 1.5rem; transition: background 0.2s, border-color 0.2s; }
.sponsor-back:hover { background: color-mix(in srgb, var(--ry-btn-bg) 26%, transparent); border-color: var(--ry-line-color); }
.sponsor-video-embed { position: relative; width: 100%; padding-bottom: 56.25%; height: 0; overflow: hidden; border-radius: 10px; background: #000; }
.sponsor-video-embed iframe { position: absolute; top: 0; left: 0; width: 100%; height: 100%; }
.sponsor-video-mp4 video { border-radius: 10px; max-width: 100%; background: #000; }
.sponsor-share { margin-top: 1.5rem; display: flex; align-items: center; flex-wrap: wrap; gap: 0.55rem; }
.sponsor-share__label { font-size: 0.8rem; color: var(--ry-text-muted); margin-right: 0.2rem; }
.sponsor-share-btn { display: inline-flex; align-items: center; justify-content: flex-start; gap: 0.45rem; min-height: 36px; padding: 0.45rem 0.75rem; border-radius: 999px; border: 1px solid var(--ry-border); color: #fff; text-decoration: none; font-size: 0.8rem; font-weight: 700; background: color-mix(in srgb, var(--ry-bar-bg) 72%, transparent); transition: transform 0.2s ease, border-color 0.2s ease, background 0.2s ease, box-shadow 0.2s ease; white-space: nowrap; cursor: pointer; font-family: inherit; }
.sponsor-share-btn svg { width: 16px; height: 16px; display: block; flex-shrink: 0; }
.sponsor-share-btn:hover { transform: translateY(-1px); box-shadow: 0 6px 16px rgba(0,0,0,0.22); }
.sponsor-share-btn--facebook { border-color: color-mix(in srgb, #1877F2 55%, var(--ry-border)); }
.sponsor-share-btn--facebook:hover { background: #1877F2; border-color: #1877F2; color: #fff; }
.sponsor-share-btn--x { border-color: color-mix(in srgb, #000 55%, var(--ry-border)); }
.sponsor-share-btn--x:hover { background: #000; border-color: #000; color: #fff; }
.sponsor-share-btn--whatsapp { border-color: color-mix(in srgb, #25D366 55%, var(--ry-border)); }
.sponsor-share-btn--whatsapp:hover { background: #25D366; border-color: #25D366; color: #fff; }
.sponsor-share-btn--telegram { border-color: color-mix(in srgb, #229ED9 55%, var(--ry-border)); }
.sponsor-share-btn--telegram:hover { background: #229ED9; border-color: #229ED9; color: #fff; }
.sponsor-share-btn--copy { border-color: color-mix(in srgb, #9ca3af 45%, var(--ry-border)); }
.sponsor-share-btn--copy:hover { background: color-mix(in srgb, var(--ry-btn-bg) 45%, transparent); }
.sponsor-share-toast { position: fixed; left: 50%; bottom: 18px; transform: translateX(-50%) translateY(8px); padding: 0.5rem 0.85rem; border-radius: 999px; background: rgba(0,0,0,0.82); color: #fff; font-size: 0.78rem; z-index: 10000; opacity: 0; pointer-events: none; transition: opacity 0.2s ease, transform 0.2s ease; }
.sponsor-share-toast.is-visible { opacity: 1; transform: translateX(-50%) translateY(0); }
@media (max-width: 640px) {
    .sponsor-detail__image-wrap img { max-height: 360px; }
}
</style>
@endpush

@section('content')
<div class="sponsor-detail">
    <a href="{{ url('/') }}#sponsors" class="sponsor-back">← Ana Sayfa</a>

    @if($sponsor->image_path ?? null)
        <div class="sponsor-detail__image-wrap">
            <img src="{{ asset($sponsor->image_path) }}" alt="{{ $sponsor->title ?? 'Sponsor' }}">
        </div>
    @else
        <div class="sponsor-detail__image-wrap">
            <div class="sponsor-detail__image-placeholder">{{ mb_substr($sponsor->title ?? '', 0, 1) }}</div>
        </div>
    @endif

    <h1 class="sponsor-name">{{ $sponsor->title ?? 'Sponsor' }}</h1>
    @if(!empty($sponsor->short_description))
        <p class="sponsor-short">{{ $sponsor->short_description }}</p>
    @endif

    @if(!empty($sponsor->description))
    <div class="sponsor-content">
        <h3>Hakkında</h3>
        <div class="sponsor-description">{!! nl2br(e($sponsor->description)) !!}</div>
    </div>
    @endif

    <div class="sponsor-social">
                @if(!empty($sponsor->website_url))
                    <a href="{{ $sponsor->website_url }}" target="_blank" rel="noopener noreferrer" class="sponsor-social-link sponsor-social-link--web" title="Web Sitesi" aria-label="Web Sitesi"><i class="bi bi-globe"></i></a>
                @endif
                @if(!empty($sponsor->facebook_url))
                    <a href="{{ $sponsor->facebook_url }}" target="_blank" rel="noopener noreferrer" class="sponsor-social-link sponsor-social-link--fb" title="Facebook" aria-label="Facebook"><svg viewBox="0 0 24 24" width="24" height="24"><path fill="currentColor" d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg></a>
                @endif
                @if(!empty($sponsor->instagram_url))
                    <a href="{{ $sponsor->instagram_url }}" target="_blank" rel="noopener noreferrer" class="sponsor-social-link sponsor-social-link--ig" title="Instagram" aria-label="Instagram"><svg viewBox="0 0 24 24" width="24" height="24"><path fill="currentColor" d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg></a>
                @endif
                @if(!empty($sponsor->x_url))
                    <a href="{{ $sponsor->x_url }}" target="_blank" rel="noopener noreferrer" class="sponsor-social-link sponsor-social-link--x" title="X (Twitter)" aria-label="X"><svg viewBox="0 0 24 24" width="24" height="24"><path fill="currentColor" d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg></a>
                @endif
                @if(!empty($sponsor->youtube_url))
                    <a href="{{ $sponsor->youtube_url }}" target="_blank" rel="noopener noreferrer" class="sponsor-social-link sponsor-social-link--yt" title="YouTube" aria-label="YouTube"><svg viewBox="0 0 24 24" width="24" height="24"><path fill="currentColor" d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/></svg></a>
                @endif
    </div>

    @if($sponsor->hasVideo())
    <div class="sponsor-video-section sponsor-content">
        <h3>Video</h3>
        @if(($sponsor->video_type ?? '') === 'youtube' && $sponsor->getYouTubeVideoId())
            <div class="sponsor-video-embed">
                <iframe src="https://www.youtube.com/embed/{{ $sponsor->getYouTubeVideoId() }}" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen title="{{ $sponsor->title ?? '' }} video"></iframe>
            </div>
        @elseif(($sponsor->video_type ?? '') === 'mp4' && !empty($sponsor->video_path))
            <div class="sponsor-video-mp4">
                <video controls width="100%" preload="metadata" poster="">
                    <source src="{{ asset($sponsor->video_path) }}" type="video/mp4">
                    Tarayıcınız video oynatmayı desteklemiyor.
                </video>
            </div>
        @endif
    </div>
    @endif

    @php
        $shareUrl = route('sponsor.show', $sponsor);
        $shareText = $sponsor->title ?? 'Sponsor';
        $encodedUrl = urlencode($shareUrl);
        $encodedText = urlencode($shareText);
    @endphp
    <div class="sponsor-share" data-share-url="{{ $shareUrl }}">
        <span class="sponsor-share__label">Paylaş:</span>
        <a class="sponsor-share-btn sponsor-share-btn--facebook" target="_blank" rel="noopener noreferrer" href="https://www.facebook.com/sharer/sharer.php?u={{ $encodedUrl }}" aria-label="Facebook">
            <svg viewBox="0 0 24 24" width="16" height="16"><path fill="currentColor" d="M22.675 0H1.325C.593 0 0 .593 0 1.326v21.348C0 23.407.593 24 1.325 24h11.495v-9.294H9.692V11.08h3.128V8.413c0-3.1 1.894-4.788 4.659-4.788 1.325 0 2.463.099 2.795.143v3.24h-1.918c-1.505 0-1.796.715-1.796 1.764v2.31h3.588l-.467 3.625H16.56V24h6.115C23.407 24 24 23.407 24 22.674V1.326C24 .593 23.407 0 22.675 0z"/></svg>
            <span>Facebook</span>
        </a>
        <a class="sponsor-share-btn sponsor-share-btn--x" target="_blank" rel="noopener noreferrer" href="https://twitter.com/intent/tweet?url={{ $encodedUrl }}&text={{ $encodedText }}" aria-label="X (Twitter)">
            <svg viewBox="0 0 24 24" width="16" height="16"><path fill="currentColor" d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>
            <span>X</span>
        </a>
        <a class="sponsor-share-btn sponsor-share-btn--whatsapp" target="_blank" rel="noopener noreferrer" href="https://wa.me/?text={{ urlencode($shareText . ' ' . $shareUrl) }}" aria-label="WhatsApp">
            <svg viewBox="0 0 24 24" width="16" height="16"><path fill="currentColor" d="M20.52 3.48A11.82 11.82 0 0 0 12.08 0C5.53 0 .18 5.36.18 11.93c0 2.1.55 4.15 1.6 5.95L0 24l6.3-1.65a11.83 11.83 0 0 0 5.78 1.48h.01c6.55 0 11.9-5.36 11.9-11.93 0-3.19-1.23-6.19-3.47-8.42zM12.1 21.82h-.01a9.84 9.84 0 0 1-5.01-1.37l-.36-.21-3.74.98 1-3.64-.24-.37a9.85 9.85 0 0 1-1.54-5.28c0-5.47 4.45-9.92 9.92-9.92 2.65 0 5.13 1.03 7 2.9a9.84 9.84 0 0 1 2.9 7c0 5.47-4.45 9.92-9.92 9.92zm5.44-7.43c-.3-.15-1.78-.88-2.06-.98-.27-.1-.47-.15-.66.15-.2.3-.76.98-.93 1.18-.17.2-.35.22-.65.07-.3-.15-1.26-.46-2.4-1.47-.89-.79-1.48-1.77-1.66-2.07-.17-.3-.02-.46.13-.61.13-.13.3-.35.45-.52.15-.17.2-.3.3-.5.1-.2.05-.37-.02-.52-.08-.15-.67-1.61-.92-2.2-.24-.58-.48-.5-.66-.5h-.56c-.2 0-.52.07-.79.37s-1.04 1.02-1.04 2.48c0 1.46 1.07 2.87 1.22 3.07.15.2 2.1 3.21 5.09 4.5.71.31 1.27.5 1.7.64.71.22 1.36.19 1.87.11.57-.08 1.78-.73 2.03-1.43.25-.7.25-1.3.17-1.43-.07-.13-.27-.2-.57-.35z"/></svg>
            <span>WhatsApp</span>
        </a>
        <a class="sponsor-share-btn sponsor-share-btn--telegram" target="_blank" rel="noopener noreferrer" href="https://t.me/share/url?url={{ $encodedUrl }}&text={{ $encodedText }}" aria-label="Telegram">
            <svg viewBox="0 0 24 24" width="16" height="16"><path fill="currentColor" d="M9.78 17.57l-.4 5.63c.57 0 .81-.25 1.1-.54l2.64-2.52 5.48 4.01c1 .56 1.71.27 1.98-.92l3.6-16.86h.01c.31-1.45-.52-2.01-1.5-1.64L1.54 12.2C.12 12.75.14 13.54 1.3 13.9l5.44 1.7L19.37 7.4c.6-.4 1.15-.18.7.22L9.78 17.57z"/></svg>
            <span>Telegram</span>
        </a>
        <button type="button" class="sponsor-share-btn sponsor-share-btn--copy js-sponsor-copy-link" aria-label="Link kopyala">
            <svg viewBox="0 0 24 24" width="16" height="16"><path fill="currentColor" d="M16 1H4a2 2 0 0 0-2 2v12h2V3h12V1zm3 4H8a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h11a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2zm0 16H8V7h11v14z"/></svg>
            <span>Link Kopyala</span>
        </button>
    </div>
</div>
<div id="sponsorShareToast" class="sponsor-share-toast" role="status" aria-live="polite">Bağlantı kopyalandı</div>
@endsection

@push('scripts')
<script>
(function(){
    var btn = document.querySelector('.js-sponsor-copy-link');
    var toast = document.getElementById('sponsorShareToast');
    var timer = null;
    if (!btn || !toast) return;
    btn.addEventListener('click', function(){
        var parent = btn.closest('[data-share-url]');
        var url = parent ? parent.getAttribute('data-share-url') : window.location.href;
        if (navigator.clipboard && navigator.clipboard.writeText) {
            navigator.clipboard.writeText(url).then(function(){
                toast.classList.add('is-visible');
                if (timer) clearTimeout(timer);
                timer = setTimeout(function(){ toast.classList.remove('is-visible'); }, 1400);
            });
        } else {
            var ta = document.createElement('textarea');
            ta.value = url;
            ta.style.position = 'fixed';
            ta.style.left = '-9999px';
            document.body.appendChild(ta);
            ta.select();
            document.execCommand('copy');
            document.body.removeChild(ta);
            toast.classList.add('is-visible');
            if (timer) clearTimeout(timer);
            timer = setTimeout(function(){ toast.classList.remove('is-visible'); }, 1400);
        }
    });
})();
</script>
@endpush
