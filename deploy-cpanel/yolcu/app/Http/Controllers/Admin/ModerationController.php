<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SongRequest;
use Illuminate\Http\Request;

class ModerationController extends Controller
{
    public function index(Request $request)
    {
        $query = SongRequest::query()->where('status', 'rejected')->orderBy('updated_at', 'desc');

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

        return view('admin.moderation.index', compact('requests'));
    }
}
