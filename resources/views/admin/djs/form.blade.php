@extends('admin.layouts.app')

@section('content')
<div class="card" style="max-width:600px;">
    <div class="card-header">{{ $dj ? 'DJ Düzenle' : 'Yeni DJ' }}</div>
    <div class="card-body">
        <form method="POST" action="{{ $dj ? route('admin.djs.update', $dj) : route('admin.djs.store') }}" enctype="multipart/form-data">
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
                <label for="avatar">Profil Resmi</label>
                <input type="file" name="avatar" id="avatar" accept="image/jpeg,image/png,image/webp" class="form-input">
                <span class="form-hint">JPG, PNG veya WebP, max 2MB</span>
                @error('avatar')<span class="form-error">{{ $message }}</span>@enderror
                <div class="avatar-preview-wrap" style="margin-top:0.75rem;{{ ($dj && $dj->avatar_path) ? '' : 'display:none;' }}" id="avatarPreviewWrap">
                    <img src="{{ $dj && $dj->avatar_path ? $dj->avatar_url : '' }}" alt="" class="avatar-preview" id="avatarPreview">
                </div>
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
.form-input[type="file"]{padding:0.5rem;}
.form-hint{display:block;font-size:0.8rem;color:var(--muted);margin-top:0.35rem;}
.form-error{font-size:0.8rem;color:#f87171;margin-top:0.35rem;display:block;}
.avatar-preview{width:80px;height:80px;border-radius:50%;object-fit:cover;border:2px solid var(--border);}
.form-actions{margin-top:1.5rem;display:flex;gap:0.75rem;}
</style>
@endpush
@push('scripts')
<script>
document.getElementById('avatar')?.addEventListener('change', function(e) {
    var wrap = document.getElementById('avatarPreviewWrap');
    var img = document.getElementById('avatarPreview');
    if (e.target.files && e.target.files[0]) {
        wrap.style.display = 'block';
        var r = new FileReader();
        r.onload = function() { img.src = r.result; };
        r.readAsDataURL(e.target.files[0]);
    } else if (!img.dataset.original) {
        wrap.style.display = 'none';
    }
});
</script>
@endpush
@endsection
