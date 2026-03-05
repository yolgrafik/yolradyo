@extends('admin.layouts.app')

@section('content')
<div class="card">
    <div class="card-header" style="display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;gap:0.75rem;">
        <span>Üyeler</span>
    </div>
    <div class="card-body">
        @if(session('success'))
            <div class="alert-success">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="alert-error">{{ session('error') }}</div>
        @endif

        <form method="GET" action="{{ route('admin.members.index') }}" class="filter-form" style="margin-bottom:1rem;display:flex;gap:0.5rem;flex-wrap:wrap;">
            <input type="text" name="q" value="{{ request('q') }}" placeholder="Ad veya e-posta ara" class="form-input" style="max-width:200px;">
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
                        <th>Avatar</th>
                        <th>Ad Soyad</th>
                        <th>E-posta</th>
                        <th>Kayıt Tarihi</th>
                        <th>Durum</th>
                        <th>İşlem</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($members as $m)
                    <tr>
                        <td>
                            <div style="width:40px;height:40px;border-radius:50%;background:rgba(255,255,255,0.1);display:flex;align-items:center;justify-content:center;font-size:1.2rem;color:var(--muted);">
                                {{ strtoupper(mb_substr($m->name, 0, 1)) }}
                            </div>
                        </td>
                        <td>{{ $m->name }}</td>
                        <td>{{ $m->email }}</td>
                        <td>{{ $m->created_at->format('d.m.Y H:i') }}</td>
                        <td>
                            @if($m->status === 'pending')
                                <span class="badge badge-warning">Beklemede</span>
                            @elseif($m->status === 'approved')
                                <span class="badge badge-success">Onaylı</span>
                            @else
                                <span class="badge badge-muted">Reddedildi</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('admin.members.edit', $m) }}" class="btn-sm btn-edit" style="text-decoration:none;">Düzenle</a>
                            @if($m->status === 'pending')
                                <form action="{{ route('admin.members.approve', $m) }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn-sm btn-edit">Onayla</button>
                                </form>
                                <form action="{{ route('admin.members.reject', $m) }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn-sm btn-danger">Reddet</button>
                                </form>
                            @elseif($m->status === 'approved')
                                <form action="{{ route('admin.members.deactivate', $m) }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn-sm btn-edit">Pasif</button>
                                </form>
                            @endif
                            <form action="{{ route('admin.members.destroy', $m) }}" method="POST" class="d-inline" onsubmit="return confirm('Silmek istediğinize emin misiniz?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-sm btn-danger">Sil</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="6" style="text-align:center;padding:2rem;">Henüz üye yok.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($members->hasPages())
            <div style="margin-top:1rem;">{{ $members->withQueryString()->links() }}</div>
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
.btn-sm{padding:0.35rem 0.65rem;font-size:0.8rem;border-radius:6px;border:none;cursor:pointer;display:inline-block;}
.btn-edit{background:rgba(255,255,255,0.08);color:var(--text);border:1px solid var(--border);}
.btn-danger{background:rgba(239,68,68,0.25);color:#fca5a5;}
.d-inline{display:inline;}
</style>
@endpush
@endsection
