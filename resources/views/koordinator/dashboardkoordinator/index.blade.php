<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Koordinator</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body class="bg-gray-100">
    <!-- Navigation -->
    <nav
        class="bg-gradient-to-r from-amber-500 to-orange-500 shadow-xl sticky top-0 z-50 backdrop-blur-sm bg-white/95 border-b border-amber-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <!-- Logo & Brand -->
                <div class="flex items-center space-x-3">
                    <div class="bg-white/20 p-2 rounded-xl backdrop-blur-sm border border-white/30">
                        <i class="fas fa-chart-line text-white text-lg"></i>
                    </div>
                    <div class="flex flex-col">
                        <span class="text-white font-bold text-lg tracking-tight">Dashboard Koordinator</span>
                        <span class="text-amber-100 text-xs font-medium">RO JEMBER</span>
                    </div>
                </div>

                <!-- User Info & Actions -->
                <div class="flex items-center space-x-4">
                    <!-- User Profile -->
                    <div
                        class="flex items-center space-x-3 bg-white/20 px-4 py-2 rounded-xl backdrop-blur-sm border border-white/30">
                        <div class="bg-white/30 p-1.5 rounded-full">
                            <i class="fas fa-user text-white text-sm"></i>
                        </div>
                        <div class="flex flex-col">
                            <span class="text-white text-sm font-semibold leading-none">Welcome,
                                {{ Auth::user()->name }}</span>
                            <span class="text-amber-100 text-xs">Online</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <!-- Sidebar & Main Content -->
    <div class="flex">
        <!-- Sidebar -->
        @include('components.koordinator-sidebar')

        <!-- Main Content -->
        <div class="flex-1 p-8 ml-64">
            <!-- Statistik Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <!-- Total Materials -->
                <div class="bg-white rounded-xl shadow-md p-6 border-l-4 border-blue-500">
                    <div class="flex items-center">
                        <div class="p-3 bg-blue-100 rounded-lg">
                            <i class="fas fa-boxes text-blue-600 text-xl"></i>
                        </div>
                        <div class="ml-4">
                            <h3 class="text-sm font-medium text-gray-600">Total Bahan Baku</h3>
                            <p class="text-2xl font-bold text-gray-800">{{ $totalMaterials }}</p>
                        </div>
                    </div>
                </div>

                <!-- Total Products -->
                <div class="bg-white rounded-xl shadow-md p-6 border-l-4 border-green-500">
                    <div class="flex items-center">
                        <div class="p-3 bg-green-100 rounded-lg">
                            <i class="fas fa-cube text-green-600 text-xl"></i>
                        </div>
                        <div class="ml-4">
                            <h3 class="text-sm font-medium text-gray-600">Total Produk</h3>
                            <p class="text-2xl font-bold text-gray-800">{{ $totalProducts }}</p>
                        </div>
                    </div>
                </div>

                <!-- Low Stock -->
                <div class="bg-white rounded-xl shadow-md p-6 border-l-4 border-yellow-500">
                    <div class="flex items-center">
                        <div class="p-3 bg-yellow-100 rounded-lg">
                            <i class="fas fa-exclamation-triangle text-yellow-600 text-xl"></i>
                        </div>
                        <div class="ml-4">
                            <h3 class="text-sm font-medium text-gray-600">Stok Menipis</h3>
                            <p class="text-2xl font-bold text-gray-800">{{ $totalLowStock }}</p>
                        </div>
                    </div>
                </div>

                <!-- Out of Stock -->
                <div class="bg-white rounded-xl shadow-md p-6 border-l-4 border-red-500">
                    <div class="flex items-center">
                        <div class="p-3 bg-red-100 rounded-lg">
                            <i class="fas fa-times-circle text-red-600 text-xl"></i>
                        </div>
                        <div class="ml-4">
                            <h3 class="text-sm font-medium text-gray-600">Stok Habis</h3>
                            <p class="text-2xl font-bold text-gray-800">{{ $totalOutOfStock }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <!-- Chart Stok Bahan Baku -->
                <div class="bg-white rounded-xl shadow-md p-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Stok Bahan Baku</h3>
                    <div class="h-64">
                        <canvas id="materialStockChart"></canvas>
                    </div>
                </div>

                <!-- Bahan Baku Menipis -->
                <div class="bg-white rounded-xl shadow-md p-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Bahan Baku Menipis</h3>
                    <div class="space-y-3">
                        @forelse($lowStockMaterials as $material)
                            <div
                                class="flex items-center justify-between p-3 bg-yellow-50 rounded-lg border border-yellow-200">
                                <div>
                                    <h4 class="font-medium text-gray-800">{{ $material->name }}</h4>
                                    <p class="text-sm text-gray-600">Stok: {{ $material->stock }} {{ $material->unit }}
                                    </p>
                                </div>
                                <span class="px-2 py-1 bg-yellow-500 text-white text-xs rounded-full">Menipis</span>
                            </div>
                        @empty
                            <p class="text-gray-500 text-center py-4">Tidak ada bahan baku menipis</p>
                        @endforelse
                    </div>
                </div>

                <!-- Jadwal Produksi -->
                <div class="bg-white rounded-xl shadow-md p-6 lg:col-span-2">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Jadwal Produksi Minggu Ini</h3>
                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead>
                                <tr class="bg-gray-50">
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Produk
                                    </th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Bahan
                                        Baku</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Quantity
                                        Produksi</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tanggal
                                    </th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Operator
                                    </th>
                                    {{-- <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">
                                        Efisiensi</th> --}}
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                @forelse($productionSchedule as $production)
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-4 py-3 text-sm text-gray-800">
                                            <div class="font-medium">{{ $production->product->name }}</div>
                                        </td>
                                        <td class="px-4 py-3 text-sm text-gray-800">
                                            {{ $production->material->name }}
                                        </td>
                                        <td class="px-4 py-3 text-sm text-gray-800">
                                            <span class="bg-green-100 text-green-800 px-2 py-1 rounded-full text-xs">
                                                {{ $production->quantity_produced }} pcs
                                            </span>
                                        </td>
                                        <td class="px-4 py-3 text-sm text-gray-800">
                                            {{ \Carbon\Carbon::parse($production->production_date)->format('d M Y') }}
                                        </td>
                                        <td class="font-medium px-4 py-3 text-sm text-gray-800">
                                            Bagian Produksi
                                        </td>
                                        {{-- <td class="px-4 py-3 text-sm">
                                            @php
                                                $efficiency =
                                                    ($production->quantity_produced / $production->quantity_used) * 100;
                                            @endphp
                                            <span
                                                class="px-2 py-1 text-xs font-medium rounded-full
                                            {{ $efficiency >= 80
                                                ? 'bg-green-100 text-green-800'
                                                : ($efficiency >= 60
                                                    ? 'bg-yellow-100 text-yellow-800'
                                                    : 'bg-red-100 text-red-800') }}">
                                                {{ number_format($efficiency, 1) }}%
                                            </span>
                                        </td> --}}
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="px-4 py-4 text-center text-gray-500">
                                            <div class="flex flex-col items-center justify-center py-4">
                                                <i class="fas fa-calendar-alt text-3xl text-gray-300 mb-2"></i>
                                                <p>Tidak ada jadwal produksi minggu ini</p>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Chart Stok Bahan Baku
        const materialStockChart = new Chart(
            document.getElementById('materialStockChart'), {
                type: 'bar',
                data: {
                    labels: @json($materials->pluck('name')),
                    datasets: [{
                        label: 'Stok Tersedia',
                        data: @json($materials->pluck('stock')),
                        backgroundColor: [
                            'rgba(59, 130, 246, 0.8)',
                            'rgba(16, 185, 129, 0.8)',
                            'rgba(245, 158, 11, 0.8)',
                            'rgba(239, 68, 68, 0.8)',
                            'rgba(139, 92, 246, 0.8)',
                        ],
                        borderColor: [
                            'rgb(59, 130, 246)',
                            'rgb(16, 185, 129)',
                            'rgb(245, 158, 11)',
                            'rgb(239, 68, 68)',
                            'rgb(139, 92, 246)',
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true,
                            title: {
                                display: true,
                                text: 'Jumlah Stok'
                            }
                        }
                    }
                }
            }
        );
    </script>
</body>

</html>
