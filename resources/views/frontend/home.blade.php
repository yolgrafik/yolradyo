@extends('layouts.frontend')

@section('title', 'Anasayfa')

@push('styles')
<style>
    .home-layout {
        max-width: 1280px;
        margin: 0 auto;
        padding: 2rem 1rem;
        overflow-x: hidden;
        min-width: 0;
    }
    .home-main {
        display: grid;
        grid-template-columns: 3fr 1fr;
        gap: 2rem;
        align-items: start;
        min-width: 0;
    }
    .home-left {
        display: flex;
        flex-direction: column;
        gap: 1.25rem;
        min-width: 0;
    }
    .home-slider-wrap {
        position: relative;
        border-radius: 14px;
        overflow: hidden;
        min-width: 0;
        box-shadow: 0 4px 24px rgba(0, 0, 0, 0.25);
        min-height: 386px;
        background: var(--panel);
        border: 1px solid var(--border);
    }
    .home-slider {
        position: relative;
        width: 100%;
        min-height: 386px;
        overflow: hidden;
    }
    .home-slider__slide {
        position: absolute;
        inset: 0;
        opacity: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        background-size: cover;
        background-position: center;
        transform: translateX(100%) translateY(0) scale(1.02);
        transition: none;
    }
    .home-slider__slide.is-active {
        opacity: 1;
        z-index: 1;
        transform: translateX(0) translateY(0) scale(1);
    }
    .home-slider__slide.is-exiting { opacity: 0; }
    .home-slider__slide.effect-1.is-active { transition: transform 1.4s cubic-bezier(0.25, 0.46, 0.45, 0.94), opacity 0.7s ease; }
    .home-slider__slide.effect-1 { transform: translateX(100%) translateY(0) scale(1.02); }
    .home-slider__slide.effect-1.is-active { transform: translateX(0) translateY(0) scale(1); }
    .home-slider__slide.effect-1.is-exiting { transform: translateX(-80%) translateY(3%) scale(0.97); transition: transform 1.1s cubic-bezier(0.55, 0.06, 0.68, 0.19), opacity 0.6s ease; }
    .home-slider__slide.effect-2 { transform: translateY(100%) scale(0.95); }
    .home-slider__slide.effect-2.is-active { transform: translateY(0) scale(1); transition: transform 1.1s cubic-bezier(0.34, 1.56, 0.64, 1), opacity 0.6s ease; }
    .home-slider__slide.effect-2.is-exiting { transform: translateY(-50%) scale(0.9); transition: transform 1s ease, opacity 0.5s ease; }
    .home-slider__slide.effect-3 { transform: translateX(-100%) scale(1.05); }
    .home-slider__slide.effect-3.is-active { transform: translateX(0) scale(1); transition: transform 1.2s cubic-bezier(0.22, 1, 0.36, 1), opacity 0.6s ease; }
    .home-slider__slide.effect-3.is-exiting { transform: translateX(80%) scale(0.95); transition: transform 1s ease, opacity 0.5s ease; }
    .home-slider__slide.effect-4 { transform: scale(0.8); opacity: 0; }
    .home-slider__slide.effect-4.is-active { transform: scale(1); transition: transform 1.3s cubic-bezier(0.34, 1.56, 0.64, 1), opacity 0.8s ease; }
    .home-slider__slide.effect-4.is-exiting { transform: scale(1.2); transition: transform 0.9s ease, opacity 0.4s ease; }
    .home-slider__slide.effect-5 { transform: translate(100%, 100%) scale(0.9); }
    .home-slider__slide.effect-5.is-active { transform: translate(0, 0) scale(1); transition: transform 1.2s cubic-bezier(0.25, 0.46, 0.45, 0.94), opacity 0.7s ease; }
    .home-slider__slide.effect-5.is-exiting { transform: translate(-60%, -40%) scale(0.92); transition: transform 1s ease, opacity 0.5s ease; }
    .home-slider__slide::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        height: 120px;
        background: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 1200 120' preserveAspectRatio='none'%3E%3Cpath d='M0,60 C150,0 300,120 450,60 S600,0 750,60 S900,120 1050,60 1200,60 L1200,120 L0,120 Z' fill='rgba(0,0,0,0.35)'/%3E%3Cpath d='M0,85 C200,45 400,125 600,85 S800,45 1000,85 1200,85 L1200,120 L0,120 Z' fill='rgba(0,0,0,0.2)'/%3E%3Cpath d='M0,100 C250,60 500,140 750,100 S1000,60 1200,100 L1200,120 L0,120 Z' fill='rgba(0,0,0,0.1)'/%3E%3C/svg%3E") no-repeat bottom center;
        background-size: 200% 100%;
        pointer-events: none;
        z-index: 1;
        opacity: 0;
    }
    .home-slider__slide.is-active::after {
        opacity: 1;
        animation: waveRoll 5s ease-in-out infinite;
    }
    @keyframes waveRoll {
        0%, 100% { background-position-x: 0%; }
        25% { background-position-x: 25%; }
        50% { background-position-x: 50%; }
        75% { background-position-x: 75%; }
        100% { background-position-x: 100%; }
    }
    .home-slider__slide::before {
        content: '';
        position: absolute;
        inset: 0;
        background: linear-gradient(90deg, rgba(0,0,0,0.6) 0%, rgba(0,0,0,0.3) 50%, transparent 100%);
        pointer-events: none;
    }
    .home-slider__content {
        position: relative;
        z-index: 2;
        padding: 2rem;
        max-width: 60%;
        text-align: left;
        opacity: 0;
        transform: translateY(20px);
        transition: opacity 0.6s ease 0.2s, transform 0.6s ease 0.2s;
    }
    .home-slider__slide.is-active .home-slider__content {
        opacity: 1;
        transform: translateY(0);
    }
    .home-slider__title {
        font-size: 2rem;
        font-weight: 700;
        color: #fff;
        margin-bottom: 0.5rem;
        text-shadow: 0 2px 8px rgba(0,0,0,0.5);
    }
    .home-slider__subtitle {
        font-size: 1.1rem;
        color: rgba(255,255,255,0.9);
        margin-bottom: 1rem;
        text-shadow: 0 1px 4px rgba(0,0,0,0.5);
    }
    .home-slider__btn {
        display: inline-block;
        padding: 0.6rem 1.25rem;
        background: var(--accent);
        color: #fff;
        font-weight: 600;
        text-decoration: none;
        border-radius: 10px;
        transition: all 0.2s ease;
        box-shadow: 0 4px 16px rgba(201, 42, 42, 0.4);
    }
    .home-slider__btn:hover {
        box-shadow: 0 0 24px rgba(201, 42, 42, 0.5);
        transform: translateY(-1px);
    }
    .home-slider__nav {
        position: absolute;
        bottom: 1rem;
        left: 50%;
        transform: translateX(-50%);
        z-index: 3;
        display: flex;
        gap: 0.5rem;
    }
    .home-slider__dot {
        width: 10px;
        height: 10px;
        border-radius: 50%;
        background: rgba(255,255,255,0.4);
        border: none;
        cursor: pointer;
        padding: 0;
        transition: background 0.2s;
    }
    .home-slider__dot.is-active { background: var(--accent); }
    .home-slider-placeholder {
        min-height: 386px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--muted);
        font-size: 1.25rem;
        background: var(--panel);
        border: 1px solid var(--border);
        border-radius: 14px;
    }
    .schedule-card {
        background: rgba(20, 25, 35, 0.6);
        backdrop-filter: blur(10px);
        -webkit-backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.08);
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2), inset 0 1px 0 rgba(255, 255, 255, 0.04);
    }
    .schedule-top-bar {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 1rem;
        padding: 0.85rem 1rem 0.5rem;
        background: rgba(255, 255, 255, 0.02);
        border-bottom: 1px solid rgba(255, 255, 255, 0.06);
    }
    .schedule-top-bar__title {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        font-weight: 700;
        font-size: 0.95rem;
        color: var(--text);
        flex-shrink: 0;
    }
    .schedule-top-bar__icon { font-size: 1.1rem; }
    .schedule-days-bar {
        display: flex;
        gap: 8px;
        flex-wrap: wrap;
        flex: 1;
        min-width: 0;
        justify-content: flex-end;
    }
    .schedule-day {
        flex: 0 0 auto;
        padding: 8px 14px;
        font-size: 14px;
        border-radius: 10px;
        background: #1e2430;
        color: #e6e6e6;
        border: 1px solid rgba(255, 255, 255, 0.15);
        font-family: Arial, sans-serif;
        font-size: 0.85rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.2s ease;
        min-height: 36px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .schedule-day:hover {
        background: #2a3342;
        border-color: #ff3b3b;
    }
    .schedule-day.active {
        background: linear-gradient(135deg, #ff3b3b, #b30000);
        border: none;
        color: #fff;
        box-shadow: 0 0 10px rgba(255, 60, 60, 0.5);
    }
    .schedule-list-wrap {
        max-height: 300px;
        overflow-y: auto;
        padding: 0 0.5rem 0.5rem;
    }
    .schedule-list, .schedule-list-inner {
        display: flex;
        flex-direction: column;
        gap: 0;
    }
    .schedule-item {
        display: flex;
        align-items: center;
        gap: 16px;
        padding: 12px 14px;
        min-height: 44px;
        border-bottom: 1px solid rgba(255, 255, 255, 0.06);
        font-size: 0.9rem;
        transition: background 0.2s ease;
    }
    .schedule-item:hover {
        background: rgba(255, 255, 255, 0.04);
    }
    .schedule-item:last-child { border-bottom: none; }
    .schedule-item.is-live {
        background: linear-gradient(90deg, rgba(201, 42, 42, 0.2), rgba(185, 28, 28, 0.15));
        border: 1px solid rgba(255, 255, 255, 0.12);
        border-radius: 12px;
        margin: 6px 0;
        padding: 12px 14px;
        box-shadow: 0 0 20px rgba(201, 42, 42, 0.15);
    }
    .schedule-item.is-live:hover {
        background: linear-gradient(90deg, rgba(201, 42, 42, 0.25), rgba(185, 28, 28, 0.2));
    }
    .schedule-time {
        width: 70px;
        flex-shrink: 0;
        color: #ff3b3b;
        font-weight: 700;
        font-size: 0.9rem;
    }
    .schedule-program {
        flex: 1;
        color: var(--text);
        font-weight: 600;
        min-width: 0;
    }
    .schedule-dj {
        width: 160px;
        flex-shrink: 0;
        text-align: right;
        color: var(--muted);
        font-size: 0.85rem;
        opacity: 0.85;
    }
    .schedule-badge {
        flex-shrink: 0;
        margin-left: 10px;
        padding: 0.25rem 0.6rem;
        background: rgba(34, 197, 94, 0.35);
        color: #86efac;
        font-size: 0.7rem;
        font-weight: 700;
        border-radius: 6px;
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
        cursor: pointer;
        font-family: inherit;
        padding: 1rem 1.5rem;
        background: linear-gradient(135deg, #16a34a, var(--accent));
        border: 1px solid rgba(255, 255, 255, 0.2);
        border-radius: 12px;
        color: #fff;
        font-size: 1rem;
        font-weight: 700;
        text-transform: none;
        box-shadow: 0 4px 20px rgba(22, 163, 74, 0.35);
        transition: all 0.25s ease;
    }
    .btn-request:hover {
        transform: translateY(-2px);
        background: linear-gradient(135deg, #22c55e, #dc2626);
        box-shadow: 0 0 24px rgba(34, 197, 94, 0.4), 0 0 40px rgba(220, 38, 38, 0.35);
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
    @media (max-width: 768px) {
        .schedule-day { padding: 8px 12px; font-size: 0.75rem; min-height: 34px; }
        .schedule-dj { width: 120px; }
    }
    @media (max-width: 600px) {
        .home-layout { padding: 1rem; }
        .schedule-top-bar { flex-direction: column; align-items: stretch; }
        .schedule-days-bar { justify-content: flex-start; }
        .schedule-dj { width: 100px; }
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
            @if(isset($sliders) && $sliders->isNotEmpty())
            <div class="home-slider-wrap">
                <div class="home-slider" id="homeSlider">
                    @foreach($sliders as $i => $s)
                    <div class="home-slider__slide effect-{{ ($i % 5) + 1 }} {{ $i === 0 ? 'is-active' : '' }}" data-index="{{ $i }}" data-effect="{{ ($i % 5) + 1 }}" style="background-image: url('{{ asset($s->image_path) }}');">
                        <div class="home-slider__content">
                            <h2 class="home-slider__title">{{ $s->title }}</h2>
                            @if($s->subtitle)<p class="home-slider__subtitle">{{ $s->subtitle }}</p>@endif
                            @if($s->button_text && $s->button_link)<a href="{{ url($s->button_link) }}" class="home-slider__btn">{{ $s->button_text }}</a>@endif
                        </div>
                    </div>
                    @endforeach
                </div>
                @if($sliders->count() > 1)
                <div class="home-slider__nav" id="sliderNav">
                    @foreach($sliders as $i => $s)
                    <button type="button" class="home-slider__dot {{ $i === 0 ? 'is-active' : '' }}" data-index="{{ $i }}" aria-label="Slide {{ $i + 1 }}"></button>
                    @endforeach
                </div>
                @endif
            </div>
            @else
            <div class="home-slider-placeholder">Slider</div>
            @endif
            <div class="schedule-card">
                <div class="schedule-top-bar">
                    <span class="schedule-top-bar__title">
                        <span class="schedule-top-bar__icon">📻</span>
                        Yayın Akışı
                    </span>
                    <div class="schedule-days-bar">
                        <button type="button" class="schedule-day" data-day="0">Pazartesi</button>
                        <button type="button" class="schedule-day" data-day="1">Salı</button>
                        <button type="button" class="schedule-day" data-day="2">Çarşamba</button>
                        <button type="button" class="schedule-day" data-day="3">Perşembe</button>
                        <button type="button" class="schedule-day" data-day="4">Cuma</button>
                        <button type="button" class="schedule-day" data-day="5">Cumartesi</button>
                        <button type="button" class="schedule-day" data-day="6">Pazar</button>
                    </div>
                </div>
                <div class="schedule-list-wrap">
                    <div class="schedule-list" id="scheduleListContainer">
                        <div class="schedule-loading" id="scheduleLoading">Yükleniyor...</div>
                        <div class="schedule-empty" id="scheduleEmpty" style="display:none;padding:2rem;text-align:center;color:var(--muted);">Bu gün için program yok.</div>
                    </div>
                </div>
            </div>
            @include('partials.requests-ticker')
        </div>
        <div class="home-right">
            <div class="home-actions">
                <a href="#" class="btn-live" id="quickMenuLive">CANLI DİNLE</a>
                <button type="button" class="btn-request" data-open-song-request>İstek Gönder</button>
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
    var dayBtns = document.querySelectorAll('.schedule-day');
    var container = document.getElementById('scheduleListContainer');
    var loadingEl = document.getElementById('scheduleLoading');
    var emptyEl = document.getElementById('scheduleEmpty');
    var currentDay = (function(){ var d=new Date().getDay(); return d===0?6:d-1; })();

    function renderSchedule(items) {
        if (!container) return;
        if (loadingEl) loadingEl.style.display='none';
        if (emptyEl) emptyEl.style.display=items.length===0?'block':'none';
        container.querySelectorAll('.schedule-list-inner').forEach(function(el){ el.remove(); });
        if (items.length===0) return;
        var wrap = document.createElement('div');
        wrap.className = 'schedule-list-inner';
        items.forEach(function(it){
            var row = document.createElement('div');
            row.className = 'schedule-item' + (it.is_live ? ' is-live' : '');
            row.innerHTML = '<span class="schedule-time">' + (it.start_time||'') + '</span>' +
                '<span class="schedule-program">' + (it.title||'') + '</span>' +
                '<span class="schedule-dj">' + (it.host||'') + '</span>' +
                (it.is_live ? '<span class="schedule-badge">CANLI</span>' : '');
            wrap.appendChild(row);
        });
        container.appendChild(wrap);
    }

    function loadSchedule(day) {
        if (loadingEl) loadingEl.style.display='block';
        if (emptyEl) emptyEl.style.display='none';
        fetch('{{ url("/api/schedule") }}?day=' + day)
            .then(function(r){ return r.json(); })
            .then(function(data){
                renderSchedule(data.items || []);
            })
            .catch(function(){
                renderSchedule([]);
            });
    }

    dayBtns.forEach(function(btn) {
        btn.addEventListener('click', function() {
            var day = parseInt(btn.getAttribute('data-day'), 10);
            dayBtns.forEach(function(b) { b.classList.remove('active'); });
            btn.classList.add('active');
            loadSchedule(day);
        });
    });

    dayBtns.forEach(function(b){ b.classList.remove('active'); });
    var activeBtn = Array.from(dayBtns).find(function(b){ return parseInt(b.getAttribute('data-day'),10)===currentDay; });
    if (activeBtn) activeBtn.classList.add('active');
    loadSchedule(currentDay);

    var slider = document.getElementById('homeSlider');
    var nav = document.getElementById('sliderNav');
    if (slider && nav) {
        var slides = slider.querySelectorAll('.home-slider__slide');
        var dots = nav.querySelectorAll('.home-slider__dot');
        var current = 0;
        var total = slides.length;
        var isTransitioning = false;
        var effectIndex = 0;

        function goTo(i) {
            if (isTransitioning || i === current) return;
            isTransitioning = true;
            var prev = current;
            var next = (i + total) % total;
            slides[prev].classList.remove('is-active');
            slides[prev].classList.add('is-exiting');
            var eff = (effectIndex % 5) + 1;
            slides[next].className = 'home-slider__slide effect-' + eff + ' is-active';
            slides[next].classList.remove('is-exiting');
            current = next;
            effectIndex++;
            dots.forEach(function(d, idx) {
                d.classList.toggle('is-active', idx === current);
            });
            setTimeout(function() {
                slides[prev].classList.remove('is-active', 'is-exiting');
                slides[prev].className = 'home-slider__slide effect-' + ((effectIndex - 1) % 5 + 1);
                isTransitioning = false;
            }, 1200);
        }

        dots.forEach(function(dot, i) {
            dot.addEventListener('click', function() { goTo(i); });
        });

        setInterval(function() {
            if (total > 1) goTo(current + 1);
        }, 5000);
    }
})();
</script>
@endpush
@endsection
