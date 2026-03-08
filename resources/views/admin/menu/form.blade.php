@extends('admin.layouts.app')

@section('content')
<div class="card" style="max-width:700px;">
    <div class="card-header">{{ $item ? 'Menu Ogesi Duzenle' : 'Yeni Menu Ogesi' }}</div>
    <div class="card-body">
        @if(session('error'))
            <div class="alert-error">{{ session('error') }}</div>
        @endif

        <form method="POST" action="{{ $item ? route('admin.menu.update', $item) : route('admin.menu.store') }}">
            @csrf
            @if($item) @method('PUT') @endif

            <input type="hidden" name="location" value="{{ $location }}">

            <div class="form-group">
                <label for="title">Baslik *</label>
                <input type="text" name="title" id="title" required value="{{ old('title', $item?->title) }}" class="form-input" maxlength="120">
                @error('title')<span class="form-error">{{ $message }}</span>@enderror
            </div>

            <div class="form-group">
                <label for="type">Tip *</label>
                <select name="type" id="type" class="form-input">
                    <option value="page" {{ old('type', $item?->type ?? 'page') === 'page' ? 'selected' : '' }}>Sayfa (ic link)</option>
                    <option value="url" {{ old('type', $item?->type) === 'url' ? 'selected' : '' }}>URL (harici link)</option>
                </select>
                @error('type')<span class="form-error">{{ $message }}</span>@enderror
            </div>

            <div class="form-group" id="urlPageGroup">
                <label for="url">Link *</label>
                <input type="text" name="url" id="url" value="{{ old('url', $item?->url) }}" class="form-input" placeholder="/programlar veya https://...">
                <p class="muted" style="font-size:0.8rem;margin-top:0.35rem;">Sayfa icin: /programlar, /hakkimizda/biz-kimiz gibi. URL icin: https://example.com</p>
                @error('url')<span class="form-error">{{ $message }}</span>@enderror
            </div>

            <div class="form-group">
                <label for="parent_id">Ust Menu</label>
                <select name="parent_id" id="parent_id" class="form-input">
                    <option value="">- Yok (ana menu) -</option>
                    @foreach($parents as $p)
                        <option value="{{ $p->id }}" {{ old('parent_id', $item?->parent_id) == $p->id ? 'selected' : '' }}>{{ $p->title }}</option>
                    @endforeach
                </select>
                <p class="muted" style="font-size:0.8rem;margin-top:0.35rem;">Sadece 1 seviye alt menu desteklenir.</p>
                @error('parent_id')<span class="form-error">{{ $message }}</span>@enderror
            </div>

            <div class="form-group">
                <label for="sort_order">Sira</label>
                <input type="number" name="sort_order" id="sort_order" value="{{ old('sort_order', $item?->sort_order ?? 0) }}" min="0" class="form-input">
                @error('sort_order')<span class="form-error">{{ $message }}</span>@enderror
            </div>

            <div class="form-group">
                <label class="checkbox-label">
                    <input type="checkbox" name="target_blank" value="1" {{ old('target_blank', $item?->target_blank) ? 'checked' : '' }}>
                    Yeni sekmede ac
                </label>
            </div>

            <div class="form-group">
                <label class="checkbox-label">
                    <input type="checkbox" name="is_active" value="1" {{ old('is_active', $item?->is_active ?? true) ? 'checked' : '' }}>
                    Aktif
                </label>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn-save">Kaydet</button>
                <a href="{{ route('admin.menu.index', ['location' => $location]) }}" class="btn-cancel">Iptal</a>
            </div>
        </form>
    </div>
</div>

@push('styles')
<style>
.alert-error{padding:0.75rem 1rem;background:rgba(239,68,68,0.2);border:1px solid rgba(239,68,68,0.4);border-radius:10px;color:#fca5a5;font-size:0.9rem;margin-bottom:1rem;}
.form-group{margin-bottom:1.25rem;}
.form-group label{display:block;font-size:0.9rem;font-weight:600;color:var(--text);margin-bottom:0.5rem;}
.form-input{width:100%;padding:0.75rem 1rem;font-size:0.9rem;background:rgba(255,255,255,0.06);border:1px solid var(--border);border-radius:10px;color:var(--text);}
.form-input[type="number"]{max-width:120px;}
.checkbox-label{display:flex;align-items:center;gap:0.5rem;cursor:pointer;font-size:0.9rem;font-weight:600;color:var(--text);}
.checkbox-label input{width:18px;height:18px;accent-color:var(--accent);}
.form-error{font-size:0.8rem;color:#f87171;margin-top:0.35rem;display:block;}
.form-actions{margin-top:1.5rem;display:flex;gap:0.75rem;}
.muted{color:var(--muted);}
</style>
@endpush
@push('scripts')
<script>
(function() {
    var typeSelect = document.getElementById('type');
    var urlInput = document.getElementById('url');
    if (typeSelect && urlInput) {
        typeSelect.addEventListener('change', function() {
            if (typeSelect.value === 'page') {
                urlInput.placeholder = '/programlar, /hakkimizda/biz-kimiz';
            } else {
                urlInput.placeholder = 'https://example.com';
            }
        });
    }
})();
</script>
@endpush
@endsection
