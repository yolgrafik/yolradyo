<?php

namespace App\Http\Controllers;

use App\Models\AboutPage;
use App\Models\ArtistVideo;
use App\Models\DjProfile;
use App\Models\ForumPost;
use App\Models\News;
use App\Models\Programci;
use App\Models\Setting;
use App\Models\Slider;
use App\Services\SettingsService;

class FrontendController extends Controller
{
    public function home()
    {
        $sliders = Slider::active()->ordered()->get();
        $latestNews = News::query()
            ->active()
            ->latest()
            ->limit(4)
            ->get();
        $programcilar = Programci::active()->ordered()->get();
        $artistVideos = ArtistVideo::query()
            ->active()
            ->orderBy('sort_order')
            ->latest()
            ->limit(12)
            ->get();
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

        return view('frontend.home', compact('sliders', 'programcilar', 'listenerSubmissions', 'latestNews', 'artistVideos'));
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
        $news = News::query()
            ->active()
            ->latest()
            ->get();

        return view('frontend.haberler.index', compact('news'));
    }

    public function haberDetay(string $slug)
    {
        $newsItem = News::query()
            ->active()
            ->with('media')
            ->where('slug', $slug)
            ->firstOrFail();

        $relatedNews = News::query()
            ->active()
            ->where('id', '!=', $newsItem->id)
            ->latest()
            ->limit(4)
            ->get();

        return view('frontend.haberler.show', compact('newsItem', 'relatedNews'));
    }

    public function videolar()
    {
        $artistVideos = ArtistVideo::query()
            ->active()
            ->orderBy('sort_order')
            ->latest()
            ->paginate(12);

        return view('frontend.videolar', compact('artistVideos'));
    }

    public function galeri()
    {
        return view('frontend.page', ['pageTitle' => 'Foto Galeri']);
    }

    public function reklam()
    {
        $page = AboutPage::query()
            ->active()
            ->where('slug', 'reklam')
            ->first();

        return view('frontend.page', [
            'pageTitle' => $page?->title ?? 'Reklam',
            'pageContent' => $page?->content,
            'pageImage' => $page?->image_path,
        ]);
    }

    public function hakkimizda(string $slug)
    {
        $page = AboutPage::query()
            ->active()
            ->where('slug', $slug)
            ->first();

        $titles = [
            'biz-kimiz' => 'Biz Kimiz',
            'misyon' => 'Misyon & Vizyon',
            'politika' => 'Yayın Politikamız',
        ];

        return view('frontend.page', [
            'pageTitle' => $page?->title ?? ($titles[$slug] ?? 'Hakkımızda'),
            'pageDescription' => $page?->short_description,
            'pageContent' => $page?->content,
            'pageImage' => $page?->image_path,
        ]);
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

    public function dmca(SettingsService $settings)
    {
        $content = $settings->get('legal_dmca', '');
        return view('frontend.page', ['pageTitle' => 'DMCA / Telif Hakkı Bildirimi', 'pageContent' => $content]);
    }
}
