<?php

namespace App\Http\Controllers;

use App\Models\DjProfile;
use App\Models\ForumPost;
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
        $listenerSubmissions = ForumPost::with('user')
            ->where('approval_status', ForumPost::APPROVAL_APPROVED)
            ->whereIn('type', [ForumPost::TYPE_PHOTO, ForumPost::TYPE_VIDEO])
            ->where(function ($q) {
                $q->whereNotNull('file_path')
                    ->orWhere(function ($q2) {
                        $q2->where('type', ForumPost::TYPE_VIDEO)->whereNotNull('video_url');
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

    public function gizlilik(SettingsService $settings)
    {
        $content = $settings->get('legal_gizlilik', '');
        return view('frontend.page', ['pageTitle' => 'Gizlilik Politikası', 'pageContent' => $content]);
    }

    public function cerez(SettingsService $settings)
    {
        $content = $settings->get('legal_cerez', '');
        return view('frontend.page', ['pageTitle' => 'Çerez Politikası', 'pageContent' => $content]);
    }

    public function kullanim(SettingsService $settings)
    {
        $content = $settings->get('legal_kullanim', '');
        return view('frontend.page', ['pageTitle' => 'Kullanım Şartları', 'pageContent' => $content]);
    }

    public function kvkk(SettingsService $settings)
    {
        $content = $settings->get('legal_kvkk', '');
        return view('frontend.page', ['pageTitle' => 'KVKK Aydınlatma Metni', 'pageContent' => $content]);
    }
}
