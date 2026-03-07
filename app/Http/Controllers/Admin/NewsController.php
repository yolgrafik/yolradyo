<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\News;
use App\Models\NewsMedia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class NewsController extends Controller
{
    protected string $uploadDir = 'uploads/news';
    protected string $galleryUploadDir = 'uploads/news/gallery';

    public function index()
    {
        $news = News::query()->latest()->get();
        return view('admin.news.index', compact('news'));
    }

    public function create()
    {
        return view('admin.news.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255',
            'excerpt' => 'nullable|string|max:500',
            'content' => 'nullable|string',
            'cover_image' => 'nullable|image|mimes:jpeg,jpg,png,gif,webp|max:5120',
            'video_url' => 'nullable|url|max:500',
            'gallery_images' => 'nullable|array',
            'gallery_images.*' => 'image|mimes:jpeg,jpg,png,gif,webp|max:5120',
            'status' => 'nullable|boolean',
        ]);

        $coverImagePath = $request->hasFile('cover_image') ? $this->handleUpload($request->file('cover_image')) : null;
        $slug = $this->uniqueSlug($validated['slug'] ?? null, $validated['title']);

        $news = News::create([
            'title' => $validated['title'],
            'slug' => $slug,
            'excerpt' => $validated['excerpt'] ?? null,
            'content' => $validated['content'] ?? null,
            'cover_image' => $coverImagePath,
            'video_url' => $validated['video_url'] ?? null,
            'status' => (bool) ($validated['status'] ?? true),
        ]);

        $this->storeGalleryImages($news, $request);

        return redirect()->route('admin.news.index')->with('success', 'Haber eklendi.');
    }

    public function edit(News $news)
    {
        $news->load('media');
        return view('admin.news.edit', compact('news'));
    }

    public function update(Request $request, News $news)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255',
            'excerpt' => 'nullable|string|max:500',
            'content' => 'nullable|string',
            'cover_image' => 'nullable|image|mimes:jpeg,jpg,png,gif,webp|max:5120',
            'video_url' => 'nullable|url|max:500',
            'gallery_images' => 'nullable|array',
            'gallery_images.*' => 'image|mimes:jpeg,jpg,png,gif,webp|max:5120',
            'remove_media_ids' => 'nullable|array',
            'remove_media_ids.*' => 'integer',
            'status' => 'nullable|boolean',
        ]);

        $coverImagePath = $news->cover_image;
        if ($request->hasFile('cover_image')) {
            $this->deleteFile($news->cover_image);
            $coverImagePath = $this->handleUpload($request->file('cover_image'));
        }

        $slug = $this->uniqueSlug($validated['slug'] ?? null, $validated['title'], $news->id);

        $news->update([
            'title' => $validated['title'],
            'slug' => $slug,
            'excerpt' => $validated['excerpt'] ?? null,
            'content' => $validated['content'] ?? null,
            'cover_image' => $coverImagePath,
            'video_url' => $validated['video_url'] ?? null,
            'status' => (bool) ($validated['status'] ?? true),
        ]);

        $this->removeSelectedMedia($news, $request->input('remove_media_ids', []));
        $this->storeGalleryImages($news, $request);

        return redirect()->route('admin.news.index')->with('success', 'Haber guncellendi.');
    }

    public function destroy(News $news)
    {
        $this->deleteFile($news->cover_image);
        foreach ($news->media as $media) {
            $this->deleteFile($media->file_path);
        }
        $news->media()->delete();
        $news->delete();
        return redirect()->route('admin.news.index')->with('success', 'Haber silindi.');
    }

    protected function handleUpload($file): string
    {
        $dir = public_path($this->uploadDir);
        if (!File::isDirectory($dir)) {
            File::makeDirectory($dir, 0755, true);
        }
        $name = uniqid() . '_' . preg_replace('/[^a-zA-Z0-9._-]/', '', $file->getClientOriginalName());
        $file->move($dir, $name);
        return $this->uploadDir . '/' . $name;
    }

    protected function deleteFile(?string $path): void
    {
        if ($path && File::exists(public_path($path))) {
            File::delete(public_path($path));
        }
    }

    protected function handleGalleryUpload($file): string
    {
        $dir = public_path($this->galleryUploadDir);
        if (!File::isDirectory($dir)) {
            File::makeDirectory($dir, 0755, true);
        }
        $name = uniqid() . '_' . preg_replace('/[^a-zA-Z0-9._-]/', '', $file->getClientOriginalName());
        $file->move($dir, $name);
        return $this->galleryUploadDir . '/' . $name;
    }

    protected function storeGalleryImages(News $news, Request $request): void
    {
        $files = $request->file('gallery_images', []);
        if (!$files) {
            return;
        }

        $order = (int) ($news->media()->max('sort_order') ?? 0);
        foreach ($files as $file) {
            if (!$file) {
                continue;
            }
            $order++;
            $news->media()->create([
                'type' => 'image',
                'file_path' => $this->handleGalleryUpload($file),
                'sort_order' => $order,
            ]);
        }
    }

    protected function removeSelectedMedia(News $news, array $ids): void
    {
        if (empty($ids)) {
            return;
        }

        $mediaItems = $news->media()->whereIn('id', $ids)->get();
        foreach ($mediaItems as $media) {
            $this->deleteFile($media->file_path);
            $media->delete();
        }
    }

    protected function uniqueSlug(?string $candidate, string $title, ?int $ignoreId = null): string
    {
        $base = Str::slug($candidate ?: $title);
        if ($base === '') {
            $base = 'haber';
        }

        $slug = $base;
        $index = 2;
        while (
            News::query()
                ->when($ignoreId, fn ($q) => $q->where('id', '!=', $ignoreId))
                ->where('slug', $slug)
                ->exists()
        ) {
            $slug = $base . '-' . $index;
            $index++;
        }

        return $slug;
    }
}
