<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    // list users (Owner sees all; non-owner maybe limited — di sini Owner only list full)
    public function index()
    {
        // hanya Owner boleh melihat daftar user lengkap
        if (! auth()->user()->hasRole('Owner')) {
            abort(403);
        }

        $users = User::with('role')->orderBy('name')->paginate(20);
        return view('users.index', compact('users'));
    }

    // form create user (Owner only)
    public function create()
    {
        if (! auth()->user()->hasRole('Owner')) {
            abort(403);
        }

        $roles = Role::orderBy('name')->get();
        return view('users.create', compact('roles'));
    }

    // simpan user baru (Owner only)
    public function store(Request $request)
    {
        if (! auth()->user()->hasRole('Owner')) {
            abort(403);
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
            'role_id' => 'required|exists:roles,id',
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => bcrypt($validated['password']),
            'role_id' => $validated['role_id'],
        ]);

        return redirect()->route('users.index')->with('success', 'User berhasil dibuat.');
    }

    // show user detail (Owner or self)
    public function show(User $user)
    {
        $auth = auth()->user();
        if (! ($auth->hasRole('Owner') || $auth->id === $user->id)) {
            abort(403);
        }

        $user->load('role');
        return view('users.show', compact('user'));
    }

    // edit form (Owner or self)
    public function edit(User $user)
    {
        $auth = auth()->user();
        if (! ($auth->hasRole('Owner') || $auth->id === $user->id)) {
            abort(403);
        }

        $roles = Role::orderBy('name')->get();
        return view('users.edit', compact('user','roles'));
    }

    // update user (Owner can change role; self can change own name/email/password)
    public function update(Request $request, User $user)
    {
        $auth = auth()->user();
        if (! ($auth->hasRole('Owner') || $auth->id === $user->id)) {
            abort(403);
        }

        $rules = [
            'name' => 'required|string|max:255',
            'email' => ['required','email', Rule::unique('users','email')->ignore($user->id)],
        ];

        // Owner may change role
        if ($auth->hasRole('Owner')) {
            $rules['role_id'] = 'required|exists:roles,id';
        }

        // password optional
        if ($request->filled('password')) {
            $rules['password'] = 'nullable|string|min:6|confirmed';
        }

        $validated = $request->validate($rules);

        $user->name = $validated['name'];
        $user->email = $validated['email'];

        if (isset($validated['role_id']) && $auth->hasRole('Owner')) {
            $user->role_id = $validated['role_id'];
        }

        if ($request->filled('password')) {
            $user->password = bcrypt($request->input('password'));
        }

        $user->save();

        return redirect()->route('users.show', $user)->with('success', 'User berhasil diperbarui.');
    }

    // delete user (Owner only)
    public function destroy(User $user)
    {
        if (! auth()->user()->hasRole('Owner')) {
            abort(403);
        }

        // safety: tidak hapus diri sendiri
        if (auth()->id() === $user->id) {
            return redirect()->route('users.index')->with('error', 'Tidak dapat menghapus akun sendiri.');
        }

        $user->delete();

        return redirect()->route('users.index')->with('success', 'User berhasil dihapus.');
    }
}
