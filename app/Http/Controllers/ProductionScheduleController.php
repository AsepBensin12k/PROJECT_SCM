<?php

namespace App\Http\Controllers;

use App\Models\{Production, Product, Material, ProductionMaterial};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class ProductionScheduleController extends Controller
{
    // 📜 INDEX
    public function index()
    {
        $productions = Production::with(['product', 'materials'])
            ->orderBy('production_date', 'desc')
            ->get();

        $activeMenu = 'productions';

        return view('koordinator.manajemenproduksi.index', compact('productions', 'activeMenu'));
    }

    // ➕ CREATE
    public function create()
    {
        $products = Product::all();
        $materials = Material::all();
        $activeMenu = 'productions';
        return view('koordinator.manajemenproduksi.create', compact('products', 'materials', 'activeMenu'));
    }

    // 💾 STORE
    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'production_date' => 'required|date',
            'materials' => 'required|array|min:1',
            'materials.*.id' => 'required|exists:materials,id|distinct',
            'materials.*.qty' => 'required|numeric|min:1',
            'quantity_produced' => 'required|numeric|min:1'
        ]);

        $latest = Production::latest()->first();
        $nextNumber = $latest ? ((int) Str::of($latest->code)->replace('PRD', '')) + 1 : 1;
        $code = 'PRD' . str_pad($nextNumber, 3, '0', STR_PAD_LEFT);

        $production = Production::create([
            'code' => $code,
            'user_id' => Auth::id(),
            'product_id' => $request->product_id,
            'quantity_produced' => $request->quantity_produced,
            'production_date' => $request->production_date,
            'operator' => 'Bagian Produksi',
            'status' => 'pending',
        ]);

        foreach ($request->materials as $mat) {
            ProductionMaterial::create([
                'production_id' => $production->id,
                'material_id' => $mat['id'],
                'quantity_used' => $mat['qty'],
            ]);
        }

        return redirect()->route('koordinator.productions.index')->with('success', 'Jadwal produksi berhasil ditambahkan!');
    }

    // 🔍 SHOW
    public function show($id)
    {
        $production = Production::with(['product', 'materials'])->findOrFail($id);
        $activeMenu = 'productions';
        return view('koordinator.manajemenproduksi.show', compact('production', 'activeMenu'));
    }

    // ⚙️ UPDATE STATUS
    public function updateStatus(Request $request, $id)
    {
        $request->validate(['status' => 'required|in:pending,sedang_diproduksi,selesai,dibatalkan']);

        $production = Production::findOrFail($id);
        $oldStatus = $production->status;
        $newStatus = $request->status;

        if ($oldStatus === 'selesai') {
            return back()->with('error', 'Produksi yang sudah selesai tidak dapat diubah lagi!');
        }

        $production->update(['status' => $newStatus]);

        if ($oldStatus !== 'sedang_diproduksi' && $newStatus === 'sedang diproduksi') {
            foreach ($production->materials as $mat) {
                $material = Material::find($mat->id);
                if ($material) {
                    $material->decrement('stock', $mat->pivot->quantity_used);
                }
            }
        }

        if ($oldStatus !== 'selesai' && $newStatus === 'selesai') {
            $product = $production->product;
            $product->increment('stock', $production->quantity_produced);
        }

        return back()->with('success', 'Status produksi berhasil diperbarui!');
    }
}
