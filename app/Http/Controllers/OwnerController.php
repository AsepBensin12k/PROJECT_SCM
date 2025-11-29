<?php

namespace App\Http\Controllers;

use App\Models\Material;
use App\Models\Product;
use App\Models\Production;
use App\Models\Distribution;
use App\Models\Stock;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class OwnerController extends Controller
{
    /**
     * Display owner dashboard with general information
     */
    public function index()
    {
        // Statistik Umum
        $totalMaterials = Material::count();
        $totalProducts = Product::count();
        $totalProductions = Production::count();
        $totalDistributions = Distribution::count();

        // Stok Bahan Baku
        $totalMaterialStock = Material::sum('stock');
        $lowStockMaterials = Material::where('stock', '<', 50)->get(); // threshold 50
        $totalLowStock = $lowStockMaterials->count();
        $totalOutOfStock = Material::where('stock', '=', 0)->count();

        // Stok Produk Jadi
        $totalProductStock = Product::sum('stock');
        $lowStockProducts = Product::where('stock', '<', 20)->get(); // threshold 20

        // Data untuk chart bahan baku (top 5)
        $materials = Material::orderBy('stock', 'desc')->take(5)->get();

        // Data untuk chart produk jadi (top 5)
        $products = Product::orderBy('stock', 'desc')->take(5)->get();

        // Produksi Terbaru (7 hari terakhir)
        $recentProductions = Production::with(['product', 'materials', 'user'])
            ->where('production_date', '>=', Carbon::now()->subDays(7))
            ->orderBy('production_date', 'desc')
            ->take(10)
            ->get();

        // Distribusi Terbaru (7 hari terakhir)
        $recentDistributions = Distribution::with(['product', 'user'])
            ->where('created_at', '>=', Carbon::now()->subDays(7))
            ->orderBy('created_at', 'desc')
            ->take(10)
            ->get();

        // Statistik Produksi Bulanan
        $monthlyProduction = Production::select(
            DB::raw('MONTH(production_date) as month'),
            DB::raw('SUM(quantity_produced) as total')
        )
            ->whereYear('production_date', Carbon::now()->year)
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        // Statistik Distribusi Berdasarkan Status
        $distributionByStatus = Distribution::select('status', DB::raw('count(*) as total'))
            ->groupBy('status')
            ->get();

        // Total Nilai Stok Bahan Baku
        $totalMaterialValue = Material::sum(DB::raw('stock * price'));

        // Total Nilai Stok Produk Jadi
        $totalProductValue = Product::sum(DB::raw('stock * price'));


        return view('owner.dashboard.index', compact(
            'totalMaterials',
            'totalProducts',
            'totalProductions',
            'totalDistributions',
            'totalMaterialStock',
            'totalProductStock',
            'lowStockMaterials',
            'lowStockProducts',
            'totalLowStock',
            'totalOutOfStock',
            'materials',
            'products',
            'recentProductions',
            'recentDistributions',
            'monthlyProduction',
            'distributionByStatus',
            'totalMaterialValue',
            'totalProductValue'
        ));
    }

    public function laporanBahanBaku()
    {
        $materials = Material::with('supplier')->orderBy('stock', 'desc')->get();

        // Statistik utama
        $totalMaterials = $materials->count();
        $totalStock = $materials->sum('stock');
        $lowStock = $materials->where('stock', '<', 50)->count();
        $outOfStock = $materials->where('stock', '=', 0)->count();

        // Data chart top 5 bahan baku
        $topMaterials = $materials->sortByDesc('stock')->take(5);
        $chartLabels = $topMaterials->pluck('name');
        $chartData = $topMaterials->pluck('stock');

        // Kirim ke view
        return view('owner.laporan-bahan-baku.index', compact(
            'materials',
            'totalMaterials',
            'totalStock',
            'lowStock',
            'outOfStock',
            'chartLabels',
            'chartData'
        ));
    }

    public function laporanProdukJadi()
    {
        $products = Product::orderBy('stock', 'desc')->get();
        $totalProducts = $products->count();
        $totalStock = $products->sum('stock');
        $lowStock = $products->where('stock', '<', 20)->count();
        $outOfStock = $products->where('stock', '=', 0)->count();
        $topProducts = $products->sortByDesc('stock')->take(5);
        $chartLabels = $topProducts->pluck('name');
        $chartData = $topProducts->pluck('stock');

        return view('owner.laporan-stok-barang-jadi.index', compact(
            'products',
            'totalProducts',
            'totalStock',
            'lowStock',
            'outOfStock',
            'chartLabels',
            'chartData'
        ));
    }

    public function detailProdukJadi($id)
    {
        $product = Product::with(['productions.material', 'productions.user'])->findOrFail($id);
        $productions = $product->productions()->orderBy('production_date', 'desc')->get();
        $totalProduced = $productions->sum('quantity_produced');
        $totalUsedMaterial = $productions->sum('quantity_used');

        $chartData = $productions
            ->groupBy(fn($p) => Carbon::parse($p->production_date)->format('M Y'))
            ->map(fn($items) => $items->sum('quantity_produced'));

        return view('owner.laporan-stok-barang-jadi.show', compact(
            'product',
            'productions',
            'totalProduced',
            'totalUsedMaterial',
            'chartData'
        ));
    }

    /**
     * Display supplier management page
     */
    public function suppliers()
    {
        $suppliers = Supplier::orderBy('created_at', 'desc')->get();
        $activeSuppliers = Supplier::active()->count();
        $inactiveSuppliers = Supplier::inactive()->count();

        return view('owner.manajemen-supplier.index', compact(
            'suppliers',
            'activeSuppliers',
            'inactiveSuppliers'
        ));
    }

    /**
     * Show create supplier form
     */
    public function createSupplier()
    {
        return view('owner.manajemen-supplier.create');
    }

    /**
     * Store new supplier
     */
    public function storeSupplier(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'origin' => 'nullable|string|max:255',
            'contact' => 'nullable|string|max:255',
            'status' => 'required|in:aktif,non-aktif',
        ], [
            'name.required' => 'Nama supplier wajib diisi',
            'name.max' => 'Nama supplier maksimal 255 karakter',
            'status.required' => 'Status wajib dipilih',
            'status.in' => 'Status tidak valid',
        ]);

        try {
            Supplier::create($validated);

            return redirect()
                ->route('owner.suppliers')
                ->with('success', 'Supplier berhasil ditambahkan!');
        } catch (\Exception $e) {
            return redirect()
                ->route('owner.suppliers')
                ->with('error', 'Gagal menambahkan supplier: ' . $e->getMessage());
        }
    }

    /**
     * Show edit supplier form
     */
    public function editSupplier($id)
    {
        $supplier = Supplier::findOrFail($id);
        return view('owner.manajemen-supplier.edit', compact('supplier'));
    }

    /**
     * Update supplier
     */
    public function updateSupplier(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'origin' => 'nullable|string|max:255',
            'contact' => 'nullable|string|max:255',
            'status' => 'required|in:aktif,non-aktif',
        ], [
            'name.required' => 'Nama supplier wajib diisi',
            'name.max' => 'Nama supplier maksimal 255 karakter',
            'status.required' => 'Status wajib dipilih',
            'status.in' => 'Status tidak valid',
        ]);

        try {
            $supplier = Supplier::findOrFail($id);
            $supplier->update($validated);

            return redirect()
                ->route('owner.suppliers')
                ->with('success', 'Supplier berhasil diupdate!');
        } catch (\Exception $e) {
            return redirect()
                ->route('owner.suppliers')
                ->with('error', 'Gagal mengupdate supplier: ' . $e->getMessage());
        }
    }

    /**
     * Toggle supplier status (quick action)
     */
    public function toggleSupplierStatus($id)
    {
        try {
            $supplier = Supplier::findOrFail($id);
            $newStatus = $supplier->status === 'aktif' ? 'non-aktif' : 'aktif';
            $supplier->status = $newStatus;
            $supplier->save();

            return redirect()
                ->route('owner.suppliers')
                ->with('success', "Status supplier berhasil diubah menjadi {$newStatus}!");
        } catch (\Exception $e) {
            return redirect()
                ->route('owner.suppliers')
                ->with('error', 'Gagal mengubah status supplier: ' . $e->getMessage());
        }
    }

    /**
     * Delete supplier
     */
    public function destroySupplier($id)
    {
        try {
            $supplier = Supplier::findOrFail($id);
            
            // Cek apakah supplier memiliki material terkait
            if ($supplier->materials()->count() > 0) {
                return redirect()
                    ->route('owner.suppliers')
                    ->with('error', 'Tidak dapat menghapus supplier yang memiliki bahan baku terkait!');
            }

            $supplierName = $supplier->name;
            $supplier->delete();

            return redirect()
                ->route('owner.suppliers')
                ->with('success', "Supplier '{$supplierName}' berhasil dihapus!");
        } catch (\Exception $e) {
            return redirect()
                ->route('owner.suppliers')
                ->with('error', 'Gagal menghapus supplier: ' . $e->getMessage());
        }
    }
    
    public function laporanProduksi()
    {
        $productions = Production::with(['product', 'materials'])
            ->orderBy('production_date', 'desc')
            ->get();

        $totalProductions = $productions->count();
        $totalQuantity = $productions->sum('quantity_produced');

        // ✅ Hitung total bahan terpakai dari pivot table
        $totalMaterialsUsed = 0;
        foreach ($productions as $prod) {
            foreach ($prod->materials as $mat) {
                $totalMaterialsUsed += $mat->pivot->quantity_used;
            }
        }

        $chartData = $productions
            ->groupBy(fn($p) => \Carbon\Carbon::parse($p->production_date)->format('M Y'))
            ->map(fn($items) => $items->sum('quantity_produced'));

        return view('owner.laporan-produksi.index', compact(
            'productions',
            'totalProductions',
            'totalQuantity',
            'totalMaterialsUsed',
            'chartData'
        ));
    }


    public function detailProduksi($id)
    {
        $production = Production::with(['product', 'materials'])->findOrFail($id);
        return view('owner.laporan-produksi.show', compact('production'));
    }


    public function laporanDistribusi()
    {
        $distributions = Distribution::with(['product', 'user'])
            ->orderBy('created_at', 'desc')
            ->get();

        // Total semua distribusi
        $totalDistributions = $distributions->count();

        $totalQuantitySent = $distributions
            ->whereIn('status', ['dikirim', 'selesai'])
            ->sum('quantity');

        $countInProgress = $distributions
            ->where('status', 'diproses')
            ->count();

        $countCompleted = $distributions
            ->where('status', 'selesai')
            ->count();

        $chartData = $distributions
            ->groupBy(fn($d) => Carbon::parse($d->created_at)->format('M Y'))
            ->map(fn($items) => $items->sum('quantity'));

        return view('owner.laporan-distribusi.index', compact(
            'distributions',
            'totalDistributions',
            'totalQuantitySent',
            'countInProgress',
            'countCompleted',
            'chartData'
        ));
    }

    public function detailDistribusi($id)
    {
        $distribution = Distribution::with(['product', 'user'])->findOrFail($id);

        return view('owner.laporan-distribusi.show', compact('distribution'));
    }

    public function profile()
    {
        $user = Auth::user();
        return view('owner.profile.index', compact('user'));
    }

    /**
     * Tampilkan form edit profil Owner
     */
    public function editProfile()
    {
        $user = Auth::user();
        return view('owner.profile.edit', compact('user'));
    }

    /**
     * Update data profil Owner
     */
    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255',
        ]);

        $user->update($validated);

        return redirect()->route('owner.profile')->with('success', 'Profil berhasil diperbarui!');
    }

    /**
     * Ganti password Owner
     */
    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:6|confirmed',
        ]);

        $user = Auth::user();

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Password lama salah']);
        }

        $user->password = Hash::make($request->new_password);
        $user->save();

        return back()->with('success', 'Password berhasil diperbarui!');
    }
}

