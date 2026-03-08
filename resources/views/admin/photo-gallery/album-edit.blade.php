@extends('admin.layouts.app')

@section('content')
<div class="card pg-card">
    <div class="card-header">Albüm Düzenle</div>
    <div class="card-body">
        @if($errors->any())<div class="pg-alert" style="background:rgba(239,68,68,.2);border:1px solid rgba(239,68,68,.35);color:#fecaca;">{{ $errors->first() }}</div>@endif
        <form method="POST" action="{{ route('admin.photo-gallery.albums.update', $album) }}">
            @csrf
            @method('PUT')
            <div class="pg-form-group">
                <label>Albüm Adı</label>
                <input type="text" name="name" class="pg-input" value="{{ old('name', $album->name) }}" required>
            </div>
            <div class="pg-form-group">
                <label>Açıklama</label>
                <textarea name="description" rows="3" class="pg-input">{{ old('description', $album->description) }}</textarea>
            </div>
            <div class="pg-form-group">
                <label>Sıra</label>
                <input type="number" name="sort_order" class="pg-input" min="0" value="{{ old('sort_order', $album->sort_order) }}">
            </div>
            <label style="display:flex;gap:.5rem;align-items:center;font-size:.88rem;">
                <input type="checkbox" name="is_active" value="1" {{ old('is_active', $album->is_active) ? 'checked' : '' }}>
                Aktif
            </label>
            <div class="pg-actions">
                <button class="btn-save" type="submit">Güncelle</button>
                <a class="btn-cancel" href="{{ route('admin.photo-gallery.albums.edit.list') }}">Geri</a>
            </div>
        </form>
    </div>
</div>
@include('admin.photo-gallery._style')
@endsection
