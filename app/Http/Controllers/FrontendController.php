<?php

namespace App\Http\Controllers;

use App\Models\DjProfile;
use App\Models\MemberSubmission;
use App\Models\Programci;
use App\Models\Setting;
use App\Models\Slider;
use App\Services\SettingsService;

class FrontendController extends Controller
{
    public function home()
    {
        $sliders = Slider::active()->ordered()->get();
        $programcilar = Programci::active()->ordered()->get();
        $listenerSubmissions = MemberSubmission::with('user')
            ->where('status', 'approved')
            ->whereIn('type', ['image', 'video'])
            ->where(function ($q) {
                $q->whereNotNull('file_path')
                    ->orWhere(function ($q2) {
                        $q2->where('type', 'video')->whereNotNull('video_url');
                    });
            })
            ->orderByDesc('created_at')
            ->limit(20)
            ->get();

        return view('frontend.home', compact('sliders', 'programcilar', 'listenerSubmissions'));
    }

    public function player(SettingsService $settings, \Illuminate\Http\Request $request)
    {
        $radioSettings = Setting::getSettings();
        $siteSettings = $settings->getAll();
        $streamUrl = $radioSettings?->radio_stream_url ?? '';
        $backupUrl = $radioSettings?->radio_backup_stream_url ?? '';
        $defaultVolume = $radioSettings?->radio_default_volume ?? 0.8;
        $siteName = $siteSettings['site_name'] ?? 'RadyoYol';
        $shareUrl = $request->url();
        $shareText = ($siteName ?? 'RadyoYol') . ' - Canlı Dinle';

        return view('frontend.player', compact(
            'streamUrl', 'backupUrl', 'defaultVolume', 'siteName', 'shareUrl', 'shareText'
        ));
    }

    public function programlar()
    {
        $djs = DjProfile::with(['schedules' => fn ($q) => $q->active()->ordered()])
            ->orderBy('name')
            ->get();
        return view('frontend.programlar', compact('djs'));
    }

    public function programcilarIndex()
    {
        $programcilar = Programci::active()->ordered()->get();
        return view('frontend.programcilar-index', compact('programcilar'));
    }

    public function programciShow(string $slug)
    {
        $programci = Programci::where('slug', $slug)->active()->firstOrFail();
        $programci->load(['schedules' => fn ($q) => $q->active()->ordered()]);
        return view('frontend.programci-show', compact('programci'));
    }

    public function haberler()
    {
        return view('frontend.page', ['pageTitle' => 'Haberler']);
    }

    public function videolar()
    {
        return view('frontend.page', ['pageTitle' => 'Video Galeri']);
    }

    public function galeri()
    {
        return view('frontend.page', ['pageTitle' => 'Foto Galeri']);
    }

    public function reklam()
    {
        return view('frontend.page', ['pageTitle' => 'Sponsor']);
    }

    public function hakkimizda(string $slug)
    {
        $titles = [
            'biz-kimiz' => 'Biz Kimiz',
            'misyon' => 'Misyon & Vizyon',
            'politika' => 'Yayin Politikamiz',
        ];
        $pageTitle = $titles[$slug] ?? 'Hakkimizda';
        return view('frontend.page', ['pageTitle' => $pageTitle]);
    }

    public function iletisim()
    {
        return view('frontend.page', ['pageTitle' => 'Iletisim']);
    }

    public function gizlilik()
    {
        return view('frontend.page', ['pageTitle' => 'Gizlilik Politikasi']);
    }

    public function cerez()
    {
        return view('frontend.page', ['pageTitle' => 'Cerez Politikasi']);
    }

    public function kullanim()
    {
        return view('frontend.page', ['pageTitle' => 'Kullanim Sartlari']);
    }

    public function kvkk()
    {
        return view('frontend.page', ['pageTitle' => 'KVKK Aydinlatma Metni']);
    }
}
