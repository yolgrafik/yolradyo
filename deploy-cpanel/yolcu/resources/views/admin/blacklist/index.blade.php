@extends('admin.layouts.app')

@section('content')
<div class="card">
    <div class="card-header" style="display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;gap:0.75rem;">
        <span>Kara Liste</span>
    </div>
    <div class="card-body">
        @if(session('success'))
            <div class="alert-success">{{ session('success') }}</div>
        @endif

        <form method="GET" class="filter-form" style="margin-bottom:1.25rem;display:flex;gap:0.75rem;flex-wrap:wrap;">
            <input type="text" name="q" value="{{ request('q') }}" placeholder="Ara (değer, sebep...)" class="filter-input" style="flex:1;min-width:200px;padding:0.5rem 0.75rem;background:rgba(255,255,255,0.06);border:1px solid var(--border);border-radius:8px;color:var(--text);">
            <button type="submit" class="quick-btn">Ara</button>
        </form>

        <div class="request-table-wrap" style="overflow-x:auto;">
            <table class="request-table" style="width:100%;border-collapse:collapse;">
                <thead>
                    <tr style="border-bottom:1px solid var(--border);">
                        <th style="padding:0.75rem;text-align:left;font-size:0.8rem;color:var(--muted);">Tip</th>
                        <th style="padding:0.75rem;text-align:left;font-size:0.8rem;color:var(--muted);">Değer</th>
                        <th style="padding:0.75rem;text-align:left;font-size:0.8rem;color:var(--muted);">Sebep</th>
                        <th style="padding:0.75rem;text-align:left;font-size:0.8rem;color:var(--muted);">Tarih</th>
                        <th style="padding:0.75rem;text-align:right;font-size:0.8rem;color:var(--muted);">İşlem</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($items as $item)
                    <tr style="border-bottom:1px solid var(--border);">
                        <td style="padding:0.75rem;font-size:0.85rem;">
                            @if($item->type === 'name') İsim
                            @elseif($item->type === 'email') E-posta
                            @elseif($item->type === 'ip') IP
                            @else {{ $item->type }}
                            @endif
                        </td>
                        <td style="padding:0.75rem;font-size:0.9rem;">{{ $item->value }}</td>
                        <td style="padding:0.75rem;font-size:0.85rem;color:var(--muted);">{{ $item->reason ?: '—' }}</td>
                        <td style="padding:0.75rem;font-size:0.85rem;">{{ $item->created_at->format('d.m.Y H:i') }}</td>
                        <td style="padding:0.75rem;text-align:right;">
                            <form action="{{ route('admin.blacklist.destroy', $item) }}" method="POST" class="d-inline" onsubmit="return confirm('Kara listeden kaldırmak istediğinize emin misiniz?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-sm btn-danger">Kaldır</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" style="padding:2rem;text-align:center;color:var(--muted);">Kara listede kayıt bulunmuyor.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($items->hasPages())
            <div style="margin-top:1rem;">{{ $items->links() }}</div>
        @endif
    </div>
</div>

@push('styles')
<style>
.alert-success{padding:0.75rem 1rem;background:rgba(34,197,94,0.2);border:1px solid rgba(34,197,94,0.4);border-radius:10px;color:#86efac;font-size:0.9rem;margin-bottom:1rem;}
.btn-sm{padding:0.35rem 0.65rem;font-size:0.8rem;border-radius:6px;border:none;cursor:pointer;}
.btn-danger{background:rgba(239,68,68,0.25);color:#fca5a5;}
.d-inline{display:inline;}
nav[aria-label="Pagination"] ul{display:flex;gap:0.5rem;list-style:none;margin:0;padding:0;flex-wrap:wrap;}
nav[aria-label="Pagination"] a,nav[aria-label="Pagination"] span{padding:0.5rem 0.75rem;background:rgba(255,255,255,0.06);border:1px solid var(--border);border-radius:8px;color:var(--text);text-decoration:none;font-size:0.9rem;}
nav[aria-label="Pagination"] a:hover{background:rgba(201,42,42,0.2);border-color:var(--accent);}
nav[aria-label="Pagination"] span{color:var(--muted);}
</style>
@endpush
@endsection
