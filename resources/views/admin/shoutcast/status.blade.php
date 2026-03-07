@extends('admin.layouts.app')

@section('content')
<div class="card" style="max-width: 700px;">
    <div class="card-header">Online / Offline Kontrol</div>
    <div class="card-body">
        @if(session('success'))
            <div class="settings-success">{{ session('success') }}</div>
        @endif

        <form method="POST" action="{{ route('admin.shoutcast.status') }}">
            @csrf
            <div class="form-group">
                <label>Yayın Durumu</label>
                <p class="form-help">Sitede ve API'de görünen yayın durumunu manuel olarak ayarlayın. "Otomatik" seçildiğinde Shoutcast sunucusundan gerçek durum alınır.</p>
                <div class="radio-group">
                    <label class="radio-option">
                        <input type="radio" name="radio_force_status" value="auto" {{ old('radio_force_status', $settings->radio_force_status ?? 'auto') === 'auto' || empty($settings->radio_force_status) ? 'checked' : '' }}>
                        <span>Otomatik</span> – Sunucudan gerçek durum alınır
                    </label>
                    <label class="radio-option">
                        <input type="radio" name="radio_force_status" value="online" {{ old('radio_force_status', $settings->radio_force_status ?? '') === 'online' ? 'checked' : '' }}>
                        <span>Online</span> – Her zaman "Yayında" göster
                    </label>
                    <label class="radio-option">
                        <input type="radio" name="radio_force_status" value="offline" {{ old('radio_force_status', $settings->radio_force_status ?? '') === 'offline' ? 'checked' : '' }}>
                        <span>Offline</span> – Her zaman "Yayın Dışı" göster
                    </label>
                </div>
                @error('radio_force_status')<span class="form-error">{{ $message }}</span>@enderror
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
.form-help { font-size: 0.85rem; color: var(--muted); margin-bottom: 1rem; line-height: 1.4; }
.radio-group { display: flex; flex-direction: column; gap: 0.75rem; }
.radio-option { display: flex; align-items: center; gap: 0.5rem; cursor: pointer; font-size: 0.9rem; color: var(--text); padding: 0.75rem 1rem; background: rgba(255,255,255,0.04); border-radius: 10px; border: 1px solid var(--border); }
.radio-option input { accent-color: var(--accent); }
.radio-option span { font-weight: 600; }
.form-error { font-size: 0.8rem; color: #f87171; margin-top: 0.35rem; display: block; }
.form-actions { margin-top: 1.5rem; }
.btn-save { padding: 0.65rem 1.25rem; font-size: 0.9rem; font-weight: 600; background: linear-gradient(135deg, #dc2626, var(--accent)); color: #fff; border: none; border-radius: 10px; cursor: pointer; }
</style>
@endpush
@endsection
