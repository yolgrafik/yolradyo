@extends('layouts.frontend')

@section('title', $sponsor->title ?? 'Sponsor')

@push('styles')
<style>
.sponsor-detail { max-width: 900px; margin: 0 auto; padding: 2rem 1rem; }
.sponsor-hero { display: flex; align-items: flex-start; gap: 1.5rem; margin-bottom: 2rem; flex-wrap: wrap; }
.sponsor-logo-wrap { flex-shrink: 0; width: 160px; height: 120px; border-radius: 12px; overflow: hidden; background: rgba(255,255,255,0.06); border: 1px solid var(--ry-border); display: flex; align-items: center; justify-content: center; }
.sponsor-logo-wrap img { width: 100%; height: 100%; object-fit: contain; padding: 0.5rem; }
.sponsor-logo-placeholder { width: 100%; height: 100%; display: flex; align-items: center; justify-content: center; font-size: 2.5rem; font-weight: 800; color: var(--ry-schedule-active); }
.sponsor-name { font-size: 1.75rem; font-weight: 700; color: #fff; margin: 0 0 0.35rem 0; }
.sponsor-short { font-size: 1rem; color: var(--ry-text-muted); margin: 0 0 1rem 0; line-height: 1.5; }
.sponsor-social { display: flex; gap: 0.5rem; flex-wrap: wrap; align-items: center; }
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
@media (max-width: 640px) {
    .sponsor-hero { flex-direction: column; }
    .sponsor-logo-wrap { width: 120px; height: 90px; }
}
</style>
@endpush

@section('content')
<div class="sponsor-detail">
    <a href="{{ url('/') }}#sponsors" class="sponsor-back">← Ana Sayfa</a>

    <div class="sponsor-hero">
        @if($sponsor->image_path ?? null)
            <div class="sponsor-logo-wrap">
                <img src="{{ asset($sponsor->image_path) }}" alt="{{ $sponsor->title }}">
            </div>
        @else
            <div class="sponsor-logo-wrap sponsor-logo-placeholder">{{ mb_substr($sponsor->title ?? '', 0, 1) }}</div>
        @endif
        <div style="flex: 1; min-width: 0;">
            <h1 class="sponsor-name">{{ $sponsor->title ?? 'Sponsor' }}</h1>
            @if(!empty($sponsor->short_description))
                <p class="sponsor-short">{{ $sponsor->short_description }}</p>
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
        </div>
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

    @if(!empty($sponsor->description))
    <div class="sponsor-content">
        <h3>Hakkında</h3>
        <div class="sponsor-description">{!! nl2br(e($sponsor->description)) !!}</div>
    </div>
    @endif
</div>
@endsection
