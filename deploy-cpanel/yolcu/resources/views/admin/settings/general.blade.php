@extends('admin.layouts.app')

@section('content')
<div class="card" style="max-width: 700px;">
    <div class="card-header">Genel Site Ayarlari</div>
    <div class="card-body">
        @if(session('success'))
            <div class="settings-success">{{ session('success') }}</div>
        @endif

        <form method="POST" action="{{ route('admin.settings.general') }}">
            @csrf

            <div class="form-group">
                <label for="site_name">Site Adi *</label>
                <input type="text" name="site_name" id="site_name" required
                    value="{{ old('site_name', $site_name ?? '') }}"
                    placeholder="RADYOYOL">
                @error('site_name')<span class="form-error">{{ $message }}</span>@enderror
            </div>

            <div class="form-group">
                <label for="site_slogan">Slogan</label>
                <input type="text" name="site_slogan" id="site_slogan"
                    value="{{ old('site_slogan', $site_slogan ?? '') }}"
                    placeholder="Canli Radyo">
                @error('site_slogan')<span class="form-error">{{ $message }}</span>@enderror
            </div>

            <div class="form-group">
                <label for="contact_email">Iletisim E-posta</label>
                <input type="email" name="contact_email" id="contact_email"
                    value="{{ old('contact_email', $contact_email ?? '') }}"
                    placeholder="info@radyoyol.com">
                @error('contact_email')<span class="form-error">{{ $message }}</span>@enderror
            </div>

            <div class="form-group">
                <label for="contact_phone">Iletisim Telefon</label>
                <input type="text" name="contact_phone" id="contact_phone"
                    value="{{ old('contact_phone', $contact_phone ?? '') }}"
                    placeholder="+90 555 123 4567">
                @error('contact_phone')<span class="form-error">{{ $message }}</span>@enderror
            </div>

            <div class="form-group">
                <label for="address_text">Adres</label>
                <textarea name="address_text" id="address_text" rows="3"
                    placeholder="Adres bilgisi">{{ old('address_text', $address_text ?? '') }}</textarea>
                @error('address_text')<span class="form-error">{{ $message }}</span>@enderror
            </div>

            <div class="form-group">
                <label class="checkbox-label">
                    <input type="checkbox" name="maintenance_mode" value="1"
                        {{ old('maintenance_mode', $maintenance_mode ?? false) ? 'checked' : '' }}>
                    Bakim modu (site ziyaretcilere kapali)
                </label>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn-save">Kaydet</button>
            </div>
        </form>
    </div>
</div>

@push('styles')
<style>
.settings-success { padding: 0.75rem 1rem; background: rgba(34,197,94,0.2); border: 1px solid rgba(34,197,94,0.4); border-radius: 10px; color: #86efac; font-size: 0.9rem; margin-bottom: 1.25rem; }
.form-group { margin-bottom: 1.25rem; }
.form-group label { display: block; font-size: 0.9rem; font-weight: 600; color: var(--text); margin-bottom: 0.5rem; }
.form-group input, .form-group textarea { width: 100%; padding: 0.75rem 1rem; font-size: 0.9rem; background: rgba(255,255,255,0.06); border: 1px solid var(--border); border-radius: 10px; color: var(--text); }
.form-error { font-size: 0.8rem; color: #f87171; margin-top: 0.35rem; display: block; }
.checkbox-label { display: flex; align-items: center; gap: 0.5rem; cursor: pointer; font-size: 0.9rem; font-weight: 600; color: var(--text); }
.checkbox-label input { width: 18px; height: 18px; accent-color: var(--accent); }
.form-actions { margin-top: 1.5rem; }
.btn-save { padding: 0.65rem 1.25rem; font-size: 0.9rem; font-weight: 600; background: linear-gradient(135deg, #dc2626, var(--accent)); color: #fff; border: none; border-radius: 10px; cursor: pointer; }
.btn-save:hover { opacity: 0.95; }
</style>
@endpush
@endsection
