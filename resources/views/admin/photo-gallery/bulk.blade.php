@extends('admin.layouts.app')

@section('content')
<div class="card pg-card">
    <div class="card-header">Toplu Foto Yükleme</div>
    <div class="card-body">
        @if($errors->any())<div class="pg-alert" style="background:rgba(239,68,68,.2);border:1px solid rgba(239,68,68,.35);color:#fecaca;">{{ $errors->first() }}</div>@endif
        <form method="POST" action="{{ route('admin.photo-gallery.photos.bulk.store') }}" enctype="multipart/form-data">
            @csrf
            <div class="pg-form-group">
                <label>Albüm</label>
                <select name="album_id" class="pg-input" required>
                    <option value="">Seçiniz</option>
                    @foreach($albums as $album)
                        <option value="{{ $album->id }}">{{ $album->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="pg-form-group">
                <label>Fotoğraflar</label>
                <input type="file" name="images[]" class="pg-input" accept="image/*" multiple required>
            </div>
            <label style="display:flex;gap:.5rem;align-items:center;font-size:.88rem;"><input type="checkbox" name="is_active" value="1" checked> Aktif</label>
            <div class="pg-actions">
                <button class="btn-save" type="submit">Yükle</button>
            </div>
        </form>
    </div>
</div>
@include('admin.photo-gallery._style')
@endsection
