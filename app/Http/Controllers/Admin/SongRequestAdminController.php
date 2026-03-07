<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Blacklist;
use App\Models\SongRequest;
use Illuminate\Http\Request;

class SongRequestAdminController extends Controller
{
    public function index(Request $request)
    {
        $query = SongRequest::query()->where('status', 'pending')->orderBy('created_at', 'desc');

        if ($request->filled('q')) {
            $q = $request->q;
            $query->where(function ($qry) use ($q) {
                $qry->where('full_name', 'like', "%{$q}%")
                    ->orWhere('artist_name', 'like', "%{$q}%")
                    ->orWhere('song_name', 'like', "%{$q}%")
                    ->orWhere('message', 'like', "%{$q}%");
            });
        }

        $requests = $query->paginate(20)->withQueryString();

        return view('admin.song_requests.index', compact('requests'));
    }

    public function approve(SongRequest $songRequest)
    {
        $songRequest->update(['status' => 'approved', 'approved_at' => now()]);
        return back()->with('success', 'İstek onaylandı.');
    }

    public function reject(SongRequest $songRequest)
    {
        $songRequest->update(['status' => 'rejected']);
        return back()->with('success', 'İstek reddedildi.');
    }

    public function blacklist(Request $request, SongRequest $songRequest)
    {
        $reason = $request->input('reason', 'Spam/Uygunsuz');

        $entries = [];
        if ($songRequest->full_name) {
            $entries[] = ['type' => 'name', 'value' => trim($songRequest->full_name), 'reason' => $reason];
        }
        if ($songRequest->email) {
            $entries[] = ['type' => 'email', 'value' => trim(strtolower($songRequest->email)), 'reason' => $reason];
        }

        foreach ($entries as $entry) {
            Blacklist::firstOrCreate(
                ['type' => $entry['type'], 'value' => $entry['value']],
                ['reason' => $entry['reason']]
            );
        }

        $songRequest->update(['status' => 'rejected']);
        return back()->with('success', 'Kara listeye alındı ve istek reddedildi.');
    }

    public function destroy(SongRequest $songRequest)
    {
        $songRequest->delete();
        return back()->with('success', 'İstek silindi.');
    }
}
