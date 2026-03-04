@extends('admin.layouts.app')

@section('content')
<div class="card">
    <div class="card-header" style="display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;gap:0.75rem;">
        <span>Moderasyon</span>
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
                        <th style="padding:0.75rem;text-align:right;font-size:0.8rem;color:var(--muted);">İşlem</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($requests as $r)
                    <tr style="border-bottom:1px solid var(--border);">
                        <td style="padding:0.75rem;font-size:0.85rem;">{{ $r->updated_at->format('d.m.Y H:i') }}</td>
                        <td style="padding:0.75rem;font-size:0.9rem;">{{ $r->full_name }}</td>
                        <td style="padding:0.75rem;font-size:0.9rem;">{{ $r->artist_name }}</td>
                        <td style="padding:0.75rem;font-size:0.9rem;">{{ $r->song_name }}</td>
                        <td style="padding:0.75rem;font-size:0.85rem;color:var(--muted);max-width:200px;">{{ Str::limit($r->message, 50) ?: '—' }}</td>
                        <td style="padding:0.75rem;text-align:right;">
                            <form action="{{ route('admin.song-requests.approve', $r) }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="btn-sm btn-success">Onayla</button>
                            </form>
                            <form action="{{ route('admin.song-requests.destroy', $r) }}" method="POST" class="d-inline" onsubmit="return confirm('Silmek istediğinize emin misiniz?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-sm btn-danger">Sil</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" style="padding:2rem;text-align:center;color:var(--muted);">Reddedilmiş kayıt bulunmuyor.</td>
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
.btn-sm{padding:0.35rem 0.65rem;font-size:0.8rem;border-radius:6px;border:none;cursor:pointer;margin-left:0.25rem;}
.btn-success{background:rgba(34,197,94,0.3);color:#86efac;}
.btn-danger{background:rgba(239,68,68,0.25);color:#fca5a5;}
.d-inline{display:inline;}
nav[aria-label="Pagination"] ul{display:flex;gap:0.5rem;list-style:none;margin:0;padding:0;flex-wrap:wrap;}
nav[aria-label="Pagination"] a,nav[aria-label="Pagination"] span{padding:0.5rem 0.75rem;background:rgba(255,255,255,0.06);border:1px solid var(--border);border-radius:8px;color:var(--text);text-decoration:none;font-size:0.9rem;}
nav[aria-label="Pagination"] a:hover{background:rgba(201,42,42,0.2);border-color:var(--accent);}
nav[aria-label="Pagination"] span{color:var(--muted);}
</style>
@endpush
@endsection
