@extends('admin.layouts.app')

@section('content')
<div class="card" style="max-width:600px;">
    <div class="card-header">Yonetici Duzenle: {{ $user->name }}</div>
    <div class="card-body">
        <form method="POST" action="{{ route('admin.users.update', $user) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label>Profil Resmi</label>
                <div class="avatar-edit-row">
                    <div class="avatar-preview-wrap">
                        <img src="{{ $user->avatarUrl() }}" alt="" class="avatar-preview" id="avatarPreview">
                    </div>
                    <div class="avatar-edit-actions">
                        <input type="file" name="avatar" id="avatar" accept="image/jpeg,image/png,image/webp" class="form-input form-input--sm">
                        <span class="form-hint">JPG, PNG, WebP. Maks. 2MB</span>
                        @error('avatar')<span class="form-error">{{ $message }}</span>@enderror
                        @if($user->avatar_path)
                        <label class="checkbox-label" style="margin-top:0.75rem;">
                            <input type="checkbox" name="remove_avatar" value="1" {{ old('remove_avatar') ? 'checked' : '' }}>
                            Resmi Kaldir
                        </label>
                        @endif
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label for="name">Ad Soyad *</label>
                <input type="text" name="name" id="name" required value="{{ old('name', $user->name) }}" class="form-input">
                @error('name')<span class="form-error">{{ $message }}</span>@enderror
            </div>
            <div class="form-group">
                <label for="email">E-posta *</label>
                <input type="email" name="email" id="email" required value="{{ old('email', $user->email) }}" class="form-input">
                @error('email')<span class="form-error">{{ $message }}</span>@enderror
            </div>
            <div class="form-group">
                <label for="password">Yeni Sifre (bos birakin degistirmemek icin)</label>
                <input type="password" name="password" id="password" class="form-input">
                @error('password')<span class="form-error">{{ $message }}</span>@enderror
            </div>
            <div class="form-group">
                <label for="password_confirmation">Sifre Tekrar</label>
                <input type="password" name="password_confirmation" id="password_confirmation" class="form-input">
            </div>
            <div class="form-group">
                <label for="role_id">Rol</label>
                <select name="role_id" id="role_id" class="form-input">
                    <option value="">-- Seciniz --</option>
                    @foreach($roles as $role)
                        <option value="{{ $role->id }}" {{ old('role_id', $user->role_id) == $role->id ? 'selected' : '' }}>{{ $role->name }}</option>
                    @endforeach
                </select>
                @error('role_id')<span class="form-error">{{ $message }}</span>@enderror
            </div>
            <div class="form-group">
                <label class="checkbox-label">
                    <input type="checkbox" name="is_active" value="1" {{ old('is_active', $user->is_active) ? 'checked' : '' }}>
                    Aktif
                </label>
            </div>
            <div class="form-actions">
                <button type="submit" class="btn-save">Kaydet</button>
                <a href="{{ route('admin.users.index') }}" class="btn-cancel">Iptal</a>
            </div>
        </form>
    </div>
</div>

@push('styles')
<style>
.form-group{margin-bottom:1.25rem;}
.form-group label{display:block;font-size:0.9rem;font-weight:600;color:var(--text);margin-bottom:0.5rem;}
.form-input{width:100%;padding:0.75rem 1rem;font-size:0.9rem;background:rgba(255,255,255,0.06);border:1px solid var(--border);border-radius:10px;color:var(--text);}
.checkbox-label{display:flex;align-items:center;gap:0.5rem;cursor:pointer;font-size:0.9rem;font-weight:600;color:var(--text);}
.checkbox-label input{width:18px;height:18px;accent-color:var(--accent);}
.form-error{font-size:0.8rem;color:#f87171;margin-top:0.35rem;display:block;}
.form-hint{font-size:0.8rem;color:var(--muted);margin-top:0.25rem;display:block;}
.avatar-edit-row{display:flex;gap:1rem;align-items:center;}
.avatar-preview-wrap{flex-shrink:0;}
.avatar-preview{width:44px;height:44px;border-radius:50%;object-fit:cover;border:2px solid var(--border);}
.avatar-edit-actions{flex:1;min-width:0;}
.form-input--sm{padding:0.5rem 0.75rem;font-size:0.85rem;max-width:240px;}
.form-actions{margin-top:1.5rem;display:flex;gap:0.75rem;}
.btn-save{padding:0.65rem 1.25rem;font-size:0.9rem;font-weight:600;background:linear-gradient(135deg,#dc2626,var(--accent));color:#fff;border:none;border-radius:10px;cursor:pointer;}
.btn-cancel{padding:0.65rem 1.25rem;font-size:0.9rem;font-weight:600;background:rgba(255,255,255,0.08);color:var(--text);border:1px solid var(--border);border-radius:10px;text-decoration:none;}
</style>
@endpush
@push('scripts')
<script>
(function(){
    var input = document.getElementById('avatar');
    var preview = document.getElementById('avatarPreview');
    if (input && preview) {
        input.addEventListener('change', function(){
            var f = this.files[0];
            if (f) {
                var r = new FileReader();
                r.onload = function(){ preview.src = r.result; };
                r.readAsDataURL(f);
            }
        });
    }
})();
</script>
@endpush
@endsection
