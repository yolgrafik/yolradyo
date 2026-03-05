@extends('layouts.frontend')

@section('title', 'Programlar')

@php
    $dayNames = ['Pazartesi', 'Salı', 'Çarşamba', 'Perşembe', 'Cuma', 'Cumartesi', 'Pazar'];
@endphp

@push('styles')
<style>
    .programlar-layout { max-width: 1200px; margin: 0 auto; padding: 2rem 1rem; }
    .programlar-hero { padding: 2rem 0; margin-bottom: 2rem; border-bottom: 1px solid var(--ry-border); }
    .programlar-hero h1 { font-size: 2rem; font-weight: 700; color: #fff; margin: 0 0 0.5rem 0; }
    .programlar-hero p { color: var(--muted); font-size: 1rem; margin: 0; }
    .dj-section { margin-bottom: 2.5rem; }
    .dj-card { background: var(--ry-bar-bg); border: 1px solid rgba(255,255,255,0.08); border-radius: 14px; overflow: hidden; }
    .dj-header { display: flex; align-items: center; gap: 1.25rem; padding: 1.25rem 1.5rem; background: rgba(255,255,255,0.03); flex-wrap: wrap; }
    .dj-avatar { width: 80px; height: 80px; border-radius: 14px; object-fit: cover; flex-shrink: 0; background: rgba(255,255,255,0.06); }
    .dj-avatar-placeholder { width: 80px; height: 80px; border-radius: 14px; background: var(--ry-schedule-active); color: #fff; display: flex; align-items: center; justify-content: center; font-size: 1.75rem; font-weight: 800; flex-shrink: 0; }
    .dj-info { flex: 1; min-width: 0; }
    .dj-name { font-size: 1.25rem; font-weight: 700; color: #fff; margin-bottom: 0.35rem; }
    .dj-bio { font-size: 0.9rem; color: var(--muted); line-height: 1.5; }
    .dj-programs { padding: 1rem 1.5rem; }
    .dj-programs-title { font-size: 0.8rem; text-transform: uppercase; letter-spacing: 0.06em; color: var(--muted); font-weight: 600; margin-bottom: 1rem; }
    .program-item { display: flex; gap: 1rem; padding: 1rem 0; border-bottom: 1px solid rgba(255,255,255,0.06); align-items: flex-start; flex-wrap: wrap; }
    .program-item:last-child { border-bottom: none; }
    .program-day-time { flex-shrink: 0; min-width: 140px; font-size: 0.85rem; }
    .program-day { font-weight: 600; color: var(--ry-schedule-active); }
    .program-time { color: var(--muted); font-size: 0.8rem; margin-top: 2px; }
    .program-content { flex: 1; min-width: 0; }
    .program-title { font-weight: 600; color: #fff; margin-bottom: 0.25rem; }
    .program-desc { font-size: 0.9rem; color: var(--muted); line-height: 1.5; }
    .program-empty { padding: 2rem; text-align: center; color: var(--muted); font-size: 0.95rem; }
    @media (max-width: 768px) {
        .dj-header { flex-direction: column; align-items: flex-start; }
        .program-item { flex-direction: column; gap: 0.5rem; }
    }
</style>
@endpush

@section('content')
<div class="programlar-layout">
    <section class="programlar-hero">
        <h1>Programlar</h1>
        <p>DJ'lere göre haftalık yayın takvimi ve program açıklamaları</p>
    </section>

    @if(isset($djs) && $djs->isNotEmpty())
        @foreach($djs as $dj)
        <section class="dj-section">
            <div class="dj-card">
                <div class="dj-header">
                    @if($dj->avatar_url)
                        <img src="{{ $dj->avatar_url }}" alt="{{ $dj->name }}" class="dj-avatar">
                    @else
                        <div class="dj-avatar-placeholder">{{ $dj->display_initials }}</div>
                    @endif
                    <div class="dj-info">
                        <div class="dj-name">{{ $dj->name }}</div>
                        @if($dj->bio)
                            <div class="dj-bio">{{ $dj->bio }}</div>
                        @endif
                    </div>
                </div>
                <div class="dj-programs">
                    <div class="dj-programs-title">Yayın Takvimi</div>
                    @php $schedules = $dj->schedules ?? collect(); @endphp
                    @if($schedules->isNotEmpty())
                        @foreach($schedules as $s)
                        <div class="program-item">
                            <div class="program-day-time">
                                <div class="program-day">{{ $dayNames[$s->day_of_week] ?? '-' }}</div>
                                <div class="program-time">
                                    {{ $s->start_time_formatted }}{{ $s->end_time ? ' - ' . $s->end_time_formatted : '' }}
                                </div>
                            </div>
                            <div class="program-content">
                                <div class="program-title">{{ $s->title }}</div>
                                @if($s->description)
                                    <div class="program-desc">{{ $s->description }}</div>
                                @endif
                            </div>
                        </div>
                        @endforeach
                    @else
                        <div class="program-empty">Bu DJ için henüz program tanımlanmamış.</div>
                    @endif
                </div>
            </div>
        </section>
        @endforeach
    @else
        <div class="dj-card">
            <div class="program-empty">Henüz DJ profili veya program eklenmemiş.</div>
        </div>
    @endif
</div>
@endsection
