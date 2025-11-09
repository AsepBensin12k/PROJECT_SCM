<?php

namespace App\Http\Controllers;

use App\Models\Forecast;
use App\Models\Material;
use App\Models\Production;
use Illuminate\Http\Request;

class ForecastController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    // Tampilkan semua forecast
    public function index()
    {
        $forecasts = Forecast::with('material')->orderBy('period','desc')->paginate(20);
        return view('forecasts.index', compact('forecasts'));
    }

    // form untuk membuat forecast baru (pilih material & periode & jumlah periode WMA)
    public function create()
    {
        // Owner may run forecast; but allow Admin/Koordinator to view (tapi only Owner can save if you want)
        $materials = Material::orderBy('name')->get();
        return view('forecasts.create', compact('materials'));
    }

    // hitung WMA lalu simpan
    public function store(Request $request)
    {
        // hanya Owner yang boleh menyimpan forecast (sesuai diskusi)
        if (! auth()->user()->hasRole('Owner')) {
            abort(403);
        }

        $validated = $request->validate([
            'material_id' => 'required|exists:materials,id',
            'period' => 'required|string', // format yyyy-mm
            'periods' => 'nullable|integer|min:1|max:12',
        ]);

        $periods = $validated['periods'] ?? 3;
        // default weights: lebih berat ke data terbaru
        $weights = $this->generateWeights($periods);

        // ambil produksi terakhir per period (bulan) untuk material
        $productions = Production::selectRaw('YEAR(production_date) as y, MONTH(production_date) as m, SUM(quantity_used) as total_used')
            ->where('material_id', $validated['material_id'])
            ->groupBy('y','m')
            ->orderByRaw('y desc, m desc')
            ->limit($periods)
            ->get();

        // jika tidak cukup data, kita tetap bisa pakai yang ada (weights trimmed)
        $values = $productions->pluck('total_used')->toArray();
        if (count($values) === 0) {
            return back()->withInput()->withErrors(['material_id' => 'Tidak ada data produksi untuk material ini.']);
        }

        // align values with weights: values in desc order (most recent first)
        // weights array is [w1, w2, ...] with w1 for most recent
        $weights = array_slice($weights, 0, count($values));

        // calculate weighted sum
        $wma = 0.0;
        $sumW = array_sum($weights);
        foreach ($values as $i => $val) {
            $wma += ($val * $weights[$i]);
        }
        if ($sumW > 0) {
            $wma = $wma / $sumW;
        }

        // simpan ke forecasts
        $forecast = Forecast::create([
            'material_id' => $validated['material_id'],
            'period' => $validated['period'],
            'forecast_result' => round($wma, 2),
        ]);

        return redirect()->route('forecasts.index')->with('success', 'Forecast berhasil dibuat (WMA).');
    }

    // helper generate weights for n periods (decaying weights)
    private function generateWeights(int $n): array
    {
        // simplest: geometric weights: recent has largest weight
        // e.g. for n=3 -> [0.5, 0.3, 0.2] normalized
        $weights = [];
        $base = 0.6; // relative decay (tweakable)
        for ($i = 0; $i < $n; $i++) {
            $weights[] = pow($base, $i);
        }
        // normalize to sum 1
        $sum = array_sum($weights);
        return array_map(fn($w) => $w / $sum, $weights);
    }

    public function show(Forecast $forecast)
    {
        $forecast->load('material');
        return view('forecasts.show', compact('forecast'));
    }

    public function destroy(Forecast $forecast)
    {
        if (! auth()->user()->hasRole('Owner')) {
            abort(403);
        }
        $forecast->delete();
        return redirect()->route('forecasts.index')->with('success', 'Forecast berhasil dihapus.');
    }
}
