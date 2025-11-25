<?php

namespace App\Http\Controllers;

use App\Models\Material;
use App\Models\Supplier;
use Illuminate\Http\Request;

class MaterialController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $materials = Material::with('supplier')->orderBy('name')->paginate(20);
        return view('materials.index', compact('materials'));
    }

    public function create()
    {
        $user = auth()->user();
        if (! ($user->hasRole('Owner') || $user->hasRole('Admin') || $user->hasRole('Koordinator'))) {
            abort(403);
        }

        $suppliers = Supplier::orderBy('name')->get();
        return view('materials.create', compact('suppliers'));
    }

    public function store(Request $request)
    {
        $user = auth()->user();
        if (! ($user->hasRole('Owner') || $user->hasRole('Admin') || $user->hasRole('Koordinator'))) {
            abort(403);
        }

        $validated = $request->validate([
            'supplier_id' => 'required|exists:suppliers,id',
            'name' => 'required|string|max:255',
            'unit' => 'required|string|max:50',
            'stock' => 'nullable|integer|min:0',
            'price' => 'nullable|numeric|min:0',
        ]);

        Material::create($validated);

        return redirect()->route('materials.index')->with('success', 'Material berhasil dibuat.');
    }

    public function show(Material $material)
    {
        $material->load('supplier', 'stocks', 'productions');
        return view('materials.show', compact('material'));
    }

    public function edit(Material $material)
    {
        $user = auth()->user();
        if (! ($user->hasRole('Owner') || $user->hasRole('Admin') || $user->hasRole('Koordinator'))) {
            abort(403);
        }

        $suppliers = Supplier::orderBy('name')->get();
        return view('materials.edit', compact('material','suppliers'));
    }

    public function update(Request $request, Material $material)
    {
        $user = auth()->user();
        if (! ($user->hasRole('Owner') || $user->hasRole('Admin') || $user->hasRole('Koordinator'))) {
            abort(403);
        }

        $validated = $request->validate([
            'supplier_id' => 'required|exists:suppliers,id',
            'name' => 'required|string|max:255',
            'unit' => 'required|string|max:50',
            'stock' => 'nullable|integer|min:0',
            'price' => 'nullable|numeric|min:0',
        ]);

        $material->update($validated);

        return redirect()->route('materials.show', $material)->with('success', 'Material berhasil diupdate.');
    }

    public function destroy(Material $material)
    {
        $user = auth()->user();
        if (! ($user->hasRole('Owner') || $user->hasRole('Admin') || $user->hasRole('Koordinator'))) {
            abort(403);
        }

        $material->delete();

        return redirect()->route('materials.index')->with('success', 'Material berhasil dihapus.');
    }
}
