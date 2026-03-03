@extends('layouts.frontend')

@section('title', 'Anasayfa')

@push('styles')
<style>
    .home-layout {
        max-width: 1280px;
        margin: 0 auto;
        padding: 2rem 1.5rem;
    }
    .home-main {
        display: grid;
        grid-template-columns: 3fr 1fr;
        gap: 2rem;
        align-items: start;
    }
    .home-left {
        display: flex;
        flex-direction: column;
        gap: 1.25rem;
    }
    .home-slider {
        background: var(--panel);
        border: 1px solid var(--border);
        border-radius: 14px;
        box-shadow: 0 4px 24px rgba(0, 0, 0, 0.25);
        min-height: 280px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--muted);
        font-size: 1.25rem;
        transition: box-shadow 0.2s ease;
    }
    .home-slider:hover {
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.35);
    }
    .home-day-tabs {
        display: flex;
        flex-wrap: wrap;
        gap: 0.5rem;
    }
    .home-day-tabs button {
        flex: 1;
        min-width: 80px;
        padding: 0.75rem 1rem;
        background: var(--panel);
        border: 1px solid var(--border);
        border-radius: 10px;
        color: var(--text);
        font-family: Arial, sans-serif;
        font-size: 0.9rem;
        cursor: pointer;
        transition: all 0.2s ease;
    }
    .home-day-tabs button:hover,
    .home-day-tabs button.active {
        background: rgba(201, 42, 42, 0.15);
        border-color: rgba(201, 42, 42, 0.4);
        color: #fff;
    }
    .home-schedule {
        background: var(--panel);
        border: 1px solid var(--border);
        border-radius: 12px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2);
        padding: 1.25rem 1.5rem;
        color: var(--text);
        font-size: 1rem;
        transition: box-shadow 0.2s ease;
    }
    .home-schedule:hover {
        box-shadow: 0 6px 28px rgba(0, 0, 0, 0.3);
    }
    .home-requests {
        background: var(--panel);
        border: 1px solid var(--border);
        border-radius: 14px;
        box-shadow: 0 4px 24px rgba(0, 0, 0, 0.25);
        min-height: 280px;
        padding: 1.5rem;
        display: flex;
        align-items: flex-start;
        color: var(--text);
        font-size: 1rem;
        transition: box-shadow 0.2s ease;
    }
    .home-requests:hover {
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.35);
    }
    .home-right {
        display: flex;
        flex-direction: column;
        gap: 1.25rem;
        max-width: 360px;
    }
    .home-actions {
        display: flex;
        flex-direction: column;
        gap: 0.75rem;
    }
    .btn-live {
        display: grid;
        place-items: center;
        padding: 1rem 1.5rem;
        background: linear-gradient(135deg, #2563eb, #1d4ed8);
        border: 1px solid rgba(255, 255, 255, 0.2);
        border-radius: 12px;
        color: #fff;
        font-family: Arial, sans-serif;
        font-size: 1rem;
        font-weight: 700;
        text-decoration: none;
        text-transform: none;
        box-shadow: 0 4px 20px rgba(37, 99, 235, 0.4);
        transition: all 0.2s ease;
    }
    .btn-live:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 28px rgba(37, 99, 235, 0.5);
    }
    .btn-request {
        display: grid;
        place-items: center;
        padding: 1rem 1.5rem;
        background: linear-gradient(135deg, var(--accent), #a02020);
        border: 1px solid rgba(255, 255, 255, 0.2);
        border-radius: 12px;
        color: #fff;
        font-family: Arial, sans-serif;
        font-size: 1rem;
        font-weight: 700;
        text-decoration: none;
        text-transform: none;
        box-shadow: 0 4px 20px rgba(201, 42, 42, 0.4);
        transition: all 0.2s ease;
    }
    .btn-request:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 28px rgba(201, 42, 42, 0.5);
    }
    .home-icon-buttons {
        display: flex;
        gap: 0.5rem;
    }
    .home-icon-buttons button {
        flex: 1;
        aspect-ratio: 1;
        padding: 0.75rem;
        background: var(--panel);
        border: 1px solid var(--border);
        border-radius: 10px;
        color: var(--muted);
        font-size: 1.25rem;
        cursor: pointer;
        transition: all 0.2s ease;
    }
    .home-icon-buttons button:hover {
        background: rgba(201, 42, 42, 0.15);
        border-color: rgba(201, 42, 42, 0.3);
        color: #fff;
    }
    .home-badges {
        display: flex;
        flex-direction: column;
        gap: 0.5rem;
    }
    .badge-placeholder {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        padding: 0.75rem 1rem;
        background: #1f2937;
        border: 1px solid var(--border);
        border-radius: 10px;
        color: var(--muted);
        font-size: 0.85rem;
        transition: all 0.2s ease;
    }
    .badge-placeholder:hover {
        background: #374151;
        color: var(--text);
    }
    .home-dj-card {
        background: var(--panel);
        border: 1px solid var(--border);
        border-radius: 14px;
        box-shadow: 0 4px 24px rgba(0, 0, 0, 0.25);
        padding: 1.5rem;
        display: flex;
        flex-direction: column;
        align-items: center;
        text-align: center;
        transition: box-shadow 0.2s ease;
    }
    .home-dj-card:hover {
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.35);
    }
    .dj-avatar {
        width: 100px;
        height: 100px;
        border-radius: 50%;
        background: linear-gradient(135deg, #374151, #1f2937);
        border: 3px solid rgba(201, 42, 42, 0.4);
        margin-bottom: 1rem;
        overflow: hidden;
    }
    .dj-avatar img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    .home-dj-card h3 {
        font-size: 1.75rem;
        font-weight: 700;
        color: #fff;
        margin-bottom: 0.4rem;
        text-transform: none;
    }
    .home-dj-card .dj-slogan {
        font-size: 0.9rem;
        color: var(--muted);
        margin-bottom: 1rem;
    }
    .live-badge {
        display: inline-block;
        padding: 0.5rem 1.25rem;
        background: var(--accent);
        border-radius: 10px;
        color: #fff;
        font-size: 0.85rem;
        font-weight: 700;
        box-shadow: 0 4px 16px rgba(201, 42, 42, 0.4);
        transition: all 0.2s ease;
    }
    .live-badge:hover {
        box-shadow: 0 0 30px rgba(201, 42, 42, 0.5);
    }
    @media (max-width: 992px) {
        .home-main {
            grid-template-columns: 1fr;
        }
        .home-right {
            order: -1;
            max-width: none;
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1rem;
        }
        .home-actions {
            grid-column: 1 / -1;
            flex-direction: row;
        }
        .btn-live, .btn-request { flex: 1; }
        .home-dj-card {
            grid-column: 1 / -1;
        }
    }
    @media (max-width: 600px) {
        .home-layout { padding: 1rem; }
        .home-day-tabs button { min-width: 60px; font-size: 0.8rem; }
        .home-right {
            grid-template-columns: 1fr;
        }
        .home-actions { flex-direction: column; }
    }
</style>
@endpush

@section('content')
<div class="home-layout">
    <div class="home-main">
        <div class="home-left">
            <div class="home-slider">slider</div>
            <div class="home-day-tabs">
                <button type="button" class="active">Pazartesi</button>
                <button type="button">Salı</button>
                <button type="button">Çarşamba</button>
                <button type="button">Perşembe</button>
                <button type="button">Cuma</button>
                <button type="button">Cumartesi</button>
                <button type="button">Pazar</button>
            </div>
            <div class="home-schedule">Yayın Akışı</div>
            <div class="home-requests">İstekler</div>
        </div>
        <div class="home-right">
            <div class="home-actions">
                <a href="#" class="btn-live">CANLI DİNLE</a>
                <a href="#" class="btn-request">İSTEK Gönder</a>
            </div>
            <div class="home-icon-buttons">
                <button type="button" class="icon-placeholder" aria-label="Play">▶</button>
                <button type="button" class="icon-placeholder" aria-label="A">A</button>
                <button type="button" class="icon-placeholder" aria-label="Lightning">⚡</button>
                <button type="button" class="icon-placeholder" aria-label="Video">🎬</button>
            </div>
            <div class="home-badges">
                <a href="#" class="badge-placeholder">GET IT ON Google Play</a>
                <a href="#" class="badge-placeholder">Download on the App Store</a>
            </div>
            <div class="home-dj-card">
                <div class="dj-avatar">
                    <img src="https://ui-avatars.com/api/?name=Desmal&size=100&background=374151&color=fff" alt="Desmal">
                </div>
                <h3>Desmal</h3>
                <p class="dj-slogan">Türküler bizim</p>
                <span class="live-badge">CANLI YAYINDA</span>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
(function() {
    var tabs = document.querySelectorAll('.home-day-tabs button');
    tabs.forEach(function(btn) {
        btn.addEventListener('click', function() {
            tabs.forEach(function(b) { b.classList.remove('active'); });
            btn.classList.add('active');
        });
    });
})();
</script>
@endpush
@endsection
