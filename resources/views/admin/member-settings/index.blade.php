@extends('admin.layouts.app')

@section('content')
<div class="card">
    <div class="card-header">Üye Ayarları</div>
    <div class="card-body">
        @if(session('success'))
            <div class="alert-success">{{ session('success') }}</div>
        @endif

        <form method="POST" action="{{ route('admin.member-settings.store') }}">
            @csrf
            <div class="form-group" style="margin-bottom:1.25rem;">
                <label style="display:flex;align-items:center;gap:0.5rem;cursor:pointer;">
                    <input type="checkbox" name="member_approval_required" value="1" {{ $approvalRequired ? 'checked' : '' }}>
                    <span>Üye onayı zorunlu</span>
                </label>
                <p style="font-size:0.85rem;color:var(--muted);margin-top:0.35rem;">Açıkken yeni kayıtlar "Beklemede" durumunda olur. Sadece onaylı üyeler mesaj gönderebilir ve içerik paylaşabilir.</p>
            </div>
            <div class="form-group" style="margin-bottom:1.25rem;">
                <label for="daily_limit">Günlük gönderi limiti</label>
                <input type="number" name="member_daily_submission_limit" id="daily_limit" value="{{ $dailyLimit }}" min="1" max="100" class="form-input" style="max-width:120px;">
                <p style="font-size:0.85rem;color:var(--muted);margin-top:0.35rem;">Her üye günde en fazla bu kadar gönderi yapabilir.</p>
            </div>
            <div class="form-group" style="margin-bottom:1.25rem;">
                <label for="max_mp3">Maksimum MP3 boyutu (MB)</label>
                <input type="number" name="member_max_mp3_size_mb" id="max_mp3" value="{{ $maxMp3Mb }}" min="1" max="100" class="form-input" style="max-width:120px;">
                <p style="font-size:0.85rem;color:var(--muted);margin-top:0.35rem;">MP3 yükleme için izin verilen maksimum dosya boyutu.</p>
            </div>
            <div class="form-group" style="margin-bottom:1.25rem;">
                <label for="max_video">Maksimum Video boyutu (MB)</label>
                <input type="number" name="member_max_video_size_mb" id="max_video" value="{{ $maxVideoMb }}" min="1" max="1000" class="form-input" style="max-width:120px;">
                <p style="font-size:0.85rem;color:var(--muted);margin-top:0.35rem;">Video dosyası yükleme için izin verilen maksimum boyut.</p>
            </div>
            <button type="submit" class="btn-save">Kaydet</button>
        </form>
    </div>
</div>

@push('styles')
<style>
.alert-success{padding:0.75rem 1rem;background:rgba(34,197,94,0.2);border:1px solid rgba(34,197,94,0.4);border-radius:10px;color:#86efac;margin-bottom:1rem;}
.form-input{padding:0.5rem 0.75rem;background:rgba(255,255,255,0.06);border:1px solid var(--border);border-radius:6px;color:var(--text);}
</style>
@endpush
@endsection
