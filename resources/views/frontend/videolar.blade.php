@extends('layouts.frontend')

@section('title', 'Video Galeri')

@section('content')
<div class="container py-4">
    <h1 style="margin-bottom:0.25rem;">Video Galeri</h1>
    <p style="opacity:0.8;margin-bottom:1rem;">Sanatçı Videoları</p>
    @if($artistVideos->isEmpty())
        <p>Henüz video bulunmuyor.</p>
    @else
        <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(260px,1fr));gap:16px;">
            @foreach($artistVideos as $video)
                <article style="background:rgba(255,255,255,0.06);border:1px solid rgba(255,255,255,0.08);border-radius:12px;overflow:hidden;">
                    @if($video->cover_image_path)
                        <img src="{{ asset($video->cover_image_path) }}" alt="{{ $video->title }}" style="width:100%;aspect-ratio:16/9;object-fit:cover;">
                    @endif
                    <div style="padding:12px;">
                        <h3 style="margin:0 0 6px 0;">{{ $video->title }}</h3>
                        @if($video->short_description)
                            <p style="margin:0;opacity:0.85;">{{ $video->short_description }}</p>
                        @endif
                    </div>
                </article>
            @endforeach
        </div>
        <div style="margin-top:1rem;">{{ $artistVideos->links() }}</div>
    @endif
</div>
@endsection
