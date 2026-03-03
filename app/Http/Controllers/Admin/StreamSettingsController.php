<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class StreamSettingsController extends Controller
{
    public function index()
    {
        if (!session('admin_logged_in')) {
            return redirect()->route('admin.login');
        }

        $settings = Setting::getSettings();

        return view('admin.stream-settings', [
            'settings' => $settings,
        ]);
    }

    public function store(Request $request)
    {
        if (!session('admin_logged_in')) {
            return redirect()->route('admin.login');
        }

        $validated = $request->validate([
            'radio_stream_url' => 'nullable|string|max:500',
            'radio_backup_stream_url' => 'nullable|string|max:500',
        ]);

        $settings = Setting::firstOrNew([]);
        $settings->radio_stream_url = $validated['radio_stream_url'] ?? null;
        $settings->radio_backup_stream_url = $validated['radio_backup_stream_url'] ?? null;
        $settings->save();

        return redirect()->route('admin.stream-settings.index')
            ->with('success', 'Yayın ayarları kaydedildi.');
    }
}
