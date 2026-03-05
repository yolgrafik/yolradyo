<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
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

    public function edit(User $user): View
    {
        return view('admin.members.edit', compact('user'));
    }

    public function update(Request $request, User $user): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'status' => 'required|string|in:pending,approved,rejected',
            'password' => ['nullable', 'confirmed', Password::min(8)],
        ]);

        $user->name = $validated['name'];
        $user->email = $validated['email'];
        $user->status = $validated['status'];

        if (filled($validated['password'] ?? '')) {
            $user->password = Hash::make($validated['password']);
        }

        $user->save();

        return redirect()->route('admin.members.index')->with('success', 'Üye güncellendi.');
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
