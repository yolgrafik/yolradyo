@extends('admin.layouts.app')

@section('content')
<div class="card" style="max-width:820px;">
    <div class="card-header">Haber Duzenle: {{ $news->title }}</div>
    <div class="card-body">
        <form method="POST" action="{{ route('admin.news.update', $news) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="title">Haber Basligi *</label>
                <input type="text" name="title" id="title" required value="{{ old('title', $news->title) }}" class="form-input">
                @error('title')<span class="form-error">{{ $message }}</span>@enderror
            </div>
            <div class="form-group">
                <label for="slug">Slug</label>
                <input type="text" name="slug" id="slug" value="{{ old('slug', $news->slug) }}" class="form-input" placeholder="haber-basligi">
                @error('slug')<span class="form-error">{{ $message }}</span>@enderror
            </div>
            <div class="form-group">
                <label for="excerpt">Kisa Aciklama</label>
                <textarea name="excerpt" id="excerpt" rows="3" class="form-input">{{ old('excerpt', $news->excerpt) }}</textarea>
                @error('excerpt')<span class="form-error">{{ $message }}</span>@enderror
            </div>
            <div class="form-group">
                <label for="content">Detay Icerik</label>
                <textarea name="content" id="content" rows="8" class="form-input">{{ old('content', $news->content) }}</textarea>
                @error('content')<span class="form-error">{{ $message }}</span>@enderror
            </div>
            <div class="form-group">
                <label for="cover_image">Kapak Gorseli (degistirmek icin yeni secin)</label>
                @if($news->cover_image)
                    <div style="margin-bottom:0.5rem;">
                        <img src="{{ asset($news->cover_image) }}" alt="{{ $news->title }}" style="max-width:240px;max-height:140px;border-radius:10px;">
                    </div>
                @endif
                <input type="file" name="cover_image" id="cover_image" accept="image/*" class="form-input">
                @error('cover_image')<span class="form-error">{{ $message }}</span>@enderror
            </div>
            <div class="form-group">
                <label for="gallery_images">Yeni Galeri Gorselleri (coklu secim)</label>
                <input type="file" name="gallery_images[]" id="gallery_images" accept="image/*" multiple class="form-input">
                @error('gallery_images')<span class="form-error">{{ $message }}</span>@enderror
                @error('gallery_images.*')<span class="form-error">{{ $message }}</span>@enderror
            </div>
            @if($news->media->isNotEmpty())
            <div class="form-group">
                <label>Mevcut Galeri</label>
                <div class="media-grid">
                    @foreach($news->media as $media)
                        @if($media->type === 'image')
                        <label class="media-item">
                            <img src="{{ asset($media->file_path) }}" alt="">
                            <span><input type="checkbox" name="remove_media_ids[]" value="{{ $media->id }}"> Kaldir</span>
                        </label>
                        @endif
                    @endforeach
                </div>
            </div>
            @endif
            <div class="form-group">
                <label for="video_url">Video Linki (YouTube)</label>
                <input type="url" name="video_url" id="video_url" value="{{ old('video_url', $news->video_url) }}" class="form-input" placeholder="https://www.youtube.com/watch?v=...">
                @error('video_url')<span class="form-error">{{ $message }}</span>@enderror
            </div>
            <div class="form-group">
                <label class="checkbox-label">
                    <input type="checkbox" name="status" value="1" {{ old('status', $news->status) ? 'checked' : '' }}>
                    Durum (Aktif/Pasif)
                </label>
            </div>
            <div class="form-actions">
                <button type="submit" class="btn-save">Kaydet</button>
                <a href="{{ route('admin.news.index') }}" class="btn-cancel">Iptal</a>
            </div>
        </form>
    </div>
</div>

@push('styles')
<style>
.form-group{margin-bottom:1.25rem;}
.form-group label{display:block;font-size:0.9rem;font-weight:600;color:var(--text);margin-bottom:0.5rem;}
.form-input{width:100%;padding:0.75rem 1rem;font-size:0.9rem;background:rgba(255,255,255,0.06);border:1px solid var(--border);border-radius:10px;color:var(--text);}
.form-input[type="file"]{padding:0.5rem;}
.checkbox-label{display:flex;align-items:center;gap:0.5rem;cursor:pointer;font-size:0.9rem;font-weight:600;color:var(--text);}
.checkbox-label input{width:18px;height:18px;accent-color:var(--accent);}
.form-error{font-size:0.8rem;color:#f87171;margin-top:0.35rem;display:block;}
.form-actions{margin-top:1.5rem;display:flex;gap:0.75rem;}
.btn-save{padding:0.65rem 1.25rem;font-size:0.9rem;font-weight:600;background:linear-gradient(135deg,#dc2626,var(--accent));color:#fff;border:none;border-radius:10px;cursor:pointer;}
.btn-cancel{padding:0.65rem 1.25rem;font-size:0.9rem;font-weight:600;background:rgba(255,255,255,0.08);color:var(--text);border:1px solid var(--border);border-radius:10px;text-decoration:none;}
.media-grid{display:grid;grid-template-columns:repeat(4,minmax(0,1fr));gap:0.75rem;}
.media-item{display:flex;flex-direction:column;gap:0.45rem;font-size:0.8rem;color:var(--muted);}
.media-item img{width:100%;height:88px;object-fit:cover;border-radius:8px;border:1px solid var(--border);}
@media (max-width:900px){.media-grid{grid-template-columns:repeat(2,minmax(0,1fr));}}
</style>
@endpush
@endsection
