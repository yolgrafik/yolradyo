<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SongRequest;
use Illuminate\Http\JsonResponse;

class NotificationController extends Controller
{
    public function pendingCount(): JsonResponse
    {
        $count = SongRequest::where('status', 'pending')->count();

        return response()->json(['count' => $count]);
    }
}
