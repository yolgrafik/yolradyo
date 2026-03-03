@extends('admin.layouts.app')

@section('content')
<div class="card">
    <div class="card-header" style="display:flex;justify-content:space-between;align-items:center;">
        <span>Slider Yonetimi</span>
        <a href="{{ route('admin.sliders.create') }}" class="quick-btn">+ Yeni Slider</a>
    </div>
    <div class="card-body">
        @if(session('success'))
            <div class="alert-success">{{ session('success') }}</div>
        @endif

        <p class="muted" style="margin-bottom:1rem;font-size:0.9rem;">Siralama icin surukleyip birakabilirsiniz.</p>

        <input type="hidden" name="_token" value="{{ csrf_token() }}" id="csrfToken">
        <ul id="sliderList" class="slider-list">
            @foreach($sliders as $s)
            <li class="slider-item" data-id="{{ $s->id }}" draggable="true">
                <span class="drag-handle" title="Surukle">&#9776;</span>
                <div class="slider-preview">
                    @if($s->image_path)
                        <img src="{{ asset($s->image_path) }}" alt="{{ $s->title }}">
                    @else
                        <div class="no-img">Gorsel yok</div>
                    @endif
                </div>
                <div class="slider-info">
                    <strong>{{ $s->title }}</strong>
                    @if($s->subtitle)<span class="muted">{{ Str::limit($s->subtitle, 50) }}</span>@endif
                    <span class="badge {{ $s->status ? 'badge-success' : 'badge-muted' }}">{{ $s->status ? 'Aktif' : 'Pasif' }}</span>
                </div>
                <div class="slider-actions">
                    <a href="{{ route('admin.sliders.edit', $s) }}" class="btn-sm btn-edit">Duzenle</a>
                    <form action="{{ route('admin.sliders.destroy', $s) }}" method="POST" class="d-inline" onsubmit="return confirm('Silmek istediginize emin misiniz?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn-sm btn-danger">Sil</button>
                    </form>
                </div>
            </li>
            @endforeach
        </ul>

        @if($sliders->isEmpty())
            <p class="muted" style="text-align:center;padding:2rem;">Henuz slider eklenmemis. <a href="{{ route('admin.sliders.create') }}" style="color:var(--accent);">Ilk slideri ekleyin</a>.</p>
        @endif
    </div>
</div>

@push('styles')
<style>
.alert-success{padding:0.75rem 1rem;background:rgba(34,197,94,0.2);border:1px solid rgba(34,197,94,0.4);border-radius:10px;color:#86efac;font-size:0.9rem;margin-bottom:1rem;}
.slider-list{list-style:none;margin:0;padding:0;}
.slider-item{display:flex;align-items:center;gap:1rem;padding:0.75rem 1rem;background:rgba(255,255,255,0.04);border:1px solid var(--border);border-radius:10px;margin-bottom:0.5rem;cursor:grab;}
.slider-item:active{cursor:grabbing;}
.slider-item.dragging{opacity:0.5;}
.drag-handle{cursor:grab;color:var(--muted);font-size:1.2rem;padding:0 0.5rem;}
.slider-preview{width:120px;height:50px;flex-shrink:0;border-radius:6px;overflow:hidden;background:rgba(0,0,0,0.3);}
.slider-preview img{width:100%;height:100%;object-fit:cover;}
.no-img{width:100%;height:100%;display:flex;align-items:center;justify-content:center;font-size:0.75rem;color:var(--muted);}
.slider-info{flex:1;display:flex;flex-direction:column;gap:0.25rem;}
.slider-info strong{font-size:0.95rem;}
.badge{padding:0.2rem 0.5rem;border-radius:6px;font-size:0.75rem;font-weight:600;display:inline-block;}
.badge-success{background:rgba(34,197,94,0.25);color:#86efac;}
.badge-muted{background:rgba(148,163,184,0.25);color:#94a3b8;}
.slider-actions{display:flex;gap:0.5rem;}
.btn-sm{padding:0.35rem 0.65rem;font-size:0.8rem;border-radius:6px;border:none;cursor:pointer;text-decoration:none;display:inline-block;}
.btn-edit{background:rgba(255,255,255,0.08);color:var(--text);border:1px solid var(--border);}
.btn-danger{background:rgba(239,68,68,0.25);color:#fca5a5;}
.d-inline{display:inline;}
.muted{color:var(--muted);}
</style>
@endpush
@push('scripts')
<script>
(function() {
    var list = document.getElementById('sliderList');
    if (!list) return;
    var items = list.querySelectorAll('.slider-item');
    var dragged = null;

    items.forEach(function(item) {
        item.addEventListener('dragstart', function(e) {
            dragged = item;
            item.classList.add('dragging');
            e.dataTransfer.effectAllowed = 'move';
            e.dataTransfer.setData('text/plain', item.dataset.id);
        });
        item.addEventListener('dragend', function() {
            item.classList.remove('dragging');
            dragged = null;
        });
        item.addEventListener('dragover', function(e) {
            e.preventDefault();
            if (dragged && dragged !== item) {
                var rect = item.getBoundingClientRect();
                var mid = rect.top + rect.height / 2;
                if (e.clientY < mid) {
                    list.insertBefore(dragged, item);
                } else {
                    list.insertBefore(dragged, item.nextSibling);
                }
            }
        });
    });

    list.addEventListener('dragend', function() {
        var ids = [];
        list.querySelectorAll('.slider-item').forEach(function(el) {
            ids.push(parseInt(el.dataset.id, 10));
        });
        if (ids.length === 0) return;
        fetch('{{ route("admin.sliders.reorder") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.getElementById('csrfToken')?.value || document.querySelector('input[name="_token"]')?.value,
                'Accept': 'application/json',
            },
            body: JSON.stringify({ order: ids })
        }).then(function(r) { return r.json(); }).catch(function() {});
    });
})();
</script>
@endpush
@endsection
