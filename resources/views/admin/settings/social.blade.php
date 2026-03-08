@extends('admin.layouts.app')

@section('content')
<div class="card" style="max-width: 700px;">
    <div class="card-header">Sosyal Medya Linkleri</div>
    <div class="card-body">
        @if(session('success'))
            <div class="settings-success">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="settings-error">{{ session('error') }}</div>
        @endif

        <form method="POST" action="{{ route('admin.settings.social') }}">
            @csrf

            @php
                $platforms = [
                    'whatsapp' => ['label' => 'WhatsApp', 'placeholder' => 'https://wa.me/905551234567'],
                    'telegram' => ['label' => 'Telegram', 'placeholder' => 'https://t.me/radyoyol'],
                    'instagram' => ['label' => 'Instagram', 'placeholder' => 'https://instagram.com/radyoyol'],
                    'facebook' => ['label' => 'Facebook', 'placeholder' => 'https://facebook.com/radyoyol'],
                    'tiktok' => ['label' => 'TikTok', 'placeholder' => 'https://tiktok.com/@radyoyol'],
                    'youtube' => ['label' => 'YouTube', 'placeholder' => 'https://youtube.com/@radyoyol'],
                    'x' => ['label' => 'X (Twitter)', 'placeholder' => 'https://x.com/radyoyol'],
                    'android_app' => ['label' => 'Android Uygulaması', 'placeholder' => 'https://play.google.com/store/apps/details?id=...'],
                    'ios_app' => ['label' => 'iOS Uygulaması', 'placeholder' => 'https://apps.apple.com/app/...'],
                    'winamp' => ['label' => 'Winamp İle Dinle', 'placeholder' => 'https://stream.example.com/live.m3u'],
                    'media_player' => ['label' => 'Medya Player', 'placeholder' => 'https://stream.example.com/live.m3u'],
                    'quicktime' => ['label' => 'QuickTime Player', 'placeholder' => 'https://stream.example.com/live.m3u'],
                    'real_player' => ['label' => 'Real Player', 'placeholder' => 'https://stream.example.com/live.ram'],
                ];
            @endphp

            @foreach($platforms as $key => $info)
            <div class="form-group social-row">
                <div class="social-row-header">
                    <label for="{{ $key }}_url">{{ $info['label'] }}</label>
                    <label class="toggle-label">
                        <input type="hidden" name="{{ $key }}_active" value="0">
                        <input type="checkbox" name="{{ $key }}_active" id="{{ $key }}_active" value="1"
                            {{ old($key . '_active', ${$key . '_active'} ?? false) ? 'checked' : '' }}>
                        <span class="toggle-text">Aktif</span>
                    </label>
                </div>
                <input type="url" name="{{ $key }}_url" id="{{ $key }}_url"
                    value="{{ old($key . '_url', ${$key . '_url'} ?? '') }}"
                    placeholder="{{ $info['placeholder'] }}">
                @error($key . '_url')<span class="form-error">{{ $message }}</span>@enderror
            </div>
            @endforeach

            <div class="form-actions">
                <button type="submit" class="btn-save">Kaydet</button>
            </div>
        </form>

        @include('admin.settings.partials.export-sql-link')
    </div>
</div>

@push('styles')
<style>
.settings-success { padding: 0.75rem 1rem; background: rgba(34,197,94,0.2); border: 1px solid rgba(34,197,94,0.4); border-radius: 10px; color: #86efac; font-size: 0.9rem; margin-bottom: 1.25rem; }
.settings-error { padding: 0.75rem 1rem; background: rgba(239,68,68,0.2); border: 1px solid rgba(239,68,68,0.4); border-radius: 10px; color: #fca5a5; font-size: 0.9rem; margin-bottom: 1.25rem; }
.form-group { margin-bottom: 1.25rem; }
.form-group label { display: block; font-size: 0.9rem; font-weight: 600; color: var(--text); margin-bottom: 0.5rem; }
.social-row-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.5rem; }
.social-row-header label:first-child { margin-bottom: 0; }
.toggle-label { display: flex; align-items: center; gap: 0.5rem; font-weight: 500; font-size: 0.85rem; cursor: pointer; }
.toggle-label input[type="checkbox"] { width: 18px; height: 18px; accent-color: var(--accent); cursor: pointer; }
.form-group input[type="url"] { width: 100%; padding: 0.75rem 1rem; font-size: 0.9rem; background: rgba(255,255,255,0.06); border: 1px solid var(--border); border-radius: 10px; color: var(--text); }
.form-error { font-size: 0.8rem; color: #f87171; margin-top: 0.35rem; display: block; }
.form-actions { margin-top: 1.5rem; }
</style>
@endpush
@endsection
