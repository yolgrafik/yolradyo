<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DjProfile;
use Illuminate\Http\Request;

class DjProfileController extends Controller
{
    public function index()
    {
        $djs = DjProfile::orderBy('name')->get();

        return view('admin.djs.index', compact('djs'));
    }

    public function create()
    {
        return view('admin.djs.form', ['dj' => null]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'bio' => 'nullable|string|max:500',
            'initials' => 'nullable|string|max:10',
            'avatar_path' => 'nullable|string|max:500',
        ]);

        DjProfile::create($validated);

        return redirect()->route('admin.djs.index')->with('success', 'DJ profili eklendi.');
    }

    public function edit(DjProfile $dj)
    {
        return view('admin.djs.form', ['dj' => $dj]);
    }

    public function update(Request $request, DjProfile $dj)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'bio' => 'nullable|string|max:500',
            'initials' => 'nullable|string|max:10',
            'avatar_path' => 'nullable|string|max:500',
        ]);

        $dj->update($validated);

        return redirect()->route('admin.djs.index')->with('success', 'DJ profili güncellendi.');
    }

    public function destroy(DjProfile $dj)
    {
        $dj->delete();

        return redirect()->route('admin.djs.index')->with('success', 'DJ profili silindi.');
    }

    /** Set this DJ as live; all others to offline */
    public function setLive(DjProfile $dj)
    {
        DjProfile::where('id', '!=', $dj->id)->update(['is_live' => false]);
        $dj->update(['is_live' => true]);

        return redirect()->route('admin.djs.index')->with('success', $dj->name . ' canlı yayında olarak işaretlendi.');
    }

    /** Set this DJ as offline */
    public function setOffline(DjProfile $dj)
    {
        $dj->update(['is_live' => false]);

        return redirect()->route('admin.djs.index')->with('success', $dj->name . ' canlı yayından çıkarıldı.');
    }
}
