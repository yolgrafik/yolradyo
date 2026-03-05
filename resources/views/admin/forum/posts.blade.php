@extends('admin.layouts.app')

@section('content')
<div class="card">
    <div class="card-header" style="display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;gap:0.75rem;">
        <span>Forum Gönderileri</span>
        <a href="{{ route('admin.forum.comments') }}" class="btn-sm btn-edit">Yorumlar</a>
    </div>
    <div class="card-body">
        @if(session('success'))
            <div class="alert-success">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="alert-error">{{ session('error') }}</div>
        @endif

        <form method="GET" action="{{ route('admin.forum.posts') }}" class="filter-form" style="margin-bottom:1rem;display:flex;gap:0.5rem;flex-wrap:wrap;align-items:center;">
            <select name="type" class="form-input" style="max-width:150px;">
                <option value="">Tüm türler</option>
                <option value="request" {{ request('type') === 'request' ? 'selected' : '' }}>İstek</option>
                <option value="complaint" {{ request('type') === 'complaint' ? 'selected' : '' }}>Şikayet</option>
                <option value="photo" {{ request('type') === 'photo' ? 'selected' : '' }}>Foto Gönder</option>
                <option value="video" {{ request('type') === 'video' ? 'selected' : '' }}>Video Gönder</option>
                <option value="mp3" {{ request('type') === 'mp3' ? 'selected' : '' }}>MP3</option>
            </select>
            <select name="approval_status" class="form-input" style="max-width:150px;">
                <option value="">Tüm onay durumları</option>
                <option value="pending" {{ request('approval_status') === 'pending' ? 'selected' : '' }}>Beklemede</option>
                <option value="approved" {{ request('approval_status') === 'approved' ? 'selected' : '' }}>Onaylı</option>
                <option value="rejected" {{ request('approval_status') === 'rejected' ? 'selected' : '' }}>Reddedildi</option>
            </select>
            <button type="submit" class="btn-sm btn-edit">Filtrele</button>
        </form>

        <div class="table-wrap">
            <table class="menu-table">
                <thead>
                    <tr>
                        <th>Üye</th>
                        <th>Tür</th>
                        <th>Başlık</th>
                        <th>Önizleme</th>
                        <th>Tarih</th>
                        <th>Onay</th>
                        <th>İşlem</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($posts as $post)
                    <tr>
                        <td>{{ $post->user->name }}</td>
                        <td>
                            @switch($post->type)
                                @case('video')<span class="badge badge-success">Video</span>@break
                                @case('mp3')<span class="badge badge-success">MP3</span>@break
                                @case('photo')<span class="badge badge-success">Foto</span>@break
                                @case('request')<span class="badge badge-success">İstek</span>@break
                                @case('complaint')<span class="badge badge-warning">Şikayet</span>@break
                                @default<span class="badge badge-muted">{{ $post->type_label }}</span>
                            @endswitch
                        </td>
                        <td>
                            <a href="{{ route('forum.show', $post->slug) }}" target="_blank" rel="noopener">{{ Str::limit($post->title, 40) }}</a>
                            @if($post->body)
                                <br><small style="color:var(--muted);">{{ Str::limit($post->body, 50) }}</small>
                            @endif
                        </td>
                        <td>
                            @if($post->type === 'photo' && $post->file_path)
                                <a href="{{ $post->media_url }}" target="_blank" rel="noopener"><img src="{{ $post->media_url }}" alt="" style="width:48px;height:48px;object-fit:cover;border-radius:6px;"></a>
                            @elseif($post->type === 'video')
                                @if($post->video_url)
                                    <a href="{{ $post->video_url }}" target="_blank" rel="noopener" class="btn-sm btn-edit">Video</a>
                                @elseif($post->file_path)
                                    <a href="{{ $post->media_url }}" target="_blank" rel="noopener" class="btn-sm btn-edit">Video</a>
                                @else
                                    —
                                @endif
                            @else
                                —
                            @endif
                        </td>
                        <td>{{ $post->created_at->format('d.m.Y H:i') }}</td>
                        <td>
                            @if($post->approval_status === 'pending')
                                <span class="badge badge-warning">Beklemede</span>
                            @elseif($post->approval_status === 'approved')
                                <span class="badge badge-success">Onaylı</span>
                            @else
                                <span class="badge badge-muted">Reddedildi</span>
                            @endif
                        </td>
                        <td>
                            @if(in_array($post->type, ['photo', 'video']) && $post->approval_status === 'pending')
                                <form action="{{ route('admin.forum.approve', $post) }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn-sm btn-edit">Onayla</button>
                                </form>
                                <form action="{{ route('admin.forum.reject', $post) }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn-sm btn-danger">Reddet</button>
                                </form>
                            @endif
                            <form action="{{ route('admin.forum.toggle-status', $post) }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="btn-sm btn-edit">{{ $post->status === 'open' ? 'Kapat' : 'Aç' }}</button>
                            </form>
                            <form action="{{ route('admin.forum.destroy-post', $post) }}" method="POST" class="d-inline" onsubmit="return confirm('Bu gönderiyi silmek istediğinize emin misiniz?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-sm btn-danger">Sil</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" style="text-align:center;padding:2rem;color:var(--muted);">Henüz gönderi yok.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($posts->hasPages())
            <div style="margin-top:1rem;">{{ $posts->withQueryString()->links() }}</div>
        @endif
    </div>
</div>
@endsection
