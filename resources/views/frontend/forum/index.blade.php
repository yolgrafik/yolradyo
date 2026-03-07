@extends('layouts.frontend')

@section('title', 'Forum')

@push('styles')
<style>
.page-hero { padding: 2rem 1.5rem; background: var(--ry-header-bg); border-top: 1px solid var(--ry-line-color); border-bottom: 1px solid var(--ry-line-color); }
.page-hero h1 { font-size: 1.75rem; font-weight: 700; color: #fff; margin: 0; }
.forum-content { max-width: 800px; margin: 0 auto; padding: 2rem 1.5rem; }
.forum-tabs { display: flex; gap: 0.5rem; margin-bottom: 1.5rem; flex-wrap: wrap; }
.forum-tab { padding: 0.5rem 1rem; font-size: 0.9rem; font-weight: 600; color: var(--muted); text-decoration: none; border-radius: 10px; background: rgba(255,255,255,0.06); border: 1px solid rgba(255,255,255,0.1); transition: all 0.2s; }
.forum-tab:hover { color: #fff; background: rgba(255,255,255,0.1); }
.forum-tab.active { color: #fff; background: var(--ry-btn-bg); border-color: transparent; }
.btn-new { padding: 0.5rem 1rem; font-size: 0.9rem; font-weight: 600; background: var(--ry-btn-bg); color: #fff; text-decoration: none; border-radius: 10px; display: inline-flex; align-items: center; gap: 0.5rem; }
.btn-new:hover { opacity: 0.95; color: #fff; }
.forum-header { display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1rem; margin-bottom: 1.5rem; }
.post-list { display: flex; flex-direction: column; gap: 0.75rem; }
.post-card { background: var(--ry-bar-bg); border: 1px solid rgba(255,255,255,0.08); border-top: 1px solid var(--ry-line-color); border-bottom: 1px solid var(--ry-line-color); border-radius: 12px; padding: 1rem 1.25rem; transition: background 0.2s; }
.post-card:hover { background: rgba(255,255,255,0.04); }
.post-card a { text-decoration: none; color: inherit; }
.post-title { font-size: 1.05rem; font-weight: 600; color: #fff; margin-bottom: 0.35rem; }
.post-meta { font-size: 0.85rem; color: var(--muted); display: flex; flex-wrap: wrap; gap: 0.75rem; align-items: center; }
.badge { display: inline-block; padding: 0.2rem 0.5rem; font-size: 0.75rem; font-weight: 600; border-radius: 6px; }
.badge-video { background: rgba(168,85,247,0.25); color: #c4b5fd; }
.badge-mp3 { background: rgba(34,197,94,0.25); color: #86efac; }
.badge-photo { background: rgba(59,130,246,0.25); color: #93c5fd; }
.badge-istek, .badge-request { background: rgba(34,197,94,0.25); color: #86efac; }
.badge-sikayet, .badge-complaint { background: rgba(239,68,68,0.25); color: #fca5a5; }
.badge-open { background: rgba(59,130,246,0.25); color: #93c5fd; }
.badge-closed { background: rgba(107,114,128,0.3); color: #9ca3af; }
.alert-success { padding: 0.75rem 1rem; background: rgba(34,197,94,0.2); border: 1px solid rgba(34,197,94,0.4); border-radius: 10px; color: #86efac; margin-bottom: 1rem; }
.alert-error { padding: 0.75rem 1rem; background: rgba(239,68,68,0.2); border: 1px solid rgba(239,68,68,0.4); border-radius: 10px; color: #fca5a5; margin-bottom: 1rem; }
.pagination-wrap { margin-top: 1.5rem; }
</style>
@endpush

@section('content')
<section class="page-hero">
    <h1>Forum</h1>
</section>
<div class="forum-content">
    @if(session('success'))
        <div class="alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert-error">{{ session('error') }}</div>
    @endif

    <div class="forum-header">
        <div class="forum-tabs">
            <a href="{{ route('forum.index') }}" class="forum-tab {{ !request('type') ? 'active' : '' }}">Tümü</a>
            <a href="{{ route('forum.index', ['type' => 'video']) }}" class="forum-tab {{ request('type') === 'video' ? 'active' : '' }}">Video</a>
            <a href="{{ route('forum.index', ['type' => 'mp3']) }}" class="forum-tab {{ request('type') === 'mp3' ? 'active' : '' }}">MP3</a>
            <a href="{{ route('forum.index', ['type' => 'photo']) }}" class="forum-tab {{ request('type') === 'photo' ? 'active' : '' }}">Foto</a>
            <a href="{{ route('forum.index', ['type' => 'request']) }}" class="forum-tab {{ request('type') === 'request' ? 'active' : '' }}">İstek</a>
            <a href="{{ route('forum.index', ['type' => 'complaint']) }}" class="forum-tab {{ request('type') === 'complaint' ? 'active' : '' }}">Şikayet</a>
        </div>
        <a href="{{ route('forum.create') }}" class="btn-new"><i class="bi bi-plus-lg"></i> Yeni Gönderi</a>
    </div>

    <div class="post-list">
        @forelse($posts as $post)
            <article class="post-card">
                <a href="{{ route('forum.show', $post->slug) }}">
                    <div class="post-title">{{ $post->title }}</div>
                    <div class="post-meta">
                        <span class="badge badge-{{ $post->type }}">{{ $post->type_label }}</span>
                        <span class="badge badge-{{ $post->status === 'open' ? 'open' : 'closed' }}">{{ $post->status_label }}</span>
                        <span>{{ $post->user->name }}</span>
                        <span>{{ $post->created_at->format('d.m.Y H:i') }}</span>
                    </div>
                </a>
            </article>
        @empty
            <p style="color:var(--muted);text-align:center;padding:2rem;">Henüz gönderi yok. İlk gönderiyi siz oluşturun!</p>
        @endforelse
    </div>

    @if($posts->hasPages())
        <div class="pagination-wrap">
            {{ $posts->withQueryString()->links() }}
        </div>
    @endif
</div>
@endsection
