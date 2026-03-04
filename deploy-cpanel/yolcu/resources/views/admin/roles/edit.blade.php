@extends('admin.layouts.app')

@section('content')
<div class="card" style="max-width:700px;">
    <div class="card-header">Rol Duzenle: {{ $role->name }}</div>
    <div class="card-body">
        <form method="POST" action="{{ route('admin.roles.update', $role) }}">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="name">Rol Adi *</label>
                <input type="text" name="name" id="name" required value="{{ old('name', $role->name) }}" class="form-input">
                @error('name')<span class="form-error">{{ $message }}</span>@enderror
            </div>
            <div class="form-group">
                <label>Yetkiler</label>
                <div class="permission-grid">
                    @php $rolePermIds = $role->permissions->pluck('id')->toArray(); @endphp
                    @foreach($permissions as $perm)
                    <label class="permission-item">
                        <input type="checkbox" name="permissions[]" value="{{ $perm->id }}" {{ in_array($perm->id, old('permissions', $rolePermIds)) ? 'checked' : '' }}>
                        <span>{{ $perm->label }}</span>
                        <small class="muted">({{ $perm->key }})</small>
                    </label>
                    @endforeach
                </div>
                @error('permissions')<span class="form-error">{{ $message }}</span>@enderror
            </div>
            <div class="form-actions">
                <button type="submit" class="btn-save">Kaydet</button>
                <a href="{{ route('admin.roles.index') }}" class="btn-cancel">Iptal</a>
            </div>
        </form>
    </div>
</div>

@push('styles')
<style>
.form-group{margin-bottom:1.25rem;}
.form-group label{display:block;font-size:0.9rem;font-weight:600;color:var(--text);margin-bottom:0.5rem;}
.form-input{width:100%;max-width:400px;padding:0.75rem 1rem;font-size:0.9rem;background:rgba(255,255,255,0.06);border:1px solid var(--border);border-radius:10px;color:var(--text);}
.permission-grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(220px,1fr));gap:0.5rem;}
.permission-item{display:flex;align-items:center;gap:0.5rem;padding:0.5rem 0.75rem;background:rgba(255,255,255,0.04);border-radius:8px;cursor:pointer;font-size:0.9rem;}
.permission-item input{width:18px;height:18px;accent-color:var(--accent);}
.permission-item .muted{font-size:0.75rem;color:var(--muted);}
.form-error{font-size:0.8rem;color:#f87171;margin-top:0.35rem;display:block;}
.form-actions{margin-top:1.5rem;display:flex;gap:0.75rem;}
.btn-save{padding:0.65rem 1.25rem;font-size:0.9rem;font-weight:600;background:linear-gradient(135deg,#dc2626,var(--accent));color:#fff;border:none;border-radius:10px;cursor:pointer;}
.btn-cancel{padding:0.65rem 1.25rem;font-size:0.9rem;font-weight:600;background:rgba(255,255,255,0.08);color:var(--text);border:1px solid var(--border);border-radius:10px;text-decoration:none;}
</style>
@endpush
@endsection
