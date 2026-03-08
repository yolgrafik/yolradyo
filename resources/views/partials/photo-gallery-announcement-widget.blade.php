<section class="home-news-section photo-gallery-announcement-section" aria-label="Foto Galeri Duyuru">
    <div class="home-news-section__header photo-gallery-announcement-section__header">
        <div class="photo-gallery-announcement-section__title-row">
            <h2 class="home-news-section__title photo-gallery-announcement-section__title">Foto Galeri</h2>
            <span class="photo-gallery-announcement-section__sep" aria-hidden="true">|</span>
            <p class="photo-gallery-announcement-section__subtitle">DUYURU</p>
        </div>
    </div>
    <div class="photo-gallery-announcement-widget">
        <div class="photo-gallery-announcement-widget__body">
            Yakında burada foto galeri duyuruları yayınlanacak.
        </div>
    </div>
</section>

@push('styles')
<style>
.photo-gallery-announcement-section{margin-top:1rem;}
.photo-gallery-announcement-section__header{margin-bottom:1rem;}
.photo-gallery-announcement-section__title{margin:0;}
.photo-gallery-announcement-section__title-row{display:flex;align-items:center;gap:.5rem;flex-wrap:wrap;}
.photo-gallery-announcement-section__sep{color:var(--ry-text-muted);font-size:.9rem;line-height:1;}
.photo-gallery-announcement-section__subtitle{font-size:.74rem;color:var(--ry-text-muted);margin:0;line-height:1;}
.photo-gallery-announcement-widget{position:relative;background:color-mix(in srgb,var(--ry-bar-bg) 75%, #0b0f16);border:1px solid var(--border);border-radius:14px;overflow:hidden;box-shadow:0 6px 20px rgba(0,0,0,0.25);border-top:1px solid var(--ry-line-color);border-bottom:1px solid var(--ry-line-color);}
.photo-gallery-announcement-widget__body{padding:14px;color:var(--ry-text-muted);font-size:.85rem;line-height:1.5;}
@media (max-width: 768px){.photo-gallery-announcement-section__subtitle{font-size:.7rem;}}
</style>
@endpush
