<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\GalleryPhoto;
use App\Models\PhotoAlbum;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class PhotoGalleryController extends Controller
{
    private string $uploadDir = 'uploads/gallery/photos';

    public function albums()
    {
        $albums = PhotoAlbum::query()->withCount('photos')->orderBy('sort_order')->latest()->get();
        return view('admin.photo-gallery.albums', compact('albums'));
    }

    public function storeAlbum(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'sort_order' => 'nullable|integer|min:0|max:9999',
            'is_active' => 'nullable|boolean',
        ]);

        PhotoAlbum::create([
            'name' => $validated['name'],
            'slug' => Str::slug($validated['name']) . '-' . Str::random(4),
            'description' => $validated['description'] ?? null,
            'sort_order' => (int) ($validated['sort_order'] ?? 0),
            'is_active' => (bool) ($validated['is_active'] ?? false),
        ]);

        return redirect()->route('admin.photo-gallery.albums')->with('success', 'Albüm eklendi.');
    }

    public function createPhoto()
    {
        $albums = PhotoAlbum::query()->where('is_active', true)->orderBy('sort_order')->get();
        return view('admin.photo-gallery.create', compact('albums'));
    }

    public function storePhoto(Request $request)
    {
        $validated = $request->validate([
            'album_id' => 'required|exists:photo_albums,id',
            'title' => 'nullable|string|max:255',
            'image' => 'required|image|mimes:jpeg,jpg,png,webp,gif|max:8192',
            'sort_order' => 'nullable|integer|min:0|max:9999',
            'is_active' => 'nullable|boolean',
        ]);

        $path = $this->uploadImage($request->file('image'));

        GalleryPhoto::create([
            'album_id' => (int) $validated['album_id'],
            'title' => $validated['title'] ?? null,
            'image_path' => $path,
            'sort_order' => (int) ($validated['sort_order'] ?? 0),
            'is_active' => (bool) ($validated['is_active'] ?? false),
        ]);

        return redirect()->route('admin.photo-gallery.photos.edit.list')->with('success', 'Fotoğraf eklendi.');
    }

    public function bulkUploadForm()
    {
        $albums = PhotoAlbum::query()->where('is_active', true)->orderBy('sort_order')->get();
        return view('admin.photo-gallery.bulk', compact('albums'));
    }

    public function bulkUploadStore(Request $request)
    {
        $validated = $request->validate([
            'album_id' => 'required|exists:photo_albums,id',
            'images' => 'required|array|min:1',
            'images.*' => 'image|mimes:jpeg,jpg,png,webp,gif|max:8192',
            'is_active' => 'nullable|boolean',
        ]);

        foreach ($request->file('images', []) as $file) {
            $path = $this->uploadImage($file);
            GalleryPhoto::create([
                'album_id' => (int) $validated['album_id'],
                'title' => null,
                'image_path' => $path,
                'sort_order' => 0,
                'is_active' => (bool) ($validated['is_active'] ?? true),
            ]);
        }

        return redirect()->route('admin.photo-gallery.photos.edit.list')->with('success', 'Toplu yükleme tamamlandı.');
    }

    public function editList()
    {
        $photos = GalleryPhoto::query()->with('album')->orderBy('sort_order')->latest()->paginate(24);
        return view('admin.photo-gallery.edit-list', compact('photos'));
    }

    public function editPhoto(GalleryPhoto $photo)
    {
        $albums = PhotoAlbum::query()->where('is_active', true)->orderBy('sort_order')->get();
        return view('admin.photo-gallery.edit', compact('photo', 'albums'));
    }

    public function updatePhoto(Request $request, GalleryPhoto $photo)
    {
        $validated = $request->validate([
            'album_id' => 'required|exists:photo_albums,id',
            'title' => 'nullable|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,jpg,png,webp,gif|max:8192',
            'sort_order' => 'nullable|integer|min:0|max:9999',
            'is_active' => 'nullable|boolean',
        ]);

        $path = $photo->image_path;
        if ($request->hasFile('image')) {
            $this->deleteImage($path);
            $path = $this->uploadImage($request->file('image'));
        }

        $photo->update([
            'album_id' => (int) $validated['album_id'],
            'title' => $validated['title'] ?? null,
            'image_path' => $path,
            'sort_order' => (int) ($validated['sort_order'] ?? 0),
            'is_active' => (bool) ($validated['is_active'] ?? false),
        ]);

        return redirect()->route('admin.photo-gallery.photos.edit.list')->with('success', 'Fotoğraf güncellendi.');
    }

    public function destroyPhoto(GalleryPhoto $photo)
    {
        $this->deleteImage($photo->image_path);
        $photo->delete();

        return redirect()->route('admin.photo-gallery.photos.delete.list')->with('success', 'Fotoğraf silindi.');
    }

    public function deleteList()
    {
        $photos = GalleryPhoto::query()->with('album')->latest()->paginate(24);
        return view('admin.photo-gallery.delete-list', compact('photos'));
    }

    private function uploadImage($file): string
    {
        $fullDir = public_path($this->uploadDir);
        if (!File::isDirectory($fullDir)) {
            File::makeDirectory($fullDir, 0755, true);
        }

        $name = uniqid() . '_' . preg_replace('/[^a-zA-Z0-9._-]/', '', $file->getClientOriginalName());
        $file->move($fullDir, $name);

        return $this->uploadDir . '/' . $name;
    }

    private function deleteImage(?string $path): void
    {
        if ($path && File::exists(public_path($path))) {
            File::delete(public_path($path));
        }
    }
}
