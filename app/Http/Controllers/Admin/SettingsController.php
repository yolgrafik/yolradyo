<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\ActivityLogger;
use App\Http\Controllers\Controller;
use App\Services\SettingsService;
use App\Services\ThemeService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SettingsController extends Controller
{
    public function __construct(
        protected SettingsService $settings,
        protected ThemeService $themeService
    ) {}

    protected function ensureAdmin()
    {
        if (!session('admin_logged_in')) {
            return redirect()->route('admin.login');
        }
    }

    public function generalForm()
    {
        if ($r = $this->ensureAdmin()) return $r;
        return view('admin.settings.general', [
            'site_name' => $this->settings->get('site_name', 'RADYOYOL'),
            'site_slogan' => $this->settings->get('site_slogan'),
            'contact_email' => $this->settings->get('contact_email'),
            'contact_phone' => $this->settings->get('contact_phone'),
            'address_text' => $this->settings->get('address_text'),
            'maintenance_mode' => $this->settings->get('maintenance_mode', false),
        ]);
    }

    public function saveGeneral(Request $request)
    {
        if ($r = $this->ensureAdmin()) return $r;
        $validated = $request->validate([
            'site_name' => 'required|string|max:255',
            'site_slogan' => 'nullable|string|max:255',
            'contact_email' => 'nullable|email|max:255',
            'contact_phone' => 'nullable|string|max:50',
            'address_text' => 'nullable|string|max:500',
            'maintenance_mode' => 'nullable|boolean',
        ]);

        $this->settings->setMany([
            'site_name' => ['value' => $validated['site_name'], 'type' => 'text'],
            'site_slogan' => ['value' => $validated['site_slogan'] ?? '', 'type' => 'text'],
            'contact_email' => ['value' => $validated['contact_email'] ?? '', 'type' => 'text'],
            'contact_phone' => ['value' => $validated['contact_phone'] ?? '', 'type' => 'text'],
            'address_text' => ['value' => $validated['address_text'] ?? '', 'type' => 'text'],
            'maintenance_mode' => ['value' => (bool) ($validated['maintenance_mode'] ?? false), 'type' => 'boolean'],
        ]);
        ActivityLogger::log('settings.updated', ['section' => 'general']);

        return redirect()->route('admin.settings.general')->with('success', 'Kaydedildi');
    }

    public function brandingForm()
    {
        if ($r = $this->ensureAdmin()) return $r;
        return view('admin.settings.branding', [
            'brand_logo_path' => $this->settings->get('brand_logo_path'),
            'brand_favicon_path' => $this->settings->get('brand_favicon_path'),
        ]);
    }

    public function saveBranding(Request $request)
    {
        if ($r = $this->ensureAdmin()) return $r;
        $validated = $request->validate([
            'logo_file' => 'nullable|file|mimes:png,jpg,jpeg,svg|max:2048',
            'favicon_file' => 'nullable|file|mimes:png,ico|max:1024',
        ]);

        $dir = 'assets/brand';
        if (!Storage::disk('public')->exists($dir)) {
            Storage::disk('public')->makeDirectory($dir);
        }

        if ($request->hasFile('logo_file')) {
            $oldPath = $this->settings->get('brand_logo_path');
            if ($oldPath && Storage::disk('public')->exists($oldPath)) {
                Storage::disk('public')->delete($oldPath);
            }
            $path = $request->file('logo_file')->store($dir, 'public');
            $this->settings->set('brand_logo_path', $path, 'text');
        }

        if ($request->hasFile('favicon_file')) {
            $oldPath = $this->settings->get('brand_favicon_path');
            if ($oldPath && Storage::disk('public')->exists($oldPath)) {
                Storage::disk('public')->delete($oldPath);
            }
            $path = $request->file('favicon_file')->store($dir, 'public');
            $this->settings->set('brand_favicon_path', $path, 'text');
        }
        ActivityLogger::log('settings.updated', ['section' => 'branding']);

        return redirect()->route('admin.settings.branding')->with('success', 'Kaydedildi');
    }

    public function seoForm()
    {
        if ($r = $this->ensureAdmin()) return $r;
        return view('admin.settings.seo', [
            'seo_meta_title' => $this->settings->get('seo_meta_title'),
            'seo_meta_description' => $this->settings->get('seo_meta_description'),
            'seo_meta_keywords' => $this->settings->get('seo_meta_keywords'),
            'seo_og_image_path' => $this->settings->get('seo_og_image_path'),
        ]);
    }

    public function saveSeo(Request $request)
    {
        if ($r = $this->ensureAdmin()) return $r;
        $validated = $request->validate([
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:160',
            'meta_keywords' => 'nullable|string|max:500',
            'og_image_file' => 'nullable|file|mimes:png,jpg,jpeg|max:2048',
        ]);

        $this->settings->set('seo_meta_title', $validated['meta_title'] ?? '', 'text');
        $this->settings->set('seo_meta_description', $validated['meta_description'] ?? '', 'text');
        $this->settings->set('seo_meta_keywords', $validated['meta_keywords'] ?? '', 'text');

        $dir = 'assets/seo';
        if ($request->hasFile('og_image_file')) {
            if (!Storage::disk('public')->exists($dir)) {
                Storage::disk('public')->makeDirectory($dir);
            }
            $oldPath = $this->settings->get('seo_og_image_path');
            if ($oldPath && Storage::disk('public')->exists($oldPath)) {
                Storage::disk('public')->delete($oldPath);
            }
            $path = $request->file('og_image_file')->store($dir, 'public');
            $this->settings->set('seo_og_image_path', $path, 'text');
        }
        ActivityLogger::log('settings.updated', ['section' => 'seo']);

        return redirect()->route('admin.settings.seo')->with('success', 'Kaydedildi');
    }

    public function socialForm()
    {
        if ($r = $this->ensureAdmin()) return $r;
        $platforms = ['whatsapp', 'telegram', 'instagram', 'facebook', 'tiktok', 'youtube', 'x'];
        $data = [];
        foreach ($platforms as $p) {
            $data[$p . '_url'] = $this->settings->get($p . '_url', '');
            $data[$p . '_active'] = (bool) $this->settings->get($p . '_active', false);
        }
        return view('admin.settings.social', $data);
    }

    public function saveSocial(Request $request)
    {
        if ($r = $this->ensureAdmin()) return $r;
        $rules = [];
        $platforms = ['whatsapp', 'telegram', 'instagram', 'facebook', 'tiktok', 'youtube', 'x'];
        foreach ($platforms as $p) {
            $rules[$p . '_url'] = 'nullable|string|max:500';
            $rules[$p . '_active'] = 'nullable|boolean';
        }
        $validated = $request->validate($rules);

        foreach ($platforms as $p) {
            $url = trim($validated[$p . '_url'] ?? '');
            if ($url !== '' && !filter_var($url, FILTER_VALIDATE_URL)) {
                return redirect()->route('admin.settings.social')
                    ->withInput()
                    ->with('error', $p . '_url geçersiz URL formatında.');
            }
        }

        $items = [];
        foreach ($platforms as $p) {
            $items[$p . '_url'] = ['value' => trim($validated[$p . '_url'] ?? ''), 'type' => 'text'];
            $items[$p . '_active'] = ['value' => (bool) ($request->boolean($p . '_active')), 'type' => 'boolean'];
        }
        $this->settings->setMany($items);
        ActivityLogger::log('settings.updated', ['section' => 'social']);

        return redirect()->route('admin.settings.social')->with('success', 'Kaydedildi');
    }

    public function footerForm()
    {
        if ($r = $this->ensureAdmin()) return $r;
        $defaultLinks = [
            ['label' => 'Gizlilik Politikasi', 'url' => '/gizlilik'],
            ['label' => 'Cerez Politikasi', 'url' => '/cerez'],
            ['label' => 'Kullanim Sartlari', 'url' => '/kullanim'],
            ['label' => 'KVKK Aydinlatma Metni', 'url' => '/kvkk'],
        ];
        $linksJson = $this->settings->get('footer_legal_links_json');
        $links = is_array($linksJson) ? $linksJson : $defaultLinks;
        return view('admin.settings.footer', [
            'footer_legal_text' => $this->settings->get('footer_legal_text', 'Radyoyol Tum Haklari Saklidir'),
            'footer_legal_links' => $links,
        ]);
    }

    public function saveFooter(Request $request)
    {
        if ($r = $this->ensureAdmin()) return $r;
        $validated = $request->validate([
            'footer_legal_text' => 'required|string|max:255',
            'footer_legal_links_json' => 'nullable|string',
        ]);

        $this->settings->set('footer_legal_text', $validated['footer_legal_text'], 'text');

        $json = $validated['footer_legal_links_json'] ?? '[]';
        $decoded = json_decode($json, true);
        if (!is_array($decoded)) {
            $decoded = [];
        }
        $sanitized = [];
        foreach ($decoded as $item) {
            if (is_array($item) && isset($item['label'], $item['url'])) {
                $url = trim((string) $item['url']);
                if ($url === '') {
                    $url = '/';
                } elseif (!str_starts_with($url, '/') && !filter_var($url, FILTER_VALIDATE_URL)) {
                    $url = '/';
                }
                $sanitized[] = [
                    'label' => (string) $item['label'],
                    'url' => $url,
                ];
            }
        }
        $this->settings->set('footer_legal_links_json', $sanitized, 'json');
        ActivityLogger::log('settings.updated', ['section' => 'footer']);

        return redirect()->route('admin.settings.footer')->with('success', 'Kaydedildi');
    }

    public function themeForm()
    {
        if ($r = $this->ensureAdmin()) return $r;
        $presets = $this->themeService->getPresets();
        $settings = $this->themeService->getSettings();
        return view('admin.settings.theme', [
            'presets' => $presets,
            'settings' => $settings,
        ]);
    }

    public function saveTheme(Request $request)
    {
        if ($r = $this->ensureAdmin()) return $r;

        $validated = $request->validate([
            'theme_id' => 'required|integer|min:1|max:' . max(array_keys($this->themeService->getPresets())),
            'bg_mode' => 'required|in:color,image',
            'bg_color' => 'nullable|string|max:16',
            'bg_image' => 'nullable|file|mimes:jpeg,jpg,png,gif,webp|max:4096',
            'overlay_color' => 'nullable|string|max:16',
            'overlay_opacity' => 'nullable|integer|min:0|max:80',
            'bg_blur' => 'nullable|integer|min:0|max:12',
        ]);

        $data = [
            'theme_id' => (int) $validated['theme_id'],
            'bg_mode' => $validated['bg_mode'],
            'bg_color' => $validated['bg_color'] ?? '#0b0f16',
            'overlay_color' => $validated['overlay_color'] ?? '#000000',
            'overlay_opacity' => (int) ($validated['overlay_opacity'] ?? 55),
            'bg_blur' => (int) ($validated['bg_blur'] ?? 0),
        ];

        if ($request->boolean('remove_bg_image')) {
            $row = \App\Models\SiteTheme::first();
            if ($row && $row->bg_image) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($row->bg_image);
            }
            $data['bg_image'] = null;
        } elseif ($request->hasFile('bg_image')) {
            $dir = 'uploads/theme';
            if (!Storage::disk('public')->exists($dir)) {
                Storage::disk('public')->makeDirectory($dir);
            }
            $row = \App\Models\SiteTheme::first();
            if ($row && $row->bg_image) {
                Storage::disk('public')->delete($row->bg_image);
            }
            $path = $request->file('bg_image')->store($dir, 'public');
            $data['bg_image'] = $path;
        }

        $this->themeService->save($data);
        ActivityLogger::log('settings.updated', ['section' => 'theme']);

        return redirect()->route('admin.settings.theme')->with('success', 'Tema ayarları kaydedildi.');
    }
}
