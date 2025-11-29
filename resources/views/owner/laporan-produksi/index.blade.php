<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Produksi | ROJEMBER</title>
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
                        <i class="fas fa-industry text-white text-lg"></i>
                    </div>
                    <div class="flex flex-col">
                        <span class="text-white font-bold text-lg tracking-tight">Laporan Produksi</span>
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
            <h2 class="text-3xl font-bold text-gray-800 mb-6 flex items-center">
                <i class="fas fa-chart-line text-purple-600 mr-3"></i> Data Produksi
            </h2>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <div class="bg-purple-600 text-white p-6 rounded-xl shadow-lg">
                    <p class="text-purple-200 text-sm mb-1">Total Produksi</p>
                    <p class="text-3xl font-bold">{{ $totalProductions }}</p>
                </div>
                <div class="bg-indigo-600 text-white p-6 rounded-xl shadow-lg">
                    <p class="text-indigo-200 text-sm mb-1">Total Produk Dihasilkan</p>
                    <p class="text-3xl font-bold">{{ $totalQuantity }}</p>
                </div>
                <div class="bg-pink-600 text-white p-6 rounded-xl shadow-lg">
                    <p class="text-pink-200 text-sm mb-1">Total Bahan Terpakai</p>
                    <p class="text-3xl font-bold">{{ $totalMaterialsUsed }}</p>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-md p-6 mb-8">
                <h3 class="text-lg font-semibold mb-3 text-gray-800 flex items-center">
                    <i class="fas fa-chart-bar text-purple-600 mr-2"></i> Grafik Produksi Bulanan
                </h3>
                <canvas id="productionChart" height="100"></canvas>
            </div>

            <div class="bg-white rounded-xl shadow-md overflow-hidden">
                <table class="min-w-full divide-y divide-gray-200 text-sm">
                    <thead class="bg-gradient-to-r from-purple-600 to-indigo-600 text-white">
                        <tr>
                            <th class="px-6 py-3 text-left font-semibold uppercase tracking-wider">No</th>
                            <th class="px-6 py-3 text-left font-semibold uppercase tracking-wider">Tanggal Produksi</th>
                            <th class="px-6 py-3 text-left font-semibold uppercase tracking-wider">Produk</th>
                            <th class="px-6 py-3 text-left font-semibold uppercase tracking-wider">Jumlah</th>
                            <th class="px-6 py-3 text-left font-semibold uppercase tracking-wider">Operator</th>
                            <th class="px-6 py-3 text-left font-semibold uppercase tracking-wider text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach ($productions as $index => $p)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-6 py-4">{{ $index + 1 }}</td>
                                <td class="px-6 py-4">{{ \Carbon\Carbon::parse($p->production_date)->format('d M Y') }}
                                </td>
                                <td class="px-6 py-4 font-medium">{{ $p->product->name }}</td>
                                <td class="px-6 py-4">{{ $p->quantity_produced }}</td>
                                <td class="px-6 py-4">{{ $p->operator ?? 'Bagian Produksi' }}</td>
                                <td class="px-6 py-4 text-center">
                                    <a href="{{ route('owner.laporan.produksi.show', $p->id) }}"
                                        class="px-3 py-1 bg-purple-600 hover:bg-purple-700 text-white rounded-lg text-xs transition">
                                        <i class="fas fa-eye mr-1"></i> Detail
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </main>
    </div>

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
                    backgroundColor: '#7e22ce'
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>
</body>

</html>
