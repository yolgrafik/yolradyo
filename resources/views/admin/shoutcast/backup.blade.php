@extends('admin.layouts.app')

@section('content')
<div class="card" style="max-width: 700px;">
    <div class="card-header">Yedek Stream</div>
    <div class="card-body">
        @if(session('success'))
            <div class="settings-success">{{ session('success') }}</div>
        @endif

        <form method="POST" action="{{ route('admin.shoutcast.backup') }}">
            @csrf
            <div class="form-group">
                <label for="radio_backup_stream_url">Yedek Stream URL</label>
                <input type="url" name="radio_backup_stream_url" id="radio_backup_stream_url"
                    value="{{ old('radio_backup_stream_url', $settings->radio_backup_stream_url ?? '') }}"
                    placeholder="https://backup.radyoyol.com:8000/live"
                    class="form-input">
                <p class="form-help">Ana stream erişilemez olduğunda kullanılacak yedek stream adresi. Opsiyonel.</p>
                @error('radio_backup_stream_url')<span class="form-error">{{ $message }}</span>@enderror
            </div>
            <div class="form-actions">
                <button type="submit" class="btn-save">Kaydet</button>
                <a href="{{ route('admin.shoutcast.stream') }}" class="btn-secondary">Stream Link Ayarları</a>
            </div>
        </form>
    </div>
</div>

@push('styles')
<style>
.settings-success { padding: 0.75rem 1rem; background: rgba(34,197,94,0.2); border: 1px solid rgba(34,197,94,0.4); border-radius: 10px; color: #86efac; font-size: 0.9rem; margin-bottom: 1.25rem; }
.form-group { margin-bottom: 1.25rem; }
.form-group label { display: block; font-size: 0.9rem; font-weight: 600; color: var(--text); margin-bottom: 0.5rem; }
.form-input { width: 100%; padding: 0.75rem 1rem; font-size: 0.9rem; background: rgba(255,255,255,0.06); border: 1px solid var(--border); border-radius: 10px; color: var(--text); }
.form-help { font-size: 0.8rem; color: var(--muted); margin-top: 0.35rem; }
.form-error { font-size: 0.8rem; color: #f87171; margin-top: 0.35rem; display: block; }
.form-actions { margin-top: 1.5rem; display: flex; gap: 0.75rem; flex-wrap: wrap; }
.btn-secondary { padding: 0.65rem 1.25rem; font-size: 0.9rem; font-weight: 600; background: rgba(255,255,255,0.08); color: var(--text); border: 1px solid var(--border); border-radius: 10px; cursor: pointer; text-decoration: none; }
</style>
@endpush
@endsection
