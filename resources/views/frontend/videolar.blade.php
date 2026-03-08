@extends('layouts.frontend')

@section('title', 'Video Galeri')

@push('styles')
<style>
.videos-page{max-width:1180px;margin:0 auto;padding:1.2rem 1rem 2rem;}
.videos-page__title{margin:0;font-size:1.7rem;font-weight:800;color:var(--text);}
.videos-page__subtitle{margin:.35rem 0 1rem;color:var(--muted);}
.videos-grid{display:grid;grid-template-columns:repeat(auto-fit,minmax(270px,1fr));gap:14px;}
.videos-card{display:block;text-decoration:none;background:color-mix(in srgb,var(--ry-bar-bg) 78%, #0b0f16);border:1px solid var(--border);border-top:1px solid var(--ry-line-color);border-bottom:1px solid var(--ry-line-color);border-radius:12px;overflow:hidden;transition:transform .2s ease, box-shadow .2s ease, border-color .2s ease;}
.videos-card:hover{transform:translateY(-3px);border-color:var(--ry-schedule-active);box-shadow:0 10px 22px rgba(0,0,0,.28);}
.videos-card__cover{position:relative;aspect-ratio:16/9;background:#0f141e;}
.videos-card__cover img{width:100%;height:100%;object-fit:cover;display:block;}
.videos-card__play{position:absolute;left:50%;top:50%;transform:translate(-50%,-50%);width:54px;height:54px;border-radius:50%;display:grid;place-items:center;background:rgba(201,42,42,.92);color:#fff;font-size:23px;padding-left:3px;}
.videos-card__body{padding:12px;}
.videos-card__title{margin:0;color:var(--text);font-size:1rem;font-weight:700;line-height:1.35;}
.videos-card__desc{margin:.45rem 0 0;color:var(--ry-text-muted);font-size:.85rem;line-height:1.45;}
</style>
@endpush

@section('content')
<div class="videos-page">
    <h1 class="videos-page__title">Video Galeri</h1>
    <p class="videos-page__subtitle">Sanatçı Videoları</p>
    @if($artistVideos->isEmpty())
        <p>Henüz video bulunmuyor.</p>
    @else
        <div class="videos-grid">
            @foreach($artistVideos as $video)
                <a href="{{ route('videos.show', $video) }}" class="videos-card">
                    <div class="videos-card__cover">
                        @php $poster = $video->getVideoPosterUrl(); @endphp
                        @if($poster)
                            <img src="{{ $poster }}" alt="{{ $video->title }}">
                        @endif
                        <span class="videos-card__play">▶</span>
                    </div>
                    <div class="videos-card__body">
                        <h3 class="videos-card__title">{{ $video->title }}</h3>
                        @if($video->short_description)
                            <p class="videos-card__desc">{{ \Illuminate\Support\Str::limit($video->short_description, 110) }}</p>
                        @endif
                    </div>
                </a>
            @endforeach
        </div>
        <div style="margin-top:1rem;">{{ $artistVideos->links() }}</div>
    @endif
</div>
@endsection
