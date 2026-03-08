@extends('admin.layouts.app')

@section('content')
<div class="card">
    <div class="card-header">Foto Sil</div>
    <div class="card-body">
        @if(session('success'))<div class="pg-alert pg-alert--ok">{{ session('success') }}</div>@endif
        <div class="pg-grid">
            @forelse($photos as $photo)
                <article class="pg-item">
                    <img src="{{ asset($photo->image_path) }}" alt="">
                    <div class="pg-item__body">
                        <div style="font-weight:700;">{{ $photo->title ?: 'Başlıksız' }}</div>
                        <div style="font-size:.8rem;color:var(--muted);margin-top:.35rem;">Albüm: {{ $photo->album->name ?? '-' }}</div>
                        <form method="POST" action="{{ route('admin.photo-gallery.photos.destroy', $photo) }}" onsubmit="return confirm('Fotoğraf silinsin mi?');" style="margin-top:.6rem;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn-sm btn-danger">Sil</button>
                        </form>
                    </div>
                </article>
            @empty
                <p style="color:var(--muted);">Silinecek fotoğraf yok.</p>
            @endforelse
        </div>
        <div style="margin-top:1rem;">{{ $photos->links() }}</div>
    </div>
</div>
@include('admin.photo-gallery._style')
@endsection
