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
            'isim_soyad' => 'required|string|min:3|max:255',
            'sanatci_ismi' => 'required|string|min:2|max:255',
            'turku_ismi' => 'required|string|min:2|max:255',
            'mesaj' => 'nullable|string|max:500',
        ]);

        SongRequest::create([
            'full_name' => $validated['isim_soyad'],
            'email' => null,
            'artist_name' => $validated['sanatci_ismi'],
            'song_name' => $validated['turku_ismi'],
            'message' => $validated['mesaj'] ?? null,
            'status' => 'pending',
        ]);

        return response()->json([
            'ok' => true,
            'message' => 'İsteğiniz alındı.',
        ]);
    }

    public function approvedList()
    {
        $requests = SongRequest::approved()
            ->orderByDesc('approved_at')
            ->limit(30)
            ->get(['full_name', 'artist_name', 'song_name']);

        return response()->json($requests);
    }
}
