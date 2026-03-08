@extends('admin.layouts.app')

@section('content')
<div class="card">
    <div class="card-header">Albüm Sil</div>
    <div class="card-body">
        @if(session('success'))<div class="pg-alert pg-alert--ok">{{ session('success') }}</div>@endif
        <div class="pg-grid">
            @forelse($albums as $album)
                <article class="pg-item">
                    @if($album->cover_image_path)
                        <img src="{{ asset($album->cover_image_path) }}" alt="{{ $album->name }}">
                    @endif
                    <div class="pg-item__body">
                        <div style="font-weight:700;">{{ $album->name }}</div>
                        <div style="font-size:.8rem;color:var(--muted);margin-top:.35rem;">{{ $album->photos_count }} fotoğraf</div>
                        <form method="POST" action="{{ route('admin.photo-gallery.albums.destroy', $album) }}" onsubmit="return confirm('Albüm silinsin mi? Albümdeki fotoğraflar da silinecek.');" style="margin-top:.6rem;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn-save" style="background:#7f1d1d;">Sil</button>
                        </form>
                    </div>
                </article>
            @empty
                <p style="color:var(--muted);">Silinecek albüm yok.</p>
            @endforelse
        </div>
        <div style="margin-top:1rem;">{{ $albums->links() }}</div>
    </div>
</div>
@include('admin.photo-gallery._style')
@endsection
