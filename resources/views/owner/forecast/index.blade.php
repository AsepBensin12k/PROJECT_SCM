<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forecasting Bahan Baku - ROJEMBER</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body class="bg-gray-100 font-sans antialiased">

    <!-- 🔹 Navbar -->
    <nav class="bg-gradient-to-r from-purple-600 to-indigo-600 shadow-xl sticky top-0 z-50 border-b border-purple-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <!-- Logo -->
                <div class="flex items-center space-x-3">
                    <div class="bg-white/20 p-2 rounded-xl backdrop-blur-sm border border-white/30">
                        <i class="fas fa-chart-line text-white text-lg"></i>
                    </div>
                    <div class="flex flex-col">
                        <span class="text-white font-bold text-lg tracking-tight">Forecasting Bahan Baku</span>
                        <span class="text-purple-100 text-xs font-medium">ROJEMBER</span>
                    </div>
                </div>

                <!-- User -->
                <div
                    class="flex items-center space-x-3 bg-white/20 px-4 py-2 rounded-xl backdrop-blur-sm border border-white/30">
                    <div class="bg-white/30 p-1.5 rounded-full">
                        <i class="fas fa-user text-white text-sm"></i>
                    </div>
                    <div class="flex flex-col">
                        <span class="text-white text-sm font-semibold leading-none">Welcome,
                            {{ Auth::user()->name }}</span>
                        <span class="text-purple-100 text-xs">Owner</span>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <!-- 🔹 Main Layout -->
    <div class="flex">
        @include('components.owner-sidebar')

        <div class="flex-1 p-8 ml-64 relative">

            <!-- 🔄 Loading Overlay -->
            <div id="loadingOverlay"
                class="hidden absolute inset-0 bg-white/80 flex flex-col justify-center items-center z-50 rounded-xl">
                <div class="w-16 h-16 border-4 border-purple-500 border-t-transparent rounded-full animate-spin mb-4">
                </div>
                <p class="text-purple-700 font-semibold">Sedang menghitung forecast...</p>
            </div>

            <!-- Header -->
            <div class="mb-6 flex justify-between items-center">
                <div>
                    <h1 class="text-3xl font-bold text-gray-800 flex items-center">
                        <i class="fas fa-chart-line text-purple-600 mr-3"></i>
                        Forecasting Bahan Baku (WMA)
                    </h1>
                    <p class="text-gray-500 text-sm mt-1">
                        Prediksi kebutuhan bahan baku berdasarkan data pemakaian 3 bulan terakhir.
                    </p>
                </div>
                <form id="forecastForm" action="{{ route('owner.forecasts.generate') }}" method="POST">
                    @csrf
                    <button type="submit"
                        class="bg-gradient-to-r from-purple-600 to-indigo-600 text-white px-6 py-3 rounded-lg hover:from-purple-700 hover:to-indigo-700 transition shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                        <i class="fas fa-magic mr-2"></i> Jalankan Forecast
                    </button>
                </form>
            </div>

            <!-- Success/Error Message -->
            @if (session('success'))
                <div
                    class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded-lg flex items-center">
                    <i class="fas fa-check-circle mr-3 text-xl"></i>
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            @if (session('error'))
                <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded-lg flex items-center">
                    <i class="fas fa-exclamation-circle mr-3 text-xl"></i>
                    <span>{{ session('error') }}</span>
                </div>
            @endif

            <!-- 📊 Chart Section -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">

                <!-- 🔸 Line Chart - Tren Pemakaian 3 Bulan -->
                <div class="bg-white rounded-xl shadow-lg p-6 hover:shadow-xl transition-shadow">
                    <h2 class="text-xl font-semibold text-gray-800 mb-4 flex items-center">
                        <i class="fas fa-chart-line text-blue-600 mr-2"></i>
                        Tren Pemakaian Bahan Baku (3 Bulan Terakhir)
                    </h2>
                    <canvas id="lineChart" height="100"></canvas>
                </div>

                <!-- 🔸 Bar Chart - Forecast vs Stok -->
                <div class="bg-white rounded-xl shadow-lg p-6 hover:shadow-xl transition-shadow">
                    <h2 class="text-xl font-semibold text-gray-800 mb-4 flex items-center">
                        <i class="fas fa-chart-bar text-green-600 mr-2"></i>
                        Perbandingan Prediksi vs Stok Saat Ini
                    </h2>
                    <canvas id="barChart" height="100"></canvas>
                </div>

            </div>

            <!-- 📊 Pie Chart & Summary Cards -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">

                <!-- 🔸 Pie Chart - Proporsi Kebutuhan -->
                <div class="lg:col-span-1 bg-white rounded-xl shadow-lg p-6 hover:shadow-xl transition-shadow">
                    <h2 class="text-xl font-semibold text-gray-800 mb-4 flex items-center">
                        <i class="fas fa-chart-pie text-orange-600 mr-2"></i>
                        Proporsi Kebutuhan Pengadaan
                    </h2>
                    @if (count($pieChartData) > 0)
                        <canvas id="pieChart" height="200"></canvas>
                    @else
                        <div class="text-center py-8 text-gray-400">
                            <i class="fas fa-inbox text-4xl mb-2"></i>
                            <p class="text-sm">Tidak ada kebutuhan pengadaan</p>
                        </div>
                    @endif
                </div>

                <!-- 🔸 Summary Cards -->
                <div class="lg:col-span-2 grid grid-cols-1 sm:grid-cols-3 gap-4">

                    <!-- Card 1: Total Bahan Baku -->
                    <div
                        class="bg-gradient-to-br from-purple-500 to-purple-600 rounded-xl shadow-lg p-6 text-white hover:shadow-xl transition-all transform hover:-translate-y-1">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-purple-100 text-sm font-medium">Total Bahan Baku</p>
                                <h3 class="text-3xl font-bold mt-1">{{ $forecasts->count() }}</h3>
                            </div>
                            <div class="bg-white/20 p-3 rounded-lg">
                                <i class="fas fa-boxes text-2xl"></i>
                            </div>
                        </div>
                    </div>

                    <!-- Card 2: Perlu Pengadaan -->
                    <div
                        class="bg-gradient-to-br from-red-500 to-red-600 rounded-xl shadow-lg p-6 text-white hover:shadow-xl transition-all transform hover:-translate-y-1">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-red-100 text-sm font-medium">Perlu Pengadaan</p>
                                <h3 class="text-3xl font-bold mt-1">
                                    {{ $forecasts->filter(fn($f) => $f->material->stock < $f->forecast_value)->count() }}
                                </h3>
                            </div>
                            <div class="bg-white/20 p-3 rounded-lg">
                                <i class="fas fa-exclamation-triangle text-2xl"></i>
                            </div>
                        </div>
                    </div>

                    <!-- Card 3: Stok Aman -->
                    <div
                        class="bg-gradient-to-br from-green-500 to-green-600 rounded-xl shadow-lg p-6 text-white hover:shadow-xl transition-all transform hover:-translate-y-1">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-green-100 text-sm font-medium">Stok Aman</p>
                                <h3 class="text-3xl font-bold mt-1">
                                    {{ $forecasts->filter(fn($f) => $f->material->stock >= $f->forecast_value)->count() }}
                                </h3>
                            </div>
                            <div class="bg-white/20 p-3 rounded-lg">
                                <i class="fas fa-check-circle text-2xl"></i>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            <!-- 🔸 Tabel Hasil Forecast -->
            <div class="bg-white rounded-xl shadow-lg p-6 hover:shadow-xl transition-shadow">
                <h2 class="text-xl font-semibold text-gray-800 mb-4 flex items-center">
                    <i class="fas fa-table text-indigo-600 mr-2"></i>
                    Rekomendasi Pengadaan Bulan Berikutnya
                </h2>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 text-sm">
                        <thead class="bg-gradient-to-r from-indigo-600 to-purple-600 text-white">
                            <tr>
                                <th class="px-6 py-3 text-left font-semibold uppercase tracking-wider">No</th>
                                <th class="px-6 py-3 text-left font-semibold uppercase tracking-wider">Bahan Baku</th>
                                <th class="px-6 py-3 text-left font-semibold uppercase tracking-wider">Prediksi WMA</th>
                                <th class="px-6 py-3 text-left font-semibold uppercase tracking-wider">Stok Saat Ini
                                </th>
                                <th class="px-6 py-3 text-left font-semibold uppercase tracking-wider">Kebutuhan</th>
                                <th class="px-6 py-3 text-left font-semibold uppercase tracking-wider">Status</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse ($forecasts as $index => $f)
                                @php
                                    $needed = max(0, $f->forecast_value - $f->material->stock);
                                @endphp
                                <tr class="hover:bg-gray-50 transition duration-150">
                                    <td class="px-6 py-4 text-gray-600 font-medium">{{ $index + 1 }}</td>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center">
                                            <div class="bg-purple-100 p-2 rounded-lg mr-3">
                                                <i class="fas fa-box text-purple-600"></i>
                                            </div>
                                            <div>
                                                <p class="font-semibold text-gray-800">{{ $f->material->name }}</p>
                                                <p class="text-xs text-gray-500">{{ $f->material->unit }}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="text-purple-700 font-bold text-lg">
                                            {{ number_format($f->forecast_value, 2) }}
                                        </span>
                                        <span class="text-gray-500 text-xs">{{ $f->material->unit }}</span>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="text-gray-700 font-semibold">
                                            {{ number_format($f->material->stock, 2) }}
                                        </span>
                                        <span class="text-gray-500 text-xs">{{ $f->material->unit }}</span>
                                    </td>
                                    <td class="px-6 py-4">
                                        @if ($needed > 0)
                                            <span class="text-red-600 font-bold text-lg">
                                                {{ number_format($needed, 2) }}
                                            </span>
                                            <span class="text-gray-500 text-xs">{{ $f->material->unit }}</span>
                                        @else
                                            <span class="text-green-600 font-semibold">-</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4">
                                        @if ($needed > 0)
                                            <span
                                                class="inline-flex items-center px-3 py-1 bg-red-100 text-red-700 text-xs font-bold rounded-full">
                                                <i class="fas fa-exclamation-circle mr-1"></i>
                                                Perlu Pengadaan
                                            </span>
                                        @else
                                            <span
                                                class="inline-flex items-center px-3 py-1 bg-green-100 text-green-700 text-xs font-bold rounded-full">
                                                <i class="fas fa-check-circle mr-1"></i>
                                                Stok Aman
                                            </span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center py-12 text-gray-500">
                                        <i class="fas fa-inbox text-5xl text-gray-300 mb-3"></i>
                                        <p class="text-lg font-semibold">Belum ada hasil forecast</p>
                                        <p class="text-sm mt-1">Klik tombol "Jalankan Forecast" untuk memulai
                                            perhitungan</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Info Box -->
            <div
                class="mt-6 bg-gradient-to-r from-purple-50 to-indigo-50 border-l-4 border-purple-600 p-6 rounded-lg shadow-md">
                <div class="flex items-start">
                    <i class="fas fa-info-circle text-purple-600 mr-4 mt-1 text-xl"></i>
                    <div>
                        <p class="text-sm font-bold text-purple-900 mb-2">Informasi Metode Forecasting:</p>
                        <ul class="text-sm text-purple-700 space-y-2">
                            <li class="flex items-start">
                                <i class="fas fa-check text-purple-500 mr-2 mt-1"></i>
                                <span>Forecast menggunakan metode <b>Weighted Moving Average (WMA)</b> dengan bobot [1,
                                    2, 3] untuk 3 bulan terakhir.</span>
                            </li>
                            <li class="flex items-start">
                                <i class="fas fa-check text-purple-500 mr-2 mt-1"></i>
                                <span>Data diambil dari pemakaian bahan baku pada <b>produksi yang berstatus
                                        "selesai"</b>.</span>
                            </li>
                            <li class="flex items-start">
                                <i class="fas fa-check text-purple-500 mr-2 mt-1"></i>
                                <span>Rumus WMA: <code class="bg-purple-200 px-2 py-0.5 rounded">(Bulan₁×1 + Bulan₂×2 +
                                        Bulan₃×3) / 6</code></span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <script>
        // 🔹 Loading overlay saat forecast dijalankan
        const forecastForm = document.getElementById('forecastForm');
        const loadingOverlay = document.getElementById('loadingOverlay');

        forecastForm.addEventListener('submit', function() {
            loadingOverlay.classList.remove('hidden');
        });

        // 🎨 Chart.js Color Palette
        const colors = [
            '#8b5cf6', '#ec4899', '#06b6d4', '#10b981', '#f59e0b',
            '#ef4444', '#6366f1', '#14b8a6', '#f97316', '#a855f7'
        ];

        // 📈 Line Chart - Tren Pemakaian
        @if (isset($lineChartData) && count($lineChartData) > 0)
            const lineCtx = document.getElementById('lineChart').getContext('2d');
            new Chart(lineCtx, {
                type: 'line',
                data: {
                    labels: @json($lineChartLabels),
                    datasets: @json($lineChartData).map((dataset, index) => ({
                        label: dataset.label,
                        data: dataset.data,
                        borderColor: colors[index % colors.length],
                        backgroundColor: colors[index % colors.length] + '20',
                        borderWidth: 3,
                        fill: true,
                        tension: 0.4,
                        pointRadius: 4,
                        pointHoverRadius: 6
                    }))
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: true,
                    plugins: {
                        legend: {
                            display: true,
                            position: 'bottom',
                            labels: {
                                boxWidth: 12,
                                padding: 15,
                                font: {
                                    size: 11
                                }
                            }
                        },
                        tooltip: {
                            mode: 'index',
                            intersect: false,
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: {
                                color: '#f3f4f6'
                            },
                            ticks: {
                                font: {
                                    size: 11
                                }
                            }
                        },
                        x: {
                            grid: {
                                display: false
                            },
                            ticks: {
                                font: {
                                    size: 11
                                }
                            }
                        }
                    }
                }
            });
        @endif

        // 📊 Bar Chart - Forecast vs Stok
        @if (isset($barChartLabels) && count($barChartLabels) > 0)
            const barCtx = document.getElementById('barChart').getContext('2d');
            new Chart(barCtx, {
                type: 'bar',
                data: {
                    labels: @json($barChartLabels),
                    datasets: [{
                            label: 'Prediksi WMA',
                            data: @json($barChartForecast),
                            backgroundColor: '#8b5cf6',
                            borderColor: '#7c3aed',
                            borderWidth: 2,
                            borderRadius: 8,
                        },
                        {
                            label: 'Stok Saat Ini',
                            data: @json($barChartStock),
                            backgroundColor: '#10b981',
                            borderColor: '#059669',
                            borderWidth: 2,
                            borderRadius: 8,
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: true,
                    plugins: {
                        legend: {
                            display: true,
                            position: 'bottom',
                            labels: {
                                boxWidth: 12,
                                padding: 15,
                                font: {
                                    size: 11
                                }
                            }
                        },
                        tooltip: {
                            mode: 'index',
                            intersect: false,
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: {
                                color: '#f3f4f6'
                            },
                            ticks: {
                                font: {
                                    size: 11
                                }
                            }
                        },
                        x: {
                            grid: {
                                display: false
                            },
                            ticks: {
                                font: {
                                    size: 10
                                },
                                maxRotation: 45,
                                minRotation: 45
                            }
                        }
                    }
                }
            });
        @endif

        // 🥧 Pie Chart - Proporsi Kebutuhan
        @if (isset($pieChartData) && count($pieChartData) > 0)
            const pieCtx = document.getElementById('pieChart').getContext('2d');
            new Chart(pieCtx, {
                type: 'pie',
                data: {
                    labels: @json($pieChartLabels),
                    datasets: [{
                        data: @json($pieChartData),
                        backgroundColor: colors.slice(0, @json(count($pieChartData))),
                        borderColor: '#ffffff',
                        borderWidth: 2,
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: true,
                    plugins: {
                        legend: {
                            display: true,
                            position: 'bottom',
                            labels: {
                                boxWidth: 12,
                                padding: 10,
                                font: {
                                    size: 10
                                }
                            }
                        },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    let label = context.label || '';
                                    let value = context.parsed || 0;
                                    let total = context.dataset.data.reduce((a, b) => a + b, 0);
                                    let percentage = ((value / total) * 100).toFixed(1);
                                    return label + ': ' + value.toFixed(2) + ' (' + percentage + '%)';
                                }
                            }
                        }
                    }
                }
            });
        @endif
    </script>
</body>

</html>
