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
.video-share{margin-top:1rem;display:flex;gap:8px;flex-wrap:wrap;}
.video-share__btn{display:inline-flex;align-items:center;justify-content:center;padding:.55rem .85rem;border-radius:8px;text-decoration:none;font-size:.82rem;font-weight:700;background:rgba(255,255,255,.08);color:var(--text);border:1px solid var(--border);cursor:pointer;}
.video-share__btn:hover{border-color:var(--ry-schedule-active);}
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
            $shareUrl = urlencode(request()->fullUrl());
            $shareText = urlencode($video->title . ' - RadyoYol Video Galeri');
        @endphp
        <div class="video-share">
            <a class="video-share__btn" target="_blank" rel="noopener noreferrer" href="https://wa.me/?text={{ $shareText }}%20{{ $shareUrl }}">WhatsApp</a>
            <a class="video-share__btn" target="_blank" rel="noopener noreferrer" href="https://www.facebook.com/sharer/sharer.php?u={{ $shareUrl }}">Facebook</a>
            <a class="video-share__btn" target="_blank" rel="noopener noreferrer" href="https://twitter.com/intent/tweet?text={{ $shareText }}&url={{ $shareUrl }}">X/Twitter</a>
            <a class="video-share__btn" target="_blank" rel="noopener noreferrer" href="https://t.me/share/url?url={{ $shareUrl }}&text={{ $shareText }}">Telegram</a>
            <button type="button" class="video-share__btn" id="copyVideoLinkBtn">Link Kopyala</button>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
(function(){
    var btn = document.getElementById('copyVideoLinkBtn');
    if (!btn) return;
    btn.addEventListener('click', function(){
        navigator.clipboard.writeText(window.location.href).then(function(){
            btn.textContent = 'Kopyalandı';
            setTimeout(function(){ btn.textContent = 'Link Kopyala'; }, 1400);
        });
    });
})();
</script>
@endpush
