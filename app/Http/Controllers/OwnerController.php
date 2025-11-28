<?php

namespace App\Http\Controllers;

use App\Models\Material;
use App\Models\Product;
use App\Models\Production;
use App\Models\Distribution;
use App\Models\Stock;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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
        $recentProductions = Production::with(['product', 'material', 'user'])
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

        // Efisiensi Produksi Rata-rata (7 hari terakhir)
        $avgEfficiency = Production::where('production_date', '>=', Carbon::now()->subDays(7))
            ->selectRaw('AVG((quantity_produced / quantity_used) * 100) as efficiency')
            ->value('efficiency') ?? 0;

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
            'totalProductValue',
            'avgEfficiency'
        ));
    }
}