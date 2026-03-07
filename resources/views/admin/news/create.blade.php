@extends('admin.layouts.app')

@section('content')
<div class="card" style="max-width:820px;">
    <div class="card-header">Haber Ekle</div>
    <div class="card-body">
        <form method="POST" action="{{ route('admin.news.store') }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="title">Haber Basligi *</label>
                <input type="text" name="title" id="title" required value="{{ old('title') }}" class="form-input">
                @error('title')<span class="form-error">{{ $message }}</span>@enderror
            </div>
            <div class="form-group">
                <label for="excerpt">Kisa Aciklama</label>
                <textarea name="excerpt" id="excerpt" rows="3" class="form-input">{{ old('excerpt') }}</textarea>
                @error('excerpt')<span class="form-error">{{ $message }}</span>@enderror
            </div>
            <div class="form-group">
                <label for="content">Detay Icerik</label>
                <textarea name="content" id="content" rows="8" class="form-input">{{ old('content') }}</textarea>
                @error('content')<span class="form-error">{{ $message }}</span>@enderror
            </div>
            <div class="form-group">
                <label for="image">Gorsel Yukleme</label>
                <input type="file" name="image" id="image" accept="image/*" class="form-input">
                @error('image')<span class="form-error">{{ $message }}</span>@enderror
            </div>
            <div class="form-group">
                <label class="checkbox-label">
                    <input type="checkbox" name="status" value="1" {{ old('status', true) ? 'checked' : '' }}>
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
</style>
@endpush
@endsection
