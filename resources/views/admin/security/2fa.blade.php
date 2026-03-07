@extends('admin.layouts.app')

@section('content')
<div class="card" style="max-width:500px;">
    <div class="card-header">2FA Guvenlik</div>
    <div class="card-body">
        @if(session('success'))
            <div class="alert-success">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="alert-error">{{ session('error') }}</div>
        @endif

        @if($twoFactor && $twoFactor->enabled)
            <p class="status-badge enabled">2FA aktif</p>
            <form method="POST" action="{{ route('admin.security.2fa.disable') }}" onsubmit="return confirm('2FA devre disi birakilacak. Emin misiniz?');">
                @csrf
                <div class="form-group">
                    <label for="password">Sifrenizi girin *</label>
                    <input type="password" name="password" id="password" required class="form-input">
                    @error('password')<span class="form-error">{{ $message }}</span>@enderror
                </div>
                <button type="submit" class="btn-danger">2FA Devre Disi Birak</button>
            </form>
        @else
            <p class="status-badge disabled">2FA kapali</p>
            <form method="POST" action="{{ route('admin.security.2fa.enable') }}">
                @csrf
                <p class="muted" style="margin-bottom:1rem;">Google Authenticator veya benzeri uygulama ile hesabinizi guvence altina alin.</p>
                <button type="submit" class="btn-save">2FA Etkinlestir</button>
            </form>
        @endif
    </div>
</div>

@push('styles')
<style>
.alert-success{padding:0.75rem 1rem;background:rgba(34,197,94,0.2);border:1px solid rgba(34,197,94,0.4);border-radius:10px;color:#86efac;font-size:0.9rem;margin-bottom:1rem;}
.alert-error{padding:0.75rem 1rem;background:rgba(239,68,68,0.2);border:1px solid rgba(239,68,68,0.4);border-radius:10px;color:#fca5a5;font-size:0.9rem;margin-bottom:1rem;}
.status-badge{padding:0.5rem 1rem;border-radius:8px;font-weight:600;margin-bottom:1rem;display:inline-block;}
.status-badge.enabled{background:rgba(34,197,94,0.2);color:#86efac;}
.status-badge.disabled{background:rgba(148,163,184,0.2);color:#94a3b8;}
.form-group{margin-bottom:1rem;}
.form-group label{display:block;font-size:0.9rem;font-weight:600;color:var(--text);margin-bottom:0.5rem;}
.form-input{width:100%;max-width:300px;padding:0.75rem 1rem;font-size:0.9rem;background:rgba(255,255,255,0.06);border:1px solid var(--border);border-radius:10px;color:var(--text);}
.form-error{font-size:0.8rem;color:#f87171;margin-top:0.35rem;display:block;}
.muted{color:var(--muted);font-size:0.9rem;}
.btn-save{padding:0.65rem 1.25rem;font-size:0.9rem;font-weight:600;background:linear-gradient(135deg,#dc2626,var(--accent));color:#fff;border:none;border-radius:10px;cursor:pointer;}
.btn-danger{padding:0.65rem 1.25rem;font-size:0.9rem;font-weight:600;background:rgba(239,68,68,0.3);color:#fca5a5;border:1px solid rgba(239,68,68,0.5);border-radius:10px;cursor:pointer;}
</style>
@endpush
@endsection
