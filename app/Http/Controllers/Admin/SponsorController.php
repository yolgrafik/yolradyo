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
        $images = $this->processSponsorImages($request, null);
        $imagePath = !empty($images) ? $images[0] : null;
        $videoType = $validated['video_type'] ?? 'none';
        $videoPath = null;
        $videoYoutubeUrl = null;

        if ($videoType === 'youtube' && !empty($validated['video_youtube_url'] ?? '')) {
            $videoYoutubeUrl = $validated['video_youtube_url'];
        } elseif ($videoType === 'mp4' && $request->hasFile('video_file')) {
            $videoPath = $this->uploadVideo($request->file('video_file'));
        }

        Sponsor::create([
            'title' => $validated['title'],
            'short_description' => $validated['short_description'] ?? null,
            'description' => $validated['description'] ?? null,
            'image_path' => $imagePath,
            'images' => $images,
            'website_url' => $validated['website_url'] ?? null,
            'facebook_url' => $validated['facebook_url'] ?? null,
            'instagram_url' => $validated['instagram_url'] ?? null,
            'x_url' => $validated['x_url'] ?? null,
            'youtube_url' => $validated['youtube_url'] ?? null,
            'video_type' => $videoType === 'none' ? null : $videoType,
            'video_youtube_url' => $videoYoutubeUrl,
            'video_path' => $videoPath,
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
        $validated = $this->validatePayload($request, $sponsor);
        $images = $this->processSponsorImages($request, $sponsor);
        $imagePath = !empty($images) ? $images[0] : null;

        $videoType = $validated['video_type'] ?? 'none';
        $videoPath = $sponsor->video_path;
        $videoYoutubeUrl = $sponsor->video_youtube_url;

        if ($videoType === 'none') {
            if ($sponsor->video_path) {
                $this->deleteVideo($sponsor->video_path);
                $videoPath = null;
            }
            $videoYoutubeUrl = null;
        } elseif ($videoType === 'youtube') {
            if ($sponsor->video_path) {
                $this->deleteVideo($sponsor->video_path);
                $videoPath = null;
            }
            $videoYoutubeUrl = !empty($validated['video_youtube_url'] ?? '') ? $validated['video_youtube_url'] : null;
        } elseif ($videoType === 'mp4' && $request->hasFile('video_file')) {
            if ($sponsor->video_path) {
                $this->deleteVideo($sponsor->video_path);
            }
            $videoPath = $this->uploadVideo($request->file('video_file'));
        }

        $sponsor->update([
            'title' => $validated['title'],
            'short_description' => $validated['short_description'] ?? null,
            'description' => $validated['description'] ?? null,
            'image_path' => $imagePath,
            'images' => $images,
            'website_url' => $validated['website_url'] ?? null,
            'facebook_url' => $validated['facebook_url'] ?? null,
            'instagram_url' => $validated['instagram_url'] ?? null,
            'x_url' => $validated['x_url'] ?? null,
            'youtube_url' => $validated['youtube_url'] ?? null,
            'video_type' => $videoType === 'none' ? null : $videoType,
            'video_youtube_url' => $videoYoutubeUrl,
            'video_path' => $videoPath,
            'sort_order' => (int) ($validated['sort_order'] ?? 0),
            'is_active' => (bool) ($validated['is_active'] ?? false),
        ]);

        return redirect()->route('admin.sponsors.index')->with('success', 'Sponsor güncellendi.');
    }

    public function destroy(Sponsor $sponsor)
    {
        $this->deleteImage($sponsor->image_path);
        foreach ($sponsor->getGalleryImages() as $path) {
            $this->deleteImage($path);
        }
        $this->deleteVideo($sponsor->video_path);
        $sponsor->delete();
        return redirect()->route('admin.sponsors.index')->with('success', 'Sponsor silindi.');
    }

    private function validatePayload(Request $request, ?Sponsor $sponsor = null): array
    {
        $videoType = $request->input('video_type', 'none');
        $rules = [
            'title' => 'required|string|max:255',
            'short_description' => 'nullable|string|max:2000',
            'description' => 'nullable|string|max:10000',
            'image' => 'nullable|image|mimes:jpeg,jpg,png,webp,gif|max:10240',
            'images' => 'nullable|array|max:20',
            'images.*' => 'nullable|image|mimes:jpeg,jpg,png,webp,gif|max:10240',
            'existing_images' => 'nullable|array',
            'existing_images.*' => 'nullable|string|max:500',
            'website_url' => 'nullable|url|max:500',
            'facebook_url' => 'nullable|url|max:500',
            'instagram_url' => 'nullable|url|max:500',
            'x_url' => 'nullable|url|max:500',
            'youtube_url' => 'nullable|url|max:500',
            'video_type' => 'nullable|in:none,youtube,mp4',
            'video_youtube_url' => 'nullable|url|max:500',
            'video_file' => 'nullable|file|mimetypes:video/mp4|max:102400',
            'sort_order' => 'nullable|integer|min:0|max:9999',
            'is_active' => 'nullable|boolean',
        ];

        if ($videoType === 'youtube') {
            $rules['video_youtube_url'] = 'required|url|max:500|regex:#(youtube\.com/watch\?v=|youtu\.be/)#';
        }
        if ($videoType === 'mp4') {
            $hasExisting = $sponsor && !empty($sponsor->video_path);
            $rules['video_file'] = ($hasExisting && !$request->hasFile('video_file'))
                ? 'nullable|file|mimetypes:video/mp4|max:102400'
                : 'required|file|mimetypes:video/mp4|max:102400';
        }

        return $request->validate($rules);
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

    private function uploadVideo($file): string
    {
        $dir = 'uploads/sponsors/videos';
        $fullDir = public_path($dir);
        if (!File::isDirectory($fullDir)) {
            File::makeDirectory($fullDir, 0755, true);
        }
        $name = uniqid() . '_' . preg_replace('/[^a-zA-Z0-9._-]/', '', $file->getClientOriginalName());
        if (!str_ends_with(strtolower($name), '.mp4')) {
            $name .= '.mp4';
        }
        $file->move($fullDir, $name);
        return $dir . '/' . $name;
    }

    private function deleteVideo(?string $path): void
    {
        if ($path && File::exists(public_path($path))) {
            File::delete(public_path($path));
        }
    }

    private function processSponsorImages(Request $request, ?Sponsor $sponsor): array
    {
        $existing = array_values(array_filter((array) $request->input('existing_images', [])));
        $newPaths = [];
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $file) {
                if ($file && $file->isValid()) {
                    $newPaths[] = $this->uploadImage($file);
                }
            }
        }
        $allImages = array_merge($existing, $newPaths);

        if (empty($allImages) && $request->hasFile('image')) {
            $allImages = [$this->uploadImage($request->file('image'))];
        }

        if ($sponsor) {
            $current = $sponsor->getGalleryImages();
            $kept = array_intersect($current, $existing);
            $removed = array_diff($current, $existing);
            foreach ($removed as $path) {
                $this->deleteImage($path);
            }
        }

        return $allImages;
    }
}
