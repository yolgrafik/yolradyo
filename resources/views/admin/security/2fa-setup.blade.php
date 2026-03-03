@extends('admin.layouts.app')

@section('content')
<div class="card" style="max-width:500px;">
    <div class="card-header">2FA Kurulum</div>
    <div class="card-body">
        @if(session('error'))
            <div class="alert-error">{{ session('error') }}</div>
        @endif

        <p class="muted" style="margin-bottom:1rem;">Google Authenticator veya benzeri uygulamada asagidaki kodu ekleyin veya QR kodu tarayin.</p>

        <div class="qr-wrap" style="margin-bottom:1.5rem;">
            <img src="https://api.qrserver.com/v1/create-qr-code/?size=200x200&data={{ urlencode($otpauthUrl) }}" alt="QR Code" width="200" height="200">
        </div>

        <div class="form-group" style="margin-bottom:1rem;">
            <label>Manuel Giris (QR tarayamazsaniz)</label>
            <code class="secret-code">{{ $secret }}</code>
        </div>

        <form method="POST" action="{{ route('admin.security.2fa.confirm') }}">
            @csrf
            <div class="form-group">
                <label for="code">Uygulamadan gelen 6 haneli kodu girin *</label>
                <input type="text" name="code" id="code" required maxlength="6" pattern="[0-9]{6}" placeholder="000000" class="form-input" style="max-width:150px;text-align:center;font-size:1.25rem;letter-spacing:0.5em;">
                @error('code')<span class="form-error">{{ $message }}</span>@enderror
            </div>
            <button type="submit" class="btn-save">Dogrula ve Etkinlestir</button>
        </form>

        @if(!empty($twoFactor->recovery_codes ?? []))
        <div class="recovery-codes" style="margin-top:1.5rem;padding:1rem;background:rgba(255,255,255,0.04);border-radius:10px;">
            <strong>Kurtarma Kodlari (guvenli saklayin):</strong>
            <pre style="margin-top:0.5rem;font-size:0.85rem;word-break:break-all;">{{ implode(' ', $twoFactor->recovery_codes) }}</pre>
        </div>
        @endif
    </div>
</div>

@push('styles')
<style>
.alert-error{padding:0.75rem 1rem;background:rgba(239,68,68,0.2);border:1px solid rgba(239,68,68,0.4);border-radius:10px;color:#fca5a5;font-size:0.9rem;margin-bottom:1rem;}
.muted{color:var(--muted);font-size:0.9rem;}
.qr-wrap{display:inline-block;padding:0.5rem;background:#fff;border-radius:10px;}
.secret-code{display:block;padding:0.75rem;background:rgba(255,255,255,0.06);border-radius:8px;font-family:monospace;font-size:0.9rem;word-break:break-all;}
.form-group{margin-bottom:1rem;}
.form-group label{display:block;font-size:0.9rem;font-weight:600;color:var(--text);margin-bottom:0.5rem;}
.form-input{padding:0.75rem 1rem;font-size:0.9rem;background:rgba(255,255,255,0.06);border:1px solid var(--border);border-radius:10px;color:var(--text);}
.form-error{font-size:0.8rem;color:#f87171;margin-top:0.35rem;display:block;}
.btn-save{padding:0.65rem 1.25rem;font-size:0.9rem;font-weight:600;background:linear-gradient(135deg,#dc2626,var(--accent));color:#fff;border:none;border-radius:10px;cursor:pointer;}
</style>
@endpush
@endsection
