<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{Forecast, Material};
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class ForecastController extends Controller
{
    public function index()
    {
        // 🔹 Ambil data pemakaian bahan baku 3 bulan terakhir (per bulan per material)
        $historical = DB::table('production_materials')
            ->join('productions', 'production_materials.production_id', '=', 'productions.id')
            ->join('materials', 'production_materials.material_id', '=', 'materials.id')
            ->select(
                'materials.id',
                'materials.name',
                'materials.unit',
                DB::raw('DATE_FORMAT(productions.production_date, "%Y-%m") as period'),
                DB::raw('SUM(production_materials.quantity_used) as total_used')
            )
            ->where('productions.production_date', '>=', Carbon::now()->subMonths(3)->startOfMonth())
            ->where('productions.status', 'selesai')
            ->groupBy('materials.id', 'materials.name', 'materials.unit', 'period')
            ->orderBy('period', 'asc')
            ->orderBy('materials.name', 'asc')
            ->get();

        // 🔹 Ambil hasil forecast yang sudah tersimpan
        $forecasts = Forecast::with('material')->get();

        // 🔹 Urutkan berdasarkan tingkat kebutuhan (needed DESC, forecast_value DESC)
        $forecasts = $forecasts->map(function($f) {
            $f->needed = max(0, $f->forecast_value - $f->material->stock);
            return $f;
        })->sortByDesc(function($f) {
            // Primary sort: needed (yang paling butuh duluan)
            // Secondary sort: forecast_value (kalau sama-sama butuh, yang forecast lebih besar duluan)
            return [$f->needed, $f->forecast_value];
        })->values();

        // 🔹 Data untuk Line Chart (Tren per bahan baku)
        $materials = $historical->groupBy('name');
        $lineChartData = [];
        $lineChartLabels = $historical->pluck('period')->unique()->sort()->values();

        foreach ($materials as $materialName => $data) {
            $usageByPeriod = $data->pluck('total_used', 'period')->toArray();
            
            $chartValues = [];
            foreach ($lineChartLabels as $period) {
                $chartValues[] = $usageByPeriod[$period] ?? 0;
            }
            
            $lineChartData[] = [
                'label' => $materialName,
                'data' => $chartValues,
            ];
        }

        $lineChartLabels = $lineChartLabels->map(function($period) {
            return Carbon::createFromFormat('Y-m', $period)->translatedFormat('M Y');
        });

        // 🔹 Data untuk Bar Chart (Forecast vs Stok)
        $barChartLabels = $forecasts->pluck('material.name');
        $barChartForecast = $forecasts->pluck('forecast_value');
        $barChartStock = $forecasts->map(fn($f) => $f->material->stock);

        // 🔹 Data untuk Pie Chart (Proporsi Kebutuhan Pengadaan)
        $pieChartData = [];
        $pieChartLabels = [];
        
        foreach ($forecasts as $f) {
            if ($f->needed > 0) {
                $pieChartLabels[] = $f->material->name;
                $pieChartData[] = round($f->needed, 2);
            }
        }

        return view('owner.forecast.index', compact(
            'historical',
            'forecasts',
            'lineChartData',
            'lineChartLabels',
            'barChartLabels',
            'barChartForecast',
            'barChartStock',
            'pieChartData',
            'pieChartLabels'
        ));
    }

    public function generate()
    {
        try {
            // 🔍 Cek dulu ada data produksi minimal 3 bulan atau tidak
            $dataCheck = DB::table('production_materials')
                ->join('productions', 'production_materials.production_id', '=', 'productions.id')
                ->where('productions.production_date', '>=', Carbon::now()->subMonths(3)->startOfMonth())
                ->where('productions.status', 'selesai')
                ->count();

            if ($dataCheck == 0) {
                return back()->with('error', 'Tidak ada data produksi 3 bulan terakhir. Total data: ' . $dataCheck);
            }

            // Cek berapa material yang punya data minimal 3 bulan
            $materialCheck = DB::table('production_materials')
                ->join('productions', 'production_materials.production_id', '=', 'productions.id')
                ->join('materials', 'production_materials.material_id', '=', 'materials.id')
                ->select(
                    'materials.id',
                    'materials.name',
                    DB::raw('COUNT(DISTINCT DATE_FORMAT(productions.production_date, "%Y-%m")) as month_count')
                )
                ->where('productions.production_date', '>=', Carbon::now()->subMonths(3)->startOfMonth())
                ->where('productions.status', 'selesai')
                ->groupBy('materials.id', 'materials.name')
                ->having('month_count', '>=', 3)
                ->get();

            if ($materialCheck->isEmpty()) {
                return back()->with('error', 'Tidak ada material dengan data minimal 3 bulan berturut-turut.');
            }

            // Pastikan path python sesuai
            $pythonPath = 'python'; // atau 'python3'
            $scriptPath = base_path('app/Services/forecast_wma.py');
            
            // Cek apakah file python ada
            if (!file_exists($scriptPath)) {
                return back()->with('error', 'File Python tidak ditemukan di: ' . $scriptPath);
            }

            $escapedPath = escapeshellarg($scriptPath);
            $command = "$pythonPath $escapedPath 2>&1";
            $output = shell_exec($command);
            
            // 🔍 Debug: Log output python
            Log::info('Python Output:', ['output' => $output]);
            
            // Cek apakah output kosong
            if (empty($output)) {
                return back()->with('error', 'Python tidak mengembalikan output. Cek log untuk detail.');
            }

            $results = json_decode($output, true);

            // Cek JSON error
            if (json_last_error() !== JSON_ERROR_NONE) {
                return back()->with('error', 'JSON Error: ' . json_last_error_msg() . ' | Output: ' . substr($output, 0, 200));
            }

            // Cek apakah ada error dari Python
            if (isset($results['error'])) {
                $errorMsg = $results['error'];
                $debugInfo = isset($results['debug_info']) ? json_encode($results['debug_info']) : '';
                return back()->with('error', 'Python Error: ' . $errorMsg . ' | Debug: ' . $debugInfo);
            }

            if (!$results || count($results) == 0) {
                return back()->with('error', 'Python berhasil jalan tapi tidak menghasilkan forecast.');
            }

            // Simpan hasil forecast
            $saved = 0;
            foreach ($results as $res) {
                Forecast::updateOrCreate(
                    [
                        'material_id' => $res['material_id'],
                        'period' => $res['period'],
                    ],
                    [
                        'forecast_value' => $res['forecast_value'],
                    ]
                );
                $saved++;
            }

            return redirect()->route('owner.forecasts')
                ->with('success', "✅ Forecast berhasil! {$saved} bahan baku telah dihitung untuk periode Desember 2025.");
            
        } catch (\Exception $e) {
            Log::error('Forecast Error:', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return back()->with('error', 'Error: ' . $e->getMessage());
        }
    }
}