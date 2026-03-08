@extends('admin.layouts.app')

@section('content')
<div class="card">
    <div class="card-header" style="display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;gap:0.75rem;">
        <span>Üye Gönderileri</span>
    </div>
    <div class="card-body">
        @if(session('success'))
            <div class="alert-success">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="alert-error">{{ session('error') }}</div>
        @endif

        <form method="GET" action="{{ route('admin.member-submissions.index') }}" class="filter-form" style="margin-bottom:1rem;display:flex;gap:0.5rem;flex-wrap:wrap;">
            <select name="type" class="form-input" style="max-width:150px;">
                <option value="">Tüm türler</option>
                @foreach(\App\Models\MemberSubmission::TYPES as $k => $v)
                    <option value="{{ $k }}" {{ request('type') === $k ? 'selected' : '' }}>{{ $v }}</option>
                @endforeach
            </select>
            <select name="status" class="form-input" style="max-width:150px;">
                <option value="">Tüm durumlar</option>
                <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Beklemede</option>
                <option value="approved" {{ request('status') === 'approved' ? 'selected' : '' }}>Onaylı</option>
                <option value="rejected" {{ request('status') === 'rejected' ? 'selected' : '' }}>Reddedildi</option>
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
                        <th>Dosya / Link</th>
                        <th>Tarih</th>
                        <th>Durum</th>
                        <th>İşlem</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($submissions as $s)
                    <tr>
                        <td>{{ $s->user->name ?? '-' }}</td>
                        <td>{{ $s->type_label }}</td>
                        <td>{{ Str::limit($s->title, 30) }}</td>
                        <td>
                            @if($s->type === 'image' && $s->file_path)
                                <a href="{{ $s->media_url }}" target="_blank" rel="noopener" class="link">Görsel</a>
                            @elseif($s->type === 'video')
                                @if($s->video_url)
                                    <a href="{{ $s->video_url }}" target="_blank" rel="noopener" class="link">Video</a>
                                @elseif($s->file_path)
                                    <a href="{{ $s->media_url }}" target="_blank" rel="noopener" class="link">Video</a>
                                @else
                                    -
                                @endif
                            @elseif($s->type === 'mp3' && $s->file_path)
                                MP3
                            @else
                                -
                            @endif
                        </td>
                        <td>{{ $s->created_at->format('d.m.Y H:i') }}</td>
                        <td>
                            @if($s->status === 'pending')
                                <span class="badge badge-warning">Beklemede</span>
                            @elseif($s->status === 'approved')
                                <span class="badge badge-success">Onaylı</span>
                            @else
                                <span class="badge badge-muted">Reddedildi</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('admin.member-submissions.show', $s) }}" class="btn-sm btn-edit">İncele</a>
                            @if($s->type === 'mp3' && $s->file_path)
                                <a href="{{ route('admin.member-submissions.download', $s) }}" class="btn-sm btn-edit">MP3 İndir</a>
                            @endif
                            @if($s->type === 'image' && $s->file_path)
                                <a href="{{ $s->media_url }}" target="_blank" rel="noopener" class="btn-sm btn-edit">Görsel</a>
                            @endif
                            @if($s->type === 'video' && ($s->video_url || $s->file_path))
                                <a href="{{ $s->video_url ?: $s->media_url }}" target="_blank" rel="noopener" class="btn-sm btn-edit">Video</a>
                            @endif
                            @if($s->status === 'pending')
                                <form action="{{ route('admin.member-submissions.approve', $s) }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn-sm btn-edit">Onayla</button>
                                </form>
                                <form action="{{ route('admin.member-submissions.reject', $s) }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn-sm btn-danger">Reddet</button>
                                </form>
                            @endif
                            <form action="{{ route('admin.member-submissions.destroy', $s) }}" method="POST" class="d-inline" onsubmit="return confirm('Silmek istediğinize emin misiniz?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-sm btn-danger">Sil</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="7" style="text-align:center;padding:2rem;">Henüz gönderi yok.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($submissions->hasPages())
            <div style="margin-top:1rem;">{{ $submissions->withQueryString()->links() }}</div>
        @endif
    </div>
</div>

@push('styles')
<style>
.alert-success{padding:0.75rem 1rem;background:rgba(34,197,94,0.2);border:1px solid rgba(34,197,94,0.4);border-radius:10px;color:#86efac;font-size:0.9rem;margin-bottom:1rem;}
.alert-error{padding:0.75rem 1rem;background:rgba(239,68,68,0.2);border:1px solid rgba(239,68,68,0.4);border-radius:10px;color:#fca5a5;font-size:0.9rem;margin-bottom:1rem;}
.table-wrap{overflow-x:auto;}
.menu-table{width:100%;border-collapse:collapse;font-size:0.9rem;}
.menu-table th,.menu-table td{padding:0.75rem;text-align:left;border-bottom:1px solid var(--border);}
.menu-table th{font-weight:600;color:var(--muted);}
.form-input{padding:0.5rem 0.75rem;background:rgba(255,255,255,0.06);border:1px solid var(--border);border-radius:6px;color:var(--text);}
.badge{padding:0.2rem 0.5rem;border-radius:6px;font-size:0.75rem;font-weight:600;}
.badge-success{background:rgba(34,197,94,0.25);color:#86efac;}
.badge-warning{background:rgba(234,179,8,0.25);color:#fde047;}
.badge-muted{background:rgba(148,163,184,0.25);color:#94a3b8;}
.link{color:var(--accent);}
</style>
@endpush
@endsection
