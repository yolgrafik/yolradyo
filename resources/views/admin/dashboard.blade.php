@extends('admin.layouts.app')

@push('styles')
<style>
    .dashboard-layout {
        display: grid;
        grid-template-columns: 1fr 340px;
        gap: 1.5rem;
        align-items: start;
    }
    .module-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
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
    .dashboard-detail {
        background: var(--card);
        border-radius: 20px;
        overflow: hidden;
        box-shadow: 0 4px 20px rgba(0,0,0,0.25);
        border: 1px solid rgba(255,255,255,0.08);
        position: sticky;
        top: 1rem;
    }
    .dashboard-detail__header {
        padding: 1rem 1.25rem;
        background: linear-gradient(135deg, #1e293b, #0f172a);
        border-bottom: 1px solid rgba(255,255,255,0.08);
        font-weight: 700;
        font-size: 1rem;
        color: #fff;
    }
    .dashboard-detail__body { padding: 1rem 1.25rem; }
    .dashboard-detail__section {
        padding: 0.75rem 0;
        border-bottom: 1px solid rgba(255,255,255,0.06);
    }
    .dashboard-detail__section:last-child { border-bottom: none; }
    .dashboard-detail__label {
        font-size: 0.75rem;
        color: var(--muted);
        text-transform: uppercase;
        letter-spacing: 0.05em;
        margin-bottom: 0.35rem;
    }
    .dashboard-detail__value {
        font-size: 1rem;
        font-weight: 600;
        color: #fff;
    }
    .dashboard-detail__value--online { color: #22c55e; }
    .dashboard-detail__value--offline { color: #94a3b8; }
    .dashboard-detail__track {
        font-size: 0.9rem;
        color: rgba(255,255,255,0.9);
        word-break: break-word;
    }
    @media (max-width: 1200px) {
        .dashboard-layout { grid-template-columns: 1fr; }
        .dashboard-detail { position: static; }
    }
    @media (max-width: 1024px) {
        .module-grid { grid-template-columns: repeat(2, 1fr); }
    }
    @media (max-width: 768px) {
        .module-grid { grid-template-columns: 1fr; gap: 1.25rem; }
    }
</style>
@endpush

@section('content')
<div class="dashboard-layout">
<div class="module-grid">
    <a href="{{ route('admin.schedule.index') }}" class="module-card module-card--red">
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

    <a href="{{ route('admin.messages.index') }}" class="module-card module-card--blue">
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

    <div class="stream-widget-card">
        <div class="stream-widget__header">
            <svg class="stream-widget__icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 18V5l12-2v13"/><circle cx="6" cy="18" r="3"/><circle cx="18" cy="16" r="3"/></svg>
            <span class="stream-widget__title">Canlı Yayın Bilgisi</span>
        </div>
        <div class="stream-widget__body">
            <div class="stream-widget__track">
                <img class="cc_streaminfo stream-widget__img" data-type="trackimageurl" data-username="radyoyol" src="" alt="" onerror="this.style.display='none'">
                <div class="stream-widget__track-info">
                    <div class="stream-widget__label">Şu An Çalıyor</div>
                    <div class="cc_streaminfo stream-widget__song" data-type="song" data-username="radyoyol">—</div>
                    <div class="stream-widget__meta">
                        <span class="cc_streaminfo" data-type="trackartist" data-username="radyoyol">—</span>
                        <span class="stream-widget__sep">•</span>
                        <span class="cc_streaminfo" data-type="tracktitle" data-username="radyoyol">—</span>
                    </div>
                </div>
            </div>
            <div class="stream-widget__grid">
                <div class="stream-widget__item">
                    <span class="stream-widget__item-label">Dinleyici</span>
                    <span class="cc_streaminfo stream-widget__item-value" data-type="listeners" data-username="radyoyol">—</span>
                </div>
                <div class="stream-widget__item">
                    <span class="stream-widget__item-label">Bitrate</span>
                    <span class="cc_streaminfo stream-widget__item-value" data-type="bitrate" data-username="radyoyol">—</span>
                </div>
                <div class="stream-widget__item">
                    <span class="stream-widget__item-label">Sunucu</span>
                    <span class="cc_streaminfo stream-widget__item-value" data-type="server" data-username="radyoyol">—</span>
                </div>
                <div class="stream-widget__item">
                    <span class="stream-widget__item-label">AutoDJ</span>
                    <span class="cc_streaminfo stream-widget__item-value" data-type="autodj" data-username="radyoyol">—</span>
                </div>
                <div class="stream-widget__item">
                    <span class="stream-widget__item-label">Kaynak</span>
                    <span class="cc_streaminfo stream-widget__item-value" data-type="source" data-username="radyoyol">—</span>
                </div>
                <div class="stream-widget__item">
                    <span class="stream-widget__item-label">İstasyon Saati</span>
                    <span class="cc_streaminfo stream-widget__item-value" data-type="stationtime" data-username="radyoyol">—</span>
                </div>
            </div>
        </div>
    </div>

    <a href="{{ route('admin.settings.general') }}" class="module-card module-card--green">
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

    <a href="{{ route('admin.users.index') }}" class="module-card module-card--purple">
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

<aside class="dashboard-detail">
    <div class="dashboard-detail__header">Detaylı Görünüm</div>
    <div class="dashboard-detail__body">
        <div class="dashboard-detail__section">
            <div class="dashboard-detail__label">Genel Bakış</div>
            <div class="dashboard-detail__value">Kontrol Paneli özeti</div>
        </div>
        <div class="dashboard-detail__section" id="dinleyici">
            <div class="dashboard-detail__label">Anlık Dinleyici</div>
            <div class="dashboard-detail__value" id="dashboardListeners">—</div>
        </div>
        <div class="dashboard-detail__section" id="yayin">
            <div class="dashboard-detail__label">Yayın Durumu</div>
            <div class="dashboard-detail__value dashboard-detail__value--offline" id="dashboardStatus">—</div>
        </div>
        <div class="dashboard-detail__section" id="nowplaying">
            <div class="dashboard-detail__label">Şu An Çalıyor</div>
            <div class="dashboard-detail__track" id="dashboardTrack">—</div>
        </div>
    </div>
</aside>
</div>
@endsection

@push('styles')
<style>
.stream-widget-card {
    background: linear-gradient(135deg, rgba(30,41,59,0.95) 0%, rgba(15,23,42,0.98) 100%);
    border: 1px solid rgba(148,163,184,0.15);
    border-radius: 16px;
    overflow: hidden;
    grid-column: span 1;
}
.stream-widget__header {
    background: linear-gradient(135deg, #0ea5e9 0%, #0284c7 100%);
    color: #fff;
    padding: 14px 20px;
    display: flex;
    align-items: center;
    gap: 12px;
}
.stream-widget__icon {
    width: 24px;
    height: 24px;
    flex-shrink: 0;
}
.stream-widget__title {
    font-weight: 600;
    font-size: 1rem;
}
.stream-widget__body {
    padding: 20px;
}
.stream-widget__track {
    display: flex;
    gap: 16px;
    margin-bottom: 20px;
    padding-bottom: 16px;
    border-bottom: 1px solid rgba(148,163,184,0.15);
}
.stream-widget__img {
    width: 80px;
    height: 80px;
    border-radius: 10px;
    object-fit: cover;
    flex-shrink: 0;
}
.stream-widget__track-info {
    flex: 1;
    min-width: 0;
}
.stream-widget__label {
    font-size: 0.75rem;
    color: rgba(148,163,184,0.9);
    text-transform: uppercase;
    letter-spacing: 0.05em;
    margin-bottom: 4px;
}
.stream-widget__song {
    font-weight: 600;
    color: #f8fafc;
    font-size: 1rem;
    margin-bottom: 4px;
}
.stream-widget__meta {
    font-size: 0.85rem;
    color: rgba(148,163,184,0.9);
}
.stream-widget__sep {
    margin: 0 6px;
    opacity: 0.6;
}
.stream-widget__grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 12px;
}
.stream-widget__item {
    background: rgba(15,23,42,0.6);
    border-radius: 10px;
    padding: 10px 14px;
    display: flex;
    flex-direction: column;
    gap: 2px;
}
.stream-widget__item-label {
    font-size: 0.7rem;
    color: rgba(148,163,184,0.8);
    text-transform: uppercase;
    letter-spacing: 0.04em;
}
.stream-widget__item-value {
    font-size: 0.9rem;
    font-weight: 600;
    color: #e2e8f0;
}
@media (min-width: 768px) {
    .stream-widget__grid { grid-template-columns: repeat(3, 1fr); }
}
</style>
@endpush

@push('scripts')
<script src="https://r1.comcities.com/system/streaminfo.js"></script>
<script>
(function() {
    var listenersEl = document.getElementById('dashboardListeners');
    var statusEl = document.getElementById('dashboardStatus');
    var trackEl = document.getElementById('dashboardTrack');
    function updateRadioStatus() {
        fetch('{{ url("/api/radio/status") }}')
            .then(function(r) { return r.json(); })
            .then(function(data) {
                if (listenersEl) listenersEl.textContent = (data.listeners || 0) + ' dinleyici';
                if (statusEl) {
                    statusEl.textContent = data.status === 'online' ? 'Yayında' : 'Yayın Dışı';
                    statusEl.classList.toggle('dashboard-detail__value--online', data.status === 'online');
                    statusEl.classList.toggle('dashboard-detail__value--offline', data.status !== 'online');
                }
                if (trackEl) trackEl.textContent = data.song || '-';
            })
            .catch(function() {
                if (listenersEl) listenersEl.textContent = '—';
                if (statusEl) { statusEl.textContent = '—'; statusEl.classList.add('dashboard-detail__value--offline'); }
                if (trackEl) trackEl.textContent = '—';
            });
    }
    updateRadioStatus();
    setInterval(updateRadioStatus, 10000);
})();
</script>
@endpush
