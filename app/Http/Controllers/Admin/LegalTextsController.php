<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\ActivityLogger;
use App\Http\Controllers\Controller;
use App\Services\SettingsService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class LegalTextsController extends Controller
{
    public const TEXTS = [
        'kullanim' => ['key' => 'legal_kullanim', 'title' => 'Kullanım Şartları', 'route' => 'kullanim'],
        'gizlilik' => ['key' => 'legal_gizlilik', 'title' => 'Gizlilik Politikası', 'route' => 'gizlilik'],
        'cerez' => ['key' => 'legal_cerez', 'title' => 'Çerez Politikası', 'route' => 'cerez'],
        'kvkk' => ['key' => 'legal_kvkk', 'title' => 'KVKK Aydınlatma Metni', 'route' => 'kvkk'],
        'dmca' => ['key' => 'legal_dmca', 'title' => 'DMCA / Telif Hakkı Bildirimi', 'route' => 'dmca'],
    ];

    public function __construct(
        protected SettingsService $settings
    ) {}

    public function index(): View
    {
        if ($r = $this->ensureAdmin()) return $r;
        return view('admin.legal-texts.index', ['texts' => self::TEXTS]);
    }

    public function edit(string $slug): View|RedirectResponse
    {
        if ($r = $this->ensureAdmin()) return $r;
        if (!isset(self::TEXTS[$slug])) {
            return redirect()->route('admin.legal-texts.index')->with('error', 'Geçersiz sayfa.');
        }
        $config = self::TEXTS[$slug];
        $content = $this->settings->get($config['key'], '');
        return view('admin.legal-texts.edit', [
            'slug' => $slug,
            'title' => $config['title'],
            'content' => $content,
        ]);
    }

    public function update(Request $request, string $slug): RedirectResponse
    {
        if ($r = $this->ensureAdmin()) return $r;
        if (!isset(self::TEXTS[$slug])) {
            return redirect()->route('admin.legal-texts.index')->with('error', 'Geçersiz sayfa.');
        }
        $config = self::TEXTS[$slug];
        $validated = $request->validate([
            'content' => 'nullable|string|max:50000',
        ]);
        $this->settings->set($config['key'], $validated['content'] ?? '', 'text');
        ActivityLogger::log('legal_text.updated', ['slug' => $slug]);
        return redirect()->route('admin.legal-texts.index')->with('success', $config['title'] . ' güncellendi.');
    }

    protected function ensureAdmin()
    {
        if (!session('admin_logged_in')) {
            return redirect()->route('admin.login');
        }
        return null;
    }
}
