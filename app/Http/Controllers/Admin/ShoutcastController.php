<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class ShoutcastController extends Controller
{
    protected function ensureAdmin()
    {
        if (!session('admin_logged_in')) {
            return redirect()->route('admin.login');
        }
    }

    protected function getSettings(): Setting
    {
        return Setting::getSettings() ?? new Setting();
    }

    public function stream()
    {
        if ($r = $this->ensureAdmin()) return $r;
        $settings = $this->getSettings();
        return view('admin.shoutcast.stream', ['settings' => $settings]);
    }

    public function storeStream(Request $request)
    {
        if ($r = $this->ensureAdmin()) return $r;
        $validated = $request->validate([
            'radio_stream_url' => 'nullable|string|max:500',
        ]);
        $s = Setting::firstOrNew([]);
        $s->radio_stream_url = trim($validated['radio_stream_url'] ?? '') ?: null;
        $s->save();
        return redirect()->route('admin.shoutcast.stream')->with('success', 'Stream link ayarları kaydedildi.');
    }

    public function status()
    {
        if ($r = $this->ensureAdmin()) return $r;
        $settings = $this->getSettings();
        return view('admin.shoutcast.status', ['settings' => $settings]);
    }

    public function storeStatus(Request $request)
    {
        if ($r = $this->ensureAdmin()) return $r;
        $validated = $request->validate([
            'radio_force_status' => 'nullable|string|in:auto,online,offline',
        ]);
        $s = Setting::firstOrNew([]);
        $val = $validated['radio_force_status'] ?? 'auto';
        $s->radio_force_status = $val === 'auto' ? null : $val;
        $s->save();
        return redirect()->route('admin.shoutcast.status')->with('success', 'Online/Offline ayarı kaydedildi.');
    }

    public function nowplaying()
    {
        if ($r = $this->ensureAdmin()) return $r;
        $settings = $this->getSettings();
        return view('admin.shoutcast.nowplaying', ['settings' => $settings]);
    }

    public function storeNowplaying(Request $request)
    {
        if ($r = $this->ensureAdmin()) return $r;
        $validated = $request->validate([
            'shoutcast_base_url' => 'nullable|string|max:500',
            'shoutcast_sid' => 'nullable|integer|min:1|max:255',
        ]);
        $s = Setting::firstOrNew([]);
        $s->shoutcast_base_url = trim($validated['shoutcast_base_url'] ?? '') ?: null;
        $s->shoutcast_sid = (int) ($validated['shoutcast_sid'] ?? 1);
        $s->save();
        return redirect()->route('admin.shoutcast.nowplaying')->with('success', 'Now Playing ayarları kaydedildi.');
    }

    public function backup()
    {
        if ($r = $this->ensureAdmin()) return $r;
        $settings = $this->getSettings();
        return view('admin.shoutcast.backup', ['settings' => $settings]);
    }

    public function storeBackup(Request $request)
    {
        if ($r = $this->ensureAdmin()) return $r;
        $validated = $request->validate([
            'radio_backup_stream_url' => 'nullable|string|max:500',
        ]);
        $s = Setting::firstOrNew([]);
        $s->radio_backup_stream_url = trim($validated['radio_backup_stream_url'] ?? '') ?: null;
        $s->save();
        return redirect()->route('admin.shoutcast.backup')->with('success', 'Yedek stream ayarları kaydedildi.');
    }
}
