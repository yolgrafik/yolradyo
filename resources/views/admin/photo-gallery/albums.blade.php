@extends('admin.layouts.app')

@section('content')
<div class="card pg-card">
    <div class="card-header">Foto Galeri - Albümler</div>
    <div class="card-body">
        @if(session('success'))<div class="pg-alert pg-alert--ok">{{ session('success') }}</div>@endif
        @if($errors->any())<div class="pg-alert" style="background:rgba(239,68,68,.2);border:1px solid rgba(239,68,68,.35);color:#fecaca;">{{ $errors->first() }}</div>@endif

        <form method="POST" action="{{ route('admin.photo-gallery.albums.store') }}">
            @csrf
            <div class="pg-form-group">
                <label>Albüm Adı</label>
                <input type="text" name="name" class="pg-input" required>
            </div>
            <div class="pg-form-group">
                <label>Açıklama</label>
                <textarea name="description" rows="2" class="pg-input"></textarea>
            </div>
            <div class="pg-form-group">
                <label>Sıra</label>
                <input type="number" name="sort_order" class="pg-input" value="0" min="0">
            </div>
            <label style="display:flex;gap:.5rem;align-items:center;font-size:.88rem;"><input type="checkbox" name="is_active" value="1" checked> Aktif</label>
            <div class="pg-actions">
                <button class="btn-save" type="submit">Albüm Ekle</button>
            </div>
        </form>

        <hr style="margin:1rem 0;border-color:var(--border);">
        <div class="pg-grid">
            @forelse($albums as $album)
                <article class="pg-item">
                    <div class="pg-item__body">
                        <strong>{{ $album->name }}</strong>
                        <div style="margin-top:.35rem;color:var(--muted);font-size:.8rem;">{{ $album->photos_count }} fotoğraf</div>
                        <div style="margin-top:.35rem;color:var(--muted);font-size:.8rem;">Sıra: {{ $album->sort_order }} | {{ $album->is_active ? 'Aktif' : 'Pasif' }}</div>
                    </div>
                </article>
            @empty
                <p style="color:var(--muted);">Henüz albüm yok.</p>
            @endforelse
        </div>
    </div>
</div>
@include('admin.photo-gallery._style')
@endsection
