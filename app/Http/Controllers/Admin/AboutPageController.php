<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AboutPage;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\View\View;

class AboutPageController extends Controller
{
    private const PAGES = [
        'biz-kimiz' => 'Biz Kimiz',
        'misyon' => 'Misyon & Vizyon',
        'politika' => 'Yayın Politikamız',
    ];

    private string $uploadDir = 'uploads/about-pages';

    public function index(): View
    {
        $this->ensureDefaults();
        $pages = AboutPage::query()
            ->whereIn('slug', array_keys(self::PAGES))
            ->orderBy('sort_order')
            ->get()
            ->keyBy('slug');

        return view('admin.about-pages.index', compact('pages'));
    }

    public function edit(string $slug): View|RedirectResponse
    {
        if (!isset(self::PAGES[$slug])) {
            return redirect()->route('admin.about-pages.index')->with('error', 'Geçersiz sayfa.');
        }

        $this->ensureDefaults();
        $page = AboutPage::query()->where('slug', $slug)->firstOrFail();

        return view('admin.about-pages.edit', compact('page'));
    }

    public function update(Request $request, string $slug): RedirectResponse
    {
        if (!isset(self::PAGES[$slug])) {
            return redirect()->route('admin.about-pages.index')->with('error', 'Geçersiz sayfa.');
        }

        $page = AboutPage::query()->where('slug', $slug)->firstOrFail();
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'short_description' => 'nullable|string|max:500',
            'content' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,jpg,png,gif,webp|max:5120',
            'is_active' => 'nullable|boolean',
        ]);

        $imagePath = $page->image_path;
        if ($request->hasFile('image')) {
            if ($imagePath && File::exists(public_path($imagePath))) {
                File::delete(public_path($imagePath));
            }

            $dir = public_path($this->uploadDir);
            if (!File::isDirectory($dir)) {
                File::makeDirectory($dir, 0755, true);
            }

            $file = $request->file('image');
            $name = uniqid() . '_' . preg_replace('/[^a-zA-Z0-9._-]/', '', $file->getClientOriginalName());
            $file->move($dir, $name);
            $imagePath = $this->uploadDir . '/' . $name;
        }

        $page->update([
            'title' => $validated['title'],
            'short_description' => $validated['short_description'] ?? null,
            'content' => $validated['content'] ?? null,
            'image_path' => $imagePath,
            'is_active' => (bool) ($validated['is_active'] ?? false),
        ]);

        return redirect()->route('admin.about-pages.index')->with('success', 'Hakkımızda sayfası güncellendi.');
    }

    private function ensureDefaults(): void
    {
        $order = 1;
        foreach (self::PAGES as $slug => $title) {
            AboutPage::query()->firstOrCreate(
                ['slug' => $slug],
                [
                    'title' => $title,
                    'short_description' => null,
                    'content' => null,
                    'is_active' => true,
                    'sort_order' => $order,
                ]
            );
            $order++;
        }
    }
}
