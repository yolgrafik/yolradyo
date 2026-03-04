@extends('admin.layouts.app')

@section('content')
<div class="card" style="max-width: 700px;">
    <div class="card-header">SEO Ayarlari</div>
    <div class="card-body">
        @if(session('success'))
            <div class="settings-success">{{ session('success') }}</div>
        @endif

        <form method="POST" action="{{ route('admin.settings.seo') }}" enctype="multipart/form-data">
            @csrf

            <div class="form-group">
                <label for="meta_title">Meta Baslik</label>
                <input type="text" name="meta_title" id="meta_title"
                    value="{{ old('meta_title', $seo_meta_title ?? '') }}"
                    placeholder="RADYOYOL - Canli Radyo">
                @error('meta_title')<span class="form-error">{{ $message }}</span>@enderror
            </div>

            <div class="form-group">
                <label for="meta_description">Meta Aciklama (max 160 karakter)</label>
                <textarea name="meta_description" id="meta_description" rows="3" maxlength="160"
                    placeholder="Site aciklamasi">{{ old('meta_description', $seo_meta_description ?? '') }}</textarea>
                <span class="char-count"><span id="descCount">0</span>/160</span>
                @error('meta_description')<span class="form-error">{{ $message }}</span>@enderror
            </div>

            <div class="form-group">
                <label for="meta_keywords">Meta Anahtar Kelimeler</label>
                <input type="text" name="meta_keywords" id="meta_keywords"
                    value="{{ old('meta_keywords', $seo_meta_keywords ?? '') }}"
                    placeholder="radyoyol, canli radyo, online radyo">
                @error('meta_keywords')<span class="form-error">{{ $message }}</span>@enderror
            </div>

            <div class="form-group">
                <label for="og_image_file">OG Gorsel (PNG, JPG - max 2MB)</label>
                @if($seo_og_image_path ?? null)
                    <div class="current-file">
                        <img src="{{ asset('storage/' . $seo_og_image_path) }}" alt="OG" style="max-height: 120px; margin-bottom: 0.5rem;">
                    </div>
                @endif
                <input type="file" name="og_image_file" id="og_image_file" accept=".png,.jpg,.jpeg">
                @error('og_image_file')<span class="form-error">{{ $message }}</span>@enderror
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
.char-count { font-size: 0.75rem; color: var(--muted); }
.form-error { font-size: 0.8rem; color: #f87171; margin-top: 0.35rem; display: block; }
.form-actions { margin-top: 1.5rem; }
.btn-save { padding: 0.65rem 1.25rem; font-size: 0.9rem; font-weight: 600; background: linear-gradient(135deg, #dc2626, var(--accent)); color: #fff; border: none; border-radius: 10px; cursor: pointer; }
</style>
@endpush
@push('scripts')
<script>
(function() {
    var ta = document.getElementById('meta_description');
    var count = document.getElementById('descCount');
    if (ta && count) {
        count.textContent = ta.value.length;
        ta.addEventListener('input', function() { count.textContent = ta.value.length; });
    }
})();
</script>
@endpush
@endsection
