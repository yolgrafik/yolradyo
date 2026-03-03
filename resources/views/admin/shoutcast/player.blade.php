@extends('admin.layouts.app')

@section('content')
<div class="card" style="max-width: 700px;">
    <div class="card-header">Web Player Yonetimi</div>
    <div class="card-body">
        @if(session('success'))
            <div style="padding: 0.75rem 1rem; background: rgba(34,197,94,0.2); border: 1px solid rgba(34,197,94,0.4); border-radius: 10px; color: #86efac; font-size: 0.9rem; margin-bottom: 1.25rem;">
                {{ session('success') }}
            </div>
        @endif

        <form method="POST" action="{{ route('admin.shoutcast.player.store') }}">
            @csrf

            <div style="margin-bottom: 1.25rem;">
                <label for="radio_stream_url" style="display: block; font-size: 0.9rem; font-weight: 600; color: var(--text); margin-bottom: 0.5rem;">Stream URL (ana)</label>
                <input type="url" name="radio_stream_url" id="radio_stream_url"
                    value="{{ old('radio_stream_url', $settings->radio_stream_url ?? '') }}"
                    placeholder="https://stream.radyoyol.com:8000/live"
                    style="width: 100%; padding: 0.75rem 1rem; font-size: 0.9rem; background: rgba(255,255,255,0.06); border: 1px solid var(--border); border-radius: 10px; color: var(--text);">
                @error('radio_stream_url')
                    <span style="font-size: 0.8rem; color: #f87171; margin-top: 0.35rem; display: block;">{{ $message }}</span>
                @enderror
            </div>

            <div style="margin-bottom: 1.25rem;">
                <label for="radio_backup_stream_url" style="display: block; font-size: 0.9rem; font-weight: 600; color: var(--text); margin-bottom: 0.5rem;">Yedek Stream URL (opsiyonel)</label>
                <input type="url" name="radio_backup_stream_url" id="radio_backup_stream_url"
                    value="{{ old('radio_backup_stream_url', $settings->radio_backup_stream_url ?? '') }}"
                    placeholder="https://backup.radyoyol.com:8000/live"
                    style="width: 100%; padding: 0.75rem 1rem; font-size: 0.9rem; background: rgba(255,255,255,0.06); border: 1px solid var(--border); border-radius: 10px; color: var(--text);">
                @error('radio_backup_stream_url')
                    <span style="font-size: 0.8rem; color: #f87171; margin-top: 0.35rem; display: block;">{{ $message }}</span>
                @enderror
            </div>

            <div style="margin-bottom: 1.25rem;">
                <label style="display: flex; align-items: center; gap: 0.5rem; cursor: pointer;">
                    <input type="checkbox" name="radio_auto_play" value="1"
                        {{ old('radio_auto_play', $settings->radio_auto_play ?? false) ? 'checked' : '' }}
                        style="width: 18px; height: 18px; accent-color: var(--accent);">
                    <span style="font-size: 0.9rem; font-weight: 600; color: var(--text);">Otomatik oynat (sayfa yuklendiginde)</span>
                </label>
            </div>

            <div style="margin-bottom: 1.25rem;">
                <label for="radio_default_volume" style="display: block; font-size: 0.9rem; font-weight: 600; color: var(--text); margin-bottom: 0.5rem;">Varsayilan ses seviyesi (0–1)</label>
                <input type="number" name="radio_default_volume" id="radio_default_volume" step="0.1" min="0" max="1"
                    value="{{ old('radio_default_volume', $settings->radio_default_volume ?? 0.8) }}"
                    style="width: 120px; padding: 0.75rem 1rem; font-size: 0.9rem; background: rgba(255,255,255,0.06); border: 1px solid var(--border); border-radius: 10px; color: var(--text);">
                @error('radio_default_volume')
                    <span style="font-size: 0.8rem; color: #f87171; margin-top: 0.35rem; display: block;">{{ $message }}</span>
                @enderror
            </div>

            <hr style="border: none; border-top: 1px solid var(--border); margin: 1.5rem 0;">
            <h3 style="font-size: 1rem; font-weight: 700; color: var(--text); margin-bottom: 1rem;">SHOUTcast Now Playing</h3>
            <div style="margin-bottom: 1.25rem;">
                <label for="shoutcast_base_url" style="display: block; font-size: 0.9rem; font-weight: 600; color: var(--text); margin-bottom: 0.5rem;">SHOUTCAST_BASE_URL</label>
                <input type="url" name="shoutcast_base_url" id="shoutcast_base_url"
                    value="{{ old('shoutcast_base_url', $settings->shoutcast_base_url ?? '') }}"
                    placeholder="https://yourhost:8000"
                    style="width: 100%; padding: 0.75rem 1rem; font-size: 0.9rem; background: rgba(255,255,255,0.06); border: 1px solid var(--border); border-radius: 10px; color: var(--text);">
                @error('shoutcast_base_url')
                    <span style="font-size: 0.8rem; color: #f87171; margin-top: 0.35rem; display: block;">{{ $message }}</span>
                @enderror
            </div>
            <div style="margin-bottom: 1.25rem;">
                <label for="shoutcast_sid" style="display: block; font-size: 0.9rem; font-weight: 600; color: var(--text); margin-bottom: 0.5rem;">SHOUTCAST_SID (varsayilan: 1)</label>
                <input type="number" name="shoutcast_sid" id="shoutcast_sid" min="1" max="255"
                    value="{{ old('shoutcast_sid', $settings->shoutcast_sid ?? 1) }}"
                    style="width: 120px; padding: 0.75rem 1rem; font-size: 0.9rem; background: rgba(255,255,255,0.06); border: 1px solid var(--border); border-radius: 10px; color: var(--text);">
                @error('shoutcast_sid')
                    <span style="font-size: 0.8rem; color: #f87171; margin-top: 0.35rem; display: block;">{{ $message }}</span>
                @enderror
            </div>

            <div style="display: flex; flex-wrap: wrap; gap: 0.75rem; align-items: center;">
                <button type="submit" style="padding: 0.65rem 1.25rem; font-size: 0.9rem; font-weight: 600; background: linear-gradient(135deg, #dc2626, var(--accent)); color: #fff; border: none; border-radius: 10px; cursor: pointer;">
                    Kaydet
                </button>
                <button type="button" id="streamTestBtn" style="display: inline-flex; align-items: center; gap: 0.5rem; padding: 0.65rem 1.25rem; font-size: 0.9rem; font-weight: 600; background: rgba(255,255,255,0.08); color: var(--text); border: 1px solid var(--border); border-radius: 10px; cursor: pointer;">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polygon points="5 3 19 12 5 21 5 3"/></svg>
                    Stream Test
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
(function() {
    var btn = document.getElementById('streamTestBtn');
    var urlInput = document.getElementById('radio_stream_url');
    if (btn && urlInput) {
        btn.addEventListener('click', function() {
            var url = urlInput.value.trim();
            if (!url) {
                alert('Lütfen önce Stream URL girin.');
                return;
            }
            window.open(url, '_blank', 'noopener,noreferrer');
        });
    }
})();
</script>
@endpush
@endsection
