<?php

namespace App\Http\Controllers;

use App\Models\Blacklist;
use App\Models\SongRequest;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class RequestController extends Controller
{
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'full_name' => 'required|string|min:3|max:255',
                'email' => 'nullable|email|max:255',
                'artist_name' => 'required|string|min:2|max:255',
                'song_name' => 'required|string|min:2|max:255',
                'message' => 'nullable|string|max:500',
            ]);

            if (Blacklist::isBlocked($request->full_name, $request->email)) {
                return response()->json([
                    'ok' => false,
                    'message' => 'Bu kullanıcı engellendi.',
                ], 403);
            }

            SongRequest::create([
                'full_name' => request('full_name'),
                'email' => request('email') ?: null,
                'artist_name' => request('artist_name'),
                'song_name' => request('song_name'),
                'message' => request('message'),
                'status' => 'pending',
            ]);

            return response()->json([
                'ok' => true,
                'message' => 'İsteğiniz alındı.',
            ]);
        } catch (ValidationException $e) {
            return response()->json([
                'ok' => false,
                'errors' => $e->errors(),
            ], 422);
        }
    }
}
