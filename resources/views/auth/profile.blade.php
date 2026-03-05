@extends('layouts.frontend')

@section('title', 'Hesabım')

@push('styles')
<style>
.profile-page { max-width: 480px; margin: 0 auto; padding: 2rem 1rem; }
.profile-card {
    background: var(--ry-bar-bg);
    border: 1px solid rgba(255,255,255,0.08);
    border-radius: 14px;
    padding: 2rem;
}
.profile-card h1 { font-size: 1.5rem; font-weight: 700; color: #fff; margin: 0 0 1.5rem 0; }
.profile-row { display: flex; justify-content: space-between; padding: 0.75rem 0; border-bottom: 1px solid rgba(255,255,255,0.08); }
.profile-row:last-child { border-bottom: none; }
.profile-label { font-weight: 600; color: var(--muted); }
.profile-value { color: #fff; }
.page-hero { padding: 2rem 1rem; background: var(--ry-header-bg); border-bottom: 1px solid var(--ry-border); }
.page-hero h1 { font-size: 1.5rem; font-weight: 700; color: #fff; margin: 0; text-align: center; }
</style>
@endpush

@section('content')
<section class="page-hero">
    <h1>Hesabım</h1>
</section>
<div class="profile-page">
    <div class="profile-card">
        <h1>Profil Bilgileri</h1>
        <div class="profile-row">
            <span class="profile-label">Ad Soyad</span>
            <span class="profile-value">{{ auth()->user()->name }}</span>
        </div>
        <div class="profile-row">
            <span class="profile-label">E-posta</span>
            <span class="profile-value">{{ auth()->user()->email }}</span>
        </div>
    </div>
</div>
@endsection
