<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SongRequest;
use Illuminate\Http\Request;

class MessagesController extends Controller
{
    public function index(Request $request)
    {
        $query = SongRequest::query()->where('status', 'approved')->orderBy('approved_at', 'desc');

        if ($request->filled('q')) {
            $q = $request->q;
            $query->where(function ($qry) use ($q) {
                $qry->where('full_name', 'like', "%{$q}%")
                    ->orWhere('artist_name', 'like', "%{$q}%")
                    ->orWhere('song_name', 'like', "%{$q}%")
                    ->orWhere('message', 'like', "%{$q}%");
            });
        }

        $days = $request->get('days');
        if ($days === '7') {
            $query->where('approved_at', '>=', now()->subDays(7));
        } elseif ($days === '30') {
            $query->where('approved_at', '>=', now()->subDays(30));
        }

        $messages = $query->paginate(20)->withQueryString();

        return view('admin.messages.index', compact('messages'));
    }

    public function bulkDestroy(Request $request)
    {
        $ids = $request->input('ids', []);
        if (!empty($ids)) {
            SongRequest::whereIn('id', $ids)->where('status', 'approved')->delete();
        }
        return back()->with('success', 'Seçilen kayıtlar silindi.');
    }
}
