<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\News;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class NewsController extends Controller
{
    protected string $uploadDir = 'uploads/news';

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
            'excerpt' => 'nullable|string|max:500',
            'content' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,jpg,png,gif,webp|max:5120',
            'status' => 'nullable|boolean',
        ]);

        $imagePath = $request->hasFile('image') ? $this->handleUpload($request->file('image')) : null;

        News::create([
            'title' => $validated['title'],
            'excerpt' => $validated['excerpt'] ?? null,
            'content' => $validated['content'] ?? null,
            'image_path' => $imagePath,
            'status' => (bool) ($validated['status'] ?? true),
        ]);

        return redirect()->route('admin.news.index')->with('success', 'Haber eklendi.');
    }

    public function edit(News $news)
    {
        return view('admin.news.edit', compact('news'));
    }

    public function update(Request $request, News $news)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'excerpt' => 'nullable|string|max:500',
            'content' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,jpg,png,gif,webp|max:5120',
            'status' => 'nullable|boolean',
        ]);

        $imagePath = $news->image_path;
        if ($request->hasFile('image')) {
            $this->deleteFile($news->image_path);
            $imagePath = $this->handleUpload($request->file('image'));
        }

        $news->update([
            'title' => $validated['title'],
            'excerpt' => $validated['excerpt'] ?? null,
            'content' => $validated['content'] ?? null,
            'image_path' => $imagePath,
            'status' => (bool) ($validated['status'] ?? true),
        ]);

        return redirect()->route('admin.news.index')->with('success', 'Haber guncellendi.');
    }

    public function destroy(News $news)
    {
        $this->deleteFile($news->image_path);
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
}
