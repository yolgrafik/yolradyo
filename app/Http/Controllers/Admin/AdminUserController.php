<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\ActivityLogger;
use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class AdminUserController extends Controller
{
    protected string $avatarDir = 'uploads/avatars';

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
            'avatar' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'role_id' => 'nullable|exists:roles,id',
            'is_active' => 'nullable|boolean',
        ]);

        $avatarPath = $request->hasFile('avatar')
            ? $this->handleAvatarUpload($request->file('avatar'))
            : null;

        $admin = Admin::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'avatar_path' => $avatarPath,
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
            'avatar' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'remove_avatar' => 'nullable|boolean',
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

        if (!empty($validated['remove_avatar']) || $request->hasFile('avatar')) {
            $this->deleteAvatarFile($user->avatar_path);
            $user->avatar_path = null;
        }
        if ($request->hasFile('avatar')) {
            $user->avatar_path = $this->handleAvatarUpload($request->file('avatar'));
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
        $this->deleteAvatarFile($user->avatar_path);
        $email = $user->email;
        $user->delete();
        ActivityLogger::log('admin.deleted', ['email' => $email]);
        return redirect()->route('admin.users.index')->with('success', 'Yonetici silindi.');
    }

    public function removeAvatar(Admin $user)
    {
        $this->deleteAvatarFile($user->avatar_path);
        $user->avatar_path = null;
        $user->save();
        ActivityLogger::log('admin.avatar_removed', ['admin_id' => $user->id]);
        return back()->with('success', 'Profil resmi kaldirildi.');
    }

    protected function handleAvatarUpload($file): string
    {
        $dir = public_path($this->avatarDir);
        if (!File::isDirectory($dir)) {
            File::makeDirectory($dir, 0755, true);
        }
        $name = uniqid() . '_' . preg_replace('/[^a-zA-Z0-9._-]/', '', $file->getClientOriginalName());
        $file->move($dir, $name);
        return $this->avatarDir . '/' . $name;
    }

    protected function deleteAvatarFile(?string $path): void
    {
        if ($path && File::exists(public_path($path))) {
            File::delete(public_path($path));
        }
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
