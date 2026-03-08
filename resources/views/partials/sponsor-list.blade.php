@php
    $sponsors = $sponsors ?? collect();
@endphp
@if($sponsors->isNotEmpty())
<div class="sponsor-list-grid" aria-label="Sponsor listesi">
    @foreach($sponsors as $sponsor)
    <article class="sponsor-list-card">
        <div class="sponsor-list-card__inner">
            <div class="sponsor-list-card__media">
                @if($sponsor->hasVideo())
                    @php
                        $vid = $sponsor->getYouTubeVideoId();
                        $poster = $sponsor->getVideoPosterUrl();
                    @endphp
                    <div class="sponsor-list-card__video-wrap" data-video-type="{{ $sponsor->video_type ?? '' }}" data-video-id="{{ $vid ?? '' }}" data-video-src="{{ ($sponsor->video_type ?? '') === 'mp4' ? asset($sponsor->video_path ?? '') : '' }}">
                        <div class="sponsor-list-card__video-preview">
                            @if($poster)
                                <img src="{{ $poster }}" alt="" class="sponsor-list-card__video-thumb">
                            @else
                                <div class="sponsor-list-card__video-fallback"></div>
                            @endif
                            <button type="button" class="sponsor-list-card__video-play-btn" aria-label="Video oynat"><i class="bi bi-play-circle-fill"></i></button>
                        </div>
                        <div class="sponsor-list-card__video-player" style="display:none;">
                            @if(($sponsor->video_type ?? '') === 'youtube' && $vid)
                                <iframe allow="accelerometer;autoplay;clipboard-write;encrypted-media;gyroscope;picture-in-picture" allowfullscreen></iframe>
                                <button type="button" class="sponsor-list-card__video-close" aria-label="Kapat"><i class="bi bi-x-lg"></i></button>
                            @elseif(($sponsor->video_type ?? '') === 'mp4' && !empty($sponsor->video_path))
                                <video playsinline controls></video>
                                <button type="button" class="sponsor-list-card__video-close" aria-label="Kapat"><i class="bi bi-x-lg"></i></button>
                            @endif
                        </div>
                    </div>
                @elseif($sponsor->getFirstImagePath())
                    @php $firstImg = $sponsor->getFirstImagePath(); @endphp
                    <button type="button" class="sponsor-list-card__img-btn js-sponsor-list-lightbox" data-src="{{ asset($firstImg) }}" data-alt="{{ addslashes($sponsor->title ?? '') }}" aria-label="Görseli büyüt">
                        <img src="{{ asset($firstImg) }}" alt="{{ $sponsor->title ?? '' }}" class="sponsor-list-card__img">
                    </button>
                @else
                    <div class="sponsor-list-card__img-placeholder">{{ mb_substr($sponsor->title ?? '', 0, 1) }}</div>
                @endif
            </div>
            <div class="sponsor-list-card__body">
                <h3 class="sponsor-list-card__title">{{ $sponsor->title ?? 'Sponsor' }}</h3>
                @if(!empty($sponsor->short_description))
                    <p class="sponsor-list-card__desc">{{ \Illuminate\Support\Str::limit($sponsor->short_description, 150) }}</p>
                @endif
                <div class="sponsor-list-card__footer">
                    @if($sponsor->slug ?? null)
                        <a href="{{ route('sponsor.show', $sponsor) }}" class="sponsor-list-card__detail-btn">Sponsor Detayı</a>
                    @endif
                    <div class="sponsor-list-card__links">
                        @if(!empty($sponsor->website_url))<a class="sponsor-list-social-btn sponsor-list-social-btn--web" href="{{ $sponsor->website_url }}" target="_blank" rel="noopener noreferrer" title="Web Sitesi" aria-label="Web Sitesi"><i class="bi bi-globe"></i></a>@endif
                        @if(!empty($sponsor->facebook_url))<a class="sponsor-list-social-btn sponsor-list-social-btn--fb" href="{{ $sponsor->facebook_url }}" target="_blank" rel="noopener noreferrer" title="Facebook" aria-label="Facebook"><svg viewBox="0 0 24 24" width="18" height="18"><path fill="currentColor" d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg></a>@endif
                        @if(!empty($sponsor->instagram_url))<a class="sponsor-list-social-btn sponsor-list-social-btn--ig" href="{{ $sponsor->instagram_url }}" target="_blank" rel="noopener noreferrer" title="Instagram" aria-label="Instagram"><svg viewBox="0 0 24 24" width="18" height="18"><path fill="currentColor" d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg></a>@endif
                        @if(!empty($sponsor->x_url))<a class="sponsor-list-social-btn sponsor-list-social-btn--x" href="{{ $sponsor->x_url }}" target="_blank" rel="noopener noreferrer" title="X" aria-label="X"><svg viewBox="0 0 24 24" width="18" height="18"><path fill="currentColor" d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg></a>@endif
                        @if(!empty($sponsor->youtube_url))<a class="sponsor-list-social-btn sponsor-list-social-btn--yt" href="{{ $sponsor->youtube_url }}" target="_blank" rel="noopener noreferrer" title="YouTube" aria-label="YouTube"><svg viewBox="0 0 24 24" width="18" height="18"><path fill="currentColor" d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/></svg></a>@endif
                    </div>
                </div>
            </div>
        </div>
    </article>
    @endforeach
</div>

<div id="sponsorListLightbox" class="sponsor-list-lightbox" role="dialog" aria-modal="true" aria-label="Sponsor görseli" aria-hidden="true" style="display:none;">
    <div class="sponsor-list-lightbox__backdrop"></div>
    <div class="sponsor-list-lightbox__content">
        <button type="button" class="sponsor-list-lightbox__close" aria-label="Kapat"><i class="bi bi-x-lg"></i></button>
        <img src="" alt="" class="sponsor-list-lightbox__img">
    </div>
</div>

@push('styles')
<style>
.sponsor-list-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 1.25rem; }
.sponsor-list-card { background: color-mix(in srgb, var(--ry-bar-bg) 75%, #0b0f16); border: 1px solid var(--ry-border); border-radius: 12px; overflow: hidden; border-top: 1px solid var(--ry-line-color); border-bottom: 1px solid var(--ry-line-color); transition: border-color 0.2s, box-shadow 0.2s; }
.sponsor-list-card:hover { border-color: color-mix(in srgb, var(--ry-schedule-active) 60%, var(--ry-border)); box-shadow: 0 6px 16px rgba(0,0,0,.25); }
.sponsor-list-card__inner { display: flex; flex-direction: column; height: 100%; }
.sponsor-list-card__media { position: relative; width: 100%; aspect-ratio: 16/10; background: #111827; overflow: hidden; }
.sponsor-list-card__img-btn { all: unset; cursor: pointer; display: block; width: 100%; height: 100%; line-height: 0; }
.sponsor-list-card__img { width: 100%; height: 100%; object-fit: cover; object-position: center; display: block; }
.sponsor-list-card__img-placeholder { width: 100%; height: 100%; min-height: 120px; display: flex; align-items: center; justify-content: center; font-size: 2.5rem; font-weight: 800; color: var(--ry-schedule-active); background: #111827; }
.sponsor-list-card__video-wrap { position: absolute; inset: 0; width: 100%; height: 100%; }
.sponsor-list-card__video-preview { position: absolute; inset: 0; cursor: pointer; display: flex; align-items: center; justify-content: center; }
.sponsor-list-card__video-thumb { width: 100%; height: 100%; object-fit: cover; display: block; }
.sponsor-list-card__video-fallback { position: absolute; inset: 0; background: linear-gradient(135deg, #1a1a2e, #16213e); }
.sponsor-list-card__video-play-btn { position: absolute; inset: 0; margin: auto; width: 56px; height: 56px; border: none; background: rgba(0,0,0,.6); color: #fff; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 28px; cursor: pointer; z-index: 2; transition: transform 0.2s, background 0.2s; }
.sponsor-list-card__video-play-btn:hover { transform: scale(1.1); background: rgba(0,0,0,.8); }
.sponsor-list-card__video-player { position: absolute; inset: 0; width: 100%; height: 100%; z-index: 3; background: #000; }
.sponsor-list-card__video-player iframe, .sponsor-list-card__video-player video { width: 100%; height: 100%; object-fit: contain; display: block; }
.sponsor-list-card__video-close { position: absolute; top: 4px; right: 4px; width: 28px; height: 28px; border: none; background: rgba(0,0,0,.7); color: #fff; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 12px; cursor: pointer; z-index: 4; }
.sponsor-list-card__body { padding: 1rem; display: flex; flex-direction: column; gap: 0.5rem; flex: 1; min-height: 0; }
.sponsor-list-card__title { margin: 0; font-size: 1rem; font-weight: 700; color: var(--ry-text); line-height: 1.3; }
.sponsor-list-card__desc { margin: 0; font-size: 0.85rem; color: var(--ry-text-muted); line-height: 1.45; display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical; overflow: hidden; }
.sponsor-list-card__footer { display: flex; align-items: center; justify-content: space-between; gap: 0.5rem; margin-top: auto; padding-top: 0.75rem; min-height: 36px; }
.sponsor-list-card__detail-btn { display: inline-flex; align-items: center; justify-content: center; padding: 0.4rem 0.9rem; font-size: 0.8rem; font-weight: 700; background: var(--ry-schedule-active); color: #fff; border-radius: 6px; text-decoration: none; transition: opacity 0.2s; flex-shrink: 0; }
.sponsor-list-card__detail-btn:hover { opacity: 0.9; color: #fff; }
.sponsor-list-card__links { display: flex; flex-wrap: wrap; gap: 0.35rem; align-items: center; margin-left: auto; }
.sponsor-list-social-btn { display: inline-flex; align-items: center; justify-content: center; width: 32px; height: 32px; border-radius: 50%; box-shadow: 0 2px 6px rgba(0,0,0,0.3); text-decoration: none; transition: transform 0.2s; }
.sponsor-list-social-btn:hover { transform: scale(1.1); }
.sponsor-list-social-btn svg { width: 16px; height: 16px; }
.sponsor-list-social-btn i { font-size: 16px; }
.sponsor-list-social-btn--web { background: rgba(255,255,255,0.15); color: var(--ry-text); }
.sponsor-list-social-btn--web:hover { color: #fff; }
.sponsor-list-social-btn--fb { background: #1877f2; color: #fff; }
.sponsor-list-social-btn--ig { background: linear-gradient(45deg, #f09433, #e6683c, #dc2743, #cc2366, #bc1888); color: #fff; }
.sponsor-list-social-btn--x { background: #000; color: #fff; }
.sponsor-list-social-btn--yt { background: #ff0000; color: #fff; }
.sponsor-list-lightbox { position: fixed; inset: 0; z-index: 9999; display: flex; align-items: center; justify-content: center; padding: 2rem; }
.sponsor-list-lightbox.is-open { display: flex; }
.sponsor-list-lightbox__backdrop { position: absolute; inset: 0; background: rgba(0,0,0,.9); cursor: pointer; }
.sponsor-list-lightbox__content { position: relative; max-width: 95vw; max-height: 90vh; z-index: 1; }
.sponsor-list-lightbox__close { position: absolute; top: -44px; right: 0; width: 40px; height: 40px; border: none; border-radius: 50%; background: rgba(255,255,255,.2); color: #fff; font-size: 22px; cursor: pointer; display: flex; align-items: center; justify-content: center; z-index: 10; }
.sponsor-list-lightbox__close:hover { background: rgba(255,255,255,.35); }
.sponsor-list-lightbox__img { max-width: 100%; max-height: 85vh; object-fit: contain; border-radius: 8px; display: block; }
@media (max-width: 640px) {
    .sponsor-list-grid { grid-template-columns: 1fr; gap: 1rem; }
    .sponsor-list-card__media { aspect-ratio: 16/9; }
}
</style>
@endpush
@push('scripts')
<script>
(function(){
    document.querySelectorAll('.js-sponsor-list-lightbox').forEach(function(btn){
        btn.addEventListener('click', function(){
            var src = btn.getAttribute('data-src');
            var alt = btn.getAttribute('data-alt') || '';
            var lb = document.getElementById('sponsorListLightbox');
            var img = lb ? lb.querySelector('.sponsor-list-lightbox__img') : null;
            if (lb && img && src) {
                img.src = src; img.alt = alt;
                lb.style.display = 'flex'; lb.classList.add('is-open');
                document.body.style.overflow = 'hidden';
            }
        });
    });
    var lb = document.getElementById('sponsorListLightbox');
    if (lb) {
        var closeFn = function(){ lb.style.display = 'none'; lb.classList.remove('is-open'); document.body.style.overflow = ''; };
        var closeBtn = lb.querySelector('.sponsor-list-lightbox__close');
        var backdrop = lb.querySelector('.sponsor-list-lightbox__backdrop');
        if (closeBtn) closeBtn.addEventListener('click', closeFn);
        if (backdrop) backdrop.addEventListener('click', closeFn);
        document.addEventListener('keydown', function(e){ if (e.key === 'Escape' && lb && (lb.style.display === 'flex' || lb.classList.contains('is-open'))) closeFn(); });
    }
    document.querySelectorAll('.sponsor-list-card__video-wrap').forEach(function(wrap){
        var preview = wrap.querySelector('.sponsor-list-card__video-preview');
        var player = wrap.querySelector('.sponsor-list-card__video-player');
        var playBtn = wrap.querySelector('.sponsor-list-card__video-play-btn');
        var closeBtn = wrap.querySelector('.sponsor-list-card__video-close');
        var type = wrap.getAttribute('data-video-type');
        var id = wrap.getAttribute('data-video-id');
        var src = wrap.getAttribute('data-video-src');
        function showPlayer(){
            if (!player || !preview) return;
            preview.style.display = 'none';
            player.style.display = 'block';
            if (type === 'youtube' && id) {
                var iframe = player.querySelector('iframe');
                if (iframe) iframe.src = 'https://www.youtube.com/embed/' + id + '?autoplay=1';
            } else if (type === 'mp4' && src) {
                var video = player.querySelector('video');
                if (video) { video.src = src; video.play(); }
            }
        }
        function hidePlayer(){
            if (!player || !preview) return;
            player.style.display = 'none';
            preview.style.display = 'flex';
            var iframe = player.querySelector('iframe');
            if (iframe) iframe.src = '';
            var video = player.querySelector('video');
            if (video) { video.pause(); video.src = ''; }
        }
        if (playBtn) playBtn.addEventListener('click', showPlayer);
        if (closeBtn) closeBtn.addEventListener('click', hidePlayer);
    });
})();
</script>
@endpush
@endif
