<?php

namespace App\Http\Controllers;

use App\Models\Stock;
use App\Models\Material;
use App\Models\Product;
use Illuminate\Http\Request;

class StockController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $stocks = Stock::with(['material','product'])->orderBy('id','desc')->paginate(30);
        return view('stocks.index', compact('stocks'));
    }

    public function create()
    {
        $user = auth()->user();
        if (! ($user->hasRole('Owner') || $user->hasRole('Admin') || $user->hasRole('Koordinator'))) {
            abort(403);
        }

        $materials = Material::orderBy('name')->get();
        $products = Product::orderBy('name')->get();

        return view('stocks.create', compact('materials','products'));
    }

    public function store(Request $request)
    {
        $user = auth()->user();
        if (! ($user->hasRole('Owner') || $user->hasRole('Admin') || $user->hasRole('Koordinator'))) {
            abort(403);
        }

        $validated = $request->validate([
            'material_id' => 'nullable|exists:materials,id',
            'product_id' => 'nullable|exists:products,id',
            'quantity' => 'required|integer',
            'type' => 'required|in:bahan,produk',
        ]);

        // ensure correct id present for type
        if ($validated['type'] === 'bahan' && empty($validated['material_id'])) {
            return back()->withInput()->withErrors(['material_id' => 'Pilih bahan untuk type bahan.']);
        }
        if ($validated['type'] === 'produk' && empty($validated['product_id'])) {
            return back()->withInput()->withErrors(['product_id' => 'Pilih product untuk type produk.']);
        }

        Stock::create($validated);

        // update juga nilai stock di materials/products agar sinkron
        if ($validated['type'] === 'bahan' && $validated['material_id']) {
            $material = Material::find($validated['material_id']);
            $material->stock = ($material->stock ?? 0) + $validated['quantity'];
            $material->save();
        } elseif ($validated['type'] === 'produk' && $validated['product_id']) {
            $product = Product::find($validated['product_id']);
            $product->stock = ($product->stock ?? 0) + $validated['quantity'];
            $product->save();
        }

        return redirect()->route('stocks.index')->with('success', 'Stock berhasil ditambahkan.');
    }

    public function show(Stock $stock)
    {
        return view('stocks.show', compact('stock'));
    }

    public function edit(Stock $stock)
    {
        $user = auth()->user();
        if (! ($user->hasRole('Owner') || $user->hasRole('Admin') || $user->hasRole('Koordinator'))) {
            abort(403);
        }

        $materials = Material::orderBy('name')->get();
        $products = Product::orderBy('name')->get();

        return view('stocks.edit', compact('stock','materials','products'));
    }

    public function update(Request $request, Stock $stock)
    {
        $user = auth()->user();
        if (! ($user->hasRole('Owner') || $user->hasRole('Admin') || $user->hasRole('Koordinator'))) {
            abort(403);
        }

        $validated = $request->validate([
            'material_id' => 'nullable|exists:materials,id',
            'product_id' => 'nullable|exists:products,id',
            'quantity' => 'required|integer',
            'type' => 'required|in:bahan,produk',
        ]);

        // adjust previous aggregate stock: rollback old and apply new
        if ($stock->type === 'bahan' && $stock->material_id) {
            $m = Material::find($stock->material_id);
            if ($m) { $m->stock = max(0, ($m->stock ?? 0) - $stock->quantity); $m->save(); }
        }
        if ($stock->type === 'produk' && $stock->product_id) {
            $p = Product::find($stock->product_id);
            if ($p) { $p->stock = max(0, ($p->stock ?? 0) - $stock->quantity); $p->save(); }
        }

        $stock->update($validated);

        // apply new quantity
        if ($validated['type'] === 'bahan' && $validated['material_id']) {
            $material = Material::find($validated['material_id']);
            $material->stock = ($material->stock ?? 0) + $validated['quantity'];
            $material->save();
        } elseif ($validated['type'] === 'produk' && $validated['product_id']) {
            $product = Product::find($validated['product_id']);
            $product->stock = ($product->stock ?? 0) + $validated['quantity'];
            $product->save();
        }

        return redirect()->route('stocks.index')->with('success', 'Stock berhasil diupdate.');
    }

    public function destroy(Stock $stock)
    {
        $user = auth()->user();
        if (! ($user->hasRole('Owner') || $user->hasRole('Admin') || $user->hasRole('Koordinator'))) {
            abort(403);
        }

        // rollback stock aggregate
        if ($stock->type === 'bahan' && $stock->material_id) {
            $m = Material::find($stock->material_id);
            if ($m) { $m->stock = max(0, ($m->stock ?? 0) - $stock->quantity); $m->save(); }
        }
        if ($stock->type === 'produk' && $stock->product_id) {
            $p = Product::find($stock->product_id);
            if ($p) { $p->stock = max(0, ($p->stock ?? 0) - $stock->quantity); $p->save(); }
        }

        $stock->delete();

        return redirect()->route('stocks.index')->with('success', 'Stock berhasil dihapus.');
    }
}
