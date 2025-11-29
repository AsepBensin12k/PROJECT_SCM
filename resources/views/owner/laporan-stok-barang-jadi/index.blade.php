<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Produk Jadi - ROJEMBER</title>
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
            <div class="mb-6 flex justify-between items-center">
                <div>
                    <h2 class="text-3xl font-bold text-gray-800 flex items-center">
                        <i class="fas fa-cube text-purple-600 mr-3"></i>Laporan Produk Jadi
                    </h2>
                    <p class="text-gray-500 text-sm mt-1">Analisis stok dan performa produksi</p>
                </div>
                <div class="text-right">
                    <p class="text-sm text-gray-500">Diperbarui</p>
                    <p class="text-sm font-semibold text-gray-700">{{ now()->format('d M Y, H:i') }}</p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
                <div class="bg-gradient-to-br from-purple-500 to-purple-600 rounded-lg shadow-lg p-6 text-white">
                    <p class="text-purple-100 text-sm mb-1">Total Produk</p>
                    <p class="text-3xl font-bold">{{ $totalProducts }}</p>
                </div>
                <div class="bg-gradient-to-br from-green-500 to-green-600 rounded-lg shadow-lg p-6 text-white">
                    <p class="text-green-100 text-sm mb-1">Total Stok Produk</p>
                    <p class="text-3xl font-bold">{{ $totalStock }}</p>
                </div>
                <div class="bg-gradient-to-br from-yellow-500 to-yellow-600 rounded-lg shadow-lg p-6 text-white">
                    <p class="text-yellow-100 text-sm mb-1">Stok Rendah</p>
                    <p class="text-3xl font-bold">{{ $lowStock }}</p>
                </div>
                <div class="bg-gradient-to-br from-red-500 to-red-600 rounded-lg shadow-lg p-6 text-white">
                    <p class="text-red-100 text-sm mb-1">Stok Kosong</p>
                    <p class="text-3xl font-bold">{{ $outOfStock }}</p>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-md p-6 mb-6">
                <h2 class="text-xl font-semibold text-gray-800 mb-4">
                    <i class="fas fa-chart-bar text-purple-600 mr-2"></i> Grafik Stok Produk
                </h2>
                <canvas id="productChart" height="100"></canvas>
            </div>

            <div class="bg-white rounded-xl shadow-md overflow-hidden">
                <table class="min-w-full divide-y divide-gray-200 text-sm">
                    <thead class="bg-gradient-to-r from-purple-600 to-purple-700 text-white">
                        <tr>
                            <th class="px-6 py-3 text-left font-semibold uppercase tracking-wider">No</th>
                            <th class="px-6 py-3 text-left font-semibold uppercase tracking-wider">Nama Produk</th>
                            <th class="px-6 py-3 text-left font-semibold uppercase tracking-wider">Harga</th>
                            <th class="px-6 py-3 text-left font-semibold uppercase tracking-wider">Stok</th>
                            <th class="px-6 py-3 text-left font-semibold uppercase tracking-wider">Nilai Total</th>
                            <th class="px-6 py-3 text-left font-semibold uppercase tracking-wider">Status</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach ($products as $index => $product)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-6 py-4">{{ $index + 1 }}</td>
                                <td class="px-6 py-4 font-semibold text-gray-800">
                                    <a href="{{ route('owner.laporan.produkjadi.show', $product->id) }}"
                                        class="hover:text-purple-600">
                                        <i class="fas fa-cube text-purple-500 mr-1"></i>{{ $product->name }}
                                    </a>
                                </td>
                                <td class="px-6 py-4">Rp {{ number_format($product->price, 0, ',', '.') }}</td>
                                <td class="px-6 py-4">{{ $product->stock }}</td>
                                <td class="px-6 py-4">Rp
                                    {{ number_format($product->price * $product->stock, 0, ',', '.') }}</td>
                                <td class="px-6 py-4">
                                    @if ($product->stock == 0)
                                        <span
                                            class="px-3 py-1 bg-red-100 text-red-700 text-xs font-bold rounded-full">Kosong</span>
                                    @elseif ($product->stock < 20)
                                        <span
                                            class="px-3 py-1 bg-yellow-100 text-yellow-700 text-xs font-bold rounded-full">Menipis</span>
                                    @else
                                        <span
                                            class="px-3 py-1 bg-green-100 text-green-700 text-xs font-bold rounded-full">Tersedia</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </main>
    </div>

    <script>
        const ctx = document.getElementById('productChart');
        const labels = @json($chartLabels);
        const dataValues = @json($chartData);
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels,
                datasets: [{
                    label: 'Jumlah Stok',
                    data: dataValues,
                    backgroundColor: ['#7e22ce', '#9333ea', '#a855f7', '#c084fc', '#d8b4fe'],
                    borderRadius: 8,
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
