@extends('admin.layouts.app')

@section('content')
<div class="card" style="max-width:600px;">
    <div class="card-header">{{ $dj ? 'DJ Düzenle' : 'Yeni DJ' }}</div>
    <div class="card-body">
        <form method="POST" action="{{ $dj ? route('admin.djs.update', $dj) : route('admin.djs.store') }}">
            @csrf
            @if($dj) @method('PUT') @endif
            <div class="form-group">
                <label for="name">Ad *</label>
                <input type="text" name="name" id="name" required value="{{ old('name', $dj?->name) }}" class="form-input" placeholder="Örn: Desmal">
                @error('name')<span class="form-error">{{ $message }}</span>@enderror
            </div>
            <div class="form-group">
                <label for="bio">Slogan / Tagline</label>
                <input type="text" name="bio" id="bio" value="{{ old('bio', $dj?->bio) }}" class="form-input" placeholder="Örn: Türküler bizim">
                @error('bio')<span class="form-error">{{ $message }}</span>@enderror
            </div>
            <div class="form-group">
                <label for="initials">Baş harfler (opsiyonel)</label>
                <input type="text" name="initials" id="initials" value="{{ old('initials', $dj?->initials) }}" class="form-input" placeholder="Örn: DE (boş bırakılırsa addan türetilir)" maxlength="10">
                @error('initials')<span class="form-error">{{ $message }}</span>@enderror
            </div>
            <div class="form-group">
                <label for="avatar_path">Avatar yolu</label>
                <input type="text" name="avatar_path" id="avatar_path" value="{{ old('avatar_path', $dj?->avatar_path) }}" class="form-input" placeholder="Örn: storage/djs/avatar.jpg">
                @error('avatar_path')<span class="form-error">{{ $message }}</span>@enderror
            </div>
            <div class="form-actions">
                <button type="submit" class="btn-save">Kaydet</button>
                <a href="{{ route('admin.djs.index') }}" class="btn-cancel">İptal</a>
            </div>
        </form>
    </div>
</div>

@push('styles')
<style>
.form-group{margin-bottom:1.25rem;}
.form-group label{display:block;font-size:0.9rem;font-weight:600;color:var(--text);margin-bottom:0.5rem;}
.form-input{width:100%;padding:0.75rem 1rem;font-size:0.9rem;background:rgba(255,255,255,0.06);border:1px solid var(--border);border-radius:10px;color:var(--text);}
.form-error{font-size:0.8rem;color:#f87171;margin-top:0.35rem;display:block;}
.form-actions{margin-top:1.5rem;display:flex;gap:0.75rem;}
.btn-save{padding:0.65rem 1.25rem;font-size:0.9rem;font-weight:600;background:linear-gradient(135deg,#dc2626,var(--accent));color:#fff;border:none;border-radius:10px;cursor:pointer;}
.btn-cancel{padding:0.65rem 1.25rem;font-size:0.9rem;font-weight:600;background:rgba(255,255,255,0.08);color:var(--text);border:1px solid var(--border);border-radius:10px;text-decoration:none;}
</style>
@endpush
@endsection
