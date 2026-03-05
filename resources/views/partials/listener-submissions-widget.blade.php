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
                            @if($item->type === 'image' && $item->file_path)
                                <a href="{{ $item->media_url }}" target="_blank" rel="noopener" class="listener-slide__link">
                                    <img src="{{ $item->media_url }}" alt="{{ $item->title }}" class="listener-slide__img">
                                    <div class="listener-slide__caption">
                                        <span class="listener-slide__name">{{ $item->user->name ?? 'Dinleyici' }}</span>
                                        @if($item->title)<span class="listener-slide__title">{{ Str::limit($item->title, 40) }}</span>@endif
                                    </div>
                                </a>
                            @elseif($item->type === 'video')
                                @php
                                    $videoUrl = $item->video_url ?: $item->media_url;
                                    $thumbUrl = $item->video_thumbnail_url ?? null;
                                @endphp
                                <a href="{{ $videoUrl }}" target="_blank" rel="noopener" class="listener-slide__link listener-slide__link--video">
                                    <div class="listener-slide__thumb" @if($thumbUrl) style="background-image: url('{{ $thumbUrl }}');" @endif>
                                        <span class="listener-slide__play" aria-hidden="true">▶</span>
                                    </div>
                                    <div class="listener-slide__caption">
                                        <span class="listener-slide__name">{{ $item->user->name ?? 'Dinleyici' }}</span>
                                        @if($item->title)<span class="listener-slide__title">{{ Str::limit($item->title, 40) }}</span>@endif
                                    </div>
                                </a>
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
})();
</script>
@endpush
@endif
