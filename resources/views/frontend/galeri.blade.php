@extends('layouts.frontend')

@section('title', 'Foto Galeri')

@push('styles')
<style>
.gallery-page{max-width:1180px;margin:0 auto;padding:1.25rem 1rem 2rem;}
.gallery-page__head{padding:.75rem 1rem;border-radius:var(--ry-radius);background:color-mix(in srgb, var(--ry-bar-bg) 85%, transparent);border:1px solid var(--ry-border);border-top:1px solid var(--ry-line-color);border-bottom:1px solid var(--ry-line-color);margin-bottom:1rem;}
.gallery-page__title{margin:0;font-size:clamp(.95rem,1.7vw,1.15rem);font-weight:700;color:var(--ry-text);line-height:1.3;letter-spacing:.01em;word-break:break-word;text-wrap:balance;}
.gallery-albums-grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(260px,1fr));gap:14px;}
.gallery-album-card{display:block;text-decoration:none;background:color-mix(in srgb, var(--ry-bar-bg) 75%, #0b0f16);border:1px solid var(--border);border-radius:12px;overflow:hidden;border-top:1px solid var(--ry-line-color);border-bottom:1px solid var(--ry-line-color);transition:transform .2s ease, box-shadow .2s ease,border-color .2s ease;}
.gallery-album-card:hover{transform:translateY(-3px);border-color:var(--ry-schedule-active);box-shadow:0 8px 20px rgba(0,0,0,.28);}
.gallery-album-card__cover{width:100%;aspect-ratio:16/10;object-fit:cover;display:block;background:#121826;}
.gallery-album-card__body{padding:.8rem;}
.gallery-album-card__title{margin:0;font-size:.92rem;font-weight:800;color:var(--ry-text);}
.gallery-album-card__desc{margin:.4rem 0 0;font-size:.78rem;color:var(--ry-text-muted);line-height:1.45;min-height:2.6em;}
.gallery-album-card__meta{margin-top:.45rem;font-size:.72rem;color:var(--muted);}
.gallery-section-title{margin:1.4rem 0 .7rem;font-size:.95rem;font-weight:800;color:var(--ry-text);}
.gallery-plain-grid{display:grid;grid-template-columns:repeat(2,minmax(0,1fr));gap:12px;align-items:stretch;}
.gallery-plain-grid--unassigned{grid-template-columns:repeat(4,minmax(0,1fr));}
.gallery-photo-card{background:color-mix(in srgb, var(--ry-bar-bg) 75%, #0b0f16);border:1px solid var(--border);border-radius:12px;overflow:hidden;border-top:1px solid var(--ry-line-color);border-bottom:1px solid var(--ry-line-color);}
.gallery-photo-card__img-btn{display:block;width:100%;padding:0;border:none;background:none;cursor:zoom-in;}
.gallery-photo-card img{width:100%;aspect-ratio:16/10;object-fit:cover;display:block;}
.gallery-photo-card__body{padding:.58rem .68rem;min-height:86px;}
.gallery-photo-card__title{margin:0;font-size:.84rem;font-weight:700;color:var(--ry-text);line-height:1.35;}
.gallery-photo-card__desc{margin:.3rem 0 0;font-size:.75rem;color:var(--ry-text-muted);line-height:1.4;display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;overflow:hidden;}
.gallery-share{margin-top:.55rem;display:flex;gap:.35rem;flex-wrap:wrap;}
.gallery-share-btn{display:inline-flex;align-items:center;justify-content:flex-start;gap:.3rem;min-height:28px;padding:.28rem .5rem;border-radius:999px;border:1px solid var(--ry-border);color:#fff;text-decoration:none;font-size:.68rem;font-weight:700;background:color-mix(in srgb, var(--ry-bar-bg) 72%, transparent);transition:transform .2s ease,border-color .2s ease,background .2s ease,box-shadow .2s ease;white-space:nowrap;cursor:pointer;}
.gallery-share-btn svg{width:13px;height:13px;display:block;flex-shrink:0;}
.gallery-share-btn:hover{transform:translateY(-1px);box-shadow:0 4px 12px rgba(0,0,0,.22);}
.gallery-share-btn--facebook{border-color:color-mix(in srgb, #1877F2 55%, var(--ry-border));}
.gallery-share-btn--facebook:hover{background:#1877F2;border-color:#1877F2;}
.gallery-share-btn--whatsapp{border-color:color-mix(in srgb, #25D366 55%, var(--ry-border));}
.gallery-share-btn--whatsapp:hover{background:#25D366;border-color:#25D366;}
.gallery-share-btn--telegram{border-color:color-mix(in srgb, #229ED9 55%, var(--ry-border));}
.gallery-share-btn--telegram:hover{background:#229ED9;border-color:#229ED9;}
.gallery-share-btn--messenger{border-color:color-mix(in srgb, #0084FF 55%, var(--ry-border));}
.gallery-share-btn--messenger:hover{background:#0084FF;border-color:#0084FF;}
.gallery-share-btn--copy{border-color:color-mix(in srgb, #9ca3af 45%, var(--ry-border));}
.gallery-share-btn--copy:hover{background:color-mix(in srgb, var(--ry-btn-bg) 45%, transparent);}
.gallery-share-toast{position:fixed;left:50%;bottom:18px;transform:translateX(-50%) translateY(8px);padding:.5rem .85rem;border-radius:999px;background:rgba(0,0,0,.82);color:#fff;font-size:.78rem;z-index:13000;opacity:0;pointer-events:none;transition:opacity .2s ease, transform .2s ease;}
.gallery-share-toast.is-visible{opacity:1;transform:translateX(-50%) translateY(0);}
.gallery-lightbox{position:fixed;inset:0;display:none;z-index:12000;}
.gallery-lightbox.is-open{display:block;}
.gallery-lightbox__backdrop{position:absolute;inset:0;background:rgba(0,0,0,.86);}
.gallery-lightbox__dialog{position:relative;max-width:min(1200px,94vw);max-height:90vh;margin:4vh auto;z-index:1;}
.gallery-lightbox__img{display:block;max-width:100%;max-height:90vh;margin:0 auto;border-radius:12px;border:1px solid rgba(255,255,255,.2);}
.gallery-lightbox__close{position:absolute;top:8px;right:8px;width:36px;height:36px;border-radius:50%;border:1px solid rgba(255,255,255,.35);background:rgba(0,0,0,.55);color:#fff;font-size:22px;line-height:1;cursor:pointer;z-index:2;}
.gallery-empty{padding:1rem;color:var(--ry-text-muted);}
@media (max-width: 1200px){
    .gallery-plain-grid--unassigned{grid-template-columns:repeat(3,minmax(0,1fr));}
}
@media (max-width: 900px){
    .gallery-plain-grid{grid-template-columns:1fr;}
    .gallery-plain-grid--unassigned{grid-template-columns:repeat(2,minmax(0,1fr));}
}
@media (max-width: 640px){
    .gallery-plain-grid--unassigned{grid-template-columns:1fr;}
    .gallery-page__head{padding:.62rem .78rem;}
    .gallery-page__title{font-size:clamp(.9rem,4.2vw,1rem);}
}
</style>
@endpush

@section('content')
<section class="gallery-page">
    <div class="gallery-page__head">
        <h1 class="gallery-page__title">Foto Galeri &amp; Albümler &amp; Duyuru</h1>
    </div>

    @if(($albums ?? collect())->isNotEmpty())
        <div class="gallery-albums-grid">
            @foreach($albums as $album)
                @php
                    $cover = $album->cover_image_path ?: optional($album->photos->first())->image_path;
                @endphp
                <a href="{{ route('gallery.show', $album->slug) }}" class="gallery-album-card">
                    @if($cover)
                        <img src="{{ asset($cover) }}" alt="{{ $album->name }}" class="gallery-album-card__cover">
                    @else
                        <div class="gallery-album-card__cover"></div>
                    @endif
                    <div class="gallery-album-card__body">
                        <h2 class="gallery-album-card__title">{{ $album->name }}</h2>
                        <p class="gallery-album-card__desc">{{ \Illuminate\Support\Str::limit($album->description ?: 'Albüm fotoğraflarını görüntüleyin.', 90) }}</p>
                        <div class="gallery-album-card__meta">{{ (int) ($album->active_photos_count ?? 0) }} fotoğraf</div>
                    </div>
                </a>
            @endforeach
        </div>
    @endif

    @if(($announcements ?? collect())->isNotEmpty())
        <h2 class="gallery-section-title">Duyurular</h2>
        <div class="gallery-plain-grid">
            @foreach($announcements as $photo)
                @php
                    $shareUrl = asset($photo->image_path);
                    $shareText = ($photo->title ?: 'Duyuru') . ' - Foto Galeri';
                    $encodedUrl = urlencode($shareUrl);
                    $encodedText = urlencode($shareText);
                @endphp
                <article class="gallery-photo-card">
                    <button type="button" class="gallery-photo-card__img-btn js-gallery-open-lightbox" data-image-src="{{ asset($photo->image_path) }}" data-image-alt="{{ $photo->title ?: 'Duyuru' }}">
                        <img src="{{ asset($photo->image_path) }}" alt="{{ $photo->title ?: 'Duyuru' }}">
                    </button>
                    <div class="gallery-photo-card__body">
                        <h3 class="gallery-photo-card__title">{{ $photo->title ?: 'Duyuru' }}</h3>
                        @if(!empty($photo->short_description))
                            <p class="gallery-photo-card__desc">{{ \Illuminate\Support\Str::limit($photo->short_description, 90) }}</p>
                        @endif
                        <div class="gallery-share" data-share-url="{{ $shareUrl }}">
                            <a class="gallery-share-btn gallery-share-btn--facebook" target="_blank" rel="noopener noreferrer" href="https://www.facebook.com/sharer/sharer.php?u={{ $encodedUrl }}" aria-label="Facebook"><svg viewBox="0 0 24 24"><path fill="currentColor" d="M22.675 0H1.325C.593 0 0 .593 0 1.326v21.348C0 23.407.593 24 1.325 24h11.495v-9.294H9.692V11.08h3.128V8.413c0-3.1 1.894-4.788 4.659-4.788 1.325 0 2.463.099 2.795.143v3.24h-1.918c-1.505 0-1.796.715-1.796 1.764v2.31h3.588l-.467 3.625H16.56V24h6.115C23.407 24 24 23.407 24 22.674V1.326C24 .593 23.407 0 22.675 0z"/></svg><span>Facebook</span></a>
                            <a class="gallery-share-btn gallery-share-btn--whatsapp" target="_blank" rel="noopener noreferrer" href="https://wa.me/?text={{ urlencode($shareText . ' ' . $shareUrl) }}" aria-label="WhatsApp"><svg viewBox="0 0 24 24"><path fill="currentColor" d="M20.52 3.48A11.82 11.82 0 0 0 12.08 0C5.53 0 .18 5.36.18 11.93c0 2.1.55 4.15 1.6 5.95L0 24l6.3-1.65a11.83 11.83 0 0 0 5.78 1.48h.01c6.55 0 11.9-5.36 11.9-11.93 0-3.19-1.23-6.19-3.47-8.42z"/></svg><span>WhatsApp</span></a>
                            <a class="gallery-share-btn gallery-share-btn--telegram" target="_blank" rel="noopener noreferrer" href="https://t.me/share/url?url={{ $encodedUrl }}&text={{ $encodedText }}" aria-label="Telegram"><svg viewBox="0 0 24 24"><path fill="currentColor" d="M9.78 17.57l-.4 5.63c.57 0 .81-.25 1.1-.54l2.64-2.52 5.48 4.01c1 .56 1.71.27 1.98-.92l3.6-16.86h.01c.31-1.45-.52-2.01-1.5-1.64L1.54 12.2C.12 12.75.14 13.54 1.3 13.9l5.44 1.7L19.37 7.4c.6-.4 1.15-.18.7.22L9.78 17.57z"/></svg><span>Telegram</span></a>
                            <a class="gallery-share-btn gallery-share-btn--messenger" target="_blank" rel="noopener noreferrer" href="https://www.facebook.com/dialog/send?link={{ $encodedUrl }}&app_id=123456789&redirect_uri={{ $encodedUrl }}" aria-label="Messenger"><svg viewBox="0 0 24 24"><path fill="currentColor" d="M12 2C6.48 2 2 6.15 2 11.27c0 2.92 1.46 5.53 3.75 7.23V22l3.18-1.74c.95.26 1.97.4 3.07.4 5.52 0 10-4.15 10-9.27S17.52 2 12 2z"/></svg><span>Messenger</span></a>
                            <button type="button" class="gallery-share-btn gallery-share-btn--copy js-gallery-copy-link" aria-label="Link kopyala"><svg viewBox="0 0 24 24"><path fill="currentColor" d="M16 1H4a2 2 0 0 0-2 2v12h2V3h12V1zm3 4H8a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h11a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2z"/></svg><span>Kopyala</span></button>
                        </div>
                    </div>
                </article>
            @endforeach
        </div>
    @endif

    @if(($unassignedPhotos ?? collect())->isNotEmpty())
        <h2 class="gallery-section-title">Albümsüz Fotoğraflar</h2>
        <div class="gallery-plain-grid gallery-plain-grid--unassigned">
            @foreach($unassignedPhotos as $photo)
                @php
                    $shareUrl = asset($photo->image_path);
                    $shareText = ($photo->title ?: 'Albümsüz Fotoğraf') . ' - Foto Galeri';
                    $encodedUrl = urlencode($shareUrl);
                    $encodedText = urlencode($shareText);
                @endphp
                <article class="gallery-photo-card">
                    <button type="button" class="gallery-photo-card__img-btn js-gallery-open-lightbox" data-image-src="{{ asset($photo->image_path) }}" data-image-alt="{{ $photo->title ?: 'Albümsüz Fotoğraf' }}">
                        <img src="{{ asset($photo->image_path) }}" alt="{{ $photo->title ?: 'Albümsüz Fotoğraf' }}">
                    </button>
                    <div class="gallery-photo-card__body">
                        <h3 class="gallery-photo-card__title">{{ $photo->title ?: 'Albümsüz Fotoğraf' }}</h3>
                        @if(!empty($photo->short_description))
                            <p class="gallery-photo-card__desc">{{ \Illuminate\Support\Str::limit($photo->short_description, 90) }}</p>
                        @endif
                        <div class="gallery-share" data-share-url="{{ $shareUrl }}">
                            <a class="gallery-share-btn gallery-share-btn--facebook" target="_blank" rel="noopener noreferrer" href="https://www.facebook.com/sharer/sharer.php?u={{ $encodedUrl }}" aria-label="Facebook"><svg viewBox="0 0 24 24"><path fill="currentColor" d="M22.675 0H1.325C.593 0 0 .593 0 1.326v21.348C0 23.407.593 24 1.325 24h11.495v-9.294H9.692V11.08h3.128V8.413c0-3.1 1.894-4.788 4.659-4.788 1.325 0 2.463.099 2.795.143v3.24h-1.918c-1.505 0-1.796.715-1.796 1.764v2.31h3.588l-.467 3.625H16.56V24h6.115C23.407 24 24 23.407 24 22.674V1.326C24 .593 23.407 0 22.675 0z"/></svg><span>Facebook</span></a>
                            <a class="gallery-share-btn gallery-share-btn--whatsapp" target="_blank" rel="noopener noreferrer" href="https://wa.me/?text={{ urlencode($shareText . ' ' . $shareUrl) }}" aria-label="WhatsApp"><svg viewBox="0 0 24 24"><path fill="currentColor" d="M20.52 3.48A11.82 11.82 0 0 0 12.08 0C5.53 0 .18 5.36.18 11.93c0 2.1.55 4.15 1.6 5.95L0 24l6.3-1.65a11.83 11.83 0 0 0 5.78 1.48h.01c6.55 0 11.9-5.36 11.9-11.93 0-3.19-1.23-6.19-3.47-8.42z"/></svg><span>WhatsApp</span></a>
                            <a class="gallery-share-btn gallery-share-btn--telegram" target="_blank" rel="noopener noreferrer" href="https://t.me/share/url?url={{ $encodedUrl }}&text={{ $encodedText }}" aria-label="Telegram"><svg viewBox="0 0 24 24"><path fill="currentColor" d="M9.78 17.57l-.4 5.63c.57 0 .81-.25 1.1-.54l2.64-2.52 5.48 4.01c1 .56 1.71.27 1.98-.92l3.6-16.86h.01c.31-1.45-.52-2.01-1.5-1.64L1.54 12.2C.12 12.75.14 13.54 1.3 13.9l5.44 1.7L19.37 7.4c.6-.4 1.15-.18.7.22L9.78 17.57z"/></svg><span>Telegram</span></a>
                            <a class="gallery-share-btn gallery-share-btn--messenger" target="_blank" rel="noopener noreferrer" href="https://www.facebook.com/dialog/send?link={{ $encodedUrl }}&app_id=123456789&redirect_uri={{ $encodedUrl }}" aria-label="Messenger"><svg viewBox="0 0 24 24"><path fill="currentColor" d="M12 2C6.48 2 2 6.15 2 11.27c0 2.92 1.46 5.53 3.75 7.23V22l3.18-1.74c.95.26 1.97.4 3.07.4 5.52 0 10-4.15 10-9.27S17.52 2 12 2z"/></svg><span>Messenger</span></a>
                            <button type="button" class="gallery-share-btn gallery-share-btn--copy js-gallery-copy-link" aria-label="Link kopyala"><svg viewBox="0 0 24 24"><path fill="currentColor" d="M16 1H4a2 2 0 0 0-2 2v12h2V3h12V1zm3 4H8a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h11a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2z"/></svg><span>Kopyala</span></button>
                        </div>
                    </div>
                </article>
            @endforeach
        </div>
    @endif

    @if(($albums ?? collect())->isEmpty() && ($announcements ?? collect())->isEmpty() && ($unassignedPhotos ?? collect())->isEmpty())
        <div class="gallery-empty">Henüz yayınlanmış fotoğraf bulunmuyor.</div>
    @endif
</section>
<div class="gallery-share-toast" id="galleryShareToast">Link kopyalandı</div>
<div class="gallery-lightbox" id="galleryLightbox" aria-hidden="true">
    <div class="gallery-lightbox__backdrop" data-gallery-lightbox-close></div>
    <div class="gallery-lightbox__dialog">
        <button type="button" class="gallery-lightbox__close" data-gallery-lightbox-close aria-label="Kapat">×</button>
        <img class="gallery-lightbox__img" id="galleryLightboxImage" src="" alt="">
    </div>
</div>
@endsection

@push('scripts')
<script>
(function(){
    var toast = document.getElementById('galleryShareToast');
    if (toast) {
        document.querySelectorAll('.js-gallery-copy-link').forEach(function(btn){
            btn.addEventListener('click', function(){
                var wrap = btn.closest('.gallery-share');
                var url = wrap ? wrap.getAttribute('data-share-url') : window.location.href;
                navigator.clipboard.writeText(url || window.location.href).then(function(){
                    toast.classList.add('is-visible');
                    setTimeout(function(){ toast.classList.remove('is-visible'); }, 1500);
                });
            });
        });
    }

    var lightbox = document.getElementById('galleryLightbox');
    var lightboxImg = document.getElementById('galleryLightboxImage');
    if (!lightbox || !lightboxImg) return;

    function closeLightbox() {
        lightbox.classList.remove('is-open');
        lightbox.setAttribute('aria-hidden', 'true');
        lightboxImg.src = '';
        lightboxImg.alt = '';
        document.body.style.overflow = '';
    }

    document.querySelectorAll('.js-gallery-open-lightbox').forEach(function(btn){
        btn.addEventListener('click', function(){
            var src = btn.getAttribute('data-image-src');
            var alt = btn.getAttribute('data-image-alt') || 'Fotoğraf';
            if (!src) return;
            lightboxImg.src = src;
            lightboxImg.alt = alt;
            lightbox.classList.add('is-open');
            lightbox.setAttribute('aria-hidden', 'false');
            document.body.style.overflow = 'hidden';
        });
    });

    document.querySelectorAll('[data-gallery-lightbox-close]').forEach(function(el){
        el.addEventListener('click', closeLightbox);
    });

    document.addEventListener('keydown', function(e){
        if (e.key === 'Escape' && lightbox.classList.contains('is-open')) closeLightbox();
    });
})();
</script>
@endpush
