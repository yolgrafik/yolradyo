@extends('admin.layouts.app')

@section('content')
<div class="card" style="max-width: 700px;">
    <div class="card-header">Now Playing Kontrol</div>
    <div class="card-body">
        @if(session('success'))
            <div class="settings-success">{{ session('success') }}</div>
        @endif

        <form method="POST" action="{{ route('admin.shoutcast.nowplaying') }}">
            @csrf
            <div class="form-group">
                <label for="shoutcast_base_url">SHOUTcast Base URL</label>
                <input type="url" name="shoutcast_base_url" id="shoutcast_base_url"
                    value="{{ old('shoutcast_base_url', $settings->shoutcast_base_url ?? '') }}"
                    placeholder="https://yourhost:8000"
                    class="form-input">
                <p class="form-help">Shoutcast sunucu adresi (port dahil). "Şu An Çalıyor" ve dinleyici sayısı bu adresten alınır.</p>
                @error('shoutcast_base_url')<span class="form-error">{{ $message }}</span>@enderror
            </div>
            <div class="form-group">
                <label for="shoutcast_sid">SHOUTcast SID (Stream ID)</label>
                <input type="number" name="shoutcast_sid" id="shoutcast_sid" min="1" max="255"
                    value="{{ old('shoutcast_sid', $settings->shoutcast_sid ?? 1) }}"
                    class="form-input" style="width: 120px;">
                <p class="form-help">Varsayılan: 1. Birden fazla stream varsa ilgili ID'yi girin.</p>
                @error('shoutcast_sid')<span class="form-error">{{ $message }}</span>@enderror
            </div>
            <div class="form-actions">
                <button type="submit" class="btn-save">Kaydet</button>
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
.form-actions { margin-top: 1.5rem; }
</style>
@endpush
@endsection
