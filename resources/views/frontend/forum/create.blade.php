@extends('layouts.frontend')

@section('title', 'Yeni Gönderi - Forum')

@push('styles')
<style>
.page-hero { padding: 2rem 1.5rem; background: var(--ry-header-bg); border-bottom: 1px solid var(--ry-border); }
.page-hero h1 { font-size: 1.75rem; font-weight: 700; color: #fff; margin: 0; }
.forum-form-wrap { max-width: 600px; margin: 0 auto; padding: 2rem 1.5rem; }
.form-card { background: var(--ry-bar-bg); border: 1px solid rgba(255,255,255,0.08); border-radius: 14px; padding: 1.5rem; }
.form-group { margin-bottom: 1.25rem; }
.form-group label { display: block; font-size: 0.9rem; font-weight: 600; color: var(--text); margin-bottom: 0.35rem; }
.form-input, .form-textarea { width: 100%; padding: 0.75rem 1rem; background: rgba(255,255,255,0.06); border: 1px solid rgba(255,255,255,0.15); border-radius: 10px; color: var(--text); font-size: 0.95rem; }
.form-textarea { min-height: 120px; resize: vertical; }
.form-input:focus, .form-textarea:focus { outline: none; border-color: var(--ry-schedule-active); }
.form-error { font-size: 0.8rem; color: #f87171; margin-top: 0.25rem; }
.form-hint { font-size: 0.8rem; color: var(--muted); margin-top: 0.25rem; }
.btn-submit { padding: 0.75rem 1.5rem; font-size: 0.95rem; font-weight: 600; background: var(--ry-btn-bg); color: #fff; border: none; border-radius: 10px; cursor: pointer; }
.btn-submit:hover { opacity: 0.95; }
.alert-error { padding: 0.75rem 1rem; background: rgba(239,68,68,0.2); border: 1px solid rgba(239,68,68,0.4); border-radius: 10px; color: #fca5a5; margin-bottom: 1rem; }
.back-link { display: inline-block; margin-bottom: 1rem; color: var(--ry-schedule-active); text-decoration: none; font-size: 0.9rem; }
.back-link:hover { text-decoration: underline; }
</style>
@endpush

@section('content')
<section class="page-hero">
    <h1>Yeni Gönderi</h1>
</section>
<div class="forum-form-wrap">
    <a href="{{ route('forum.index') }}" class="back-link">&larr; Foruma dön</a>

    <div class="form-card">
        @if(session('error'))
            <div class="alert-error">{{ session('error') }}</div>
        @endif

        <form method="POST" action="{{ route('forum.store') }}">
            @csrf
            <div class="form-group">
                <label for="type">Tür *</label>
                <select name="type" id="type" class="form-input" required>
                    <option value="">Seçiniz</option>
                    <option value="request" {{ old('type') === 'request' ? 'selected' : '' }}>İstek</option>
                    <option value="complaint" {{ old('type') === 'complaint' ? 'selected' : '' }}>Şikayet</option>
                </select>
            </div>
            <div class="form-group">
                <label for="title">Başlık *</label>
                <input type="text" name="title" id="title" class="form-input" value="{{ old('title') }}" required maxlength="120" placeholder="Kısa ve açıklayıcı bir başlık">
                @error('title')<span class="form-error">{{ $message }}</span>@enderror
                <p class="form-hint">En fazla 120 karakter</p>
            </div>
            <div class="form-group">
                <label for="body">Mesaj *</label>
                <textarea name="body" id="body" class="form-textarea form-input" required minlength="20" maxlength="2000" placeholder="Detaylı açıklama yazın...">{{ old('body') }}</textarea>
                @error('body')<span class="form-error">{{ $message }}</span>@enderror
                <p class="form-hint">En az 20, en fazla 2000 karakter</p>
            </div>
            <button type="submit" class="btn-submit">Gönder</button>
        </form>
    </div>
</div>
@endsection
