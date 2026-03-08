@extends('admin.layouts.app')

@section('content')
<div class="card pg-card">
    <div class="card-header">Foto Düzenle</div>
    <div class="card-body">
        @if($errors->any())<div class="pg-alert" style="background:rgba(239,68,68,.2);border:1px solid rgba(239,68,68,.35);color:#fecaca;">{{ $errors->first() }}</div>@endif
        <form method="POST" action="{{ route('admin.photo-gallery.photos.update', $photo) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="pg-form-group">
                <label>Albüm</label>
                <select name="album_id" class="pg-input" required>
                    @foreach($albums as $album)
                        <option value="{{ $album->id }}" {{ $photo->album_id === $album->id ? 'selected' : '' }}>{{ $album->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="pg-form-group"><label>Başlık</label><input type="text" name="title" class="pg-input" value="{{ $photo->title }}"></div>
            <div class="pg-form-group"><label>Yeni Fotoğraf (opsiyonel)</label><input type="file" name="image" class="pg-input" accept="image/*"></div>
            <div class="pg-form-group"><label>Sıra</label><input type="number" name="sort_order" class="pg-input" min="0" value="{{ $photo->sort_order }}"></div>
            <label style="display:flex;gap:.5rem;align-items:center;font-size:.88rem;"><input type="checkbox" name="is_active" value="1" {{ $photo->is_active ? 'checked' : '' }}> Aktif</label>
            <div class="pg-actions">
                <button class="btn-save" type="submit">Güncelle</button>
                <a class="btn-cancel" href="{{ route('admin.photo-gallery.photos.edit.list') }}">Geri</a>
            </div>
        </form>
    </div>
</div>
@include('admin.photo-gallery._style')
@endsection
