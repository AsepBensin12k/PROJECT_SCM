<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Produk Jadi - {{ $product->name }} | ROJEMBER</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body class="bg-gray-100 font-sans antialiased">

    <!-- Navigation -->
    <nav
        class="bg-gradient-to-r from-purple-600 to-indigo-600 shadow-xl sticky top-0 z-50 backdrop-blur-sm bg-white/95 border-b border-purple-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <!-- Logo -->
                <div class="flex items-center space-x-3">
                    <div class="bg-white/20 p-2 rounded-xl backdrop-blur-sm border border-white/30">
                        <i class="fas fa-cube text-white text-lg"></i>
                    </div>
                    <div class="flex flex-col">
                        <span class="text-white font-bold text-lg tracking-tight">Laporan Produk Jadi</span>
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

    <div class="flex">
        @include('components.owner-sidebar')

        <main class="flex-1 p-8 ml-64">
            <!-- Header -->
            <div class="mb-6 flex justify-between items-center">
                <div>
                    <h2 class="text-3xl font-bold text-gray-800 flex items-center">
                        <i class="fas fa-cube text-purple-600 mr-3"></i> {{ $product->name }}
                    </h2>
                    <p class="text-gray-500 text-sm mt-1">Analisis detail produk dan histori produksinya</p>
                </div>
                <a href="{{ route('owner.laporan.produkjadi') }}"
                    class="px-4 py-2 bg-purple-600 text-white rounded-lg shadow hover:bg-purple-700 transition">
                    <i class="fas fa-arrow-left mr-2"></i> Kembali
                </a>
            </div>

            <!-- Statistik Ringkas -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
                <div class="bg-gradient-to-br from-purple-500 to-purple-600 rounded-lg shadow-lg p-6 text-white">
                    <p class="text-purple-100 text-sm mb-1">Harga Satuan</p>
                    <p class="text-2xl font-bold">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                </div>
                <div class="bg-gradient-to-br from-green-500 to-green-600 rounded-lg shadow-lg p-6 text-white">
                    <p class="text-green-100 text-sm mb-1">Total Stok Saat Ini</p>
                    <p class="text-2xl font-bold">{{ $product->stock }}</p>
                </div>
                <div class="bg-gradient-to-br from-indigo-500 to-indigo-600 rounded-lg shadow-lg p-6 text-white">
                    <p class="text-indigo-100 text-sm mb-1">Total Produksi Keseluruhan</p>
                    <p class="text-2xl font-bold">{{ $totalProduced }}</p>
                </div>
                <div class="bg-gradient-to-br from-pink-500 to-rose-600 rounded-lg shadow-lg p-6 text-white">
                    <p class="text-pink-100 text-sm mb-1">Total Bahan Terpakai</p>
                    <p class="text-2xl font-bold">{{ $totalUsedMaterial }}</p>
                </div>
            </div>

            <!-- Grafik Produksi -->
            <div class="bg-white rounded-xl shadow-md p-6 mb-8">
                <h2 class="text-xl font-semibold text-gray-800 mb-4 flex items-center">
                    <i class="fas fa-chart-line text-purple-600 mr-2"></i> Grafik Produksi per Bulan
                </h2>
                <canvas id="productionChart" height="100"></canvas>
            </div>

            <!-- Tabel Riwayat Produksi -->
            <div class="bg-white rounded-xl shadow-md overflow-hidden">
                <table class="min-w-full divide-y divide-gray-200 text-sm">
                    <thead class="bg-gradient-to-r from-purple-600 to-indigo-600 text-white">
                        <tr>
                            <th class="px-6 py-3 text-left font-semibold uppercase tracking-wider">No</th>
                            <th class="px-6 py-3 text-left font-semibold uppercase tracking-wider">Tanggal Produksi</th>
                            <th class="px-6 py-3 text-left font-semibold uppercase tracking-wider">Jumlah Diproduksi
                            </th>
                            <th class="px-6 py-3 text-left font-semibold uppercase tracking-wider">Bahan Digunakan</th>
                            <th class="px-6 py-3 text-left font-semibold uppercase tracking-wider">Operator</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse ($productions as $index => $prod)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-6 py-4">{{ $index + 1 }}</td>
                                <td class="px-6 py-4">
                                    {{ \Carbon\Carbon::parse($prod->production_date)->format('d M Y') }}</td>
                                <td class="px-6 py-4 font-semibold text-gray-800">{{ $prod->quantity_produced }}</td>
                                <td class="px-6 py-4 text-gray-700">{{ $prod->material->name ?? '-' }}
                                    ({{ $prod->quantity_used }})
                                </td>
                                <td class="font-medium px-6 py-4 text-gray-700">Bagian Produksi</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-8 text-gray-500">
                                    <i class="fas fa-inbox text-4xl text-gray-300 mb-2"></i>
                                    <p>Tidak ada data produksi untuk produk ini</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Info -->
            <div class="mt-6 bg-purple-50 border-l-4 border-purple-600 p-4 rounded-lg">
                <div class="flex">
                    <i class="fas fa-info-circle text-purple-600 mr-3 mt-0.5"></i>
                    <div>
                        <p class="text-sm font-semibold text-purple-900">Informasi:</p>
                        <ul class="text-sm text-purple-700 mt-1 list-disc list-inside space-y-1">
                            <li>Data produksi diurutkan berdasarkan tanggal terbaru.</li>
                            <li>Bagian Produksi menampilkan unit kerja yang menangani proses produksi.</li>
                            <li>Grafik di atas menampilkan total produksi per bulan dalam tahun berjalan.</li>
                        </ul>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <!-- Chart Script -->
    <script>
        const ctx = document.getElementById('productionChart');
        const chartLabels = @json($chartData->keys());
        const chartValues = @json($chartData->values());

        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: chartLabels,
                datasets: [{
                    label: 'Jumlah Produksi',
                    data: chartValues,
                    backgroundColor: '#7e22ce',
                    borderColor: '#6d28d9',
                    borderWidth: 2,
                    borderRadius: 6,
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: false
                    },
                    title: {
                        display: true,
                        text: 'Produksi Bulanan',
                        font: {
                            size: 16,
                            weight: 'bold'
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            precision: 0
                        }
                    }
                }
            }
        });
    </script>
</body>

</html>
