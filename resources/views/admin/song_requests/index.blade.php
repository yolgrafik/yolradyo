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

        <form method="GET" class="filter-form" style="margin-bottom:1.25rem;display:flex;gap:0.75rem;flex-wrap:wrap;">
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
                        <td style="padding:0.75rem;"><span class="badge badge-warning">Bekleyen</span></td>
                        <td style="padding:0.75rem;text-align:right;white-space:nowrap;">
                            @if($r->status === 'pending')
                                <form action="{{ route('admin.song-requests.approve', $r) }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn-sm btn-success">Onayla</button>
                                </form>
                                <form action="{{ route('admin.song-requests.reject', $r) }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn-sm btn-warning">Reddet</button>
                                </form>
                                <form action="{{ route('admin.song-requests.blacklist', $r) }}" method="POST" class="d-inline" onsubmit="return confirm('Bu kişiyi kara listeye almak istiyor musunuz?');">
                                    @csrf
                                    <input type="hidden" name="reason" value="Spam/Uygunsuz">
                                    <button type="submit" class="btn-sm btn-blacklist" title="Kara Listeye Al">
                                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="4.93" y1="4.93" x2="19.07" y2="19.07"/></svg>
                                        Kara Listeye Al
                                    </button>
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
                        <td colspan="7" style="padding:2rem;text-align:center;color:var(--muted);">Bekleyen istek bulunmuyor.</td>
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
.alert-success{padding:0.75rem 1rem;background:rgba(34,197,94,0.2);border:1px solid rgba(34,197,94,0.4);border-radius:10px;color:#86efac;font-size:0.9rem;margin-bottom:1rem;}
.badge{padding:0.25rem 0.5rem;border-radius:6px;font-size:0.75rem;font-weight:600;}
.badge-warning{background:rgba(234,179,8,0.25);color:#fde047;}
.badge-success{background:rgba(34,197,94,0.25);color:#86efac;}
.badge-danger{background:rgba(239,68,68,0.25);color:#fca5a5;}
.btn-sm.btn-success{background:rgba(34,197,94,0.3);color:#86efac;border:1px solid rgba(34,197,94,0.4);}
.btn-sm.btn-warning{background:rgba(234,179,8,0.3);color:#fde047;border:1px solid rgba(234,179,8,0.4);}
.btn-sm.btn-blacklist{background:rgba(127,29,29,0.5);color:#fca5a5;border:1px solid rgba(185,28,28,0.5);display:inline-flex;align-items:center;gap:0.35rem;}
.btn-sm.btn-blacklist:hover{background:rgba(185,28,28,0.4);border-color:rgba(220,38,38,0.6);}
nav[aria-label="Pagination"] ul{display:flex;gap:0.5rem;list-style:none;margin:0;padding:0;flex-wrap:wrap;}
nav[aria-label="Pagination"] a,nav[aria-label="Pagination"] span{padding:0.5rem 0.75rem;background:rgba(255,255,255,0.06);border:1px solid var(--border);border-radius:8px;color:var(--text);text-decoration:none;font-size:0.9rem;}
nav[aria-label="Pagination"] a:hover{background:rgba(201,42,42,0.2);border-color:var(--accent);}
nav[aria-label="Pagination"] span{color:var(--muted);}
</style>
@endpush
@endsection
