@extends('admin.layouts.app')

@section('content')
<div class="card">
    <div class="card-header" style="display:flex;justify-content:space-between;align-items:center;">
        <span>Yonetici Hesaplari</span>
        <a href="{{ route('admin.users.create') }}" class="quick-btn">+ Yeni Yonetici</a>
    </div>
    <div class="card-body">
        @if(session('success'))
            <div class="alert-success">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="alert-error">{{ session('error') }}</div>
        @endif

        <div class="table-wrap">
            <table class="data-table">
                <thead>
                    <tr>
                        <th style="width:50px;"></th>
                        <th>Yonetici</th>
                        <th>Rol</th>
                        <th>Durum</th>
                        <th>Son Giris</th>
                        <th style="width:140px;">Islemler</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($admins as $admin)
                    <tr>
                        <td>
                            <img src="{{ $admin->avatarUrl() }}" alt="" class="table-avatar">
                        </td>
                        <td>
                            <div class="table-user-name">{{ $admin->name }}</div>
                            <div class="table-user-email">{{ $admin->email }}</div>
                        </td>
                        <td>{{ $admin->role?->name ?? '-' }}</td>
                        <td>
                            @if($admin->is_active)
                                <span class="badge badge-success">Aktif</span>
                            @else
                                <span class="badge badge-muted">Pasif</span>
                            @endif
                        </td>
                        <td>{{ $admin->last_login_at?->format('d.m.Y H:i') ?? '-' }}</td>
                        <td>
                            <div class="btn-group">
                                <a href="{{ route('admin.users.edit', $admin) }}" class="btn-sm btn-edit">Duzenle</a>
                                @if($admin->id !== (int) session('admin_id'))
                                    <form action="{{ route('admin.users.toggle', $admin) }}" method="POST" class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn-sm {{ $admin->is_active ? 'btn-warn' : 'btn-success' }}">
                                            {{ $admin->is_active ? 'Pasif' : 'Aktif' }}
                                        </button>
                                    </form>
                                    <form action="{{ route('admin.users.destroy', $admin) }}" method="POST" class="d-inline" onsubmit="return confirm('Silmek istediginize emin misiniz?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-sm btn-danger">Sil</button>
                                    </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="6" class="text-center">Henuz yonetici yok.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        {{ $admins->links() }}
    </div>
</div>

@push('styles')
<style>
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
.btn-group{display:flex;gap:0.35rem;flex-wrap:wrap;}
.btn-sm{padding:0.35rem 0.65rem;font-size:0.8rem;border-radius:6px;border:none;cursor:pointer;text-decoration:none;display:inline-block;}
.btn-edit{background:rgba(255,255,255,0.08);color:var(--text);border:1px solid var(--border);}
.btn-edit:hover{background:rgba(255,255,255,0.12);}
.btn-warn{background:rgba(245,158,11,0.25);color:#fcd34d;}
.btn-success{background:rgba(34,197,94,0.25);color:#86efac;}
.btn-danger{background:rgba(239,68,68,0.25);color:#fca5a5;}
.d-inline{display:inline;}
.table-avatar{width:38px;height:38px;border-radius:50%;object-fit:cover;border:2px solid var(--border);}
.table-user-name{font-weight:600;color:var(--text);}
.table-user-email{font-size:0.8rem;color:var(--muted);}
</style>
@endpush
@endsection
