@extends('layouts.frontend')

@section('title', 'Bize Gönder')

@push('styles')
<style>
.page-hero { padding: 2.5rem 1.5rem; background: var(--ry-header-bg); border-bottom: 1px solid var(--ry-border); }
.page-hero h1 { font-size: 1.75rem; font-weight: 700; color: #fff; margin: 0; }
.page-content { max-width: 700px; margin: 0 auto; padding: 2rem 1.5rem; }
.submit-form { background: var(--ry-bar-bg); border: 1px solid rgba(255,255,255,0.08); border-top: 1px solid var(--ry-line-color); border-bottom: 1px solid var(--ry-line-color); border-radius: 14px; padding: 1.5rem; }
.submit-form h3 { font-size: 1.1rem; color: #fff; margin: 0 0 1rem 0; }
.form-group { margin-bottom: 1rem; }
.form-group label { display: block; font-size: 0.9rem; font-weight: 600; color: var(--text); margin-bottom: 0.35rem; }
.form-input { width: 100%; padding: 0.75rem 1rem; background: rgba(255,255,255,0.06); border: 1px solid rgba(255,255,255,0.15); border-radius: 10px; color: var(--text); font-size: 0.95rem; }
.form-input:focus { outline: none; border-color: var(--ry-schedule-active); }
.form-hp { position: absolute; left: -9999px; }
.btn-submit { padding: 0.75rem 1.5rem; font-size: 0.95rem; font-weight: 600; background: linear-gradient(135deg, #c92a2a, #b30000); color: #fff; border: none; border-radius: 10px; cursor: pointer; }
.btn-submit:hover { opacity: 0.9; }
.btn-submit:disabled { opacity: 0.6; cursor: not-allowed; }
.alert-success { padding: 0.75rem 1rem; background: rgba(34,197,94,0.2); border: 1px solid rgba(34,197,94,0.4); border-radius: 10px; color: #86efac; margin-bottom: 1rem; }
.alert-error { padding: 0.75rem 1rem; background: rgba(239,68,68,0.2); border: 1px solid rgba(239,68,68,0.4); border-radius: 10px; color: #fca5a5; margin-bottom: 1rem; }
.form-error { font-size: 0.8rem; color: #f87171; margin-top: 0.25rem; }
.form-hint { font-size: 0.8rem; color: var(--muted); margin-top: 0.25rem; }
.type-option { display: none; }
</style>
@endpush

@section('content')
<section class="page-hero">
    <h1>Bize Gönder</h1>
</section>
<div class="page-content">
    <p style="color:var(--muted);margin-bottom:1rem;">İstek, şikayet, video linki veya MP3 gönderebilirsiniz. Gönderileriniz incelendikten sonra yayına alınacaktır.</p>

    <div class="submit-form">
        @if(session('success'))
            <div class="alert-success">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="alert-error">{{ session('error') }}</div>
        @endif

        <p class="form-hint" style="margin-bottom:1rem;">Bugünkü gönderiniz: {{ $todayCount }} / {{ $dailyLimit }}</p>

        <form method="POST" action="{{ route('bize-gonder.store') }}" enctype="multipart/form-data" id="submitForm">
            @csrf
            <div class="form-group form-hp" aria-hidden="true">
                <label for="website">Website</label>
                <input type="text" name="website" id="website" tabindex="-1" autocomplete="off">
            </div>
            <div class="form-group">
                <label for="type">Tür *</label>
                <select name="type" id="type" class="form-input" required>
                    <option value="">Seçiniz</option>
                    <option value="istek" {{ old('type') === 'istek' ? 'selected' : '' }}>İstek</option>
                    <option value="sikayet" {{ old('type') === 'sikayet' ? 'selected' : '' }}>Şikayet</option>
                    <option value="image" {{ old('type') === 'image' ? 'selected' : '' }}>Fotoğraf</option>
                    <option value="video" {{ old('type') === 'video' ? 'selected' : '' }}>Video (Link veya Dosya)</option>
                    <option value="mp3" {{ old('type') === 'mp3' ? 'selected' : '' }}>MP3 Gönder</option>
                </select>
            </div>
            <div class="form-group">
                <label for="title">Başlık *</label>
                <input type="text" name="title" id="title" class="form-input" value="{{ old('title') }}" required maxlength="255">
                @error('title')<span class="form-error">{{ $message }}</span>@enderror
            </div>
            <div class="form-group">
                <label for="description">Açıklama</label>
                <textarea name="description" id="description" class="form-input" rows="4" maxlength="5000">{{ old('description') }}</textarea>
                @error('description')<span class="form-error">{{ $message }}</span>@enderror
            </div>
            <div class="form-group type-option" id="imageGroup">
                <label for="image_file">Fotoğraf * (max 10MB)</label>
                <input type="file" name="image_file" id="image_file" class="form-input" accept="image/*">
                @error('image_file')<span class="form-error">{{ $message }}</span>@enderror
            </div>
            <div class="form-group type-option" id="videoGroup">
                <label for="video_url">Video Link (YouTube, TikTok, Instagram vb.)</label>
                <input type="url" name="video_url" id="video_url" class="form-input" value="{{ old('video_url') }}" placeholder="https://...">
                <p class="form-hint">veya video dosyası yükleyin (max {{ $maxVideoMb }}MB):</p>
                <input type="file" name="video_file" id="video_file" class="form-input" accept="video/mp4,video/webm,video/quicktime" style="margin-top:0.5rem;">
                @error('video_url')<span class="form-error">{{ $message }}</span>@enderror
                @error('video_file')<span class="form-error">{{ $message }}</span>@enderror
            </div>
            <div class="form-group type-option" id="mp3Group">
                <label for="mp3_file">MP3 Dosyası * (max {{ $maxMp3Mb }}MB)</label>
                <input type="file" name="mp3_file" id="mp3_file" class="form-input" accept=".mp3,audio/mpeg">
                @error('mp3_file')<span class="form-error">{{ $message }}</span>@enderror
            </div>
            <button type="submit" class="btn-submit" id="submitBtn">Gönder</button>
        </form>
    </div>
</div>

@push('scripts')
<script>
(function() {
    var type = document.getElementById('type');
    var imageGroup = document.getElementById('imageGroup');
    var videoGroup = document.getElementById('videoGroup');
    var mp3Group = document.getElementById('mp3Group');
    var imageInput = document.getElementById('image_file');
    var videoInput = document.getElementById('video_url');
    var mp3Input = document.getElementById('mp3_file');

    function toggleFields() {
        var v = type.value;
        imageGroup.style.display = v === 'image' ? 'block' : 'none';
        videoGroup.style.display = v === 'video' ? 'block' : 'none';
        mp3Group.style.display = v === 'mp3' ? 'block' : 'none';
        if (v !== 'image') imageInput.removeAttribute('required');
        else imageInput.setAttribute('required', 'required');
        if (v !== 'video') { videoInput.removeAttribute('required'); }
        if (v !== 'mp3') mp3Input.removeAttribute('required');
        else mp3Input.setAttribute('required', 'required');
    }
    type.addEventListener('change', toggleFields);
    toggleFields();

    document.getElementById('submitForm')?.addEventListener('submit', function() {
        var btn = document.getElementById('submitBtn');
        if (btn) btn.disabled = true;
    });
})();
</script>
@endpush
@endsection
