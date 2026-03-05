@extends('admin.layouts.app')

@section('content')
<div class="card" style="max-width: 900px;">
    <div class="card-header">
        <a href="{{ route('admin.legal-texts.index') }}" class="back-link">← Yasal Metinlere dön</a>
        <h1 class="card-title">{{ $title }}</h1>
    </div>
    <div class="card-body">
        @if($errors->any())
            <div class="alert-error">{{ $errors->first() }}</div>
        @endif

        <form method="POST" action="{{ route('admin.legal-texts.update', $slug) }}">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="content">İçerik</label>
                <textarea name="content" id="content" rows="20" class="form-input form-textarea">{{ old('content', $content) }}</textarea>
                <span class="form-hint">HTML etiketleri kullanabilirsiniz (örn: &lt;p&gt;, &lt;h2&gt;, &lt;ul&gt;, &lt;li&gt;). Boş bırakılırsa sayfada varsayılan mesaj gösterilir.</span>
                @error('content')<span class="form-error">{{ $message }}</span>@enderror
            </div>
            <div class="form-actions">
                <button type="submit" class="btn-save">Kaydet</button>
                <a href="{{ route('admin.legal-texts.index') }}" class="btn-cancel">İptal</a>
            </div>
        </form>
    </div>
</div>

@push('styles')
<style>
.back-link { display: inline-block; font-size: 0.9rem; color: var(--muted); text-decoration: none; margin-bottom: 0.5rem; }
.back-link:hover { color: var(--text); }
.card-title { font-size: 1.25rem; font-weight: 700; margin: 0 0 1rem 0; }
.alert-error { padding: 0.75rem 1rem; background: rgba(239,68,68,0.2); border: 1px solid rgba(239,68,68,0.4); border-radius: 10px; color: #fca5a5; margin-bottom: 1rem; }
.form-group { margin-bottom: 1.25rem; }
.form-group label { display: block; font-size: 0.9rem; font-weight: 600; color: var(--text); margin-bottom: 0.5rem; }
.form-input { width: 100%; padding: 0.75rem 1rem; font-size: 0.9rem; background: rgba(255,255,255,0.06); border: 1px solid var(--border); border-radius: 10px; color: var(--text); }
.form-textarea { min-height: 400px; font-family: ui-monospace, monospace; resize: vertical; }
.form-hint { font-size: 0.8rem; color: var(--muted); margin-top: 0.35rem; display: block; }
.form-error { font-size: 0.8rem; color: #f87171; margin-top: 0.35rem; display: block; }
.form-actions { margin-top: 1.5rem; display: flex; gap: 0.75rem; }
.btn-save { padding: 0.65rem 1.25rem; font-size: 0.9rem; font-weight: 600; background: linear-gradient(135deg, #dc2626, var(--accent)); color: #fff; border: none; border-radius: 10px; cursor: pointer; }
.btn-cancel { padding: 0.65rem 1.25rem; font-size: 0.9rem; font-weight: 600; background: rgba(255,255,255,0.08); color: var(--text); border: 1px solid var(--border); border-radius: 10px; text-decoration: none; }
</style>
@endpush
@endsection
