@php
    $listenerSubmissions = $listenerSubmissions ?? collect();
@endphp
@if($listenerSubmissions->isNotEmpty())
<div class="listener-widget">
    <div class="listener-widget__header">
        <span class="listener-widget__title">Dinleyicilerden Gelenler</span>
    </div>
    <div class="listener-widget__body">
        <div class="listener-swiper-wrap">
            <div class="swiper listener-swiper" id="listenerSwiper">
                <div class="swiper-wrapper">
                    @foreach($listenerSubmissions as $item)
                    <div class="swiper-slide">
                        <div class="listener-slide">
                            @if($item->type === 'photo' && $item->file_path)
                                <div class="listener-slide__media listener-slide__media--photo">
                                    <img src="{{ $item->media_url }}" alt="{{ $item->title }}" class="listener-slide__img" draggable="false" oncontextmenu="return false;">
                                    <div class="listener-slide__caption">
                                        <span class="listener-slide__name">{{ $item->user->name ?? 'Dinleyici' }}</span>
                                        @if($item->title)<span class="listener-slide__title">{{ Str::limit($item->title, 40) }}</span>@endif
                                        @if($item->body)<span class="listener-slide__desc">{{ Str::limit($item->body, 60) }}</span>@endif
                                    </div>
                                </div>
                            @elseif($item->type === 'video')
                                @php
                                    $thumbUrl = $item->video_thumbnail_url ?? null;
                                    $embedUrl = null;
                                    if ($item->video_url && preg_match('#(?:youtube\.com/watch\?v=|youtu\.be/|youtube\.com/embed/)([a-zA-Z0-9_-]{11})#', $item->video_url, $m)) {
                                        $embedUrl = 'https://www.youtube.com/embed/' . $m[1] . '?autoplay=1';
                                    }
                                    $videoSrc = $item->file_path ? $item->media_url : null;
                                    $playSrc = $embedUrl ?? $videoSrc;
                                @endphp
                                <div class="listener-slide__media listener-slide__media--video{{ $playSrc ? ' js-video-play' : '' }}" @if($playSrc) data-video-src="{{ $playSrc }}" data-video-type="{{ $embedUrl ? 'embed' : 'file' }}" @endif>
                                    <div class="listener-slide__thumb" @if($thumbUrl) style="background-image: url('{{ $thumbUrl }}');" @endif>
                                        <span class="listener-slide__play" aria-hidden="true">▶</span>
                                    </div>
                                    <div class="listener-slide__caption">
                                        <span class="listener-slide__name">{{ $item->user->name ?? 'Dinleyici' }}</span>
                                        @if($item->title)<span class="listener-slide__title">{{ Str::limit($item->title, 40) }}</span>@endif
                                        @if($item->body)<span class="listener-slide__desc">{{ Str::limit($item->body, 60) }}</span>@endif
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                    @endforeach
                </div>
                <div class="swiper-button-prev listener-swiper-btn listener-swiper-btn--prev" aria-label="Önceki"></div>
                <div class="swiper-button-next listener-swiper-btn listener-swiper-btn--next" aria-label="Sonraki"></div>
                <div class="swiper-pagination listener-swiper-pagination"></div>
            </div>
        </div>
    </div>
</div>
@push('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css">
<style>
.listener-slide__media { display: block; width: 100%; }
.listener-slide__media--photo .listener-slide__img { pointer-events: none; user-select: none; -webkit-user-drag: none; }
.listener-slide__media--video { cursor: pointer; }
.listener-slide__media--video .listener-slide__thumb { cursor: pointer; }
.listener-slide__video-player { width: 100%; aspect-ratio: 16/10; background: #000; display: none; }
.listener-slide__video-player.is-playing { display: block; }
.listener-slide__video-player video { width: 100%; height: 100%; object-fit: contain; }
.listener-slide__video-player iframe { width: 100%; height: 100%; border: none; }
.listener-slide__media--video.is-playing .listener-slide__thumb { display: none; }
</style>
@endpush
@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
<script>
(function(){
    var el = document.getElementById('listenerSwiper');
    if (!el) return;
    var slideCount = el.querySelectorAll('.swiper-slide').length;
    if (slideCount < 1) return;
    new Swiper('#listenerSwiper', {
        loop: true,
        slidesPerView: 1,
        slidesPerGroup: 1,
        spaceBetween: 12,
        speed: 400,
        autoplay: { delay: 3500, disableOnInteraction: false },
        watchOverflow: false,
        navigation: {
            nextEl: '.listener-swiper-btn--next',
            prevEl: '.listener-swiper-btn--prev',
        },
        pagination: {
            el: '.listener-swiper-pagination',
            clickable: true,
        },
    });
    document.querySelectorAll('.listener-slide__media--video.js-video-play').forEach(function(media) {
        media.addEventListener('click', function(e) {
            if (media.classList.contains('is-playing')) return;
            var src = media.getAttribute('data-video-src');
            var type = media.getAttribute('data-video-type');
            if (!src) return;
            var thumb = media.querySelector('.listener-slide__thumb');
            var player = media.querySelector('.listener-slide__video-player');
            if (player) return;
            player = document.createElement('div');
            player.className = 'listener-slide__video-player is-playing';
            if (type === 'embed') {
                var iframe = document.createElement('iframe');
                iframe.src = src;
                iframe.allow = 'accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture';
                iframe.allowFullscreen = true;
                player.appendChild(iframe);
            } else {
                var video = document.createElement('video');
                video.src = src;
                video.controls = true;
                video.autoplay = true;
                video.playsInline = true;
                player.appendChild(video);
            }
            thumb.parentNode.insertBefore(player, thumb);
            media.classList.add('is-playing');
        });
    });
})();
</script>
@endpush
@endif
