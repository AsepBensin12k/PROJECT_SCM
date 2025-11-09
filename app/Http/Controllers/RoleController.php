<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class RoleController extends Controller
{
    public function __construct()
    {
        // semua method butuh auth
        $this->middleware('auth');
    }

    /**
     * Display a listing of the roles.
     */
    public function index()
    {
        $roles = Role::orderBy('name')->get();
        // backend-only: return json or you can return view later
        return response()->json(['data' => $roles], 200);
    }

    /**
     * Store a newly created role in storage.
     */
    public function store(Request $request)
    {
        // owner-only
        $user = $request->user();
        if (! $user || ! $user->hasRole('Owner')) {
            return response()->json(['message' => 'Forbidden'], 403);
        }

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:100', 'unique:roles,name'],
            'description' => ['nullable', 'string'],
        ]);

        $role = Role::create($validated);

        return response()->json(['message' => 'Role created', 'data' => $role], 201);
    }

    /**
     * Display the specified role.
     */
    public function show(Role $role)
    {
        return response()->json(['data' => $role], 200);
    }

    /**
     * Update the specified role in storage.
     */
    public function update(Request $request, Role $role)
    {
        // owner-only
        $user = $request->user();
        if (! $user || ! $user->hasRole('Owner')) {
            return response()->json(['message' => 'Forbidden'], 403);
        }

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:100', Rule::unique('roles', 'name')->ignore($role->id)],
            'description' => ['nullable', 'string'],
        ]);

        $role->update($validated);

        return response()->json(['message' => 'Role updated', 'data' => $role], 200);
    }

    /**
     * Remove the specified role from storage.
     */
    public function destroy(Request $request, Role $role)
    {
        // owner-only
        $user = $request->user();
        if (! $user || ! $user->hasRole('Owner')) {
            return response()->json(['message' => 'Forbidden'], 403);
        }

        // optional safety: prevent deleting Owner role itself if users exist
        if ($role->name === 'Owner' && $role->users()->count() > 0) {
            return response()->json(['message' => 'Cannot delete Owner role while users exist with this role'], 400);
        }

        $role->delete();

        return response()->json(['message' => 'Role deleted'], 200);
    }
}
