@extends('admin.layouts.app')

@section('content')
<div class="forum-posts-page">
    <header class="forum-posts-header">
        <div>
            <h1 class="forum-posts-title">Forum Gönderileri</h1>
            <p class="forum-posts-desc">Dinleyicilerden gelen istek, şikayet, foto ve video gönderilerini yönetin.</p>
        </div>
        <a href="{{ route('admin.forum.comments') }}" class="forum-btn forum-btn--secondary">Forum Yorumları</a>
    </header>

    @if(session('success'))
        <div class="forum-alert forum-alert--success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="forum-alert forum-alert--error">{{ session('error') }}</div>
    @endif

    <div class="forum-filters">
        <form method="GET" action="{{ route('admin.forum.posts') }}" class="forum-filter-form">
            <select name="type" class="forum-select">
                <option value="">Tüm türler</option>
                <option value="request" {{ request('type') === 'request' ? 'selected' : '' }}>İstek</option>
                <option value="complaint" {{ request('type') === 'complaint' ? 'selected' : '' }}>Şikayet</option>
                <option value="photo" {{ request('type') === 'photo' ? 'selected' : '' }}>Foto Gönder</option>
                <option value="video" {{ request('type') === 'video' ? 'selected' : '' }}>Video Gönder</option>
                <option value="mp3" {{ request('type') === 'mp3' ? 'selected' : '' }}>MP3 Gönder</option>
            </select>
            <select name="approval_status" class="forum-select">
                <option value="">Tüm onay durumları</option>
                <option value="pending" {{ request('approval_status') === 'pending' ? 'selected' : '' }}>Beklemede</option>
                <option value="approved" {{ request('approval_status') === 'approved' ? 'selected' : '' }}>Onaylı</option>
                <option value="rejected" {{ request('approval_status') === 'rejected' ? 'selected' : '' }}>Reddedildi</option>
            </select>
            <button type="submit" class="forum-btn forum-btn--primary">Filtrele</button>
        </form>
    </div>

    <div class="forum-posts-list">
        @forelse($posts as $post)
        <article class="forum-post-card">
            <div class="forum-post-card__media">
                @if($post->type === 'photo' && $post->file_path)
                    <a href="{{ $post->media_url }}" target="_blank" rel="noopener" class="forum-post-thumb">
                        <img src="{{ $post->media_url }}" alt="">
                    </a>
                @elseif($post->type === 'video')
                    @if($post->video_url)
                        <a href="{{ $post->video_url }}" target="_blank" rel="noopener" class="forum-post-thumb forum-post-thumb--video">
                            @if($post->video_thumbnail_url)
                                <img src="{{ $post->video_thumbnail_url }}" alt="">
                            @else
                                <span>▶ Video</span>
                            @endif
                        </a>
                    @elseif($post->file_path)
                        <a href="{{ $post->media_url }}" target="_blank" rel="noopener" class="forum-post-thumb forum-post-thumb--video"><span>▶ Video</span></a>
                    @else
                        <div class="forum-post-thumb forum-post-thumb--empty">—</div>
                    @endif
                @else
                    <div class="forum-post-thumb forum-post-thumb--empty">—</div>
                @endif
            </div>
            <div class="forum-post-card__body">
                <div class="forum-post-card__meta">
                    <span class="forum-post-type forum-post-type--{{ $post->type }}">
                        @switch($post->type)
                            @case('video') Video @break
                            @case('mp3') MP3 @break
                            @case('photo') Foto @break
                            @case('request') İstek @break
                            @case('complaint') Şikayet @break
                            @default {{ $post->type_label }}
                        @endswitch
                    </span>
                    <span class="forum-post-status forum-post-status--{{ $post->approval_status }}">
                        @if($post->approval_status === 'pending') Beklemede
                        @elseif($post->approval_status === 'approved') Onaylı
                        @else Reddedildi
                        @endif
                    </span>
                    <span class="forum-post-date">{{ $post->created_at->format('d.m.Y H:i') }}</span>
                </div>
                <h3 class="forum-post-card__title">
                    <a href="{{ route('forum.show', $post->slug) }}" target="_blank" rel="noopener">{{ $post->title }}</a>
                </h3>
                @if($post->body)
                    <p class="forum-post-card__excerpt">{{ Str::limit($post->body, 120) }}</p>
                @endif
                <div class="forum-post-card__author">{{ $post->user->name ?? '—' }}</div>
            </div>
            <div class="forum-post-card__actions">
                @if($post->file_path)
                    <a href="{{ route('admin.forum.download', $post) }}" class="forum-btn forum-btn--secondary forum-btn--sm">İndir</a>
                @endif
                @if(in_array($post->type, ['photo', 'video']) && $post->approval_status === 'pending')
                    <form action="{{ route('admin.forum.approve', $post) }}" method="POST" class="forum-action-form">
                        @csrf
                        <button type="submit" class="forum-btn forum-btn--success forum-btn--sm">Onayla</button>
                    </form>
                    <form action="{{ route('admin.forum.reject', $post) }}" method="POST" class="forum-action-form">
                        @csrf
                        <button type="submit" class="forum-btn forum-btn--danger forum-btn--sm">Reddet</button>
                    </form>
                @endif
                <form action="{{ route('admin.forum.toggle-status', $post) }}" method="POST" class="forum-action-form">
                    @csrf
                    <button type="submit" class="forum-btn forum-btn--secondary forum-btn--sm">{{ $post->status === 'open' ? 'Kapat' : 'Aç' }}</button>
                </form>
                <form action="{{ route('admin.forum.destroy-post', $post) }}" method="POST" class="forum-action-form" onsubmit="return confirm('Bu gönderiyi silmek istediğinize emin misiniz?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="forum-btn forum-btn--danger forum-btn--sm">Sil</button>
                </form>
            </div>
        </article>
        @empty
        <div class="forum-empty">
            <p>Henüz gönderi yok.</p>
        </div>
        @endforelse
    </div>

    @if($posts->hasPages())
        <div class="forum-pagination">{{ $posts->withQueryString()->links() }}</div>
    @endif
</div>

@push('styles')
<style>
.forum-posts-page { max-width: 960px; }
.forum-posts-header { display: flex; justify-content: space-between; align-items: flex-start; gap: 1rem; flex-wrap: wrap; margin-bottom: 1.5rem; }
.forum-posts-title { font-size: 1.5rem; font-weight: 700; color: #f0f2f5; margin: 0 0 0.25rem 0; }
.forum-posts-desc { font-size: 0.9rem; color: #8b95a5; margin: 0; }
.forum-btn { display: inline-flex; align-items: center; padding: 0.5rem 1rem; font-size: 0.9rem; font-weight: 600; border-radius: 8px; text-decoration: none; border: 1px solid transparent; cursor: pointer; transition: opacity 0.2s; }
.forum-btn--primary { background: linear-gradient(135deg, #dc2626, var(--accent)); color: #fff; }
.forum-btn--secondary { background: rgba(255,255,255,0.08); color: #e5e7eb; border-color: rgba(255,255,255,0.15); }
.forum-btn--secondary:hover { background: rgba(255,255,255,0.12); }
.forum-btn--success { background: rgba(34,197,94,0.3); color: #86efac; border-color: rgba(34,197,94,0.5); }
.forum-btn--danger { background: rgba(239,68,68,0.2); color: #fca5a5; border-color: rgba(239,68,68,0.4); }
.forum-btn--sm { padding: 0.4rem 0.75rem; font-size: 0.8rem; }
.forum-alert { padding: 1rem 1.25rem; border-radius: 10px; margin-bottom: 1rem; font-size: 0.9rem; }
.forum-alert--success { background: rgba(34,197,94,0.15); border: 1px solid rgba(34,197,94,0.35); color: #86efac; }
.forum-alert--error { background: rgba(239,68,68,0.15); border: 1px solid rgba(239,68,68,0.35); color: #fca5a5; }
.forum-filters { margin-bottom: 1.5rem; }
.forum-filter-form { display: flex; gap: 0.75rem; flex-wrap: wrap; align-items: center; }
.forum-select { padding: 0.5rem 0.9rem; font-size: 0.9rem; background: rgba(255,255,255,0.06); border: 1px solid rgba(255,255,255,0.12); border-radius: 8px; color: #e5e7eb; min-width: 140px; }
.forum-posts-list { display: flex; flex-direction: column; gap: 1rem; }
.forum-post-card { display: flex; gap: 1.25rem; align-items: flex-start; padding: 1.25rem; background: rgba(255,255,255,0.03); border: 1px solid rgba(255,255,255,0.08); border-radius: 12px; transition: border-color 0.2s; }
.forum-post-card:hover { border-color: rgba(255,255,255,0.12); }
.forum-post-card__media { flex-shrink: 0; }
.forum-post-thumb { display: flex; align-items: center; justify-content: center; width: 80px; height: 80px; border-radius: 10px; overflow: hidden; background: rgba(0,0,0,0.3); text-decoration: none; color: #8b95a5; font-size: 0.85rem; }
.forum-post-thumb img { width: 100%; height: 100%; object-fit: cover; }
.forum-post-thumb--video { background: rgba(0,0,0,0.4); }
.forum-post-thumb--empty { color: #6b7280; font-size: 0.9rem; }
.forum-post-card__body { flex: 1; min-width: 0; }
.forum-post-card__meta { display: flex; flex-wrap: wrap; gap: 0.5rem 1rem; margin-bottom: 0.5rem; }
.forum-post-type { font-size: 0.75rem; font-weight: 600; padding: 0.2rem 0.5rem; border-radius: 6px; text-transform: uppercase; letter-spacing: 0.03em; }
.forum-post-type--photo, .forum-post-type--video, .forum-post-type--mp3 { background: rgba(34,197,94,0.2); color: #86efac; }
.forum-post-type--request { background: rgba(59,130,246,0.2); color: #93c5fd; }
.forum-post-type--complaint { background: rgba(234,179,8,0.2); color: #fde047; }
.forum-post-status { font-size: 0.75rem; font-weight: 600; padding: 0.2rem 0.5rem; border-radius: 6px; }
.forum-post-status--pending { background: rgba(234,179,8,0.2); color: #fde047; }
.forum-post-status--approved { background: rgba(34,197,94,0.2); color: #86efac; }
.forum-post-status--rejected { background: rgba(107,114,128,0.3); color: #9ca3af; }
.forum-post-date { font-size: 0.8rem; color: #8b95a5; }
.forum-post-card__title { font-size: 1rem; font-weight: 600; margin: 0 0 0.35rem 0; line-height: 1.35; }
.forum-post-card__title a { color: #e5e7eb; text-decoration: none; }
.forum-post-card__title a:hover { color: #fff; text-decoration: underline; }
.forum-post-card__excerpt { font-size: 0.9rem; color: #9ca3af; margin: 0 0 0.5rem 0; line-height: 1.45; }
.forum-post-card__author { font-size: 0.8rem; color: #8b95a5; }
.forum-post-card__actions { display: flex; flex-wrap: wrap; gap: 0.5rem; flex-shrink: 0; }
.forum-action-form { margin: 0; }
.forum-empty { padding: 3rem 2rem; text-align: center; background: rgba(255,255,255,0.02); border: 1px dashed rgba(255,255,255,0.1); border-radius: 12px; color: #8b95a5; }
.forum-pagination { margin-top: 1.5rem; }
@media (max-width: 640px) {
    .forum-post-card { flex-direction: column; }
    .forum-post-card__actions { width: 100%; }
}
</style>
@endpush
@endsection
