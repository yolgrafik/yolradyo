@extends('admin.layouts.app')

@section('content')
<div class="card">
    <div class="card-header">
        <h1 class="card-title">Hakkımızda Sayfaları</h1>
        <p class="card-desc">Hakkımızda ana menüsü altındaki sabit sayfaları buradan yönetin.</p>
    </div>
    <div class="card-body">
        @if(session('success'))
            <div class="alert-success">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="alert-error">{{ session('error') }}</div>
        @endif

        <ul class="about-list">
            @foreach(['biz-kimiz', 'misyon', 'politika', 'reklam'] as $slug)
                @php $page = $pages[$slug] ?? null; @endphp
                <li class="about-item">
                    <a href="{{ route('admin.about-pages.edit', $slug) }}" class="about-link">
                        <div class="about-title-wrap">
                            <span class="about-title">{{ $page?->title ?? ucfirst(str_replace('-', ' ', $slug)) }}</span>
                            <span class="about-slug">/{{ $slug }}</span>
                        </div>
                        <span class="about-status {{ ($page?->is_active ?? false) ? 'is-active' : 'is-passive' }}">
                            {{ ($page?->is_active ?? false) ? 'Aktif' : 'Pasif' }}
                        </span>
                        <span class="about-arrow">→</span>
                    </a>
                </li>
            @endforeach
        </ul>
    </div>
</div>

@push('styles')
<style>
.card-title { font-size: 1.25rem; font-weight: 700; margin: 0 0 0.25rem 0; }
.card-desc { font-size: 0.9rem; color: var(--muted); margin: 0 0 1.5rem 0; }
.alert-success { padding: 0.75rem 1rem; background: rgba(34,197,94,0.2); border: 1px solid rgba(34,197,94,0.4); border-radius: 10px; color: #86efac; margin-bottom: 1rem; }
.alert-error { padding: 0.75rem 1rem; background: rgba(239,68,68,0.2); border: 1px solid rgba(239,68,68,0.4); border-radius: 10px; color: #fca5a5; margin-bottom: 1rem; }
.about-list { list-style: none; padding: 0; margin: 0; }
.about-item { margin-bottom: 0.5rem; }
.about-link { display: flex; align-items: center; gap: 0.85rem; padding: 1rem 1.25rem; background: rgba(255,255,255,0.04); border: 1px solid var(--border); border-radius: 10px; text-decoration: none; color: var(--text); }
.about-link:hover { background: rgba(255,255,255,0.08); border-color: rgba(255,255,255,0.15); }
.about-title-wrap { flex: 1; min-width: 0; display: flex; gap: 0.5rem; align-items: baseline; }
.about-title { font-weight: 700; }
.about-slug { color: var(--muted); font-size: 0.82rem; }
.about-status { font-size: 0.75rem; font-weight: 700; border-radius: 999px; padding: 0.25rem 0.65rem; }
.about-status.is-active { background: rgba(34,197,94,0.2); color: #86efac; border: 1px solid rgba(34,197,94,0.4); }
.about-status.is-passive { background: rgba(239,68,68,0.18); color: #fca5a5; border: 1px solid rgba(239,68,68,0.35); }
.about-arrow { color: var(--muted); font-size: 1.1rem; }
</style>
@endpush
@endsection
