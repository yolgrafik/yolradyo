@extends('admin.layouts.app')

@section('content')
<div class="card">
    <div class="card-header">Albüm Düzenle</div>
    <div class="card-body">
        @if(session('success'))<div class="pg-alert pg-alert--ok">{{ session('success') }}</div>@endif
        <div class="pg-grid">
            @forelse($albums as $album)
                <article class="pg-item">
                    <div class="pg-item__body">
                        <div style="font-weight:700;">{{ $album->name }}</div>
                        <div style="font-size:.8rem;color:var(--muted);margin-top:.35rem;">{{ $album->photos_count }} fotoğraf</div>
                        <div style="font-size:.8rem;color:var(--muted);margin-top:.35rem;">Sıra: {{ $album->sort_order }} | {{ $album->is_active ? 'Aktif' : 'Pasif' }}</div>
                        <div class="pg-actions">
                            <a href="{{ route('admin.photo-gallery.albums.edit', $album) }}" class="btn-sm btn-edit">Düzenle</a>
                        </div>
                    </div>
                </article>
            @empty
                <p style="color:var(--muted);">Henüz albüm yok.</p>
            @endforelse
        </div>
        <div style="margin-top:1rem;">{{ $albums->links() }}</div>
    </div>
</div>
@include('admin.photo-gallery._style')
@endsection
