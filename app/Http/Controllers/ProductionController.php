<?php

namespace App\Http\Controllers;

use App\Models\Production;
use App\Models\Material;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $productions = Production::with(['user','material','product'])->orderBy('production_date','desc')->paginate(30);
        return view('productions.index', compact('productions'));
    }

    public function create()
    {
        $user = auth()->user();
        if (! ($user->hasRole('Owner') || $user->hasRole('Koordinator'))) {
            abort(403);
        }

        $materials = Material::orderBy('name')->get();
        $products = Product::orderBy('name')->get();

        return view('productions.create', compact('materials','products'));
    }

    public function store(Request $request)
    {
        $user = auth()->user();
        if (! ($user->hasRole('Owner') || $user->hasRole('Koordinator'))) {
            abort(403);
        }

        $validated = $request->validate([
            'material_id' => 'required|exists:materials,id',
            'product_id' => 'required|exists:products,id',
            'quantity_used' => 'required|integer|min:1',
            'quantity_produced' => 'required|integer|min:0',
            'production_date' => 'required|date',
        ]);

        // check material stock available
        $material = Material::find($validated['material_id']);
        if ($material->stock < $validated['quantity_used']) {
            return back()->withInput()->withErrors(['quantity_used' => 'Stok bahan tidak mencukupi.']);
        }

        // create production
        $production = Production::create([
            'user_id' => $user->id,
            'material_id' => $validated['material_id'],
            'product_id' => $validated['product_id'],
            'quantity_used' => $validated['quantity_used'],
            'quantity_produced' => $validated['quantity_produced'],
            'production_date' => $validated['production_date'],
        ]);

        // adjust stocks
        $material->stock = max(0, $material->stock - $validated['quantity_used']);
        $material->save();

        $product = Product::find($validated['product_id']);
        $product->stock = ($product->stock ?? 0) + $validated['quantity_produced'];
        $product->save();

        return redirect()->route('productions.index')->with('success', 'Produksi berhasil dicatat.');
    }

    public function show(Production $production)
    {
        $production->load('user','material','product');
        return view('productions.show', compact('production'));
    }

    public function edit(Production $production)
    {
        $user = auth()->user();
        if (! ($user->hasRole('Owner') || $user->hasRole('Koordinator'))) {
            abort(403);
        }

        $materials = Material::orderBy('name')->get();
        $products = Product::orderBy('name')->get();

        return view('productions.edit', compact('production','materials','products'));
    }

    public function update(Request $request, Production $production)
    {
        $user = auth()->user();
        if (! ($user->hasRole('Owner') || $user->hasRole('Koordinator'))) {
            abort(403);
        }

        $validated = $request->validate([
            'material_id' => 'required|exists:materials,id',
            'product_id' => 'required|exists:products,id',
            'quantity_used' => 'required|integer|min:1',
            'quantity_produced' => 'required|integer|min:0',
            'production_date' => 'required|date',
        ]);

        // rollback previous stock effects
        $oldMaterial = Material::find($production->material_id);
        if ($oldMaterial) {
            $oldMaterial->stock = max(0, ($oldMaterial->stock ?? 0) + $production->quantity_used);
            $oldMaterial->save();
        }
        $oldProduct = Product::find($production->product_id);
        if ($oldProduct) {
            $oldProduct->stock = max(0, ($oldProduct->stock ?? 0) - $production->quantity_produced);
            $oldProduct->save();
        }

        // check new material stock
        $newMaterial = Material::find($validated['material_id']);
        if ($newMaterial->stock < $validated['quantity_used']) {
            return back()->withInput()->withErrors(['quantity_used' => 'Stok bahan tidak mencukupi untuk update.']);
        }

        // update production
        $production->update([
            'material_id' => $validated['material_id'],
            'product_id' => $validated['product_id'],
            'quantity_used' => $validated['quantity_used'],
            'quantity_produced' => $validated['quantity_produced'],
            'production_date' => $validated['production_date'],
        ]);

        // apply new stock changes
        $newMaterial->stock = max(0, $newMaterial->stock - $validated['quantity_used']);
        $newMaterial->save();

        $newProduct = Product::find($validated['product_id']);
        $newProduct->stock = ($newProduct->stock ?? 0) + $validated['quantity_produced'];
        $newProduct->save();

        return redirect()->route('productions.index')->with('success', 'Produksi berhasil diupdate.');
    }

    public function destroy(Production $production)
    {
        $user = auth()->user();
        if (! ($user->hasRole('Owner') || $user->hasRole('Koordinator'))) {
            abort(403);
        }

        // rollback stock effect
        $material = Material::find($production->material_id);
        if ($material) {
            $material->stock = ($material->stock ?? 0) + $production->quantity_used;
            $material->save();
        }

        $product = Product::find($production->product_id);
        if ($product) {
            $product->stock = max(0, ($product->stock ?? 0) - $production->quantity_produced);
            $product->save();
        }

        $production->delete();

        return redirect()->route('productions.index')->with('success', 'Produksi berhasil dihapus.');
    }
}
