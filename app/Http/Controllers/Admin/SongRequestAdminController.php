<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SongRequest;
use Illuminate\Http\Request;

class SongRequestAdminController extends Controller
{
    public function index(Request $request)
    {
        $query = SongRequest::orderByDesc('created_at');

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $requests = $query->paginate(25)->withQueryString();

        return view('admin.song_requests.index', compact('requests'));
    }

    public function approve(SongRequest $songRequest)
    {
        $songRequest->update([
            'status' => 'approved',
            'approved_at' => now(),
        ]);

        return back()->with('success', 'Istek onaylandi.');
    }

    public function reject(SongRequest $songRequest)
    {
        $songRequest->update(['status' => 'rejected']);

        return back()->with('success', 'Istek reddedildi.');
    }

    public function destroy(SongRequest $songRequest)
    {
        $songRequest->delete();

        return back()->with('success', 'Istek silindi.');
    }
}
