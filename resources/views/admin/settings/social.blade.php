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
                <label for="social_facebook">Facebook URL</label>
                <input type="url" name="social_facebook" id="social_facebook"
                    value="{{ old('social_facebook', $social_facebook ?? '') }}"
                    placeholder="https://facebook.com/radyoyol">
                @error('social_facebook')<span class="form-error">{{ $message }}</span>@enderror
            </div>

            <div class="form-group">
                <label for="social_x">X (Twitter) URL</label>
                <input type="url" name="social_x" id="social_x"
                    value="{{ old('social_x', $social_x ?? '') }}"
                    placeholder="https://x.com/radyoyol">
                @error('social_x')<span class="form-error">{{ $message }}</span>@enderror
            </div>

            <div class="form-group">
                <label for="social_youtube">YouTube URL</label>
                <input type="url" name="social_youtube" id="social_youtube"
                    value="{{ old('social_youtube', $social_youtube ?? '') }}"
                    placeholder="https://youtube.com/@radyoyol">
                @error('social_youtube')<span class="form-error">{{ $message }}</span>@enderror
            </div>

            <div class="form-group">
                <label for="social_instagram">Instagram URL</label>
                <input type="url" name="social_instagram" id="social_instagram"
                    value="{{ old('social_instagram', $social_instagram ?? '') }}"
                    placeholder="https://instagram.com/radyoyol">
                @error('social_instagram')<span class="form-error">{{ $message }}</span>@enderror
            </div>

            <div class="form-group">
                <label for="social_tiktok">TikTok URL</label>
                <input type="url" name="social_tiktok" id="social_tiktok"
                    value="{{ old('social_tiktok', $social_tiktok ?? '') }}"
                    placeholder="https://tiktok.com/@radyoyol">
                @error('social_tiktok')<span class="form-error">{{ $message }}</span>@enderror
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
