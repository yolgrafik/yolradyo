@extends('admin.layouts.app')

@section('content')
<div class="card" style="max-width: 700px;">
    <div class="card-header">Sosyal Medya Linkleri</div>
    <div class="card-body">
        @if(session('success'))
            <div class="settings-success">{{ session('success') }}</div>
        @endif

        <form method="POST" action="{{ route('admin.settings.social') }}">
            @csrf

            <div class="form-group">
                <label for="whatsapp_url">WhatsApp URL</label>
                <input type="url" name="whatsapp_url" id="whatsapp_url"
                    value="{{ old('whatsapp_url', $whatsapp_url ?? '') }}"
                    placeholder="https://wa.me/905551234567">
                @error('whatsapp_url')<span class="form-error">{{ $message }}</span>@enderror
            </div>

            <div class="form-group">
                <label for="facebook_url">Facebook URL</label>
                <input type="url" name="facebook_url" id="facebook_url"
                    value="{{ old('facebook_url', $facebook_url ?? '') }}"
                    placeholder="https://facebook.com/radyoyol">
                @error('facebook_url')<span class="form-error">{{ $message }}</span>@enderror
            </div>

            <div class="form-group">
                <label for="instagram_url">Instagram URL</label>
                <input type="url" name="instagram_url" id="instagram_url"
                    value="{{ old('instagram_url', $instagram_url ?? '') }}"
                    placeholder="https://instagram.com/radyoyol">
                @error('instagram_url')<span class="form-error">{{ $message }}</span>@enderror
            </div>

            <div class="form-group">
                <label for="youtube_url">YouTube URL</label>
                <input type="url" name="youtube_url" id="youtube_url"
                    value="{{ old('youtube_url', $youtube_url ?? '') }}"
                    placeholder="https://youtube.com/@radyoyol">
                @error('youtube_url')<span class="form-error">{{ $message }}</span>@enderror
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
.form-group input { width: 100%; padding: 0.75rem 1rem; font-size: 0.9rem; background: rgba(255,255,255,0.06); border: 1px solid var(--border); border-radius: 10px; color: var(--text); }
.form-error { font-size: 0.8rem; color: #f87171; margin-top: 0.35rem; display: block; }
.form-actions { margin-top: 1.5rem; }
.btn-save { padding: 0.65rem 1.25rem; font-size: 0.9rem; font-weight: 600; background: linear-gradient(135deg, #dc2626, var(--accent)); color: #fff; border: none; border-radius: 10px; cursor: pointer; }
</style>
@endpush
@endsection
