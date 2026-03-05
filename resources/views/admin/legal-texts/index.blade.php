@extends('admin.layouts.app')

@section('content')
<div class="card">
    <div class="card-header">
        <h1 class="card-title">Yasal Metinler</h1>
        <p class="card-desc">Kullanım şartları, gizlilik politikası ve diğer yasal sayfaları düzenleyin.</p>
    </div>
    <div class="card-body">
        @if(session('success'))
            <div class="alert-success">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="alert-error">{{ session('error') }}</div>
        @endif

        <ul class="legal-texts-list">
            @foreach($texts as $slug => $config)
            <li class="legal-texts-item">
                <a href="{{ route('admin.legal-texts.edit', $slug) }}" class="legal-texts-link">
                    <span class="legal-texts-icon">📄</span>
                    <span class="legal-texts-title">{{ $config['title'] }}</span>
                    <span class="legal-texts-arrow">→</span>
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
.legal-texts-list { list-style: none; padding: 0; margin: 0; }
.legal-texts-item { margin-bottom: 0.5rem; }
.legal-texts-link { display: flex; align-items: center; gap: 0.75rem; padding: 1rem 1.25rem; background: rgba(255,255,255,0.04); border: 1px solid var(--border); border-radius: 10px; text-decoration: none; color: var(--text); transition: background 0.2s, border-color 0.2s; }
.legal-texts-link:hover { background: rgba(255,255,255,0.08); border-color: rgba(255,255,255,0.15); }
.legal-texts-icon { font-size: 1.25rem; }
.legal-texts-title { flex: 1; font-weight: 600; }
.legal-texts-arrow { color: var(--muted); font-size: 1.1rem; }
</style>
@endpush
@endsection
