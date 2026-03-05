@extends('layouts.frontend')

@section('title', $post->title . ' - Forum')

@push('styles')
<style>
.page-hero { padding: 2rem 1.5rem; background: var(--ry-header-bg); border-bottom: 1px solid var(--ry-border); }
.page-hero h1 { font-size: 1.5rem; font-weight: 700; color: #fff; margin: 0; }
.forum-detail { max-width: 700px; margin: 0 auto; padding: 2rem 1.5rem; }
.post-detail { background: var(--ry-bar-bg); border: 1px solid rgba(255,255,255,0.08); border-radius: 14px; padding: 1.5rem; margin-bottom: 1.5rem; }
.post-meta { font-size: 0.9rem; color: var(--muted); margin-bottom: 1rem; display: flex; flex-wrap: wrap; gap: 0.75rem; align-items: center; }
.badge { display: inline-block; padding: 0.2rem 0.5rem; font-size: 0.75rem; font-weight: 600; border-radius: 6px; }
.badge-istek { background: rgba(34,197,94,0.25); color: #86efac; }
.badge-sikayet { background: rgba(239,68,68,0.25); color: #fca5a5; }
.badge-open { background: rgba(59,130,246,0.25); color: #93c5fd; }
.badge-closed { background: rgba(107,114,128,0.3); color: #9ca3af; }
.post-body { color: var(--text); line-height: 1.6; white-space: pre-wrap; }
.comments-section { margin-top: 2rem; }
.comments-section h3 { font-size: 1.1rem; color: #fff; margin-bottom: 1rem; }
.comment-form { margin-bottom: 1.5rem; }
.comment-form .form-textarea { width: 100%; padding: 0.75rem 1rem; background: rgba(255,255,255,0.06); border: 1px solid rgba(255,255,255,0.15); border-radius: 10px; color: var(--text); font-size: 0.95rem; min-height: 80px; resize: vertical; }
.comment-form .form-textarea:focus { outline: none; border-color: var(--ry-schedule-active); }
.comment-form .btn-submit { padding: 0.5rem 1rem; font-size: 0.9rem; font-weight: 600; background: var(--ry-btn-bg); color: #fff; border: none; border-radius: 8px; cursor: pointer; margin-top: 0.5rem; }
.comment-list { display: flex; flex-direction: column; gap: 0.75rem; }
.comment-item { background: rgba(255,255,255,0.04); border: 1px solid rgba(255,255,255,0.06); border-radius: 10px; padding: 1rem; }
.comment-author { font-size: 0.9rem; font-weight: 600; color: #fff; margin-bottom: 0.25rem; }
.comment-date { font-size: 0.8rem; color: var(--muted); margin-bottom: 0.5rem; }
.comment-body { font-size: 0.95rem; color: var(--text); line-height: 1.5; white-space: pre-wrap; }
.alert-success { padding: 0.75rem 1rem; background: rgba(34,197,94,0.2); border: 1px solid rgba(34,197,94,0.4); border-radius: 10px; color: #86efac; margin-bottom: 1rem; }
.alert-error { padding: 0.75rem 1rem; background: rgba(239,68,68,0.2); border: 1px solid rgba(239,68,68,0.4); border-radius: 10px; color: #fca5a5; margin-bottom: 1rem; }
.form-error { font-size: 0.8rem; color: #f87171; margin-top: 0.25rem; }
.back-link { display: inline-block; margin-bottom: 1rem; color: var(--ry-schedule-active); text-decoration: none; font-size: 0.9rem; }
.back-link:hover { text-decoration: underline; }
</style>
@endpush

@section('content')
<section class="page-hero">
    <h1>{{ $post->title }}</h1>
</section>
<div class="forum-detail">
    <a href="{{ route('forum.index') }}" class="back-link">&larr; Foruma dön</a>

    @if(session('success'))
        <div class="alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert-error">{{ session('error') }}</div>
    @endif

    <article class="post-detail">
        <div class="post-meta">
            <span class="badge badge-{{ $post->type === 'request' ? 'istek' : 'sikayet' }}">{{ $post->type_label }}</span>
            <span class="badge badge-{{ $post->status === 'open' ? 'open' : 'closed' }}">{{ $post->status_label }}</span>
            <span>{{ $post->user->name }}</span>
            <span>{{ $post->created_at->format('d.m.Y H:i') }}</span>
        </div>
        <div class="post-body">{{ $post->body }}</div>
    </article>

    <div class="comments-section">
        <h3>Yorumlar ({{ $post->comments->count() }})</h3>

        @if($post->status === 'open' && auth()->user()?->isApproved())
            <div class="comment-form">
                <form method="POST" action="{{ route('forum.comments.store', $post->slug) }}">
                    @csrf
                    <textarea name="body" class="form-textarea" placeholder="Yorumunuzu yazın..." required minlength="5" maxlength="1000">{{ old('body') }}</textarea>
                    @error('body')<span class="form-error">{{ $message }}</span>@enderror
                    <button type="submit" class="btn-submit">Yorum Ekle</button>
                </form>
            </div>
        @elseif($post->status === 'closed')
            <p style="color:var(--muted);font-size:0.9rem;">Bu gönderi yorumlara kapatılmış.</p>
        @endif

        <div class="comment-list">
            @foreach($post->comments as $comment)
                <div class="comment-item">
                    <div class="comment-author">{{ $comment->user->name }}</div>
                    <div class="comment-date">{{ $comment->created_at->format('d.m.Y H:i') }}</div>
                    <div class="comment-body">{{ $comment->body }}</div>
                </div>
            @endforeach
        </div>
    </div>
</div>
@endsection
