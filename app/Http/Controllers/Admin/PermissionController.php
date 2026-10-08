<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{
    public function index()
    {
        return Inertia::render('Admin/Permissions', [
            'permissions' => Permission::latest()->get(),
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:permissions,name',
        ]);

        Permission::create(['name' => strtolower($request->name)]);

        return back()->with('success', 'Fitur akses (permission) berhasil ditambahkan.');
    }

    public function update(Request $request, Permission $permission)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:permissions,name,'.$permission->id,
        ]);

        $permission->update(['name' => strtolower($request->name)]);

        return back()->with('success', 'Fitur akses (permission) berhasil diperbarui.');
    }

    public function destroy(Permission $permission)
    {
        $permission->delete();

        return back()->with('success', 'Fitur akses (permission) berhasil dihapus.');
    }
}