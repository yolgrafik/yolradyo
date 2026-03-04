<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\ActivityLogger;
use App\Http\Controllers\Controller;
use App\Services\SettingsService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SettingsController extends Controller
{
    public function __construct(
        protected SettingsService $settings
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
        return view('admin.settings.theme', [
            'theme_primary' => $this->settings->get('theme_primary', '#0f1319'),
            'theme_accent' => $this->settings->get('theme_accent', '#c92a2a'),
            'theme_bg' => $this->settings->get('theme_bg', '#0f1319'),
            'theme_text' => $this->settings->get('theme_text', '#f0f2f5'),
            'theme_glow' => $this->settings->get('theme_glow', '#c92a2a'),
        ]);
    }

    public function saveTheme(Request $request)
    {
        if ($r = $this->ensureAdmin()) return $r;
        $validated = $request->validate([
            'theme_primary' => 'nullable|string|regex:/^#[0-9A-Fa-f]{6}$/|max:20',
            'theme_accent' => 'nullable|string|regex:/^#[0-9A-Fa-f]{6}$/|max:20',
            'theme_bg' => 'nullable|string|regex:/^#[0-9A-Fa-f]{6}$/|max:20',
            'theme_text' => 'nullable|string|regex:/^#[0-9A-Fa-f]{6}$/|max:20',
            'theme_glow' => 'nullable|string|regex:/^#[0-9A-Fa-f]{6}$/|max:20',
        ]);

        $this->settings->setMany([
            'theme_primary' => ['value' => $validated['theme_primary'] ?? '#0f1319', 'type' => 'color'],
            'theme_accent' => ['value' => $validated['theme_accent'] ?? '#c92a2a', 'type' => 'color'],
            'theme_bg' => ['value' => $validated['theme_bg'] ?? '#0f1319', 'type' => 'color'],
            'theme_text' => ['value' => $validated['theme_text'] ?? '#f0f2f5', 'type' => 'color'],
            'theme_glow' => ['value' => $validated['theme_glow'] ?? '#c92a2a', 'type' => 'color'],
        ]);
        ActivityLogger::log('settings.updated', ['section' => 'theme']);

        return redirect()->route('admin.settings.theme')->with('success', 'Kaydedildi');
    }
}
