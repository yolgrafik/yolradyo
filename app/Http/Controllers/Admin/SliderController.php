<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Slider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class SliderController extends Controller
{
    protected string $uploadDir = 'uploads/sliders';

    public function index()
    {
        $sliders = Slider::orderBy('order')->get();
        return view('admin.sliders.index', compact('sliders'));
    }

    public function create()
    {
        return view('admin.sliders.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'subtitle' => 'nullable|string|max:500',
            'button_text' => 'nullable|string|max:100',
            'button_link' => 'nullable|string|max:500',
            'image' => 'required|image|mimes:jpeg,jpg,png,gif,webp|max:5120',
            'status' => 'nullable|boolean',
        ]);

        $path = $this->handleUpload($request->file('image'));
        $maxOrder = Slider::max('order') ?? 0;

        Slider::create([
            'title' => $validated['title'],
            'subtitle' => $validated['subtitle'] ?? null,
            'button_text' => $validated['button_text'] ?? null,
            'button_link' => $validated['button_link'] ?? null,
            'image_path' => $path,
            'status' => (bool) ($validated['status'] ?? true),
            'order' => $maxOrder + 1,
        ]);

        return redirect()->route('admin.sliders.index')->with('success', 'Slider eklendi.');
    }

    public function edit(Slider $slider)
    {
        return view('admin.sliders.edit', compact('slider'));
    }

    public function update(Request $request, Slider $slider)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'subtitle' => 'nullable|string|max:500',
            'button_text' => 'nullable|string|max:100',
            'button_link' => 'nullable|string|max:500',
            'image' => 'nullable|image|mimes:jpeg,jpg,png,gif,webp|max:5120',
            'status' => 'nullable|boolean',
        ]);

        $path = $slider->image_path;
        if ($request->hasFile('image')) {
            $this->deleteFile($slider->image_path);
            $path = $this->handleUpload($request->file('image'));
        }

        $slider->update([
            'title' => $validated['title'],
            'subtitle' => $validated['subtitle'] ?? null,
            'button_text' => $validated['button_text'] ?? null,
            'button_link' => $validated['button_link'] ?? null,
            'image_path' => $path,
            'status' => (bool) ($validated['status'] ?? true),
        ]);

        return redirect()->route('admin.sliders.index')->with('success', 'Slider guncellendi.');
    }

    public function destroy(Slider $slider)
    {
        $this->deleteFile($slider->image_path);
        $slider->delete();
        return redirect()->route('admin.sliders.index')->with('success', 'Slider silindi.');
    }

    public function reorder(Request $request)
    {
        $validated = $request->validate([
            'order' => 'required|array',
            'order.*' => 'integer|exists:sliders,id',
        ]);

        foreach ($validated['order'] as $position => $id) {
            Slider::where('id', $id)->update(['order' => $position]);
        }

        return response()->json(['success' => true]);
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
