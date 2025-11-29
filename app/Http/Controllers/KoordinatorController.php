<?php

namespace App\Http\Controllers;

use App\Models\Material;
use App\Models\Product;
use App\Models\Distribution;
use App\Models\Stock;
use App\Models\Procurement;
use App\Models\Production;
use App\Models\Supplier;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KoordinatorController extends Controller
{
    public function index()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        // Data untuk dashboard
        $materials = Material::with('supplier')->get();
        $products = Product::with('stocks')->get();
        $lowStockMaterials = Material::where('stock', '<', 30)->get();
        $outOfStockMaterials = Material::where('stock', 0)->get();

        // Jadwal produksi minggu ini - PERBAIKAN
        $productionSchedule = Production::with(['product', 'materials', 'user'])
            ->whereBetween('production_date', [now()->startOfWeek(), now()->endOfWeek()])
            ->orderBy('production_date')
            ->orderBy('created_at')
            ->get();

        // Statistik
        $totalMaterials = Material::count();
        $totalProducts = Product::count();
        $totalLowStock = $lowStockMaterials->count();
        $totalOutOfStock = $outOfStockMaterials->count();

        return view('koordinator.dashboardkoordinator.index', compact(
            'materials',
            'products',
            'lowStockMaterials',
            'outOfStockMaterials',
            'productionSchedule',
            'totalMaterials',
            'totalProducts',
            'totalLowStock',
            'totalOutOfStock'
        ));
    }

    // 🧾 PENGADAAN BAHAN BAKU (PROCUREMENT) =====================================
    public function procurements()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $procurements = Procurement::with(['material', 'supplier'])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('koordinator.manajemen-pengadaan.index', compact('procurements'));
    }

    public function createProcurement()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $materials = Material::all();
        $suppliers = Supplier::all();

        return view('koordinator.manajemen-pengadaan.create', compact('materials', 'suppliers'));
    }

    public function storeProcurement(Request $request)
    {
        $request->validate([
        'material_id' => 'required|exists:materials,id',
        'supplier_id' => 'required|exists:suppliers,id',
        'tanggal_datang' => 'required|date',
        'qty' => 'required|integer|min:1',
    ]);

        // Ambil data harga dari material
        $material = \App\Models\Material::findOrFail($request->material_id);
        $total_harga = $material->price * $request->qty;

        // Simpan data pengadaan
        \App\Models\Procurement::create([
            'material_id' => $request->material_id,
            'supplier_id' => $request->supplier_id,
            'tanggal_datang' => $request->tanggal_datang,
            'qty' => $request->qty,
            'total_harga' => $total_harga,
            'status' => 'diproses', // default status otomatis
        ]);

        return redirect()->route('koordinator.procurements')->with('success', 'Pengadaan berhasil ditambahkan!');
    }


    public function editProcurement($id)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $procurement = Procurement::with(['material', 'supplier'])->findOrFail($id);
        $materials = Material::all();
        $suppliers = Supplier::all();

        return view('koordinator.manajemen-pengadaan.edit', compact('procurement', 'materials', 'suppliers'));
    }

    public function updateProcurement(Request $request, $id)
    {
        $request->validate([
        'material_id' => 'required|exists:materials,id',
        'supplier_id' => 'required|exists:suppliers,id',
        'tanggal_datang' => 'required|date',
        'qty' => 'required|integer|min:1',
        'status' => 'required|in:diproses,dikirim,sampai,dibatalkan',
    ]);


        $procurement = Procurement::findOrFail($id);
        $oldStatus = $procurement->status;
        $procurement->update($request->all());

        // 🧮 Jika status berubah jadi "sampai", stok bahan baku bertambah
        if ($oldStatus !== 'sampai' && $request->status === 'sampai') {
            $material = Material::find($procurement->material_id);
            if ($material) {
                $material->increment('stock', $procurement->qty);

                // Simpan log stok
                Stock::create([
                    'material_id' => $material->id,
                    'quantity' => $procurement->qty,
                    'type' => 'in',
                    'source' => 'procurement',
                    'notes' => 'Stok masuk dari pengadaan bahan baku oleh supplier ' . $procurement->supplier->name,
                ]);
            }
        }

        return redirect()->route('koordinator.procurements')
            ->with('success', 'Data pengadaan berhasil diperbarui!');
    }

    public function destroyProcurement($id)
    {
        $procurement = Procurement::findOrFail($id);
        $procurement->delete();

        return redirect()->route('koordinator.procurements')
            ->with('success', 'Data pengadaan berhasil dihapus!');
    }


    // MANAJEMEN PRODUKSI - INDEX
    public function production()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $productions = Production::with(['product', 'material', 'user'])
            ->orderBy('production_date', 'desc')
            ->get();

        return view('koordinator.manajemenproduksi.index', compact('productions'));
    }

    // 🏭 MANAJEMEN PRODUKSI - CREATE
    public function createProduction()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $products = Product::all();
        $materials = Material::all();

        return view('koordinator.manajemenproduksi.create', compact('products', 'materials'));
    }


    // 🏭 MANAJEMEN PRODUKSI - STORE
    public function storeProduction(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'production_date' => 'required|date',
            'materials' => 'required|array|min:1',
            'materials.*' => 'exists:materials,id',
            'quantities' => 'required|array|min:1',
            'quantities.*' => 'numeric|min:1',
            'quantity_produced' => 'required|numeric|min:1',
        ]);

        // 🔹 Generate kode produksi (PRD001, PRD002, dst)
        $latestCode = Production::max('code');
        $nextCode = $latestCode ? 'PRD' . str_pad((int)substr($latestCode, 3) + 1, 3, '0', STR_PAD_LEFT) : 'PRD001';

        // 🔹 Simpan data utama produksi
        $production = Production::create([
            'code' => $nextCode,
            'user_id' => Auth::id(),
            'product_id' => $request->product_id,
            'quantity_produced' => $request->quantity_produced,
            'production_date' => $request->production_date,
            'operator' => 'Bagian Produksi',
            'status' => 'pending',
        ]);

        // 🔹 Simpan bahan baku & kurangi stok
        foreach ($request->materials as $index => $materialId) {
            $qtyUsed = $request->quantities[$index] ?? 0;

            if ($qtyUsed > 0) {
                $production->materials()->attach($materialId, ['quantity_used' => $qtyUsed]);

                // Kurangi stok bahan baku
                $material = Material::find($materialId);
                if ($material) {
                    $material->decrement('stock', $qtyUsed);
                }
            }
        }

        // 🔹 Redirect ke halaman index produksi
        return redirect()->route('manajemenproduksi')->with('success', 'Jadwal produksi berhasil dibuat!');
    }


    // MANAJEMEN PRODUKSI - EDIT
    public function editProduction($id)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $production = Production::with(['product', 'material', 'user'])->findOrFail($id);
        $products = Product::all();
        $materials = Material::all();
        $users = User::all();

        return view('koordinator.manajemenproduksi.edit', compact('production', 'products', 'materials', 'users'));
    }

    // MANAJEMEN PRODUKSI - UPDATE
    public function updateProduction(Request $request, $id)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'material_id' => 'required|exists:materials,id',
            'user_id' => 'required|exists:users,id',
            'quantity_used' => 'required|numeric|min:1',
            'quantity_produced' => 'required|numeric|min:1',
            'production_date' => 'required|date'
        ]);

        $production = Production::findOrFail($id);
        $production->update([
            'product_id' => $request->product_id,
            'material_id' => $request->material_id,
            'user_id' => $request->user_id,
            'quantity_used' => $request->quantity_used,
            'quantity_produced' => $request->quantity_produced,
            'production_date' => $request->production_date
        ]);

        return redirect()->route('manajemenproduksi')->with('success', 'Data produksi berhasil diperbarui!');
    }

    // MANAJEMEN PRODUKSI - DESTROY
    public function destroyProduction($id)
    {
        $production = Production::findOrFail($id);
        $production->delete();

        return redirect()->route('manajemenproduksi')->with('success', 'Data produksi berhasil dihapus!');
    }

    // CRUD Materials
    public function materials()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $materials = Material::with('supplier')->get();
        $suppliers = Supplier::all();

        return view('koordinator.manajemenstokbahanbaku.index', compact('materials', 'suppliers'));
    }

    public function storeMaterial(Request $request)
    {
        $request->validate([
            'supplier_id' => 'required|exists:suppliers,id',
            'name' => 'required|string|max:255',
            'unit' => 'required|string|max:50',
            'price' => 'required|numeric|min:0'
        ]);

        Material::create([
            'supplier_id' => $request->supplier_id,
            'name' => $request->name,
            'unit' => $request->unit,
            'price' => $request->price,
            'stock' => 0, // default stok awal = 0
        ]);

        return redirect()->route('koordinator.materials')->with('success', 'Bahan baku baru berhasil ditambahkan!');
    }


    public function updateMaterial(Request $request, $id)
    {
        $request->validate([
            'supplier_id' => 'required|exists:suppliers,id',
            'name' => 'required|string|max:255',
            'unit' => 'required|string|max:50',
            'stock' => 'required|numeric|min:0',
            'price' => 'required|numeric|min:0'
        ]);

        $material = Material::findOrFail($id);
        $material->update($request->all());

        return redirect()->route('koordinator.materials')->with('success', 'Material berhasil diperbarui!');
    }
    public function createMaterial()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        // Ambil semua data Supplier untuk digunakan dalam dropdown/select di form.
        $suppliers = Supplier::all();

        // Tampilkan view form untuk membuat material baru.
        // Ganti 'koordinator.materials.create' dengan path view Anda yang sebenarnya.
        return view('koordinator.manajemenstokbahanbaku.create', compact('suppliers'));
    }

    public function destroyMaterial($id)
    {
        $material = Material::findOrFail($id);
        $material->delete();

        return redirect()->route('koordinator.materials')->with('success', 'Material berhasil dihapus!');
    }

        // PRODUCTS - INDEX
    public function products()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $products = Product::all();

        return view('koordinator.manajemenstokbarangjadi.index', compact('products'));
    }

    // PRODUCTS - CREATE
    public function createProduct()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        return view('koordinator.manajemenstokbarangjadi.create');
    }

    // PRODUCTS - STORE
    public function storeProduct(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0'
        ]);

        Product::create([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'stock' => 0
        ]);

        return redirect()->route('koordinator.products')->with('success', 'Produk berhasil ditambahkan dengan stok awal 0.');
    }

    // PRODUCTS - UPDATE
    public function updateProduct(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0'
        ]);

        $product = Product::findOrFail($id);
        $product->update($request->all());

        return redirect()->route('koordinator.products')->with('success', 'Produk berhasil diperbarui!');
    }

    // PRODUCTS - DESTROY
    public function destroyProduct($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();

        return redirect()->route('koordinator.products')->with('success', 'Produk berhasil dihapus!');
    }

    // DISTRIBUTION - INDEX
    public function distributions()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $distributions = Distribution::with(['product', 'user'])
            ->orderBy('created_at', 'desc')
            ->get();

        // Statistik
        $totalDistributions = $distributions->count();
        $totalQuantitySent = $distributions->whereIn('status', ['dikirim', 'selesai'])->sum('quantity');
        $inProgressCount = $distributions->where('status', 'diproses')->count();
        $completedCount = $distributions->where('status', 'selesai')->count();

        return view('koordinator.manajemendistribusi.index', compact(
            'distributions',
            'totalDistributions',
            'totalQuantitySent',
            'inProgressCount',
            'completedCount'
        ));
    }
    
    public function showDistribution($id)
    {
        // Pastikan user login
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        // Ambil data distribusi dengan relasi produk & user
        $distribution = \App\Models\Distribution::with(['product', 'user'])->findOrFail($id);

        // Kirim data ke view
        return view('koordinator.manajemendistribusi.show', compact('distribution'));
    }


    // DISTRIBUTION - CREATE
    public function createDistribution()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $products = Product::all();
        $users = User::all();

        return view('koordinator.manajemendistribusi.create', compact('products', 'users'));
    }

        // DISTRIBUTION - STORE
    public function storeDistribution(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'destination' => 'required|string|max:255',
            'quantity' => 'required|integer|min:1',
            'notes' => 'nullable|string',
        ]);

        $product = Product::findOrFail($request->product_id);
        if ($product->stock < $request->quantity) {
            return redirect()->back()->with('error', 'Stok produk tidak mencukupi! Stok tersedia: ' . $product->stock);
        }

        // 🔹 Generate kode distribusi (DST001, DST002, dst)
        $latestCode = Distribution::max('code');
        $nextCode = $latestCode ? 'DST' . str_pad((int)substr($latestCode, 3) + 1, 4, '0', STR_PAD_LEFT) : 'DST0001';

        // 🔹 Simpan data distribusi
        Distribution::create([
            'code' => $nextCode,
            'user_id' => Auth::id(),
            'product_id' => $request->product_id,
            'destination' => $request->destination,
            'quantity' => $request->quantity,
            'status' => 'diproses', // default otomatis
            'notes' => $request->notes,
        ]);

        $product->decrement('stock', $request->quantity);

        return redirect()->route('koordinator.distributions')
            ->with('success', 'Distribusi baru berhasil ditambahkan!');
    }


    // DISTRIBUTION - EDIT
    public function editDistribution($id)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $distribution = Distribution::with(['product', 'user'])->findOrFail($id);
        $products = Product::all();
        $users = User::all();

        return view('koordinator.manajemendistribusi.edit', compact('distribution', 'products', 'users'));
    }

    // DISTRIBUTION - UPDATE
    public function updateDistribution(Request $request, $id)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'destination' => 'required|string|max:255',
            'quantity' => 'required|integer|min:1',
            'status' => 'required|in:diproses,dikirim,selesai,dibatalkan',
            'notes' => 'nullable|string'
        ]);

        $distribution = Distribution::findOrFail($id);
        $product = Product::findOrFail($request->product_id);

        // Handle stok perubahan
        $oldQuantity = $distribution->quantity;
        $newQuantity = $request->quantity;
        $oldStatus = $distribution->status;
        $newStatus = $request->status;

        // Jika status berubah dari dibatalkan ke status lain, kurangi stok
        if ($oldStatus === 'dibatalkan' && $newStatus !== 'dibatalkan') {
            if ($product->stock < $newQuantity) {
                return redirect()->back()->with('error', 'Stok produk tidak mencukupi! Stok tersedia: ' . $product->stock);
            }
            $product->decrement('stock', $newQuantity);
        }
        // Jika status berubah dari bukan dibatalkan ke dibatalkan, kembalikan stok
        elseif ($oldStatus !== 'dibatalkan' && $newStatus === 'dibatalkan') {
            $product->increment('stock', $oldQuantity);
        }
        // Jika quantity berubah dan status bukan dibatalkan
        elseif ($oldStatus !== 'dibatalkan' && $newStatus !== 'dibatalkan' && $oldQuantity != $newQuantity) {
            $stockDifference = $newQuantity - $oldQuantity;
            if ($stockDifference > 0 && $product->stock < $stockDifference) {
                return redirect()->back()->with('error', 'Stok produk tidak mencukupi untuk penambahan quantity! Stok tersedia: ' . $product->stock);
            }

            if ($stockDifference > 0) {
                $product->decrement('stock', $stockDifference);
            } else {
                $product->increment('stock', abs($stockDifference));
            }
        }

        $distribution->update([
            'product_id' => $request->product_id,
            'destination' => $request->destination,
            'quantity' => $request->quantity,
            'status' => $request->status,
            'notes' => $request->notes
            // updated_at otomatis diupdate oleh Laravel
        ]);

        return redirect()->route('koordinator.distributions')->with('success', 'Data distribusi berhasil diperbarui!');
    }

    // DISTRIBUTION - DESTROY
    public function destroyDistribution($id)
    {
        $distribution = Distribution::findOrFail($id);

        // Kembalikan stok jika status bukan dibatalkan
        if ($distribution->status !== 'dibatalkan') {
            $product = $distribution->product;
            $product->increment('stock', $distribution->quantity);
        }

        $distribution->delete();

        return redirect()->route('koordinator.distributions')->with('success', 'Data distribusi berhasil dihapus!');
    }

    // PROFILE - SHOW (Read Only)
    public function profile()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();
        return view('koordinator.profile.index', compact('user'));
    }

    // PROFILE - EDIT FORM
    public function editProfile()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();
        return view('koordinator.profile.edit', compact('user'));
    }

    // PROFILE - UPDATE
    public function updateProfile(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:500'
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address
        ]);

        return redirect()->route('koordinator.profile')->with('success', 'Profile berhasil diperbarui!');
    }
}
