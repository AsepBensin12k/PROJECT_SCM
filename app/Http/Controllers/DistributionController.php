<?php

namespace App\Http\Controllers;

use App\Models\Distribution;
use App\Models\Product;
use Illuminate\Http\Request;

class DistributionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $distributions = Distribution::with(['user','product'])->orderBy('created_at','desc')->paginate(30);
        return view('distributions.index', compact('distributions'));
    }

    public function create()
    {
        $user = auth()->user();
        if (! ($user->hasRole('Owner') || $user->hasRole('Koordinator'))) {
            abort(403);
        }

        $products = Product::orderBy('name')->get();
        return view('distributions.create', compact('products'));
    }

    public function store(Request $request)
    {
        $user = auth()->user();
        if (! ($user->hasRole('Owner') || $user->hasRole('Koordinator'))) {
            abort(403);
        }

        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'destination' => 'required|string|max:255',
            'quantity' => 'required|integer|min:1',
            'status' => 'required|in:diproses,dikirim,dibatalkan',
        ]);

        $product = Product::find($validated['product_id']);
        if ($product->stock < $validated['quantity']) {
            return back()->withInput()->withErrors(['quantity' => 'Stok produk tidak mencukupi.']);
        }

        $distribution = Distribution::create([
            'user_id' => $user->id,
            'product_id' => $validated['product_id'],
            'destination' => $validated['destination'],
            'quantity' => $validated['quantity'],
            'status' => $validated['status'],
        ]);

        // reduce product stock when distribution recorded & status is diproses or dikirim
        if (in_array($validated['status'], ['diproses','dikirim'])) {
            $product->stock = max(0, $product->stock - $validated['quantity']);
            $product->save();
        }

        return redirect()->route('distributions.index')->with('success', 'Distribusi berhasil dicatat.');
    }

    public function show(Distribution $distribution)
    {
        $distribution->load('user','product');
        return view('distributions.show', compact('distribution'));
    }

    public function edit(Distribution $distribution)
    {
        $user = auth()->user();
        if (! ($user->hasRole('Owner') || $user->hasRole('Koordinator'))) {
            abort(403);
        }

        $products = Product::orderBy('name')->get();
        return view('distributions.edit', compact('distribution','products'));
    }

    public function update(Request $request, Distribution $distribution)
    {
        $user = auth()->user();
        if (! ($user->hasRole('Owner') || $user->hasRole('Koordinator'))) {
            abort(403);
        }

        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'destination' => 'required|string|max:255',
            'quantity' => 'required|integer|min:1',
            'status' => 'required|in:diproses,dikirim,dibatalkan',
        ]);

        $oldProduct = Product::find($distribution->product_id);
        // rollback old quantity if previously reduced
        if (in_array($distribution->status, ['diproses','dikirim']) && $oldProduct) {
            $oldProduct->stock = ($oldProduct->stock ?? 0) + $distribution->quantity;
            $oldProduct->save();
        }

        $distribution->update($validated);

        $newProduct = Product::find($validated['product_id']);
        if (in_array($validated['status'], ['diproses','dikirim']) && $newProduct) {
            if ($newProduct->stock < $validated['quantity']) {
                return back()->withInput()->withErrors(['quantity' => 'Stok produk tidak mencukupi untuk update.']);
            }
            $newProduct->stock = max(0, $newProduct->stock - $validated['quantity']);
            $newProduct->save();
        }

        return redirect()->route('distributions.index')->with('success', 'Distribusi berhasil diupdate.');
    }

    public function destroy(Distribution $distribution)
    {
        $user = auth()->user();
        if (! ($user->hasRole('Owner') || $user->hasRole('Koordinator'))) {
            abort(403);
        }

        // rollback stock if previously reduced
        if (in_array($distribution->status, ['diproses','dikirim'])) {
            $product = Product::find($distribution->product_id);
            if ($product) {
                $product->stock = ($product->stock ?? 0) + $distribution->quantity;
                $product->save();
            }
        }

        $distribution->delete();

        return redirect()->route('distributions.index')->with('success', 'Distribusi berhasil dihapus.');
    }
}
