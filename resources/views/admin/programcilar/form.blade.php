@extends('admin.layouts.app')

@section('content')
<div class="card" style="max-width:700px;">
    <div class="card-header">{{ $programci ? 'Programcı Düzenle' : 'Yeni Programcı' }}</div>
    <div class="card-body">
        <form method="POST" action="{{ $programci ? route('admin.programcilar.update', $programci) : route('admin.programcilar.store') }}" enctype="multipart/form-data">
            @csrf
            @if($programci) @method('PUT') @endif

            <div class="form-row" style="display:grid;grid-template-columns:1fr 1fr;gap:1rem;">
                <div class="form-group">
                    <label for="ad">Ad *</label>
                    <input type="text" name="ad" id="ad" required value="{{ old('ad', $programci?->ad) }}" class="form-input" placeholder="Örn: Fido">
                    @error('ad')<span class="form-error">{{ $message }}</span>@enderror
                </div>
                <div class="form-group">
                    <label for="slug">Slug</label>
                    <input type="text" name="slug" id="slug" value="{{ old('slug', $programci?->slug) }}" class="form-input" placeholder="Boş bırakılırsa addan türetilir">
                    @error('slug')<span class="form-error">{{ $message }}</span>@enderror
                </div>
            </div>

            <div class="form-group">
                <label for="avatar">Profil Resmi</label>
                <input type="file" name="avatar" id="avatar" accept="image/jpeg,image/png,image/webp" class="form-input">
                <span class="form-hint">JPG, PNG veya WebP, max 2MB</span>
                @error('avatar')<span class="form-error">{{ $message }}</span>@enderror
                <div class="avatar-preview-wrap" style="margin-top:0.75rem;{{ ($programci && $programci->avatar_path) ? '' : 'display:none;' }}" id="avatarPreviewWrap">
                    <img src="{{ $programci && $programci->avatar_path ? $programci->avatar_url : '' }}" alt="" class="avatar-preview" id="avatarPreview" style="width:80px;height:80px;border-radius:50%;object-fit:cover;">
                </div>
            </div>

            <div class="form-group">
                <label for="kisa_aciklama">Kısa Açıklama (Slogan)</label>
                <input type="text" name="kisa_aciklama" id="kisa_aciklama" value="{{ old('kisa_aciklama', $programci?->kisa_aciklama) }}" class="form-input" placeholder="Örn: Heybemdeki Türküler" maxlength="500">
                @error('kisa_aciklama')<span class="form-error">{{ $message }}</span>@enderror
            </div>

            <div class="form-group">
                <label for="uzun_aciklama">Uzun Açıklama</label>
                <textarea name="uzun_aciklama" id="uzun_aciklama" rows="6" class="form-input form-textarea" placeholder="Programcı hakkında detaylı bilgi">{{ old('uzun_aciklama', $programci?->uzun_aciklama) }}</textarea>
                @error('uzun_aciklama')<span class="form-error">{{ $message }}</span>@enderror
            </div>

            <div class="form-group">
                <label for="email">E-posta (İletişim formu için)</label>
                <input type="email" name="email" id="email" value="{{ old('email', $programci?->email) }}" class="form-input" placeholder="programci@radyoyol.com">
                @error('email')<span class="form-error">{{ $message }}</span>@enderror
            </div>

            <div class="form-section-label">Sosyal Medya</div>
            <div class="form-row" style="display:grid;grid-template-columns:1fr 1fr;gap:1rem;">
                <div class="form-group">
                    <label for="instagram">Instagram</label>
                    <input type="url" name="instagram" id="instagram" value="{{ old('instagram', $programci?->instagram) }}" class="form-input" placeholder="https://instagram.com/...">
                    @error('instagram')<span class="form-error">{{ $message }}</span>@enderror
                </div>
                <div class="form-group">
                    <label for="facebook">Facebook</label>
                    <input type="url" name="facebook" id="facebook" value="{{ old('facebook', $programci?->facebook) }}" class="form-input" placeholder="https://facebook.com/...">
                    @error('facebook')<span class="form-error">{{ $message }}</span>@enderror
                </div>
                <div class="form-group">
                    <label for="tiktok">TikTok</label>
                    <input type="url" name="tiktok" id="tiktok" value="{{ old('tiktok', $programci?->tiktok) }}" class="form-input" placeholder="https://tiktok.com/...">
                    @error('tiktok')<span class="form-error">{{ $message }}</span>@enderror
                </div>
                <div class="form-group">
                    <label for="youtube">YouTube</label>
                    <input type="url" name="youtube" id="youtube" value="{{ old('youtube', $programci?->youtube) }}" class="form-input" placeholder="https://youtube.com/...">
                    @error('youtube')<span class="form-error">{{ $message }}</span>@enderror
                </div>
            </div>
            <div class="form-group">
                <label for="website">Web Sitesi</label>
                <input type="url" name="website" id="website" value="{{ old('website', $programci?->website) }}" class="form-input" placeholder="https://...">
                @error('website')<span class="form-error">{{ $message }}</span>@enderror
            </div>

            <div class="form-row" style="display:grid;grid-template-columns:1fr 1fr;gap:1rem;">
                <div class="form-group">
                    <label for="sira">Sıra</label>
                    <input type="number" name="sira" id="sira" value="{{ old('sira', $programci?->sira ?? 0) }}" class="form-input" min="0">
                    @error('sira')<span class="form-error">{{ $message }}</span>@enderror
                </div>
                <div class="form-group">
                    <label class="checkbox-label" style="display:flex;align-items:center;gap:0.5rem;margin-top:2rem;">
                        <input type="checkbox" name="aktif" value="1" {{ old('aktif', $programci?->aktif ?? true) ? 'checked' : '' }}> Aktif
                    </label>
                </div>
            </div>

            <div class="form-section-label">SEO (Opsiyonel)</div>
            <div class="form-group">
                <label for="seo_title">SEO Başlık</label>
                <input type="text" name="seo_title" id="seo_title" value="{{ old('seo_title', $programci?->seo_title) }}" class="form-input" maxlength="255">
                @error('seo_title')<span class="form-error">{{ $message }}</span>@enderror
            </div>
            <div class="form-group">
                <label for="seo_description">SEO Açıklama</label>
                <textarea name="seo_description" id="seo_description" rows="2" class="form-input" maxlength="500">{{ old('seo_description', $programci?->seo_description) }}</textarea>
                @error('seo_description')<span class="form-error">{{ $message }}</span>@enderror
            </div>

            <div class="form-actions">
                <button type="submit" class="btn-save">Kaydet</button>
                <a href="{{ route('admin.programcilar.index') }}" class="btn-cancel">İptal</a>
            </div>
        </form>
    </div>
</div>

@push('styles')
<style>
.form-group{margin-bottom:1.25rem;}
.form-section-label{font-size:0.85rem;font-weight:600;color:var(--muted);margin:1.5rem 0 0.75rem;text-transform:uppercase;letter-spacing:0.05em;}
.form-group label{display:block;font-size:0.9rem;font-weight:600;color:var(--text);margin-bottom:0.5rem;}
.form-input{width:100%;padding:0.75rem 1rem;font-size:0.9rem;background:rgba(255,255,255,0.06);border:1px solid var(--border);border-radius:10px;color:var(--text);}
.form-input[type="file"]{padding:0.5rem;}
.form-textarea{resize:vertical;min-height:120px;}
.form-hint{display:block;font-size:0.8rem;color:var(--muted);margin-top:0.35rem;}
.form-error{font-size:0.8rem;color:#f87171;margin-top:0.35rem;display:block;}
.form-actions{margin-top:1.5rem;display:flex;gap:0.75rem;}
.btn-save{padding:0.65rem 1.25rem;font-size:0.9rem;font-weight:600;background:linear-gradient(135deg,#dc2626,var(--accent));color:#fff;border:none;border-radius:10px;cursor:pointer;}
.btn-cancel{padding:0.65rem 1.25rem;font-size:0.9rem;font-weight:600;background:rgba(255,255,255,0.08);color:var(--text);border:1px solid var(--border);border-radius:10px;text-decoration:none;}
@media(max-width:600px){.form-row{grid-template-columns:1fr !important;}}
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
