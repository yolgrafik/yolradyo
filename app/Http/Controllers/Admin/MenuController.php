<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\ActivityLogger;
use App\Http\Controllers\Controller;
use App\Models\MenuItem;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    protected function ensureAdmin()
    {
        if (!session('admin_logged_in')) {
            return redirect()->route('admin.login');
        }
    }

    public function index(Request $request)
    {
        if ($r = $this->ensureAdmin()) return $r;

        $location = $request->get('location', 'header');
        if (!in_array($location, ['header', 'footer'])) {
            $location = 'header';
        }

        $items = MenuItem::where('location', $location)
            ->with('parent')
            ->orderBy('parent_id')
            ->orderBy('sort_order')
            ->get();

        $parents = MenuItem::where('location', $location)
            ->whereNull('parent_id')
            ->orderBy('sort_order')
            ->pluck('title', 'id')
            ->toArray();

        return view('admin.menu.index', [
            'items' => $items,
            'parents' => $parents,
            'location' => $location,
        ]);
    }

    public function create(Request $request)
    {
        if ($r = $this->ensureAdmin()) return $r;

        $location = $request->get('location', 'header');
        $parents = MenuItem::where('location', $location)
            ->whereNull('parent_id')
            ->orderBy('sort_order')
            ->get();

        return view('admin.menu.form', [
            'item' => null,
            'parents' => $parents,
            'location' => $location,
        ]);
    }

    public function store(Request $request)
    {
        if ($r = $this->ensureAdmin()) return $r;

        $rules = [
            'title' => 'required|string|max:120',
            'location' => 'required|in:header,footer',
            'type' => 'required|in:page,url',
            'url' => 'required|string|max:500',
            'parent_id' => 'nullable|exists:menu_items,id',
            'target_blank' => 'nullable|boolean',
            'is_active' => 'nullable|boolean',
            'sort_order' => 'nullable|integer|min:0',
        ];

        $validated = $request->validate($rules);

        if ($validated['type'] === 'page') {
            $url = $validated['url'];
            if (!str_starts_with($url, '/')) {
                $url = '/' . $url;
            }
            $validated['url'] = $url;
        }

        if (!empty($validated['parent_id'])) {
            $parent = MenuItem::find($validated['parent_id']);
            if ($parent && $parent->parent_id !== null) {
                return redirect()->back()->withInput()->with('error', 'Sadece 1 seviye alt menü desteklenir.');
            }
        } else {
            $validated['parent_id'] = null;
        }

        $validated['target_blank'] = (bool) ($request->boolean('target_blank'));
        $validated['is_active'] = (bool) ($request->boolean('is_active', true));
        $validated['sort_order'] = (int) ($validated['sort_order'] ?? 0);

        MenuItem::create($validated);
        ActivityLogger::log('menu.created', ['title' => $validated['title']]);

        return redirect()->route('admin.menu.index', ['location' => $validated['location']])
            ->with('success', 'Menü öğesi eklendi.');
    }

    public function edit(MenuItem $menu)
    {
        if ($r = $this->ensureAdmin()) return $r;

        $parents = MenuItem::where('location', $menu->location)
            ->whereNull('parent_id')
            ->where('id', '!=', $menu->id)
            ->orderBy('sort_order')
            ->get();

        return view('admin.menu.form', [
            'item' => $menu,
            'parents' => $parents,
            'location' => $menu->location,
        ]);
    }

    public function update(Request $request, MenuItem $menu)
    {
        if ($r = $this->ensureAdmin()) return $r;

        $rules = [
            'title' => 'required|string|max:120',
            'location' => 'required|in:header,footer',
            'type' => 'required|in:page,url',
            'url' => 'required|string|max:500',
            'parent_id' => 'nullable|exists:menu_items,id',
            'target_blank' => 'nullable|boolean',
            'is_active' => 'nullable|boolean',
            'sort_order' => 'nullable|integer|min:0',
        ];

        $validated = $request->validate($rules);

        if ($validated['type'] === 'page') {
            $url = $validated['url'];
            if (!str_starts_with($url, '/')) {
                $url = '/' . $url;
            }
            $validated['url'] = $url;
        }

        if (!empty($validated['parent_id'])) {
            if ((int) $validated['parent_id'] === $menu->id) {
                return redirect()->back()->withInput()->with('error', 'Kendini üst menü olarak seçemezsiniz.');
            }
            $parent = MenuItem::find($validated['parent_id']);
            if ($parent && $parent->parent_id !== null) {
                return redirect()->back()->withInput()->with('error', 'Sadece 1 seviye alt menü desteklenir.');
            }
        } else {
            $validated['parent_id'] = null;
        }

        $validated['target_blank'] = (bool) ($request->boolean('target_blank'));
        $validated['is_active'] = (bool) ($request->boolean('is_active', true));
        $validated['sort_order'] = (int) ($validated['sort_order'] ?? 0);

        $menu->update($validated);
        ActivityLogger::log('menu.updated', ['id' => $menu->id]);

        return redirect()->route('admin.menu.index', ['location' => $validated['location']])
            ->with('success', 'Menü öğesi güncellendi.');
    }

    public function destroy(MenuItem $menu)
    {
        if ($r = $this->ensureAdmin()) return $r;

        $location = $menu->location;
        $id = $menu->id;
        $menu->delete();
        ActivityLogger::log('menu.deleted', ['id' => $id]);

        return redirect()->route('admin.menu.index', ['location' => $location])
            ->with('success', 'Menü öğesi silindi.');
    }

    public function reorder(Request $request)
    {
        if ($r = $this->ensureAdmin()) return $r;

        $request->validate([
            'location' => 'required|in:header,footer',
            'items' => 'required|array',
            'items.*.id' => 'required|integer|exists:menu_items,id',
            'items.*.sort_order' => 'required|integer|min:0',
        ]);

        foreach ($request->items as $item) {
            MenuItem::where('id', $item['id'])->update(['sort_order' => $item['sort_order']]);
        }

        ActivityLogger::log('menu.reordered', ['location' => $request->location]);

        return response()->json(['success' => true]);
    }
}
