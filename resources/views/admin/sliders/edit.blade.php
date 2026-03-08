@extends('admin.layouts.app')

@section('content')
<div class="card" style="max-width:700px;">
    <div class="card-header">Slider Duzenle: {{ $slider->title }}</div>
    <div class="card-body">
        <form method="POST" action="{{ route('admin.sliders.update', $slider) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="title">Baslik *</label>
                <input type="text" name="title" id="title" required value="{{ old('title', $slider->title) }}" class="form-input">
                @error('title')<span class="form-error">{{ $message }}</span>@enderror
            </div>
            <div class="form-group">
                <label for="subtitle">Alt Baslik</label>
                <input type="text" name="subtitle" id="subtitle" value="{{ old('subtitle', $slider->subtitle) }}" class="form-input">
                @error('subtitle')<span class="form-error">{{ $message }}</span>@enderror
            </div>
            <div class="form-group">
                <label for="button_text">Buton Metni</label>
                <input type="text" name="button_text" id="button_text" value="{{ old('button_text', $slider->button_text) }}" class="form-input">
                @error('button_text')<span class="form-error">{{ $message }}</span>@enderror
            </div>
            <div class="form-group">
                <label for="button_link">Buton Linki</label>
                <input type="text" name="button_link" id="button_link" value="{{ old('button_link', $slider->button_link) }}" class="form-input">
                @error('button_link')<span class="form-error">{{ $message }}</span>@enderror
            </div>
            <div class="form-group">
                <label for="image">Gorsel (degistirmek icin yeni yukleyin)</label>
                @if($slider->image_path)
                    <div class="current-img" style="margin-bottom:0.5rem;">
                        <img src="{{ asset($slider->image_path) }}" alt="" style="max-width:100%;max-height:120px;border-radius:8px;">
                    </div>
                @endif
                <input type="file" name="image" id="image" accept="image/*" class="form-input">
                @error('image')<span class="form-error">{{ $message }}</span>@enderror
            </div>
            <div class="form-group">
                <label class="checkbox-label">
                    <input type="checkbox" name="status" value="1" {{ old('status', $slider->status) ? 'checked' : '' }}>
                    Aktif
                </label>
            </div>
            <div class="form-actions">
                <button type="submit" class="btn-save">Kaydet</button>
                <a href="{{ route('admin.sliders.index') }}" class="btn-cancel">Iptal</a>
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
</style>
@endpush
@endsection
