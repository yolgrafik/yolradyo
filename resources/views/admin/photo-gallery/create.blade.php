@extends('admin.layouts.app')

@section('content')
<div class="card pg-card">
    <div class="card-header">Foto Ekle</div>
    <div class="card-body">
        @if($errors->any())<div class="pg-alert" style="background:rgba(239,68,68,.2);border:1px solid rgba(239,68,68,.35);color:#fecaca;">{{ $errors->first() }}</div>@endif
        <form method="POST" action="{{ route('admin.photo-gallery.photos.store') }}" enctype="multipart/form-data">
            @csrf
            <div class="pg-form-group">
                <label>Albüm</label>
                <select name="album_id" class="pg-input">
                    <option value="">Albüm seçmeden devam et</option>
                    @foreach($albums as $album)
                        <option value="{{ $album->id }}">{{ $album->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="pg-form-group"><label>Foto Başlığı</label><input type="text" name="title" class="pg-input"></div>
            <div class="pg-form-group"><label>Kısa Açıklama</label><textarea name="short_description" rows="3" class="pg-input"></textarea></div>
            <div class="pg-form-group"><label>Foto Yükle</label><input type="file" name="image" class="pg-input" accept="image/*" required></div>
            <label style="display:flex;gap:.5rem;align-items:center;font-size:.88rem;margin-bottom:.6rem;"><input type="checkbox" name="is_cover" value="1"> Kapak Foto</label>
            <div class="pg-form-group"><label>Sıra</label><input type="number" name="sort_order" class="pg-input" min="0" value="0"></div>
            <label style="display:flex;gap:.5rem;align-items:center;font-size:.88rem;"><input type="checkbox" name="is_active" value="1" checked> Durum (Aktif/Pasif)</label>
            <div class="pg-actions">
                <button class="btn-save" type="submit">Kaydet</button>
                <a class="btn-cancel" href="{{ route('admin.photo-gallery.photos.edit.list') }}">Liste</a>
            </div>
        </form>
    </div>
</div>
@include('admin.photo-gallery._style')
@endsection
