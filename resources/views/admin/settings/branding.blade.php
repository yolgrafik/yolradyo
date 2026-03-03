@extends('admin.layouts.app')

@section('content')
<div class="card" style="max-width: 700px;">
    <div class="card-header">Logo & Favicon</div>
    <div class="card-body">
        @if(session('success'))
            <div class="settings-success">{{ session('success') }}</div>
        @endif

        <form method="POST" action="{{ route('admin.settings.branding') }}" enctype="multipart/form-data">
            @csrf

            <div class="form-group">
                <label for="logo_file">Logo (PNG, JPG, SVG - max 2MB)</label>
                @if(isset($brand_logo_path) && $brand_logo_path)
                    <div class="current-file">
                        <img src="{{ asset('storage/' . $brand_logo_path) }}" alt="Logo" style="max-height: 80px; margin-bottom: 0.5rem;">
                        <span class="muted">Mevcut: {{ $brand_logo_path }}</span>
                    </div>
                @endif
                <input type="file" name="logo_file" id="logo_file" accept=".png,.jpg,.jpeg,.svg">
                @error('logo_file')<span class="form-error">{{ $message }}</span>@enderror
            </div>

            <div class="form-group">
                <label for="favicon_file">Favicon (PNG, ICO - max 1MB)</label>
                @if(isset($brand_favicon_path) && $brand_favicon_path)
                    <div class="current-file">
                        <img src="{{ asset('storage/' . $brand_favicon_path) }}" alt="Favicon" style="max-height: 32px; margin-bottom: 0.5rem;">
                        <span class="muted">Mevcut: {{ $brand_favicon_path }}</span>
                    </div>
                @endif
                <input type="file" name="favicon_file" id="favicon_file" accept=".png,.ico">
                @error('favicon_file')<span class="form-error">{{ $message }}</span>@enderror
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
.form-group input[type="file"] { padding: 0.5rem; font-size: 0.9rem; color: var(--text); }
.current-file { margin-bottom: 0.5rem; }
.muted { font-size: 0.8rem; color: var(--muted); }
.form-error { font-size: 0.8rem; color: #f87171; margin-top: 0.35rem; display: block; }
.form-actions { margin-top: 1.5rem; }
.btn-save { padding: 0.65rem 1.25rem; font-size: 0.9rem; font-weight: 600; background: linear-gradient(135deg, #dc2626, var(--accent)); color: #fff; border: none; border-radius: 10px; cursor: pointer; }
</style>
@endpush
@endsection
