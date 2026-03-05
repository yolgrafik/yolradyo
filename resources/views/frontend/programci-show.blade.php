@extends('layouts.frontend')

@section('title', $programci->seo_title ?: $programci->ad)

@php
    $dayNames = ['Pazartesi', 'Salı', 'Çarşamba', 'Perşembe', 'Cuma', 'Cumartesi', 'Pazar'];
    $schedules = $programci->schedules ?? collect();
@endphp

@push('meta')
@if($programci->seo_description)
<meta name="description" content="{{ $programci->seo_description }}">
@endif
@endpush

@push('styles')
<style>
.programci-detail { max-width: 900px; margin: 0 auto; padding: 2rem 1rem; }
.programci-hero { display: flex; align-items: center; gap: 1.5rem; margin-bottom: 2rem; flex-wrap: wrap; }
.programci-avatar { width: 120px; height: 120px; border-radius: 12px; object-fit: cover; background: rgba(255,255,255,0.06); }
.programci-avatar-placeholder { width: 120px; height: 120px; border-radius: 12px; background: linear-gradient(135deg, #c92a2a, #b30000); color: #fff; display: flex; align-items: center; justify-content: center; font-size: 2.5rem; font-weight: 800; }
.programci-name { font-size: 1.75rem; font-weight: 700; color: #fff; margin: 0 0 0.25rem 0; }
.programci-slogan { font-size: 1rem; color: var(--muted); margin: 0 0 1rem 0; }
.programci-social { display: flex; gap: 0.75rem; flex-wrap: wrap; }
.programci-social a { color: rgba(255,255,255,0.8); transition: color 0.2s; }
.programci-social a:hover { color: #fff; }
.programci-content { background: var(--ry-bar-bg); border: 1px solid rgba(255,255,255,0.08); border-radius: 14px; padding: 1.5rem; margin-bottom: 2rem; }
.programci-content h3 { font-size: 1.1rem; color: #fff; margin: 0 0 1rem 0; }
.programci-bio { color: var(--muted); line-height: 1.7; white-space: pre-wrap; }
.programci-schedule { background: var(--ry-bar-bg); border: 1px solid rgba(255,255,255,0.08); border-radius: 14px; padding: 1.5rem; margin-bottom: 2rem; }
.programci-schedule h3 { font-size: 1.1rem; color: #fff; margin: 0 0 1rem 0; }
.schedule-item { display: flex; gap: 1rem; padding: 0.75rem 0; border-bottom: 1px solid rgba(255,255,255,0.06); }
.schedule-item:last-child { border-bottom: none; }
.schedule-day-time { min-width: 140px; font-size: 0.9rem; }
.schedule-day { font-weight: 600; color: var(--ry-schedule-active); }
.schedule-time { color: var(--muted); font-size: 0.85rem; }
.schedule-title { font-weight: 600; color: #fff; }
.contact-form { background: var(--ry-bar-bg); border: 1px solid rgba(255,255,255,0.08); border-radius: 14px; padding: 1.5rem; }
.contact-form h3 { font-size: 1.1rem; color: #fff; margin: 0 0 1rem 0; }
.form-group { margin-bottom: 1rem; }
.form-group label { display: block; font-size: 0.9rem; font-weight: 600; color: var(--text); margin-bottom: 0.35rem; }
.form-input { width: 100%; padding: 0.75rem 1rem; background: rgba(255,255,255,0.06); border: 1px solid rgba(255,255,255,0.15); border-radius: 10px; color: var(--text); font-size: 0.95rem; }
.form-input:focus { outline: none; border-color: var(--ry-schedule-active); }
.form-hp { position: absolute; left: -9999px; }
.btn-submit { padding: 0.75rem 1.5rem; font-size: 0.95rem; font-weight: 600; background: linear-gradient(135deg, #c92a2a, #b30000); color: #fff; border: none; border-radius: 10px; cursor: pointer; }
.btn-submit:hover { opacity: 0.9; }
.btn-submit:disabled { opacity: 0.6; cursor: not-allowed; }
.alert-success { padding: 0.75rem 1rem; background: rgba(34,197,94,0.2); border: 1px solid rgba(34,197,94,0.4); border-radius: 10px; color: #86efac; margin-bottom: 1rem; }
.alert-error { padding: 0.75rem 1rem; background: rgba(239,68,68,0.2); border: 1px solid rgba(239,68,68,0.4); border-radius: 10px; color: #fca5a5; margin-bottom: 1rem; }
.form-error { font-size: 0.8rem; color: #f87171; margin-top: 0.25rem; }
.form-input[readonly] { opacity: 0.85; cursor: default; }
.auth-required { padding: 1.5rem; text-align: center; color: var(--muted); margin-bottom: 1rem; }
.auth-buttons { display: flex; gap: 0.75rem; justify-content: center; flex-wrap: wrap; margin-top: 1rem; }
.auth-buttons a { padding: 0.6rem 1.25rem; font-size: 0.9rem; font-weight: 600; border-radius: 10px; text-decoration: none; transition: opacity 0.2s; }
.auth-buttons a:hover { opacity: 0.9; }
.btn-login { background: var(--ry-btn-bg); color: #fff; }
.btn-register { background: rgba(255,255,255,0.1); color: #fff; border: 1px solid rgba(255,255,255,0.25); }
</style>
@endpush

@section('content')
<div class="programci-detail">
    <div class="programci-hero">
        @if($programci->avatar_path)
            <img src="{{ $programci->avatar_url }}" alt="{{ $programci->ad }}" class="programci-avatar">
        @else
            <div class="programci-avatar-placeholder">{{ $programci->display_initials }}</div>
        @endif
        <div>
            <h1 class="programci-name">{{ $programci->ad }}</h1>
            @if($programci->kisa_aciklama)
                <p class="programci-slogan">{{ $programci->kisa_aciklama }}</p>
            @endif
            <div class="programci-social">
                @if($programci->instagram)
                    <a href="{{ Str::startsWith($programci->instagram, 'http') ? $programci->instagram : 'https://' . $programci->instagram }}" target="_blank" rel="noopener noreferrer" title="Instagram"><svg viewBox="0 0 24 24" width="24" height="24"><path fill="currentColor" d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073z"/></svg></a>
                @endif
                @if($programci->facebook)
                    <a href="{{ Str::startsWith($programci->facebook, 'http') ? $programci->facebook : 'https://' . $programci->facebook }}" target="_blank" rel="noopener noreferrer" title="Facebook"><svg viewBox="0 0 24 24" width="24" height="24"><path fill="currentColor" d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg></a>
                @endif
                @if($programci->tiktok)
                    <a href="{{ Str::startsWith($programci->tiktok, 'http') ? $programci->tiktok : 'https://' . $programci->tiktok }}" target="_blank" rel="noopener noreferrer" title="TikTok"><svg viewBox="0 0 24 24" width="24" height="24"><path fill="currentColor" d="M19.59 6.69a4.83 4.83 0 0 1-3.77-4.25V2h-3.45v13.67a2.89 2.89 0 0 1-5.2 1.74 2.89 2.89 0 0 1 2.31-4.64 2.93 2.93 0 0 1 .88.13V9.4a6.84 6.84 0 0 0-1-.05A6.33 6.33 0 0 0 5 20.1a6.34 6.34 0 0 0 10.86-4.43v-7a8.16 8.16 0 0 0 4.77 1.52v-3.4a4.85 4.85 0 0 1-1-.1z"/></svg></a>
                @endif
                @if($programci->youtube)
                    <a href="{{ Str::startsWith($programci->youtube, 'http') ? $programci->youtube : 'https://' . $programci->youtube }}" target="_blank" rel="noopener noreferrer" title="YouTube"><svg viewBox="0 0 24 24" width="24" height="24"><path fill="currentColor" d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814z"/></svg></a>
                @endif
                @if($programci->website)
                    <a href="{{ Str::startsWith($programci->website, 'http') ? $programci->website : 'https://' . $programci->website }}" target="_blank" rel="noopener noreferrer" title="Web Sitesi"><i class="bi bi-globe" style="font-size:1.25rem;"></i></a>
                @endif
            </div>
        </div>
    </div>

    @if($programci->uzun_aciklama)
    <div class="programci-content">
        <h3>Hakkında</h3>
        <div class="programci-bio">{!! nl2br(e($programci->uzun_aciklama)) !!}</div>
    </div>
    @endif

    @if($schedules->isNotEmpty())
    <div class="programci-schedule">
        <h3>Yayın Takvimi</h3>
        @foreach($schedules as $s)
        <div class="schedule-item">
            <div class="schedule-day-time">
                <div class="schedule-day">{{ $dayNames[$s->day_of_week] ?? '-' }}</div>
                <div class="schedule-time">{{ $s->start_time_formatted }}{{ $s->end_time ? ' - ' . $s->end_time_formatted : '' }}</div>
            </div>
            <div>
                <div class="schedule-title">{{ $s->title }}</div>
                @if($s->description)
                    <div style="font-size:0.9rem;color:var(--muted);margin-top:0.25rem;">{{ $s->description }}</div>
                @endif
            </div>
        </div>
        @endforeach
    </div>
    @endif

    <div class="contact-form">
        <h3>İletişim</h3>
        @if(session('success'))
            <div class="alert-success">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="alert-error">{{ session('error') }}</div>
        @endif

        @guest
            <p class="auth-required">Mesaj göndermek için giriş yapmalısınız.</p>
            <div class="auth-buttons">
                <a href="{{ route('login') }}" class="btn-login">Giriş Yap</a>
                <a href="{{ route('register') }}" class="btn-register">Üye Ol</a>
            </div>
        @else
            @if(!auth()->user()->isApproved())
                <p class="auth-required">Hesabınız onay bekliyor.</p>
            @elseif(!$programci->email || !filter_var($programci->email, FILTER_VALIDATE_EMAIL))
                <p class="auth-required">Bu programcı için e-posta tanımlı değil.</p>
            @else
            <form method="POST" action="{{ route('public.programcilar.contact', $programci->slug) }}" id="programciContactForm">
                @csrf
                <div class="form-group form-hp" aria-hidden="true">
                    <label for="website">Website</label>
                    <input type="text" name="website" id="website" tabindex="-1" autocomplete="off">
                </div>
                <div class="form-group">
                    <label for="contact_name">Ad Soyad</label>
                    <input type="text" name="name" id="contact_name" class="form-input" value="{{ auth()->user()->name }}" readonly>
                </div>
                <div class="form-group">
                    <label for="contact_email">E-posta</label>
                    <input type="email" name="email" id="contact_email" class="form-input" value="{{ auth()->user()->email }}" readonly>
                </div>
                <div class="form-group">
                    <label for="contact_message">Mesajınız *</label>
                    <textarea name="message" id="contact_message" class="form-input" rows="5" maxlength="2000"
                        placeholder="Mesajınızı buraya yazın (en az 20 karakter)">{{ old('message') }}</textarea>
                    @error('message')<span class="form-error">{{ $message }}</span>@enderror
                </div>
                <button type="submit" class="btn-submit" id="programciSubmitBtn">Gönder</button>
            </form>
            @endif
        @endguest
    </div>
</div>
@push('scripts')
<script>
document.getElementById('programciContactForm')?.addEventListener('submit', function() {
    var btn = document.getElementById('programciSubmitBtn');
    if (btn) btn.disabled = true;
});
</script>
@endpush
@endsection
