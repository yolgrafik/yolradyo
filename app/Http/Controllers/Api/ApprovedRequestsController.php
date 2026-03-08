<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\SongRequest;
use Illuminate\Http\JsonResponse;

class ApprovedRequestsController extends Controller
{
    public function __invoke(): JsonResponse
    {
        $items = SongRequest::approved()
            ->orderBy('approved_at', 'desc')
            ->limit(50)
            ->get()
            ->map(fn ($r) => [
                'requester' => $r->full_name,
                'artist' => $r->artist_name,
                'song' => $r->song_name,
                'name' => $r->full_name,
            ]);

        return response()->json($items->values()->all());
    }
}
