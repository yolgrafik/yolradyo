@extends('admin.layouts.app')

@section('content')
<div class="card">
    <div class="card-header" style="display:flex;justify-content:space-between;align-items:center;">
        <span>Forum Yorumları</span>
        <a href="{{ route('admin.forum.posts') }}" class="btn-sm btn-edit">Gönderiler</a>
    </div>
    <div class="card-body">
        @if(session('success'))
            <div class="alert-success">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="alert-error">{{ session('error') }}</div>
        @endif

        <div class="table-wrap">
            <table class="menu-table">
                <thead>
                    <tr>
                        <th>Üye</th>
                        <th>Gönderi</th>
                        <th>Yorum</th>
                        <th>Tarih</th>
                        <th>İşlem</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($comments as $comment)
                    <tr>
                        <td>{{ $comment->user->name }}</td>
                        <td>
                            <a href="{{ route('forum.show', $comment->post->slug) }}" target="_blank" rel="noopener">{{ Str::limit($comment->post->title, 40) }}</a>
                        </td>
                        <td>{{ Str::limit($comment->body, 80) }}</td>
                        <td>{{ $comment->created_at->format('d.m.Y H:i') }}</td>
                        <td>
                            <form action="{{ route('admin.forum.destroy-comment', $comment) }}" method="POST" class="d-inline" onsubmit="return confirm('Bu yorumu silmek istediğinize emin misiniz?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-sm btn-danger">Sil</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" style="text-align:center;padding:2rem;color:var(--muted);">Henüz yorum yok.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($comments->hasPages())
            <div style="margin-top:1rem;">{{ $comments->links() }}</div>
        @endif
    </div>
</div>
@endsection
