@extends('admin.layouts.app')

@section('content')
<div class="card">
    <div class="card-header">Sarki Istekleri</div>
    <div class="card-body">
        @if(session('success'))
            <div class="alert-success">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="alert-error">{{ session('error') }}</div>
        @endif

        <form method="GET" action="{{ route('admin.requests.index') }}" class="filter-form">
            <div class="filter-row">
                <div class="filter-item">
                    <label>Durum</label>
                    <select name="status" class="form-input role-select">
                        <option value="">Tumu</option>
                        <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Beklemede</option>
                        <option value="approved" {{ request('status') === 'approved' ? 'selected' : '' }}>Onaylandi</option>
                        <option value="rejected" {{ request('status') === 'rejected' ? 'selected' : '' }}>Reddedildi</option>
                    </select>
                </div>
                <div class="filter-item" style="align-self:flex-end;">
                    <button type="submit" class="btn-save">Filtrele</button>
                </div>
            </div>
        </form>

        <div class="table-wrap" style="margin-top:1.5rem;">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Tarih</th>
                        <th>Isim</th>
                        <th>E-posta</th>
                        <th>Sanatci</th>
                        <th>Eser</th>
                        <th>Mesaj</th>
                        <th>Durum</th>
                        <th style="width:180px;">Islemler</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($requests as $req)
                    <tr>
                        <td>{{ $req->created_at->format('d.m.Y H:i') }}</td>
                        <td>{{ $req->full_name }}</td>
                        <td>{{ $req->email }}</td>
                        <td>{{ $req->artist_name }}</td>
                        <td>{{ $req->song_name }}</td>
                        <td>{{ Str::limit($req->message, 30) ?: '-' }}</td>
                        <td>
                            @if($req->status === 'approved')
                                <span class="badge badge-success">Onaylandi</span>
                            @elseif($req->status === 'rejected')
                                <span class="badge badge-muted">Reddedildi</span>
                            @else
                                <span class="badge badge-warn">Beklemede</span>
                            @endif
                        </td>
                        <td>
                            <div class="btn-group">
                                @if($req->status === 'pending')
                                <form action="{{ route('admin.requests.approve', $req) }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn-sm btn-success">Onayla</button>
                                </form>
                                <form action="{{ route('admin.requests.reject', $req) }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn-sm btn-warn">Reddet</button>
                                </form>
                                @endif
                                <form action="{{ route('admin.requests.destroy', $req) }}" method="POST" class="d-inline" onsubmit="return confirm('Silmek istediginize emin misiniz?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-sm btn-danger">Sil</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="8" class="text-center">Henuz istek yok.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        {{ $requests->links() }}
    </div>
</div>

@push('styles')
<style>
.filter-form{margin-bottom:1rem;}
.filter-row{display:flex;flex-wrap:wrap;gap:1rem;align-items:flex-start;}
.filter-item{min-width:140px;}
.filter-item label{display:block;font-size:0.8rem;font-weight:600;color:var(--muted);margin-bottom:0.35rem;}
.alert-success{padding:0.75rem 1rem;background:rgba(34,197,94,0.2);border:1px solid rgba(34,197,94,0.4);border-radius:10px;color:#86efac;font-size:0.9rem;margin-bottom:1rem;}
.alert-error{padding:0.75rem 1rem;background:rgba(239,68,68,0.2);border:1px solid rgba(239,68,68,0.4);border-radius:10px;color:#fca5a5;font-size:0.9rem;margin-bottom:1rem;}
.table-wrap{overflow-x:auto;}
.data-table{width:100%;border-collapse:collapse;}
.data-table th,.data-table td{padding:0.75rem 1rem;text-align:left;border-bottom:1px solid var(--border);}
.data-table th{font-weight:700;color:var(--muted);font-size:0.8rem;text-transform:uppercase;}
.data-table td{font-size:0.9rem;}
.badge{padding:0.25rem 0.5rem;border-radius:6px;font-size:0.75rem;font-weight:600;}
.badge-success{background:rgba(34,197,94,0.25);color:#86efac;}
.badge-muted{background:rgba(148,163,184,0.25);color:#94a3b8;}
.badge-warn{background:rgba(245,158,11,0.25);color:#fcd34d;}
.btn-group{display:flex;gap:0.35rem;flex-wrap:wrap;}
.btn-sm{padding:0.35rem 0.65rem;font-size:0.8rem;border-radius:6px;border:none;cursor:pointer;display:inline-block;}
.btn-success{background:rgba(34,197,94,0.25);color:#86efac;}
.btn-success:hover{background:rgba(34,197,94,0.35);}
.btn-warn{background:rgba(245,158,11,0.25);color:#fcd34d;}
.btn-warn:hover{background:rgba(245,158,11,0.35);}
.btn-danger{background:rgba(239,68,68,0.25);color:#fca5a5;}
.btn-danger:hover{background:rgba(239,68,68,0.35);}
.d-inline{display:inline;}
.text-center{text-align:center;}
.btn-save{padding:0.5rem 1rem;font-size:0.9rem;font-weight:600;background:linear-gradient(135deg,#dc2626,var(--accent));color:#fff;border:none;border-radius:8px;cursor:pointer;}
</style>
@endpush
@endsection
