<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    // index: Owner/Admin/Koordinator bisa lihat; kita izinkan semua auth
    public function index()
    {
        $suppliers = Supplier::orderBy('name')->paginate(20);
        return view('suppliers.index', compact('suppliers'));
    }

    public function create()
    {
        // Owner & Admin boleh create (Owner + Admin presumed)
        $user = auth()->user();
        if (! ($user->hasRole('Owner') || $user->hasRole('Admin'))) {
            abort(403);
        }

        return view('suppliers.create');
    }

    public function store(Request $request)
    {
        $user = auth()->user();
        if (! ($user->hasRole('Owner') || $user->hasRole('Admin'))) {
            abort(403);
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'origin' => 'nullable|string|max:255',
            'contact' => 'nullable|string|max:100',
        ]);

        Supplier::create($validated);

        return redirect()->route('suppliers.index')->with('success', 'Supplier berhasil dibuat.');
    }

    public function show(Supplier $supplier)
    {
        return view('suppliers.show', compact('supplier'));
    }

    public function edit(Supplier $supplier)
    {
        $user = auth()->user();
        if (! ($user->hasRole('Owner') || $user->hasRole('Admin'))) {
            abort(403);
        }

        return view('suppliers.edit', compact('supplier'));
    }

    public function update(Request $request, Supplier $supplier)
    {
        $user = auth()->user();
        if (! ($user->hasRole('Owner') || $user->hasRole('Admin'))) {
            abort(403);
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'origin' => 'nullable|string|max:255',
            'contact' => 'nullable|string|max:100',
        ]);

        $supplier->update($validated);

        return redirect()->route('suppliers.index')->with('success', 'Supplier berhasil diupdate.');
    }

    public function destroy(Supplier $supplier)
    {
        $user = auth()->user();
        if (! ($user->hasRole('Owner') || $user->hasRole('Admin'))) {
            abort(403);
        }

        $supplier->delete();

        return redirect()->route('suppliers.index')->with('success', 'Supplier berhasil dihapus.');
    }
}
