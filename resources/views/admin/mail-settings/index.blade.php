@extends('admin.layouts.app')

@section('content')
<div class="card">
    <div class="card-header">Mail Ayarları</div>
    <div class="card-body">
        @if(session('success'))
            <div class="alert-success">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="alert-error">{{ session('error') }}</div>
        @endif

        <div class="mail-notes" style="margin-bottom:1.5rem;padding:1rem;background:rgba(59,130,246,0.15);border:1px solid rgba(59,130,246,0.3);border-radius:10px;font-size:0.9rem;">
            <strong>Geliştirici Notları:</strong>
            <ul style="margin:0.5rem 0 0 1rem;padding:0;">
                <li><strong>Gmail:</strong> Normal şifre yerine <a href="https://myaccount.google.com/apppasswords" target="_blank" rel="noopener">Uygulama Şifresi</a> kullanın. Host: smtp.gmail.com, Port: 587, Şifreleme: tls</li>
                <li><strong>Mailtrap:</strong> Test için <a href="https://mailtrap.io" target="_blank" rel="noopener">mailtrap.io</a> kullanabilirsiniz. Gerçek e-posta göndermez.</li>
                <li>Ayarlar kaydedildiğinde config ve cache otomatik temizlenir.</li>
            </ul>
        </div>

        <form method="POST" action="{{ route('admin.mail-settings.store') }}">
            @csrf
            <div class="form-row" style="display:grid;grid-template-columns:1fr 1fr;gap:1rem;">
                <div class="form-group">
                    <label for="mail_mailer">MAIL_MAILER</label>
                    <select name="mail_mailer" id="mail_mailer" class="form-input">
                        <option value="smtp" {{ $mailMailer === 'smtp' ? 'selected' : '' }}>smtp</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="mail_host">MAIL_HOST *</label>
                    <input type="text" name="mail_host" id="mail_host" class="form-input" value="{{ old('mail_host', $mailHost) }}" placeholder="smtp.gmail.com" required>
                    @error('mail_host')<span class="form-error">{{ $message }}</span>@enderror
                </div>
            </div>
            <div class="form-row" style="display:grid;grid-template-columns:1fr 1fr;gap:1rem;">
                <div class="form-group">
                    <label for="mail_port">MAIL_PORT *</label>
                    <input type="text" name="mail_port" id="mail_port" class="form-input" value="{{ old('mail_port', $mailPort) }}" placeholder="587" required>
                    @error('mail_port')<span class="form-error">{{ $message }}</span>@enderror
                </div>
                <div class="form-group">
                    <label for="mail_encryption">MAIL_ENCRYPTION</label>
                    <select name="mail_encryption" id="mail_encryption" class="form-input">
                        <option value="tls" {{ $mailEncryption === 'tls' ? 'selected' : '' }}>tls</option>
                        <option value="ssl" {{ $mailEncryption === 'ssl' ? 'selected' : '' }}>ssl</option>
                        <option value="" {{ !$mailEncryption ? 'selected' : '' }}>Yok</option>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label for="mail_username">MAIL_USERNAME *</label>
                <input type="text" name="mail_username" id="mail_username" class="form-input" value="{{ old('mail_username', $mailUsername) }}" required>
                @error('mail_username')<span class="form-error">{{ $message }}</span>@enderror
            </div>
            <div class="form-group">
                <label for="mail_password">MAIL_PASSWORD *</label>
                <input type="password" name="mail_password" id="mail_password" class="form-input" value="" placeholder="{{ $hasPassword ? '•••••••• (değiştirmek için yeni şifre girin)' : 'Şifre girin' }}" autocomplete="new-password">
                @error('mail_password')<span class="form-error">{{ $message }}</span>@enderror
            </div>
            <div class="form-row" style="display:grid;grid-template-columns:1fr 1fr;gap:1rem;">
                <div class="form-group">
                    <label for="mail_from_address">MAIL_FROM_ADDRESS *</label>
                    <input type="email" name="mail_from_address" id="mail_from_address" class="form-input" value="{{ old('mail_from_address', $mailFromAddress) }}" required>
                    @error('mail_from_address')<span class="form-error">{{ $message }}</span>@enderror
                </div>
                <div class="form-group">
                    <label for="mail_from_name">MAIL_FROM_NAME *</label>
                    <input type="text" name="mail_from_name" id="mail_from_name" class="form-input" value="{{ old('mail_from_name', $mailFromName) }}" required>
                    @error('mail_from_name')<span class="form-error">{{ $message }}</span>@enderror
                </div>
            </div>
            <div class="form-group">
                <label for="mail_contact_to">İletişim Alıcısı (CONTACT_TO) *</label>
                <input type="email" name="mail_contact_to" id="mail_contact_to" class="form-input" value="{{ old('mail_contact_to', $mailContactTo) }}" placeholder="İletişim formundan gelen mesajların gideceği e-posta" required>
                @error('mail_contact_to')<span class="form-error">{{ $message }}</span>@enderror
            </div>
            <button type="submit" class="btn-save">Kaydet</button>
        </form>

        <hr style="margin:2rem 0;border-color:var(--border);">

        <div class="test-mail-section">
            <h3 style="font-size:1rem;margin-bottom:0.75rem;">Test Mail Gönder</h3>
            <form method="POST" action="{{ route('admin.mail-settings.test') }}" style="display:flex;gap:0.5rem;align-items:flex-end;flex-wrap:wrap;">
                @csrf
                <div class="form-group" style="margin-bottom:0;">
                    <label for="test_email">Test e-posta adresi</label>
                    <input type="email" name="test_email" id="test_email" class="form-input" placeholder="test@example.com" required style="min-width:220px;">
                </div>
                <button type="submit" class="btn-test">Test Mail Gönder</button>
            </form>
        </div>
    </div>
</div>

@push('styles')
<style>
.alert-success{padding:0.75rem 1rem;background:rgba(34,197,94,0.2);border:1px solid rgba(34,197,94,0.4);border-radius:10px;color:#86efac;margin-bottom:1rem;}
.alert-error{padding:0.75rem 1rem;background:rgba(239,68,68,0.2);border:1px solid rgba(239,68,68,0.4);border-radius:10px;color:#fca5a5;margin-bottom:1rem;}
.form-group{margin-bottom:1rem;}
.form-input{width:100%;padding:0.5rem 0.75rem;background:rgba(255,255,255,0.06);border:1px solid var(--border);border-radius:6px;color:var(--text);}
.form-error{font-size:0.8rem;color:#f87171;margin-top:0.25rem;}
.btn-save{padding:0.65rem 1.25rem;font-size:0.9rem;font-weight:600;background:linear-gradient(135deg,#dc2626,var(--accent));color:#fff;border:none;border-radius:10px;cursor:pointer;}
.btn-test{padding:0.5rem 1rem;font-size:0.9rem;font-weight:600;background:rgba(59,130,246,0.3);color:#93c5fd;border:1px solid rgba(59,130,246,0.5);border-radius:8px;cursor:pointer;}
.btn-test:hover{background:rgba(59,130,246,0.4);}
.mail-notes a{color:#93c5fd;}
</style>
@endpush
@endsection
