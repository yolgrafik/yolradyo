@extends('admin.layouts.app')

@section('content')
<div class="card" style="max-width:600px;">
    <div class="card-header">Üye Düzenle: {{ $user->name }}</div>
    <div class="card-body">
        <form method="POST" action="{{ route('admin.members.update', $user) }}">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="name">Ad Soyad *</label>
                <input type="text" name="name" id="name" required value="{{ old('name', $user->name) }}" class="form-input" maxlength="255">
                @error('name')<span class="form-error">{{ $message }}</span>@enderror
            </div>
            <div class="form-group">
                <label for="email">E-posta *</label>
                <input type="email" name="email" id="email" required value="{{ old('email', $user->email) }}" class="form-input">
                @error('email')<span class="form-error">{{ $message }}</span>@enderror
            </div>
            <div class="form-group">
                <label for="status">Durum *</label>
                <select name="status" id="status" class="form-input" required>
                    <option value="aktif" {{ old('status', $user->status) === 'aktif' ? 'selected' : '' }}>Aktif</option>
                    <option value="pasif" {{ old('status', $user->status) === 'pasif' ? 'selected' : '' }}>Pasif</option>
                    <option value="ban" {{ old('status', $user->status) === 'ban' ? 'selected' : '' }}>Ban</option>
                </select>
                @error('status')<span class="form-error">{{ $message }}</span>@enderror
            </div>
            <div class="form-group">
                <label for="password">Yeni Şifre</label>
                <input type="password" name="password" id="password" class="form-input" autocomplete="new-password">
                <span class="form-hint">Boş bırakılırsa şifre değişmez.</span>
                @error('password')<span class="form-error">{{ $message }}</span>@enderror
            </div>
            <div class="form-group">
                <label for="password_confirmation">Şifre Tekrar</label>
                <input type="password" name="password_confirmation" id="password_confirmation" class="form-input" autocomplete="new-password">
            </div>
            <div class="form-actions">
                <button type="submit" class="btn-save">Kaydet</button>
                <a href="{{ route('admin.members.index') }}" class="btn-cancel">İptal</a>
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
.form-hint{font-size:0.8rem;color:var(--muted);margin-top:0.25rem;display:block;}
.form-actions{margin-top:1.5rem;display:flex;gap:0.75rem;}
.btn-save{padding:0.65rem 1.25rem;font-size:0.9rem;font-weight:600;background:linear-gradient(135deg,#dc2626,var(--accent));color:#fff;border:none;border-radius:10px;cursor:pointer;}
.btn-cancel{padding:0.65rem 1.25rem;font-size:0.9rem;font-weight:600;background:rgba(255,255,255,0.08);color:var(--text);border:1px solid var(--border);border-radius:10px;text-decoration:none;}
</style>
@endpush
@endsection
