<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Blacklist;
use App\Models\Message;
use App\Models\SongRequest;
use Illuminate\Http\Request;

class MessagesController extends Controller
{
    public function index(Request $request)
    {
        $type = $request->get('type', 'song-requests');

        if ($type === 'programci') {
            $query = Message::with(['user', 'programci'])->whereNotNull('programci_id')->latest();

            if ($request->filled('q')) {
                $search = $request->q;
                $query->where(function ($qry) use ($search) {
                    $qry->where('message', 'like', "%{$search}%")
                        ->orWhereHas('user', fn ($u) => $u->where('name', 'like', "%{$search}%")->orWhere('email', 'like', "%{$search}%"))
                        ->orWhereHas('programci', fn ($p) => $p->where('ad', 'like', "%{$search}%"));
                });
            }

            $days = $request->get('days');
            if ($days === '7') {
                $query->where('created_at', '>=', now()->subDays(7));
            } elseif ($days === '30') {
                $query->where('created_at', '>=', now()->subDays(30));
            }

            $programciMessages = $query->paginate(20)->withQueryString();
            $messages = collect();
            return view('admin.messages.index', compact('messages', 'programciMessages', 'type'));
        }

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
        $programciMessages = null;
        return view('admin.messages.index', compact('messages', 'programciMessages', 'type'));
    }

    public function approve(SongRequest $songRequest)
    {
        if ($songRequest->status === 'approved') {
            return back()->with('success', 'Kayıt zaten onaylı.');
        }
        $songRequest->update(['status' => 'approved', 'approved_at' => now()]);
        return back()->with('success', 'İstek onaylandı.');
    }

    public function blacklist(Request $request, SongRequest $songRequest)
    {
        $reason = $request->input('reason', 'Spam/uygunsuz');

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
        return back()->with('success', 'Kara listeye alındı ve listeden kaldırıldı.');
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
