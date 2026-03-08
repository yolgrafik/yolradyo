@extends('admin.layouts.app')

@section('content')
<div class="card">
    <div class="card-header">Aktivite Loglari</div>
    <div class="card-body">
        <form method="GET" action="{{ route('admin.activity-logs.index') }}" class="filter-form">
            <div class="filter-row">
                <div class="filter-item">
                    <label>Yonetici</label>
                    <select name="admin_id" class="form-input">
                        <option value="">Tumu</option>
                        @foreach($admins as $a)
                            <option value="{{ $a->id }}" {{ request('admin_id') == $a->id ? 'selected' : '' }}>{{ $a->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="filter-item">
                    <label>Baslangic</label>
                    <input type="date" name="from" value="{{ request('from') }}" class="form-input">
                </div>
                <div class="filter-item">
                    <label>Bitis</label>
                    <input type="date" name="to" value="{{ request('to') }}" class="form-input">
                </div>
                <div class="filter-item">
                    <label>Arama</label>
                    <input type="text" name="keyword" value="{{ request('keyword') }}" placeholder="Aksiyon veya meta" class="form-input">
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
                        <th>Yonetici</th>
                        <th>Aksiyon</th>
                        <th>IP</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($logs as $log)
                    <tr>
                        <td>{{ $log->created_at->format('d.m.Y H:i:s') }}</td>
                        <td>{{ $log->admin?->name ?? '-' }}</td>
                        <td>
                            {{ $log->action }}
                            @if($log->meta)
                                <small class="muted">({{ json_encode($log->meta) }})</small>
                            @endif
                        </td>
                        <td>{{ $log->ip ?? '-' }}</td>
                    </tr>
                    @empty
                    <tr><td colspan="4" class="text-center">Kayit bulunamadi.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        {{ $logs->links() }}
    </div>
</div>

@push('styles')
<style>
.filter-form{margin-bottom:1rem;}
.filter-row{display:flex;flex-wrap:wrap;gap:1rem;align-items:flex-start;}
.filter-item{min-width:140px;}
.filter-item label{display:block;font-size:0.8rem;font-weight:600;color:var(--muted);margin-bottom:0.35rem;}
.form-input{padding:0.5rem 0.75rem;font-size:0.9rem;background:rgba(255,255,255,0.06);border:1px solid var(--border);border-radius:8px;color:var(--text);width:100%;}
.table-wrap{overflow-x:auto;}
.data-table{width:100%;border-collapse:collapse;}
.data-table th,.data-table td{padding:0.75rem 1rem;text-align:left;border-bottom:1px solid var(--border);}
.data-table th{font-weight:700;color:var(--muted);font-size:0.8rem;text-transform:uppercase;}
.data-table td{font-size:0.9rem;}
.muted{font-size:0.75rem;color:var(--muted);}
.text-center{text-align:center;}
</style>
@endpush
@endsection
