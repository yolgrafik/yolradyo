<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Sponsor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class SponsorController extends Controller
{
    public function index()
    {
        $sponsors = Sponsor::query()->orderBy('sort_order')->latest()->paginate(20);
        return view('admin.sponsors.index', compact('sponsors'));
    }

    public function create()
    {
        return view('admin.sponsors.create');
    }

    public function store(Request $request)
    {
        $validated = $this->validatePayload($request);
        $imagePath = $request->hasFile('image') ? $this->uploadImage($request->file('image')) : null;

        Sponsor::create([
            'title' => $validated['title'],
            'short_description' => $validated['short_description'] ?? null,
            'image_path' => $imagePath,
            'website_url' => $validated['website_url'] ?? null,
            'facebook_url' => $validated['facebook_url'] ?? null,
            'instagram_url' => $validated['instagram_url'] ?? null,
            'x_url' => $validated['x_url'] ?? null,
            'youtube_url' => $validated['youtube_url'] ?? null,
            'sort_order' => (int) ($validated['sort_order'] ?? 0),
            'is_active' => (bool) ($validated['is_active'] ?? false),
        ]);

        return redirect()->route('admin.sponsors.index')->with('success', 'Sponsor eklendi.');
    }

    public function edit(Sponsor $sponsor)
    {
        return view('admin.sponsors.edit', compact('sponsor'));
    }

    public function update(Request $request, Sponsor $sponsor)
    {
        $validated = $this->validatePayload($request);
        $imagePath = $sponsor->image_path;

        if ($request->hasFile('image')) {
            $this->deleteImage($imagePath);
            $imagePath = $this->uploadImage($request->file('image'));
        }

        $sponsor->update([
            'title' => $validated['title'],
            'short_description' => $validated['short_description'] ?? null,
            'image_path' => $imagePath,
            'website_url' => $validated['website_url'] ?? null,
            'facebook_url' => $validated['facebook_url'] ?? null,
            'instagram_url' => $validated['instagram_url'] ?? null,
            'x_url' => $validated['x_url'] ?? null,
            'youtube_url' => $validated['youtube_url'] ?? null,
            'sort_order' => (int) ($validated['sort_order'] ?? 0),
            'is_active' => (bool) ($validated['is_active'] ?? false),
        ]);

        return redirect()->route('admin.sponsors.index')->with('success', 'Sponsor güncellendi.');
    }

    public function destroy(Sponsor $sponsor)
    {
        $this->deleteImage($sponsor->image_path);
        $sponsor->delete();
        return redirect()->route('admin.sponsors.index')->with('success', 'Sponsor silindi.');
    }

    private function validatePayload(Request $request): array
    {
        return $request->validate([
            'title' => 'required|string|max:255',
            'short_description' => 'nullable|string|max:2000',
            'image' => 'nullable|image|mimes:jpeg,jpg,png,webp,gif|max:8192',
            'website_url' => 'nullable|url|max:500',
            'facebook_url' => 'nullable|url|max:500',
            'instagram_url' => 'nullable|url|max:500',
            'x_url' => 'nullable|url|max:500',
            'youtube_url' => 'nullable|url|max:500',
            'sort_order' => 'nullable|integer|min:0|max:9999',
            'is_active' => 'nullable|boolean',
        ]);
    }

    private function uploadImage($file): string
    {
        $dir = 'uploads/sponsors';
        $fullDir = public_path($dir);
        if (!File::isDirectory($fullDir)) {
            File::makeDirectory($fullDir, 0755, true);
        }

        $name = uniqid() . '_' . preg_replace('/[^a-zA-Z0-9._-]/', '', $file->getClientOriginalName());
        $file->move($fullDir, $name);
        return $dir . '/' . $name;
    }

    private function deleteImage(?string $path): void
    {
        if ($path && File::exists(public_path($path))) {
            File::delete(public_path($path));
        }
    }
}
