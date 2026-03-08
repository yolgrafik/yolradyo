<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ArtistVideo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Validation\ValidationException;

class VideoController extends Controller
{
    protected string $coverDir = 'uploads/videos/covers';
    protected string $videoDir = 'uploads/videos/mp4';

    public function index()
    {
        $videos = ArtistVideo::query()
            ->orderByDesc('is_featured')
            ->orderBy('sort_order')
            ->latest()
            ->get();
        return view('admin.videos.index', compact('videos'));
    }

    public function featured()
    {
        $videos = ArtistVideo::query()
            ->featured()
            ->orderBy('sort_order')
            ->latest()
            ->get();
        return view('admin.videos.index', compact('videos'));
    }

    public function create()
    {
        return view('admin.videos.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'short_description' => 'nullable|string|max:500',
            'cover_image' => 'nullable|image|mimes:jpeg,jpg,png,gif,webp|max:5120',
            'video_type' => 'required|in:mp4,youtube',
            'mp4_file' => 'nullable|file|mimetypes:video/mp4|max:51200',
            'youtube_url' => 'nullable|url|max:500',
            'is_active' => 'nullable|boolean',
            'is_featured' => 'nullable|boolean',
            'sort_order' => 'nullable|integer|min:0|max:9999',
        ]);

        $this->validateTypePayload($request, null);

        $coverPath = $request->hasFile('cover_image') ? $this->uploadFile($request->file('cover_image'), $this->coverDir) : null;
        $mp4Path = $request->hasFile('mp4_file') ? $this->uploadFile($request->file('mp4_file'), $this->videoDir) : null;

        ArtistVideo::create([
            'title' => $validated['title'],
            'short_description' => $validated['short_description'] ?? null,
            'cover_image_path' => $coverPath,
            'video_type' => $validated['video_type'],
            'mp4_path' => $validated['video_type'] === 'mp4' ? $mp4Path : null,
            'youtube_url' => $validated['video_type'] === 'youtube' ? ($validated['youtube_url'] ?? null) : null,
            'is_active' => (bool) ($validated['is_active'] ?? false),
            'is_featured' => (bool) ($validated['is_featured'] ?? false),
            'sort_order' => (int) ($validated['sort_order'] ?? 0),
        ]);

        return redirect()->route('admin.videos.index')->with('success', 'Video eklendi.');
    }

    public function edit(ArtistVideo $video)
    {
        return view('admin.videos.edit', compact('video'));
    }

    public function update(Request $request, ArtistVideo $video)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'short_description' => 'nullable|string|max:500',
            'cover_image' => 'nullable|image|mimes:jpeg,jpg,png,gif,webp|max:5120',
            'video_type' => 'required|in:mp4,youtube',
            'mp4_file' => 'nullable|file|mimetypes:video/mp4|max:51200',
            'youtube_url' => 'nullable|url|max:500',
            'is_active' => 'nullable|boolean',
            'is_featured' => 'nullable|boolean',
            'sort_order' => 'nullable|integer|min:0|max:9999',
        ]);

        $this->validateTypePayload($request, $video);

        $coverPath = $video->cover_image_path;
        if ($request->hasFile('cover_image')) {
            $this->deleteFile($coverPath);
            $coverPath = $this->uploadFile($request->file('cover_image'), $this->coverDir);
        }

        $mp4Path = $video->mp4_path;
        if ($validated['video_type'] === 'mp4' && $request->hasFile('mp4_file')) {
            $this->deleteFile($mp4Path);
            $mp4Path = $this->uploadFile($request->file('mp4_file'), $this->videoDir);
        }

        if ($validated['video_type'] === 'youtube' && $video->video_type === 'mp4') {
            $this->deleteFile($mp4Path);
            $mp4Path = null;
        }

        $video->update([
            'title' => $validated['title'],
            'short_description' => $validated['short_description'] ?? null,
            'cover_image_path' => $coverPath,
            'video_type' => $validated['video_type'],
            'mp4_path' => $validated['video_type'] === 'mp4' ? $mp4Path : null,
            'youtube_url' => $validated['video_type'] === 'youtube' ? ($validated['youtube_url'] ?? null) : null,
            'is_active' => (bool) ($validated['is_active'] ?? false),
            'is_featured' => (bool) ($validated['is_featured'] ?? false),
            'sort_order' => (int) ($validated['sort_order'] ?? 0),
        ]);

        return redirect()->route('admin.videos.index')->with('success', 'Video güncellendi.');
    }

    public function destroy(ArtistVideo $video)
    {
        $this->deleteFile($video->cover_image_path);
        $this->deleteFile($video->mp4_path);
        $video->delete();

        return redirect()->route('admin.videos.index')->with('success', 'Video silindi.');
    }

    protected function validateTypePayload(Request $request, ?ArtistVideo $video): void
    {
        $type = $request->input('video_type');

        if ($type === 'mp4') {
            $hasMp4 = $request->hasFile('mp4_file') || ($video && !empty($video->mp4_path));
            if (!$hasMp4) {
                throw ValidationException::withMessages([
                    'mp4_file' => 'MP4 seçildiğinde MP4 video zorunludur.',
                ]);
            }
        }

        if ($type === 'youtube') {
            $youtubeUrl = trim((string) $request->input('youtube_url', ''));
            if ($youtubeUrl === '') {
                throw ValidationException::withMessages([
                    'youtube_url' => 'YouTube seçildiğinde YouTube linki zorunludur.',
                ]);
            }
        }
    }

    protected function uploadFile($file, string $dir): string
    {
        $fullDir = public_path($dir);
        if (!File::isDirectory($fullDir)) {
            File::makeDirectory($fullDir, 0755, true);
        }

        $name = uniqid() . '_' . preg_replace('/[^a-zA-Z0-9._-]/', '', $file->getClientOriginalName());
        $file->move($fullDir, $name);

        return $dir . '/' . $name;
    }

    protected function deleteFile(?string $path): void
    {
        if ($path && File::exists(public_path($path))) {
            File::delete(public_path($path));
        }
    }
}
