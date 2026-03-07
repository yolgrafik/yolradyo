<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\ActivityLogger;
use App\Http\Controllers\Controller;
use App\Models\Permission;
use App\Models\Role;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function index()
    {
        $roles = Role::withCount('admins')->orderBy('name')->paginate(20);
        return view('admin.roles.index', compact('roles'));
    }

    public function create()
    {
        $permissions = Permission::orderBy('key')->get();
        return view('admin.roles.create', compact('permissions'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:roles,name',
            'permissions' => 'nullable|array',
            'permissions.*' => 'exists:permissions,id',
        ]);

        $role = Role::create(['name' => $validated['name']]);
        $role->permissions()->sync($validated['permissions'] ?? []);

        ActivityLogger::log('role.created', ['role_id' => $role->id, 'name' => $role->name]);

        return redirect()->route('admin.roles.index')->with('success', 'Rol olusturuldu.');
    }

    public function edit(Role $role)
    {
        $permissions = Permission::orderBy('key')->get();
        $role->load('permissions');
        return view('admin.roles.edit', compact('role', 'permissions'));
    }

    public function update(Request $request, Role $role)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:roles,name,' . $role->id,
            'permissions' => 'nullable|array',
            'permissions.*' => 'exists:permissions,id',
        ]);

        $role->name = $validated['name'];
        $role->save();
        $role->permissions()->sync($validated['permissions'] ?? []);

        ActivityLogger::log('role.updated', ['role_id' => $role->id, 'name' => $role->name]);

        return redirect()->route('admin.roles.index')->with('success', 'Rol guncellendi.');
    }

    public function destroy(Role $role)
    {
        if ($role->admins()->exists()) {
            return back()->with('error', 'Bu role atanmis yoneticiler var. Once onlari baska role tasiyin.');
        }
        $name = $role->name;
        $role->delete();
        ActivityLogger::log('role.deleted', ['name' => $name]);
        return redirect()->route('admin.roles.index')->with('success', 'Rol silindi.');
    }
}
