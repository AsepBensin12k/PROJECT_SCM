<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class RoleController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    // list semua role
    public function index()
    {
        $roles = Role::orderBy('name')->get();
        return view('roles.index', compact('roles'));
    }

    // tampilkan form create
    public function create()
    {
        // hanya Owner boleh create
        if (! auth()->user()->hasRole('Owner')) {
            abort(403);
        }

        return view('roles.create');
    }

    // simpan role baru
    public function store(Request $request)
    {
        if (! auth()->user()->hasRole('Owner')) {
            abort(403);
        }

        $validated = $request->validate([
            'name' => 'required|string|max:100|unique:roles,name',
            'description' => 'nullable|string',
        ]);

        Role::create($validated);

        return redirect()->route('roles.index')->with('success', 'Role berhasil dibuat.');
    }

    // tampilkan detail role
    public function show(Role $role)
    {
        return view('roles.show', compact('role'));
    }

    // form edit role
    public function edit(Role $role)
    {
        if (! auth()->user()->hasRole('Owner')) {
            abort(403);
        }

        return view('roles.edit', compact('role'));
    }

    // update role
    public function update(Request $request, Role $role)
    {
        if (! auth()->user()->hasRole('Owner')) {
            abort(403);
        }

        $validated = $request->validate([
            'name' => ['required','string','max:100', Rule::unique('roles','name')->ignore($role->id)],
            'description' => 'nullable|string',
        ]);

        $role->update($validated);

        return redirect()->route('roles.index')->with('success', 'Role berhasil diupdate.');
    }

    // hapus role
    public function destroy(Role $role)
    {
        if (! auth()->user()->hasRole('Owner')) {
            abort(403);
        }

        // safety: jangan hapus Owner saat masih ada user dengan role Owner
        if ($role->name === 'Owner' && $role->users()->count() > 0) {
            return redirect()->route('roles.index')->with('error', 'Tidak dapat menghapus role Owner yang masih memiliki user.');
        }

        $role->delete();

        return redirect()->route('roles.index')->with('success', 'Role berhasil dihapus.');
    }
}
