@extends('layouts.frontend')

@section('title', 'Programlar')

@push('styles')
<style>
    .programlar-layout { max-width: 1200px; margin: 0 auto; padding: 2rem 1rem; }
    .programlar-hero { padding: 2rem 0; margin-bottom: 2rem; border-bottom: 1px solid var(--ry-border); }
    .programlar-hero h1 { font-size: 2rem; font-weight: 700; color: #fff; margin: 0 0 0.5rem 0; }
    .programlar-hero p { color: var(--muted); font-size: 1rem; margin: 0; }
    .schedule-card { background: var(--ry-bar-bg); border: 1px solid rgba(255,255,255,0.08); border-radius: 14px; overflow: hidden; margin-bottom: 2rem; }
    .schedule-top-bar { display: flex; align-items: center; justify-content: space-between; gap: 1rem; padding: 1rem 1.25rem; background: rgba(255,255,255,0.03); flex-wrap: wrap; }
    .schedule-top-bar__title { font-weight: 700; font-size: 1.1rem; color: var(--text); display: flex; align-items: center; gap: 0.5rem; }
    .schedule-days-bar { display: flex; gap: 8px; flex-wrap: wrap; }
    .schedule-day { padding: 8px 14px; border-radius: 10px; background: var(--ry-schedule-bg); color: #fff; border: 1px solid rgba(255,255,255,0.15); font-size: 0.85rem; font-weight: 600; cursor: pointer; transition: all 0.2s; text-decoration: none; }
    .schedule-day:hover { background: var(--ry-surface-2); }
    .schedule-day.active { background: var(--ry-schedule-active); border-color: transparent; }
    .schedule-table-wrap { padding: 1rem 1.25rem; overflow-x: auto; }
    .schedule-table { width: 100%; border-collapse: collapse; }
    .schedule-table th, .schedule-table td { padding: 12px 16px; text-align: left; border-bottom: 1px solid rgba(255,255,255,0.06); }
    .schedule-table th { font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.05em; color: var(--muted); font-weight: 600; }
    .schedule-table td { font-size: 0.95rem; color: var(--text); }
    .schedule-table tr:hover td { background: rgba(255,255,255,0.02); }
    .schedule-time { font-weight: 600; color: var(--ry-schedule-active); white-space: nowrap; }
    .schedule-live-badge { display: inline-block; padding: 2px 8px; border-radius: 6px; background: var(--ry-schedule-active); font-size: 0.7rem; font-weight: 800; margin-left: 8px; }
    .schedule-empty { padding: 3rem 2rem; text-align: center; color: var(--muted); font-size: 1rem; }
    .djs-section { margin-top: 3rem; }
    .djs-section h2 { font-size: 1.5rem; font-weight: 700; color: #fff; margin-bottom: 1.5rem; display: flex; align-items: center; gap: 0.5rem; }
    .djs-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(260px, 1fr)); gap: 1.25rem; }
    .dj-card { background: var(--ry-bar-bg); border: 1px solid rgba(255,255,255,0.08); border-radius: 14px; overflow: hidden; display: flex; gap: 1rem; padding: 1rem; transition: all 0.2s; }
    .dj-card:hover { border-color: rgba(255,255,255,0.15); }
    .dj-avatar { width: 72px; height: 72px; border-radius: 12px; object-fit: cover; flex-shrink: 0; background: rgba(255,255,255,0.06); }
    .dj-avatar-placeholder { width: 72px; height: 72px; border-radius: 12px; background: var(--ry-schedule-active); color: #fff; display: flex; align-items: center; justify-content: center; font-size: 1.5rem; font-weight: 800; flex-shrink: 0; }
    .dj-info { flex: 1; min-width: 0; }
    .dj-name { font-size: 1.1rem; font-weight: 700; color: #fff; margin-bottom: 0.25rem; }
    .dj-bio { font-size: 0.85rem; color: var(--muted); line-height: 1.4; }
    @media (max-width: 768px) {
        .schedule-top-bar { flex-direction: column; align-items: stretch; }
        .schedule-table th, .schedule-table td { padding: 10px 12px; font-size: 0.85rem; }
    }
</style>
@endpush

@section('content')
<div class="programlar-layout">
    <section class="programlar-hero">
        <h1>Programlar</h1>
        <p>Haftalık yayın akışı ve DJ programları</p>
    </section>

    <div class="schedule-card">
        <div class="schedule-top-bar">
            <span class="schedule-top-bar__title">📻 Yayın Takvimi</span>
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
        <div class="schedule-table-wrap">
            <div class="schedule-loading" id="scheduleLoading">Yükleniyor...</div>
            <div class="schedule-empty" id="scheduleEmpty" style="display:none;">Bu gün için program yok.</div>
            <table class="schedule-table" id="scheduleTable" style="display:none;">
                <thead>
                    <tr>
                        <th>Saat</th>
                        <th>Program</th>
                        <th>Sunucu</th>
                    </tr>
                </thead>
                <tbody id="scheduleBody"></tbody>
            </table>
        </div>
    </div>

    @if(isset($djs) && $djs->isNotEmpty())
    <section class="djs-section">
        <h2>🎙️ DJ Profilleri</h2>
        <div class="djs-grid">
            @foreach($djs as $dj)
            <div class="dj-card">
                @if($dj->avatar_url)
                    <img src="{{ $dj->avatar_url }}" alt="{{ $dj->name }}" class="dj-avatar">
                @else
                    <div class="dj-avatar-placeholder">{{ $dj->display_initials }}</div>
                @endif
                <div class="dj-info">
                    <div class="dj-name">{{ $dj->name }}</div>
                    @if($dj->bio)
                        <div class="dj-bio">{{ Str::limit($dj->bio, 120) }}</div>
                    @endif
                </div>
            </div>
            @endforeach
        </div>
    </section>
    @endif
</div>

@push('scripts')
<script>
(function() {
    var dayBtns = document.querySelectorAll('.schedule-day');
    var loadingEl = document.getElementById('scheduleLoading');
    var emptyEl = document.getElementById('scheduleEmpty');
    var tableEl = document.getElementById('scheduleTable');
    var bodyEl = document.getElementById('scheduleBody');
    var currentDay = (function(){ var d = new Date().getDay(); return d === 0 ? 6 : d - 1; })();

    function esc(s) { return (s || '').replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;').replace(/"/g,'&quot;'); }

    function renderSchedule(items) {
        if (loadingEl) loadingEl.style.display = 'none';
        if (emptyEl) emptyEl.style.display = items.length === 0 ? 'block' : 'none';
        if (tableEl) tableEl.style.display = items.length > 0 ? 'table' : 'none';
        if (!bodyEl) return;
        bodyEl.innerHTML = '';
        items.forEach(function(it) {
            var tr = document.createElement('tr');
            var timeStr = (it.start_time || '') + (it.end_time ? ' - ' + it.end_time : '');
            var hostName = (it.dj && it.dj.name) ? it.dj.name : (it.host || '');
            var liveBadge = it.is_live ? '<span class="schedule-live-badge">CANLI</span>' : '';
            tr.innerHTML = '<td class="schedule-time">' + esc(timeStr) + '</td><td>' + esc(it.title || '') + liveBadge + '</td><td>' + esc(hostName) + '</td>';
            bodyEl.appendChild(tr);
        });
    }

    function loadSchedule(day) {
        if (loadingEl) loadingEl.style.display = 'block';
        if (emptyEl) emptyEl.style.display = 'none';
        if (tableEl) tableEl.style.display = 'none';
        fetch('{{ url("/api/schedule") }}?day=' + day)
            .then(function(r) { return r.json(); })
            .then(function(data) { renderSchedule(data.items || []); })
            .catch(function() { renderSchedule([]); });
    }

    dayBtns.forEach(function(btn) {
        btn.addEventListener('click', function() {
            var day = parseInt(btn.getAttribute('data-day'), 10);
            dayBtns.forEach(function(b) { b.classList.remove('active'); });
            btn.classList.add('active');
            loadSchedule(day);
        });
    });

    dayBtns.forEach(function(b) { b.classList.remove('active'); });
    var activeBtn = Array.from(dayBtns).find(function(b) { return parseInt(b.getAttribute('data-day'), 10) === currentDay; });
    if (activeBtn) activeBtn.classList.add('active');
    loadSchedule(currentDay);
})();
</script>
@endpush
@endsection
