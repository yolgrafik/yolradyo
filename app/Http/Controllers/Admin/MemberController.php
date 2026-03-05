<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class MemberController extends Controller
{
    public function index(Request $request): View
    {
        $query = User::query()->orderBy('created_at', 'desc');

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('q')) {
            $q = $request->q;
            $query->where(function ($qry) use ($q) {
                $qry->where('name', 'like', "%{$q}%")
                    ->orWhere('email', 'like', "%{$q}%");
            });
        }

        $members = $query->paginate(20)->withQueryString();

        return view('admin.members.index', compact('members'));
    }

    public function approve(User $user): RedirectResponse
    {
        $user->update(['status' => 'approved']);
        return back()->with('success', 'Üye onaylandı.');
    }

    public function reject(User $user): RedirectResponse
    {
        $user->update(['status' => 'rejected']);
        return back()->with('success', 'Üye reddedildi.');
    }

    public function deactivate(User $user): RedirectResponse
    {
        $user->update(['status' => 'pending']);
        return back()->with('success', 'Üye pasif yapıldı.');
    }

    public function destroy(User $user): RedirectResponse
    {
        $user->delete();
        return back()->with('success', 'Üye silindi.');
    }
}
