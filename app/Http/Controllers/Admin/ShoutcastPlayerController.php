<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class ShoutcastPlayerController extends Controller
{
    public function index()
    {
        if (!session('admin_logged_in')) {
            return redirect()->route('admin.login');
        }

        $settings = Setting::getSettings() ?? new Setting();

        return view('admin.shoutcast.player', [
            'settings' => $settings,
        ]);
    }

    public function store(Request $request)
    {
        if (!session('admin_logged_in')) {
            return redirect()->route('admin.login');
        }

        $validated = $request->validate([
            'radio_auto_play' => 'nullable|boolean',
            'radio_default_volume' => 'nullable|numeric|min:0|max:1',
        ]);

        $settings = Setting::firstOrNew([]);
        $settings->radio_auto_play = (bool) ($validated['radio_auto_play'] ?? false);
        $settings->radio_default_volume = min(1, max(0, (float) ($validated['radio_default_volume'] ?? 0.8)));
        $settings->save();

        return redirect()->route('admin.shoutcast.player.index')
            ->with('success', 'Web Player ayarları kaydedildi.');
    }
}
