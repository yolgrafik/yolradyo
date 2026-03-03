<?php

namespace App\Http\Controllers;

use App\Models\SongRequest;
use Illuminate\Http\Request;

class RequestController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'isim_soyad' => 'required|string|max:255',
            'email' => 'required|email',
            'sanatci_ismi' => 'required|string|max:255',
            'eserin_ismi' => 'required|string|max:255',
            'mesaj' => 'nullable|string|max:1000',
        ]);

        SongRequest::create([
            'full_name' => $validated['isim_soyad'],
            'email' => $validated['email'],
            'artist_name' => $validated['sanatci_ismi'],
            'song_name' => $validated['eserin_ismi'],
            'message' => $validated['mesaj'] ?? null,
            'status' => 'pending',
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Istek alindi, onay sonrasi yayinlanacaktir.',
        ]);
    }

    public function approvedList()
    {
        $requests = SongRequest::approved()
            ->orderByDesc('approved_at')
            ->limit(50)
            ->get(['full_name', 'artist_name', 'song_name']);

        return response()->json($requests);
    }
}
