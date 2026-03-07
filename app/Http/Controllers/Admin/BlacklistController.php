<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Blacklist;
use Illuminate\Http\Request;

class BlacklistController extends Controller
{
    public function index(Request $request)
    {
        $query = Blacklist::query()->orderBy('created_at', 'desc');

        if ($request->filled('q')) {
            $q = $request->q;
            $query->where(function ($qry) use ($q) {
                $qry->where('value', 'like', "%{$q}%")
                    ->orWhere('reason', 'like', "%{$q}%");
            });
        }

        $items = $query->paginate(20)->withQueryString();

        return view('admin.blacklist.index', compact('items'));
    }

    public function destroy(Blacklist $blacklist)
    {
        $blacklist->delete();
        return back()->with('success', 'Kara listeden kaldırıldı.');
    }
}
