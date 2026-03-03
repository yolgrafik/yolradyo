<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\ActivityLogger;
use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class AdminUserController extends Controller
{
    public function index()
    {
        $admins = Admin::with('role')->orderBy('name')->paginate(20);
        return view('admin.users.index', compact('admins'));
    }

    public function create()
    {
        $roles = Role::orderBy('name')->get();
        return view('admin.users.create', compact('roles'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:admins,email',
            'password' => ['required', 'confirmed', Password::min(8)],
            'role_id' => 'nullable|exists:roles,id',
            'is_active' => 'nullable|boolean',
        ]);

        $admin = Admin::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role_id' => $validated['role_id'] ?? null,
            'is_active' => (bool) ($validated['is_active'] ?? true),
        ]);

        ActivityLogger::log('admin.created', ['admin_id' => $admin->id, 'email' => $admin->email]);

        return redirect()->route('admin.users.index')->with('success', 'Yonetici olusturuldu.');
    }

    public function edit(Admin $user)
    {
        $roles = Role::orderBy('name')->get();
        return view('admin.users.edit', compact('user', 'roles'));
    }

    public function update(Request $request, Admin $user)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:admins,email,' . $user->id,
            'password' => ['nullable', 'confirmed', Password::min(8)],
            'role_id' => 'nullable|exists:roles,id',
            'is_active' => 'nullable|boolean',
        ]);

        $user->name = $validated['name'];
        $user->email = $validated['email'];
        $user->role_id = $validated['role_id'] ?? null;
        $user->is_active = (bool) ($validated['is_active'] ?? true);
        if (!empty($validated['password'])) {
            $user->password = Hash::make($validated['password']);
        }
        $user->save();

        ActivityLogger::log('admin.updated', ['admin_id' => $user->id, 'email' => $user->email]);

        return redirect()->route('admin.users.index')->with('success', 'Yonetici guncellendi.');
    }

    public function destroy(Admin $user)
    {
        if ($user->id === (int) session('admin_id')) {
            return back()->with('error', 'Kendinizi silemezsiniz.');
        }
        $email = $user->email;
        $user->delete();
        ActivityLogger::log('admin.deleted', ['email' => $email]);
        return redirect()->route('admin.users.index')->with('success', 'Yonetici silindi.');
    }

    public function toggle(Admin $user)
    {
        if ($user->id === (int) session('admin_id')) {
            return back()->with('error', 'Kendinizi devre disi birakamazsiniz.');
        }
        $user->is_active = !$user->is_active;
        $user->save();
        $status = $user->is_active ? 'aktif' : 'pasif';
        ActivityLogger::log('admin.toggled', ['admin_id' => $user->id, 'is_active' => $user->is_active]);
        return back()->with('success', "Yonetici {$status} yapildi.");
    }
}
