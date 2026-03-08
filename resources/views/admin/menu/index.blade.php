@extends('admin.layouts.app')

@section('content')
<div class="card">
    <div class="card-header" style="display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;gap:0.75rem;">
        <span>Menu Yonetimi</span>
        <div style="display:flex;gap:0.5rem;align-items:center;">
            <div class="menu-tabs">
                <a href="{{ route('admin.menu.index', ['location' => 'header']) }}" class="menu-tab {{ $location === 'header' ? 'is-active' : '' }}">Header Menu</a>
                <a href="{{ route('admin.menu.index', ['location' => 'footer']) }}" class="menu-tab {{ $location === 'footer' ? 'is-active' : '' }}">Footer Menu</a>
            </div>
            <a href="{{ route('admin.menu.create', ['location' => $location]) }}" class="quick-btn">+ Menu Ogeleri Ekle</a>
        </div>
    </div>
    <div class="card-body">
        @if(session('success'))
            <div class="alert-success">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="alert-error">{{ session('error') }}</div>
        @endif

        <input type="hidden" name="_token" value="{{ csrf_token() }}" id="csrfToken">
        <form id="reorderForm" method="POST" action="{{ route('admin.menu.reorder') }}" style="display:none;">
            @csrf
            <input type="hidden" name="location" value="{{ $location }}">
        </form>

        <div class="table-wrap">
            <table class="menu-table">
                <thead>
                    <tr>
                        <th>Sira</th>
                        <th>Baslik</th>
                        <th>Tip</th>
                        <th>Link</th>
                        <th>Ust Menu</th>
                        <th>Yeni Sekme</th>
                        <th>Aktif</th>
                        <th>Islemler</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($items as $item)
                    <tr class="{{ $item->parent_id ? 'menu-child' : '' }}" data-id="{{ $item->id }}">
                        <td>
                            <input type="number" class="sort-input" name="sort[{{ $item->id }}]" value="{{ $item->sort_order }}" min="0" data-id="{{ $item->id }}">
                        </td>
                        <td>{{ $item->parent_id ? '↳ ' : '' }}{{ $item->title }}</td>
                        <td><span class="badge badge-{{ $item->type === 'page' ? 'info' : 'muted' }}">{{ $item->type === 'page' ? 'Sayfa' : 'URL' }}</span></td>
                        <td class="link-cell">{{ Str::limit($item->url ?? '-', 40) }}</td>
                        <td>{{ $item->parent?->title ?? '-' }}</td>
                        <td>{{ $item->target_blank ? 'Evet' : 'Hayir' }}</td>
                        <td>
                            <span class="badge {{ $item->is_active ? 'badge-success' : 'badge-muted' }}">{{ $item->is_active ? 'Evet' : 'Hayir' }}</span>
                        </td>
                        <td>
                            <a href="{{ route('admin.menu.edit', $item) }}" class="btn-sm btn-edit">Duzenle</a>
                            <form action="{{ route('admin.menu.destroy', $item) }}" method="POST" class="d-inline" onsubmit="return confirm('Silmek istediginize emin misiniz?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-sm btn-danger">Sil</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        @if($items->isEmpty())
            <p class="muted" style="text-align:center;padding:2rem;">Bu konum icin henuz menu ogesi yok. <a href="{{ route('admin.menu.create', ['location' => $location]) }}" style="color:var(--accent);">Ilk ogeyi ekleyin</a>.</p>
        @else
            <div class="form-actions" style="margin-top:1rem;">
                <button type="button" id="saveOrderBtn" class="btn-save">Siralari Kaydet</button>
            </div>
        @endif
    </div>
</div>

@push('styles')
<style>
.alert-success{padding:0.75rem 1rem;background:rgba(34,197,94,0.2);border:1px solid rgba(34,197,94,0.4);border-radius:10px;color:#86efac;font-size:0.9rem;margin-bottom:1rem;}
.alert-error{padding:0.75rem 1rem;background:rgba(239,68,68,0.2);border:1px solid rgba(239,68,68,0.4);border-radius:10px;color:#fca5a5;font-size:0.9rem;margin-bottom:1rem;}
.menu-tabs{display:flex;gap:0.25rem;}
.menu-tab{padding:0.5rem 1rem;font-size:0.85rem;background:rgba(255,255,255,0.06);color:var(--text);border:1px solid var(--border);border-radius:8px;text-decoration:none;}
.menu-tab:hover{background:rgba(255,255,255,0.1);}
.menu-tab.is-active{background:var(--accent);color:#fff;border-color:var(--accent);}
.quick-btn{padding:0.5rem 1rem;font-size:0.9rem;font-weight:600;background:linear-gradient(135deg,#dc2626,var(--accent));color:#fff;border:none;border-radius:8px;text-decoration:none;}
.quick-btn:hover{opacity:0.95;}
.table-wrap{overflow-x:auto;}
.menu-table{width:100%;border-collapse:collapse;font-size:0.9rem;}
.menu-table th,.menu-table td{padding:0.75rem;text-align:left;border-bottom:1px solid var(--border);}
.menu-table th{font-weight:600;color:var(--muted);}
.menu-child td:first-child{padding-left:2rem;}
.sort-input{width:60px;padding:0.35rem 0.5rem;font-size:0.85rem;background:rgba(255,255,255,0.06);border:1px solid var(--border);border-radius:6px;color:var(--text);}
.link-cell{max-width:200px;overflow:hidden;text-overflow:ellipsis;}
.badge{padding:0.2rem 0.5rem;border-radius:6px;font-size:0.75rem;font-weight:600;}
.badge-success{background:rgba(34,197,94,0.25);color:#86efac;}
.badge-muted{background:rgba(148,163,184,0.25);color:#94a3b8;}
.badge-info{background:rgba(59,130,246,0.25);color:#93c5fd;}
.slider-actions,.menu-actions{display:flex;gap:0.5rem;}
.muted{color:var(--muted);}
.form-actions{margin-top:1rem;}
.btn-save{padding:0.65rem 1.25rem;font-size:0.9rem;font-weight:600;background:linear-gradient(135deg,#dc2626,var(--accent));color:#fff;border:none;border-radius:10px;cursor:pointer;}
</style>
@endpush
@push('scripts')
<script>
(function() {
    var btn = document.getElementById('saveOrderBtn');
    if (!btn) return;
    btn.addEventListener('click', function() {
        var inputs = document.querySelectorAll('.sort-input');
        var items = [];
        inputs.forEach(function(inp) {
            items.push({ id: parseInt(inp.dataset.id, 10), sort_order: parseInt(inp.value, 10) || 0 });
        });
        var form = document.getElementById('reorderForm');
        var token = document.getElementById('csrfToken')?.value || document.querySelector('input[name="_token"]')?.value;
        fetch(form.action, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': token,
                'Accept': 'application/json',
            },
            body: JSON.stringify({
                location: form.querySelector('input[name="location"]').value,
                items: items,
                _token: token
            })
        }).then(function(r) {
            return r.json();
        }).then(function(data) {
            if (data.success) {
                window.location.reload();
            }
        }).catch(function() {});
    });
})();
</script>
@endpush
@endsection
