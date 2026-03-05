<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Programci;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProgramciController extends Controller
{
    public function index()
    {
        $programcilar = Programci::orderBy('sira')->orderBy('ad')->get();

        return view('admin.programcilar.index', compact('programcilar'));
    }

    public function create()
    {
        return view('admin.programcilar.form', ['programci' => null]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'ad' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255',
            'avatar' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'kisa_aciklama' => 'nullable|string|max:500',
            'uzun_aciklama' => 'nullable|string',
            'email' => 'nullable|email|max:255',
            'instagram' => 'nullable|string|max:500',
            'facebook' => 'nullable|string|max:500',
            'tiktok' => 'nullable|string|max:500',
            'youtube' => 'nullable|string|max:500',
            'website' => 'nullable|string|max:500',
            'aktif' => 'nullable|boolean',
            'sira' => 'nullable|integer|min:0',
            'seo_title' => 'nullable|string|max:255',
            'seo_description' => 'nullable|string|max:500',
        ]);

        $baseSlug = !empty(trim($validated['slug'] ?? '')) ? Str::slug($validated['slug']) : Str::slug($validated['ad']);
        $data = [
            'ad' => $validated['ad'],
            'slug' => Programci::uniqueSlug($baseSlug),
            'kisa_aciklama' => $validated['kisa_aciklama'] ?? null,
            'uzun_aciklama' => $validated['uzun_aciklama'] ?? null,
            'email' => $validated['email'] ?? null,
            'instagram' => $validated['instagram'] ?? null,
            'facebook' => $validated['facebook'] ?? null,
            'tiktok' => $validated['tiktok'] ?? null,
            'youtube' => $validated['youtube'] ?? null,
            'website' => $validated['website'] ?? null,
            'aktif' => $request->filled('aktif'),
            'sira' => (int) ($validated['sira'] ?? 0),
            'seo_title' => $validated['seo_title'] ?? null,
            'seo_description' => $validated['seo_description'] ?? null,
        ];

        if ($request->hasFile('avatar')) {
            $data['avatar_path'] = $request->file('avatar')->store('programcilar', 'public');
        }

        Programci::create($data);

        return redirect()->route('admin.programcilar.index')->with('success', 'Programcı eklendi.');
    }

    public function edit(Programci $programci)
    {
        return view('admin.programcilar.form', ['programci' => $programci]);
    }

    public function update(Request $request, Programci $programci)
    {
        $validated = $request->validate([
            'ad' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255',
            'avatar' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'kisa_aciklama' => 'nullable|string|max:500',
            'uzun_aciklama' => 'nullable|string',
            'email' => 'nullable|email|max:255',
            'instagram' => 'nullable|string|max:500',
            'facebook' => 'nullable|string|max:500',
            'tiktok' => 'nullable|string|max:500',
            'youtube' => 'nullable|string|max:500',
            'website' => 'nullable|string|max:500',
            'aktif' => 'nullable|boolean',
            'sira' => 'nullable|integer|min:0',
            'seo_title' => 'nullable|string|max:255',
            'seo_description' => 'nullable|string|max:500',
        ]);

        $baseSlug = !empty(trim($validated['slug'] ?? '')) ? Str::slug($validated['slug']) : Str::slug($validated['ad']);
        $data = [
            'ad' => $validated['ad'],
            'slug' => Programci::uniqueSlug($baseSlug, $programci->id),
            'kisa_aciklama' => $validated['kisa_aciklama'] ?? null,
            'uzun_aciklama' => $validated['uzun_aciklama'] ?? null,
            'email' => $validated['email'] ?? null,
            'instagram' => $validated['instagram'] ?? null,
            'facebook' => $validated['facebook'] ?? null,
            'tiktok' => $validated['tiktok'] ?? null,
            'youtube' => $validated['youtube'] ?? null,
            'website' => $validated['website'] ?? null,
            'aktif' => $request->filled('aktif'),
            'sira' => (int) ($validated['sira'] ?? 0),
            'seo_title' => $validated['seo_title'] ?? null,
            'seo_description' => $validated['seo_description'] ?? null,
        ];

        if ($request->hasFile('avatar')) {
            if ($programci->avatar_path && Storage::disk('public')->exists($programci->avatar_path)) {
                Storage::disk('public')->delete($programci->avatar_path);
            }
            $data['avatar_path'] = $request->file('avatar')->store('programcilar', 'public');
        }

        $programci->update($data);

        return redirect()->route('admin.programcilar.index')->with('success', 'Programcı güncellendi.');
    }

    public function destroy(Programci $programci)
    {
        if ($programci->avatar_path && Storage::disk('public')->exists($programci->avatar_path)) {
            Storage::disk('public')->delete($programci->avatar_path);
        }
        $programci->delete();

        return redirect()->route('admin.programcilar.index')->with('success', 'Programcı silindi.');
    }
}
