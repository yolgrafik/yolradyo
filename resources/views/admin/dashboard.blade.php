@extends('admin.layouts.app')

@push('styles')
<style>
    .module-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 1.5rem;
    }
    .module-card {
        background: var(--card);
        border-radius: 20px;
        overflow: hidden;
        box-shadow: 0 4px 20px rgba(0,0,0,0.25);
        transition: transform 0.2s, box-shadow 0.2s;
        text-decoration: none;
        color: inherit;
        display: block;
    }
    .module-card:hover {
        transform: scale(1.02);
        box-shadow: 0 8px 28px rgba(0,0,0,0.35);
    }
    .module-card__header {
        padding: 1.25rem 1.5rem;
        display: flex;
        align-items: center;
        gap: 1rem;
        color: #fff;
    }
    .module-card__icon {
        width: 48px;
        height: 48px;
        flex-shrink: 0;
        opacity: 0.95;
    }
    .module-card__title {
        font-size: 1.1rem;
        font-weight: 700;
        letter-spacing: 0.02em;
    }
    .module-card__body {
        padding: 1rem 1.5rem 1.25rem;
        background: rgba(0,0,0,0.25);
    }
    .module-card__list {
        list-style: none;
        margin: 0;
        padding: 0;
    }
    .module-card__item {
        font-size: 0.85rem;
        color: var(--muted);
        padding: 0.4rem 0;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    .module-card__item::before {
        content: '▸';
        font-size: 0.65rem;
        opacity: 0.8;
    }
    .module-card--red .module-card__header { background: linear-gradient(135deg, #dc2626, #991b1b); }
    .module-card--orange .module-card__header { background: linear-gradient(135deg, #ea580c, #c2410c); }
    .module-card--blue .module-card__header { background: linear-gradient(135deg, #2563eb, #1d4ed8); }
    .module-card--green .module-card__header { background: linear-gradient(135deg, #16a34a, #15803d); }
    .module-card--purple .module-card__header { background: linear-gradient(135deg, #7c3aed, #6d28d9); }
    @media (max-width: 1024px) {
        .module-grid { grid-template-columns: repeat(2, 1fr); }
    }
    @media (max-width: 768px) {
        .module-grid { grid-template-columns: 1fr; gap: 1.25rem; }
    }
</style>
@endpush

@section('content')
<div class="module-grid">
    <a href="#" class="module-card module-card--red">
        <div class="module-card__header">
            <svg class="module-card__icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 2a3 3 0 0 0-3 3v7a3 3 0 0 0 6 0V5a3 3 0 0 0-3-3z"/><path d="M19 10v2a7 7 0 0 1-14 0v-2"/></svg>
            <span class="module-card__title"><span class="menu-glow">Program & DJ</span></span>
        </div>
        <div class="module-card__body">
            <ul class="module-card__list">
                <li class="module-card__item">Program Listesi</li>
                <li class="module-card__item">Program Ekle</li>
                <li class="module-card__item">Program Duzenle</li>
                <li class="module-card__item">DJ Profilleri</li>
                <li class="module-card__item">Yayin Takvimi</li>
            </ul>
        </div>
    </a>

    <a href="#" class="module-card module-card--orange">
        <div class="module-card__header">
            <svg class="module-card__icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V7a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/><line x1="7" y1="10" x2="7.01" y2="10"/><line x1="11" y1="10" x2="13" y2="10"/></svg>
            <span class="module-card__title"><span class="menu-glow">Reklam Yonetimi</span></span>
        </div>
        <div class="module-card__body">
            <ul class="module-card__list">
                <li class="module-card__item">Banner Alanlari</li>
                <li class="module-card__item">Popup Reklam</li>
                <li class="module-card__item">Sponsor Yonetimi</li>
                <li class="module-card__item">Kampanya Takibi</li>
            </ul>
        </div>
    </a>

    <a href="#" class="module-card module-card--blue">
        <div class="module-card__header">
            <svg class="module-card__icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
            <span class="module-card__title"><span class="menu-glow">Mesaj & İstek</span></span>
        </div>
        <div class="module-card__body">
            <ul class="module-card__list">
                <li class="module-card__item">Gelen Mesajlar</li>
                <li class="module-card__item">Moderasyon</li>
                <li class="module-card__item">Kara Liste</li>
            </ul>
        </div>
    </a>

    <a href="#" class="module-card module-card--green">
        <div class="module-card__header">
            <svg class="module-card__icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="3"/><path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z"/></svg>
            <span class="module-card__title"><span class="menu-glow">Ayarlar</span></span>
        </div>
        <div class="module-card__body">
            <ul class="module-card__list">
                <li class="module-card__item">Genel Site Ayarlari</li>
                <li class="module-card__item">Logo & Favicon</li>
                <li class="module-card__item">SEO Ayarlari</li>
                <li class="module-card__item">Sosyal Medya Linkleri</li>
                <li class="module-card__item">Footer Yonetimi</li>
                <li class="module-card__item">Tema & Renk Ayarlari</li>
            </ul>
        </div>
    </a>

    <a href="#" class="module-card module-card--purple">
        <div class="module-card__header">
            <svg class="module-card__icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
            <span class="module-card__title"><span class="menu-glow">Kullanici Yonetimi</span></span>
        </div>
        <div class="module-card__body">
            <ul class="module-card__list">
                <li class="module-card__item">Yonetici Hesaplari</li>
                <li class="module-card__item">Rol & Yetkiler</li>
                <li class="module-card__item">Aktivite Loglari</li>
                <li class="module-card__item">2FA Guvenlik</li>
            </ul>
        </div>
    </a>
</div>
@endsection
