<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $products = Product::orderBy('name')->paginate(20);
        return view('products.index', compact('products'));
    }

    public function create()
    {
        $user = auth()->user();
        if (! ($user->hasRole('Owner') || $user->hasRole('Admin') || $user->hasRole('Koordinator'))) {
            abort(403);
        }

        return view('products.create');
    }

    public function store(Request $request)
    {
        $user = auth()->user();
        if (! ($user->hasRole('Owner') || $user->hasRole('Admin') || $user->hasRole('Koordinator'))) {
            abort(403);
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'nullable|numeric|min:0',
            'stock' => 'nullable|integer|min:0',
        ]);

        Product::create($validated);

        return redirect()->route('products.index')->with('success', 'Product berhasil dibuat.');
    }

    public function show(Product $product)
    {
        $product->load('stocks', 'productions', 'distributions');
        return view('products.show', compact('product'));
    }

    public function edit(Product $product)
    {
        $user = auth()->user();
        if (! ($user->hasRole('Owner') || $user->hasRole('Admin') || $user->hasRole('Koordinator'))) {
            abort(403);
        }

        return view('products.edit', compact('product'));
    }

    public function update(Request $request, Product $product)
    {
        $user = auth()->user();
        if (! ($user->hasRole('Owner') || $user->hasRole('Admin') || $user->hasRole('Koordinator'))) {
            abort(403);
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'nullable|numeric|min:0',
            'stock' => 'nullable|integer|min:0',
        ]);

        $product->update($validated);

        return redirect()->route('products.show', $product)->with('success', 'Product berhasil diupdate.');
    }

    public function destroy(Product $product)
    {
        $user = auth()->user();
        if (! ($user->hasRole('Owner') || $user->hasRole('Admin') || $user->hasRole('Koordinator'))) {
            abort(403);
        }

        $product->delete();

        return redirect()->route('products.index')->with('success', 'Product berhasil dihapus.');
    }
}
