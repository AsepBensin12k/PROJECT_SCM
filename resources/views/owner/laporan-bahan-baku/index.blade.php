<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Bahan Baku - ROJEMBER</title>
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
                        <i class="fas fa-boxes text-white text-lg"></i>
                    </div>
                    <div class="flex
                        flex-col">
                        <span class="text-white font-bold text-lg tracking-tight">Laporan Bahan Baku</span>
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

        <div class="flex-1 p-8 ml-64">
            <!-- Header -->
            <div class="mb-6 flex justify-between items-center">
                <div>
                    <h1 class="text-3xl font-bold text-gray-800 flex items-center">
                        <i class="fas fa-boxes-stacked text-purple-600 mr-3"></i>
                        Laporan Bahan Baku
                    </h1>
                    <p class="text-gray-500 text-sm mt-1">Menampilkan data bahan baku lengkap dan analisis stok</p>
                </div>
                <div class="text-right">
                    <p class="text-sm text-gray-500">Diperbarui pada</p>
                    <p class="text-sm font-semibold text-gray-700">{{ now()->format('d M Y, H:i') }}</p>
                </div>
            </div>

            <!-- Statistik Ringkas -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
                <div class="bg-gradient-to-br from-purple-500 to-purple-600 rounded-lg shadow-lg p-6 text-white">
                    <p class="text-purple-100 text-sm mb-1">Total Jenis Bahan Baku</p>
                    <p class="text-3xl font-bold">{{ $totalMaterials }}</p>
                </div>
                <div class="bg-gradient-to-br from-green-500 to-green-600 rounded-lg shadow-lg p-6 text-white">
                    <p class="text-green-100 text-sm mb-1">Total Stok Bahan Baku</p>
                    <p class="text-3xl font-bold">{{ $totalStock }}</p>
                </div>
                <div class="bg-gradient-to-br from-yellow-500 to-yellow-600 rounded-lg shadow-lg p-6 text-white">
                    <p class="text-yellow-100 text-sm mb-1">Bahan Baku Hampir Habis</p>
                    <p class="text-3xl font-bold">{{ $lowStock }}</p>
                </div>
                <div class="bg-gradient-to-br from-red-500 to-red-600 rounded-lg shadow-lg p-6 text-white">
                    <p class="text-red-100 text-sm mb-1">Bahan Baku Kosong</p>
                    <p class="text-3xl font-bold">{{ $outOfStock }}</p>
                </div>
            </div>

            <!-- Grafik Analisis -->
            <div class="bg-white rounded-xl shadow-md p-6 mb-6">
                <h2 class="text-xl font-semibold text-gray-800 mb-4 flex items-center">
                    <i class="fas fa-chart-line text-purple-600 mr-2"></i> Grafik Stok Bahan Baku
                </h2>
                <canvas id="materialChart" height="100"></canvas>
            </div>

            <!-- Tabel Laporan -->
            <div class="bg-white rounded-xl shadow-md overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 text-sm">
                        <thead class="bg-gradient-to-r from-purple-600 to-purple-700 text-white">
                            <tr>
                                <th class="px-6 py-3 text-left font-semibold uppercase tracking-wider">No</th>
                                <th class="px-6 py-3 text-left font-semibold uppercase tracking-wider">Nama Bahan</th>
                                <th class="px-6 py-3 text-left font-semibold uppercase tracking-wider">Supplier</th>
                                <th class="px-6 py-3 text-left font-semibold uppercase tracking-wider">Harga (Rp)</th>
                                <th class="px-6 py-3 text-left font-semibold uppercase tracking-wider">Stok Saat Ini
                                </th>
                                <th class="px-6 py-3 text-left font-semibold uppercase tracking-wider">Status</th>
                                <th class="px-6 py-3 text-left font-semibold uppercase tracking-wider">Terakhir
                                    Diperbarui</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($materials as $index => $material)
                                <tr class="hover:bg-gray-50 transition duration-150">
                                    <td class="px-6 py-4">{{ $index + 1 }}</td>
                                    <td class="px-6 py-4 font-semibold text-gray-800">
                                        <i class="fas fa-cube text-purple-500 mr-1"></i>{{ $material->name }}
                                    </td>
                                    <td class="px-6 py-4 text-gray-700">{{ $material->supplier->name ?? '-' }}</td>
                                    <td class="px-6 py-4 text-gray-700">Rp
                                        {{ number_format($material->price, 0, ',', '.') }}</td>
                                    <td class="px-6 py-4 text-gray-700">{{ $material->stock }}</td>
                                    <td class="px-6 py-4">
                                        @if ($material->stock == 0)
                                            <span
                                                class="px-3 py-1 bg-red-100 text-red-700 text-xs font-bold rounded-full">
                                                <i class="fas fa-times-circle mr-1"></i>Kosong
                                            </span>
                                        @elseif ($material->stock < 50)
                                            <span
                                                class="px-3 py-1 bg-yellow-100 text-yellow-700 text-xs font-bold rounded-full">
                                                <i class="fas fa-exclamation-triangle mr-1"></i>Hampir Habis
                                            </span>
                                        @else
                                            <span
                                                class="px-3 py-1 bg-green-100 text-green-700 text-xs font-bold rounded-full">
                                                <i class="fas fa-check-circle mr-1"></i>Tersedia
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 text-gray-600">
                                        {{ $material->updated_at->format('d M Y H:i') }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center py-8 text-gray-500">
                                        <i class="fas fa-inbox text-4xl text-gray-300 mb-2"></i>
                                        <p>Tidak ada data bahan baku</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Info -->
            <div class="mt-6 bg-purple-50 border-l-4 border-purple-600 p-4 rounded-lg">
                <div class="flex">
                    <i class="fas fa-info-circle text-purple-600 mr-3 mt-0.5"></i>
                    <div>
                        <p class="text-sm font-semibold text-purple-900">Informasi:</p>
                        <ul class="text-sm text-purple-700 mt-1 list-disc list-inside space-y-1">
                            <li>Laporan ini menampilkan seluruh bahan baku beserta jumlah stoknya.</li>
                            <li>Warna merah menandakan bahan baku kosong, kuning menandakan stok menipis.</li>
                            <li>Data diperbarui secara otomatis berdasarkan input dari koordinator.</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Chart Script -->
    <script>
        const ctx = document.getElementById('materialChart');
        const labels = @json($chartLabels);
        const dataValues = @json($chartData);
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Jumlah Stok',
                    data: dataValues,
                    backgroundColor: [
                        '#7e22ce',
                        '#9333ea',
                        '#a855f7',
                        '#c084fc',
                        '#d8b4fe'
                    ],
                    borderRadius: 8,
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
                        text: 'Top 5 Bahan Baku Berdasarkan Stok',
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
