<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\ActivityLogger;
use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\AdminTwoFactor;
use App\Services\TotpService;
use Illuminate\Http\Request;

class TwoFactorController extends Controller
{
    public function __construct(
        protected TotpService $totp
    ) {}

    public function index()
    {
        $admin = Admin::find(session('admin_id'));
        if (!$admin) {
            return redirect()->route('admin.login');
        }
        $twoFactor = $admin->twoFactor;
        return view('admin.security.2fa', compact('admin', 'twoFactor'));
    }

    public function enable(Request $request)
    {
        $admin = Admin::find(session('admin_id'));
        if (!$admin) {
            return redirect()->route('admin.login');
        }

        $twoFactor = $admin->twoFactor()->firstOrCreate([], ['enabled' => false]);

        if ($twoFactor->enabled) {
            return back()->with('error', '2FA zaten aktif.');
        }

        $secret = $this->totp->generateSecret();
        $twoFactor->setEncryptedSecret($secret);
        $twoFactor->recovery_codes = $this->totp->generateRecoveryCodes();
        $twoFactor->save();

        $otpauthUrl = $this->totp->getProvisioningUri($admin->email, $secret);

        ActivityLogger::log('2fa.enable.started', ['admin_id' => $admin->id]);

        return view('admin.security.2fa-setup', [
            'secret' => $secret,
            'otpauthUrl' => $otpauthUrl,
            'admin' => $admin,
            'twoFactor' => $twoFactor,
        ]);
    }

    public function confirmEnable(Request $request)
    {
        $request->validate(['code' => 'required|string|size:6']);

        $admin = Admin::find(session('admin_id'));
        if (!$admin) {
            return redirect()->route('admin.login');
        }

        $twoFactor = $admin->twoFactor;
        if (!$twoFactor || $twoFactor->enabled) {
            return redirect()->route('admin.security.2fa')->with('error', 'Gecersiz istek.');
        }

        $secret = $twoFactor->getDecryptedSecret();
        if (!$this->totp->verify($secret, $request->code)) {
            return back()->with('error', 'Kod hatali. Tekrar deneyin.');
        }

        $twoFactor->enabled = true;
        $twoFactor->save();

        ActivityLogger::log('2fa.enabled', ['admin_id' => $admin->id]);

        return redirect()->route('admin.security.2fa')->with('success', '2FA basariyla etkinlestirildi.');
    }

    public function disable(Request $request)
    {
        $request->validate(['password' => 'required']);

        $admin = Admin::find(session('admin_id'));
        if (!$admin) {
            return redirect()->route('admin.login');
        }

        if (!\Illuminate\Support\Facades\Hash::check($request->password, $admin->password)) {
            return back()->with('error', 'Sifre hatali.');
        }

        $twoFactor = $admin->twoFactor;
        if ($twoFactor) {
            $twoFactor->enabled = false;
            $twoFactor->secret = null;
            $twoFactor->recovery_codes = null;
            $twoFactor->save();
        }

        ActivityLogger::log('2fa.disabled', ['admin_id' => $admin->id]);

        return redirect()->route('admin.security.2fa')->with('success', '2FA devre disi birakildi.');
    }
}
