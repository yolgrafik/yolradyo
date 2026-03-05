@extends('layouts.frontend')

@section('title', 'Yeni Gönderi - Forum')

@push('styles')
<style>
.page-hero { padding: 2rem 1.5rem; background: var(--ry-header-bg); border-bottom: 1px solid var(--ry-border); }
.page-hero h1 { font-size: 1.75rem; font-weight: 700; color: #fff; margin: 0; }
.forum-form-wrap { max-width: 600px; margin: 0 auto; padding: 2rem 1.5rem; }
.form-card { background: var(--ry-bar-bg); border: 1px solid rgba(255,255,255,0.08); border-radius: 14px; padding: 1.5rem; }
.form-group { margin-bottom: 1.25rem; }
.form-group label { display: block; font-size: 0.9rem; font-weight: 600; color: var(--text); margin-bottom: 0.35rem; }
.form-input, .form-textarea { width: 100%; padding: 0.75rem 1rem; background: rgba(255,255,255,0.06); border: 1px solid rgba(255,255,255,0.15); border-radius: 10px; color: var(--text); font-size: 0.95rem; }
.form-textarea { min-height: 120px; resize: vertical; }
.form-input:focus, .form-textarea:focus { outline: none; border-color: var(--ry-schedule-active); }
.form-error { font-size: 0.8rem; color: #f87171; margin-top: 0.25rem; }
.form-hint { font-size: 0.8rem; color: var(--muted); margin-top: 0.25rem; }
.btn-submit { padding: 0.75rem 1.5rem; font-size: 0.95rem; font-weight: 600; background: var(--ry-btn-bg); color: #fff; border: none; border-radius: 10px; cursor: pointer; }
.btn-submit:hover { opacity: 0.95; }
.alert-error { padding: 0.75rem 1rem; background: rgba(239,68,68,0.2); border: 1px solid rgba(239,68,68,0.4); border-radius: 10px; color: #fca5a5; margin-bottom: 1rem; }
.back-link { display: inline-block; margin-bottom: 1rem; color: var(--ry-schedule-active); text-decoration: none; font-size: 0.9rem; }
.back-link:hover { text-decoration: underline; }
.type-option { display: none; }
.disclaimer-box { padding: 1rem; background: rgba(239,68,68,0.1); border: 1px solid rgba(239,68,68,0.3); border-radius: 10px; margin-bottom: 1rem; }
.disclaimer-box label { display: flex; align-items: flex-start; gap: 0.75rem; cursor: pointer; font-weight: 500; }
.disclaimer-box input[type="checkbox"] { margin-top: 0.25rem; accent-color: var(--ry-btn-bg); }
</style>
@endpush

@section('content')
<section class="page-hero">
    <h1>Yeni Gönderi</h1>
</section>
<div class="forum-form-wrap">
    <a href="{{ route('forum.index') }}" class="back-link">&larr; Foruma dön</a>

    <div class="form-card">
        @if(session('error'))
            <div class="alert-error">{{ session('error') }}</div>
        @endif

        <p class="form-hint" style="margin-bottom:1rem;">Bugünkü gönderiniz: {{ $todayCount }} / 5</p>

        <form method="POST" action="{{ route('forum.store') }}" enctype="multipart/form-data" id="forumForm">
            @csrf
            <div class="form-group">
                <label for="type">Tür *</label>
                <select name="type" id="type" class="form-input" required>
                    <option value="">Seçiniz</option>
                    <option value="request" {{ old('type') === 'request' ? 'selected' : '' }}>İstek</option>
                    <option value="complaint" {{ old('type') === 'complaint' ? 'selected' : '' }}>Şikayet</option>
                    <option value="photo" {{ old('type') === 'photo' ? 'selected' : '' }}>Foto Gönder</option>
                    <option value="video" {{ old('type') === 'video' ? 'selected' : '' }}>Video Gönder</option>
                    <option value="mp3" {{ old('type') === 'mp3' ? 'selected' : '' }}>MP3 Gönder</option>
                </select>
            </div>
            <div class="form-group">
                <label for="title">Başlık *</label>
                <input type="text" name="title" id="title" class="form-input" value="{{ old('title') }}" required maxlength="120" placeholder="Kısa ve açıklayıcı bir başlık">
                @error('title')<span class="form-error">{{ $message }}</span>@enderror
                <p class="form-hint">En fazla 120 karakter</p>
            </div>
            <div class="form-group" id="bodyGroup">
                <label for="body">Mesaj / Açıklama</label>
                <textarea name="body" id="body" class="form-textarea form-input" minlength="5" maxlength="2000" placeholder="Açıklama yazın...">{{ old('body') }}</textarea>
                @error('body')<span class="form-error">{{ $message }}</span>@enderror
                <p class="form-hint" id="bodyHint">İstek/şikayet için en az 20 karakter. Foto/Video için en az 10 karakter (Foto Açıklaması / Video Açıklaması) zorunlu.</p>
            </div>
            <div class="form-group type-option" id="videoGroup">
                <label for="video_url">Video Link (YouTube, TikTok, Instagram vb.)</label>
                <input type="url" name="video_url" id="video_url" class="form-input" value="{{ old('video_url') }}" placeholder="https://...">
                <p class="form-hint" style="margin-top:0.5rem;">veya video dosyası yükleyin (MP4, max 50MB):</p>
                <input type="file" name="video_file" id="video_file" class="form-input" accept="video/mp4,video/webm,video/quicktime" style="margin-top:0.5rem;">
                @error('video_url')<span class="form-error">{{ $message }}</span>@enderror
                @error('video_file')<span class="form-error">{{ $message }}</span>@enderror
            </div>
            <div class="form-group type-option" id="mp3Group">
                <label for="mp3_file">MP3 Dosyası * (max {{ $maxMp3Mb }}MB)</label>
                <input type="file" name="mp3_file" id="mp3_file" class="form-input" accept=".mp3,audio/mpeg">
                @error('mp3_file')<span class="form-error">{{ $message }}</span>@enderror
            </div>
            <div class="form-group type-option" id="photoGroup">
                <label for="photo_file">Fotoğraf * (max {{ $maxPhotoMb }}MB, JPG/PNG/WebP)</label>
                <input type="file" name="photo_file" id="photo_file" class="form-input" accept=".jpg,.jpeg,.png,.webp,image/*">
                @error('photo_file')<span class="form-error">{{ $message }}</span>@enderror
            </div>

            <div class="disclaimer-box">
                <label>
                    <input type="checkbox" name="disclaimer_accepted" id="disclaimer_accepted" value="1" {{ old('disclaimer_accepted') ? 'checked' : '' }}>
                    <span>Gönderdiğim dosyalardan (video, MP3, fotoğraf vb.) radyo yönetimi mesul değildir. Kabul ediyorum. *</span>
                </label>
                @error('disclaimer_accepted')<span class="form-error">{{ $message }}</span>@enderror
            </div>

            <button type="submit" class="btn-submit">Gönder</button>
        </form>
    </div>
</div>

@push('scripts')
<script>
(function() {
    var type = document.getElementById('type');
    var videoGroup = document.getElementById('videoGroup');
    var mp3Group = document.getElementById('mp3Group');
    var photoGroup = document.getElementById('photoGroup');
    var bodyGroup = document.getElementById('bodyGroup');
    var videoInput = document.getElementById('video_url');
    var mp3Input = document.getElementById('mp3_file');
    var photoInput = document.getElementById('photo_file');
    var bodyInput = document.getElementById('body');

    function toggleFields() {
        var v = type.value;
        videoGroup.style.display = v === 'video' ? 'block' : 'none';
        mp3Group.style.display = v === 'mp3' ? 'block' : 'none';
        photoGroup.style.display = v === 'photo' ? 'block' : 'none';
        if (v === 'mp3') { mp3Input.setAttribute('required','required'); } else { mp3Input.removeAttribute('required'); }
        if (v === 'photo') { photoInput.setAttribute('required','required'); } else { photoInput.removeAttribute('required'); }
        if (v === 'request' || v === 'complaint') { bodyInput.setAttribute('required','required'); bodyInput.setAttribute('minlength','20'); }
        else if (v === 'photo' || v === 'video') { bodyInput.setAttribute('required','required'); bodyInput.setAttribute('minlength','10'); }
        else { bodyInput.removeAttribute('required'); bodyInput.setAttribute('minlength','5'); }
    }
    type.addEventListener('change', toggleFields);
    toggleFields();
})();
</script>
@endpush
@endsection
