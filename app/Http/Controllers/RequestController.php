<?php

namespace App\Http\Controllers;

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

            SongRequest::create([
                'full_name' => $validated['full_name'],
                'email' => !empty($validated['email']) ? $validated['email'] : null,
                'artist_name' => $validated['artist_name'],
                'song_name' => $validated['song_name'],
                'message' => $validated['message'] ?? null,
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
