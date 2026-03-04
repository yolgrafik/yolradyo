@extends('admin.layouts.app')

@section('content')
<div class="card">
    <div class="card-header" style="display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;gap:0.75rem;">
        <span>Şarkı İstekleri</span>
    </div>
    <div class="card-body">
        @if(session('success'))
            <div class="alert-success">{{ session('success') }}</div>
        @endif

        <div class="filter-tabs" style="margin-bottom:1.25rem;display:flex;gap:0.5rem;flex-wrap:wrap;">
            <a href="{{ route('admin.song-requests.index', array_merge(request()->except('status'), ['status' => 'pending'])) }}" class="filter-tab {{ ($status ?? '') === 'pending' ? 'is-active' : '' }}">Bekleyen</a>
            <a href="{{ route('admin.song-requests.index', array_merge(request()->except('status'), ['status' => 'approved'])) }}" class="filter-tab {{ ($status ?? '') === 'approved' ? 'is-active' : '' }}">Onaylanan</a>
            <a href="{{ route('admin.song-requests.index', array_merge(request()->except('status'), ['status' => 'rejected'])) }}" class="filter-tab {{ ($status ?? '') === 'rejected' ? 'is-active' : '' }}">Reddedilen</a>
            <a href="{{ route('admin.song-requests.index', array_merge(request()->except('status'), ['status' => 'all'])) }}" class="filter-tab {{ ($status ?? '') === 'all' ? 'is-active' : '' }}">Tümü</a>
        </div>

        <form method="GET" class="filter-form" style="margin-bottom:1.25rem;display:flex;gap:0.75rem;flex-wrap:wrap;">
            <input type="hidden" name="status" value="{{ $status ?? 'pending' }}">
            <input type="text" name="q" value="{{ request('q') }}" placeholder="Ara (isim, sanatçı, türkü...)" class="filter-input" style="flex:1;min-width:200px;padding:0.5rem 0.75rem;background:rgba(255,255,255,0.06);border:1px solid var(--border);border-radius:8px;color:var(--text);">
            <button type="submit" class="quick-btn">Ara</button>
        </form>

        <div class="request-table-wrap" style="overflow-x:auto;">
            <table class="request-table" style="width:100%;border-collapse:collapse;">
                <thead>
                    <tr style="border-bottom:1px solid var(--border);">
                        <th style="padding:0.75rem;text-align:left;font-size:0.8rem;color:var(--muted);">Tarih</th>
                        <th style="padding:0.75rem;text-align:left;font-size:0.8rem;color:var(--muted);">İsim Soyad</th>
                        <th style="padding:0.75rem;text-align:left;font-size:0.8rem;color:var(--muted);">Sanatçı</th>
                        <th style="padding:0.75rem;text-align:left;font-size:0.8rem;color:var(--muted);">Türkü</th>
                        <th style="padding:0.75rem;text-align:left;font-size:0.8rem;color:var(--muted);">Mesaj</th>
                        <th style="padding:0.75rem;text-align:left;font-size:0.8rem;color:var(--muted);">Durum</th>
                        <th style="padding:0.75rem;text-align:left;font-size:0.8rem;color:var(--muted);">Onay Tarihi</th>
                        <th style="padding:0.75rem;text-align:right;font-size:0.8rem;color:var(--muted);">İşlem</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($requests as $r)
                    <tr style="border-bottom:1px solid var(--border);">
                        <td style="padding:0.75rem;font-size:0.85rem;">{{ $r->created_at->format('d.m.Y H:i') }}</td>
                        <td style="padding:0.75rem;font-size:0.9rem;">{{ $r->full_name }}</td>
                        <td style="padding:0.75rem;font-size:0.9rem;">{{ $r->artist_name }}</td>
                        <td style="padding:0.75rem;font-size:0.9rem;">{{ $r->song_name }}</td>
                        <td style="padding:0.75rem;font-size:0.85rem;color:var(--muted);max-width:200px;">{{ Str::limit($r->message, 50) ?: '—' }}</td>
                        <td style="padding:0.75rem;">
                            @if($r->status === 'pending')
                                <span class="badge badge-warning">Bekleyen</span>
                            @elseif($r->status === 'approved')
                                <span class="badge badge-success">Onaylanan</span>
                            @else
                                <span class="badge badge-danger">Reddedilen</span>
                            @endif
                        </td>
                        <td style="padding:0.75rem;font-size:0.85rem;color:var(--muted);">{{ $r->approved_at ? $r->approved_at->format('d.m.Y H:i') : '—' }}</td>
                        <td style="padding:0.75rem;text-align:right;">
                            @if($r->status === 'pending')
                                <form action="{{ route('admin.song-requests.approve', $r) }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn-sm btn-success">Onayla</button>
                                </form>
                                <form action="{{ route('admin.song-requests.reject', $r) }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn-sm btn-warning">Reddet</button>
                                </form>
                            @endif
                            <form action="{{ route('admin.song-requests.destroy', $r) }}" method="POST" class="d-inline" onsubmit="return confirm('Silmek istediğinize emin misiniz?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-sm btn-danger">Sil</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" style="padding:2rem;text-align:center;color:var(--muted);">Henüz istek bulunmuyor.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($requests->hasPages())
            <div style="margin-top:1rem;">{{ $requests->links() }}</div>
        @endif
    </div>
</div>

@push('styles')
<style>
.filter-tabs{display:flex;gap:0.5rem;flex-wrap:wrap;}
.filter-tab{padding:0.5rem 1rem;background:rgba(255,255,255,0.04);border:1px solid var(--border);border-radius:8px;color:var(--muted);text-decoration:none;font-size:0.9rem;transition:all 0.2s;}
.filter-tab:hover{background:rgba(255,255,255,0.08);color:var(--text);}
.filter-tab.is-active{background:rgba(201,42,42,0.25);border-color:rgba(201,42,42,0.5);color:#fff;}
.alert-success{padding:0.75rem 1rem;background:rgba(34,197,94,0.2);border:1px solid rgba(34,197,94,0.4);border-radius:10px;color:#86efac;font-size:0.9rem;margin-bottom:1rem;}
.badge{padding:0.25rem 0.5rem;border-radius:6px;font-size:0.75rem;font-weight:600;}
.badge-warning{background:rgba(234,179,8,0.25);color:#fde047;}
.badge-success{background:rgba(34,197,94,0.25);color:#86efac;}
.badge-danger{background:rgba(239,68,68,0.25);color:#fca5a5;}
.btn-sm{padding:0.35rem 0.65rem;font-size:0.8rem;border-radius:6px;border:none;cursor:pointer;margin-left:0.25rem;}
.btn-success{background:rgba(34,197,94,0.3);color:#86efac;}
.btn-warning{background:rgba(234,179,8,0.3);color:#fde047;}
.btn-danger{background:rgba(239,68,68,0.25);color:#fca5a5;}
.d-inline{display:inline;}
nav[aria-label="Pagination"] ul{display:flex;gap:0.5rem;list-style:none;margin:0;padding:0;flex-wrap:wrap;}
nav[aria-label="Pagination"] a,nav[aria-label="Pagination"] span{padding:0.5rem 0.75rem;background:rgba(255,255,255,0.06);border:1px solid var(--border);border-radius:8px;color:var(--text);text-decoration:none;font-size:0.9rem;}
nav[aria-label="Pagination"] a:hover{background:rgba(201,42,42,0.2);border-color:var(--accent);}
nav[aria-label="Pagination"] span{color:var(--muted);}
</style>
@endpush
@endsection
