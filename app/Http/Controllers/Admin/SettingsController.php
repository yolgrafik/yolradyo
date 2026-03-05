<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\ActivityLogger;
use App\Http\Controllers\Controller;
use App\Services\SettingsService;
use App\Services\ThemeService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

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
            'contact_mobile' => $this->settings->get('contact_mobile'),
            'contact_fax' => $this->settings->get('contact_fax'),
            'address_text' => $this->settings->get('address_text'),
            'contact_map_embed' => $this->settings->get('contact_map_embed'),
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
            'contact_mobile' => 'nullable|string|max:50',
            'contact_fax' => 'nullable|string|max:50',
            'address_text' => 'nullable|string|max:500',
            'contact_map_embed' => 'nullable|string|max:4000',
            'maintenance_mode' => 'nullable|boolean',
        ]);

        $this->settings->setMany([
            'site_name' => ['value' => $validated['site_name'], 'type' => 'text'],
            'site_slogan' => ['value' => $validated['site_slogan'] ?? '', 'type' => 'text'],
            'contact_email' => ['value' => $validated['contact_email'] ?? '', 'type' => 'text'],
            'contact_phone' => ['value' => $validated['contact_phone'] ?? '', 'type' => 'text'],
            'contact_mobile' => ['value' => $validated['contact_mobile'] ?? '', 'type' => 'text'],
            'contact_fax' => ['value' => $validated['contact_fax'] ?? '', 'type' => 'text'],
            'address_text' => ['value' => $validated['address_text'] ?? '', 'type' => 'text'],
            'contact_map_embed' => ['value' => trim($validated['contact_map_embed'] ?? ''), 'type' => 'text'],
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
            'site_name' => $this->settings->get('site_name', 'RADYOYOL'),
            'seo_meta_title' => $this->settings->get('seo_meta_title'),
            'seo_meta_description' => $this->settings->get('seo_meta_description'),
            'seo_meta_keywords' => $this->settings->get('seo_meta_keywords'),
            'seo_meta_author' => $this->settings->get('seo_meta_author'),
            'seo_meta_robots' => $this->settings->get('seo_meta_robots', 'index,follow'),
            'seo_canonical_url' => $this->settings->get('seo_canonical_url'),
            'seo_og_image_path' => $this->settings->get('seo_og_image_path'),
            'seo_og_title' => $this->settings->get('seo_og_title'),
            'seo_og_description' => $this->settings->get('seo_og_description'),
            'seo_og_type' => $this->settings->get('seo_og_type', 'website'),
            'seo_og_locale' => $this->settings->get('seo_og_locale', 'tr_TR'),
            'seo_twitter_card' => $this->settings->get('seo_twitter_card', 'summary_large_image'),
            'seo_twitter_site' => $this->settings->get('seo_twitter_site'),
            'seo_twitter_creator' => $this->settings->get('seo_twitter_creator'),
            'seo_google_verification' => $this->settings->get('seo_google_verification'),
            'seo_bing_verification' => $this->settings->get('seo_bing_verification'),
            'seo_yandex_verification' => $this->settings->get('seo_yandex_verification'),
            'seo_schema_org_name' => $this->settings->get('seo_schema_org_name'),
            'seo_schema_org_url' => $this->settings->get('seo_schema_org_url'),
            'seo_schema_org_logo' => $this->settings->get('seo_schema_org_logo'),
            'seo_schema_description' => $this->settings->get('seo_schema_description'),
            'seo_schema_radio_station' => (bool) $this->settings->get('seo_schema_radio_station', true),
            'seo_sitemap_url' => $this->settings->get('seo_sitemap_url'),
            'seo_geo_region' => $this->settings->get('seo_geo_region'),
            'seo_meta_referrer' => $this->settings->get('seo_meta_referrer', ''),
            'seo_schema_json' => $this->settings->get('seo_schema_json'),
        ]);
    }

    public function saveSeo(Request $request)
    {
        if ($r = $this->ensureAdmin()) return $r;
        $validated = $request->validate([
            'meta_title' => 'nullable|string|max:60',
            'meta_description' => 'nullable|string|max:160',
            'meta_keywords' => 'nullable|string|max:500',
            'meta_author' => 'nullable|string|max:100',
            'meta_robots' => ['nullable', 'string', Rule::in(['index,follow', 'noindex,nofollow', 'index,nofollow', 'noindex,follow'])],
            'canonical_url' => 'nullable|url|max:500',
            'og_image_file' => 'nullable|file|mimes:png,jpg,jpeg|max:2048',
            'remove_og_image' => 'nullable|boolean',
            'og_title' => 'nullable|string|max:95',
            'og_description' => 'nullable|string|max:200',
            'og_type' => 'nullable|string|in:website,article',
            'og_locale' => 'nullable|string|max:10',
            'twitter_card' => 'nullable|string|in:summary,summary_large_image',
            'twitter_site' => 'nullable|string|max:50',
            'twitter_creator' => 'nullable|string|max:50',
            'google_site_verification' => 'nullable|string|max:100',
            'bing_site_verification' => 'nullable|string|max:100',
            'yandex_verification' => 'nullable|string|max:100',
            'schema_organization_name' => 'nullable|string|max:150',
            'schema_organization_url' => 'nullable|url|max:500',
            'schema_organization_logo' => 'nullable|url|max:500',
            'schema_description' => 'nullable|string|max:500',
            'schema_radio_station' => 'nullable|boolean',
            'sitemap_url' => 'nullable|url|max:500',
            'geo_region' => 'nullable|string|max:10',
            'meta_referrer' => 'nullable|string|max:50',
            'schema_json' => 'nullable|string|max:8000',
        ]);

        $items = [
            'seo_meta_title' => ['value' => trim($validated['meta_title'] ?? ''), 'type' => 'text'],
            'seo_meta_description' => ['value' => trim($validated['meta_description'] ?? ''), 'type' => 'text'],
            'seo_meta_keywords' => ['value' => trim($validated['meta_keywords'] ?? ''), 'type' => 'text'],
            'seo_meta_author' => ['value' => trim($validated['meta_author'] ?? ''), 'type' => 'text'],
            'seo_meta_robots' => ['value' => $validated['meta_robots'] ?? 'index,follow', 'type' => 'text'],
            'seo_canonical_url' => ['value' => trim($validated['canonical_url'] ?? ''), 'type' => 'text'],
            'seo_og_title' => ['value' => trim($validated['og_title'] ?? ''), 'type' => 'text'],
            'seo_og_description' => ['value' => trim($validated['og_description'] ?? ''), 'type' => 'text'],
            'seo_og_type' => ['value' => $validated['og_type'] ?? 'website', 'type' => 'text'],
            'seo_og_locale' => ['value' => $validated['og_locale'] ?? 'tr_TR', 'type' => 'text'],
            'seo_twitter_card' => ['value' => $validated['twitter_card'] ?? 'summary_large_image', 'type' => 'text'],
            'seo_twitter_site' => ['value' => trim($validated['twitter_site'] ?? ''), 'type' => 'text'],
            'seo_twitter_creator' => ['value' => trim($validated['twitter_creator'] ?? ''), 'type' => 'text'],
            'seo_google_verification' => ['value' => trim($validated['google_site_verification'] ?? ''), 'type' => 'text'],
            'seo_bing_verification' => ['value' => trim($validated['bing_site_verification'] ?? ''), 'type' => 'text'],
            'seo_yandex_verification' => ['value' => trim($validated['yandex_verification'] ?? ''), 'type' => 'text'],
            'seo_schema_org_name' => ['value' => trim($validated['schema_organization_name'] ?? ''), 'type' => 'text'],
            'seo_schema_org_url' => ['value' => trim($validated['schema_organization_url'] ?? ''), 'type' => 'text'],
            'seo_schema_org_logo' => ['value' => trim($validated['schema_organization_logo'] ?? ''), 'type' => 'text'],
            'seo_schema_description' => ['value' => trim($validated['schema_description'] ?? ''), 'type' => 'text'],
            'seo_schema_radio_station' => ['value' => $request->boolean('schema_radio_station'), 'type' => 'boolean'],
            'seo_sitemap_url' => ['value' => trim($validated['sitemap_url'] ?? ''), 'type' => 'text'],
            'seo_geo_region' => ['value' => trim($validated['geo_region'] ?? ''), 'type' => 'text'],
            'seo_meta_referrer' => ['value' => trim($validated['meta_referrer'] ?? ''), 'type' => 'text'],
            'seo_schema_json' => ['value' => trim($validated['schema_json'] ?? ''), 'type' => 'text'],
        ];
        $this->settings->setMany($items);

        $dir = 'assets/seo';
        if ($request->boolean('remove_og_image')) {
            $oldPath = $this->settings->get('seo_og_image_path');
            if ($oldPath && Storage::disk('public')->exists($oldPath)) {
                Storage::disk('public')->delete($oldPath);
            }
            $this->settings->set('seo_og_image_path', '', 'text');
        } elseif ($request->hasFile('og_image_file')) {
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
        $platforms = ['whatsapp', 'telegram', 'instagram', 'facebook', 'tiktok', 'youtube', 'x', 'android_app', 'ios_app', 'winamp', 'media_player', 'quicktime', 'real_player'];
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
        $platforms = ['whatsapp', 'telegram', 'instagram', 'facebook', 'tiktok', 'youtube', 'x', 'android_app', 'ios_app', 'winamp', 'media_player', 'quicktime', 'real_player'];
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
            'button_color' => 'nullable|string|max:16',
            'button_hover_color' => 'nullable|string|max:16',
            'schedule_color' => 'nullable|string|max:16',
            'schedule_active_color' => 'nullable|string|max:16',
            'line_color' => 'nullable|string|max:32',
        ]);

        $data = [
            'theme_id' => (int) $validated['theme_id'],
            'bg_mode' => $validated['bg_mode'],
            'bg_color' => $validated['bg_color'] ?? '#0b0f16',
            'overlay_color' => $validated['overlay_color'] ?? '#000000',
            'overlay_opacity' => (int) ($validated['overlay_opacity'] ?? 55),
            'bg_blur' => (int) ($validated['bg_blur'] ?? 0),
            'button_color' => $validated['button_color'] ?? '#c92a2a',
            'button_hover_color' => $validated['button_hover_color'] ?? '#dc2626',
            'schedule_color' => $validated['schedule_color'] ?? '#1e2430',
            'schedule_active_color' => $validated['schedule_active_color'] ?? '#c92a2a',
            'line_color' => !empty(trim($validated['line_color'] ?? '')) ? trim($validated['line_color']) : null,
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
