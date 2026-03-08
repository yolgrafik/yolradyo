@extends('admin.layouts.app')

@section('content')
<div class="card" style="max-width: 960px;">
    <div class="card-header">
        <a href="{{ route('admin.about-pages.index') }}" class="back-link">← Hakkımızda Sayfalarına dön</a>
        <h1 class="card-title">{{ $page->title }}</h1>
    </div>
    <div class="card-body">
        @if($errors->any())
            <div class="alert-error">{{ $errors->first() }}</div>
        @endif

        <form method="POST" action="{{ route('admin.about-pages.update', $page->slug) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="title">Başlık *</label>
                <input type="text" id="title" name="title" class="form-input" value="{{ old('title', $page->title) }}" required>
                @error('title')<span class="form-error">{{ $message }}</span>@enderror
            </div>

            <div class="form-group">
                <label for="short_description">Kısa Açıklama</label>
                <textarea id="short_description" name="short_description" rows="3" class="form-input">{{ old('short_description', $page->short_description) }}</textarea>
                @error('short_description')<span class="form-error">{{ $message }}</span>@enderror
            </div>

            <div class="form-group">
                <label for="content">Detay İçerik</label>
                <textarea id="content" name="content" rows="12" class="form-input">{{ old('content', $page->content) }}</textarea>
                @error('content')<span class="form-error">{{ $message }}</span>@enderror
            </div>

            <div class="form-group">
                <label for="image">Resim Yükleme</label>
                <input type="file" id="image" name="image" accept="image/*" class="form-input">
                @if($page->image_path)
                    <div class="image-preview-wrap">
                        <img src="{{ asset($page->image_path) }}" alt="{{ $page->title }}" class="image-preview">
                    </div>
                @endif
                @error('image')<span class="form-error">{{ $message }}</span>@enderror
            </div>

            <div class="form-group">
                <label class="checkbox-label">
                    <input type="checkbox" name="is_active" value="1" {{ old('is_active', $page->is_active) ? 'checked' : '' }}>
                    Aktif / Pasif
                </label>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn-save">Kaydet</button>
                <a href="{{ route('admin.about-pages.index') }}" class="btn-cancel">İptal</a>
            </div>
        </form>
    </div>
</div>

@push('styles')
<style>
.back-link { display: inline-block; font-size: 0.9rem; color: var(--muted); text-decoration: none; margin-bottom: 0.5rem; }
.back-link:hover { color: var(--text); }
.card-title { font-size: 1.25rem; font-weight: 700; margin: 0 0 1rem 0; }
.alert-error { padding: 0.75rem 1rem; background: rgba(239,68,68,0.2); border: 1px solid rgba(239,68,68,0.4); border-radius: 10px; color: #fca5a5; margin-bottom: 1rem; }
.form-group { margin-bottom: 1.2rem; }
.form-group label { display: block; font-size: 0.9rem; font-weight: 600; color: var(--text); margin-bottom: 0.5rem; }
.form-input { width: 100%; padding: 0.75rem 1rem; font-size: 0.9rem; background: rgba(255,255,255,0.06); border: 1px solid var(--border); border-radius: 10px; color: var(--text); }
.form-input[type="file"] { padding: 0.5rem; }
.checkbox-label { display: flex; align-items: center; gap: 0.5rem; cursor: pointer; }
.checkbox-label input { width: 18px; height: 18px; accent-color: var(--accent); }
.form-error { font-size: 0.8rem; color: #f87171; margin-top: 0.35rem; display: block; }
.image-preview-wrap { margin-top: 0.75rem; max-width: 360px; border-radius: 10px; overflow: hidden; border: 1px solid var(--border); }
.image-preview { width: 100%; display: block; object-fit: cover; }
.form-actions { margin-top: 1.5rem; display: flex; gap: 0.75rem; }
</style>
@endpush
@endsection
