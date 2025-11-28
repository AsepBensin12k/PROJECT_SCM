<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Owner - RO JEMBER</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body class="bg-gray-100">
    <!-- Navigation -->
    <nav
        class="bg-gradient-to-r from-purple-600 to-indigo-600 shadow-xl sticky top-0 z-50 backdrop-blur-sm bg-white/95 border-b border-purple-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <!-- Logo & Brand -->
                <div class="flex items-center space-x-3">
                    <div class="bg-white/20 p-2 rounded-xl backdrop-blur-sm border border-white/30">
                        <i class="fas fa-crown text-white text-lg"></i>
                    </div>
                    <div class="flex flex-col">
                        <span class="text-white font-bold text-lg tracking-tight">Dashboard Owner</span>
                        <span class="text-purple-100 text-xs font-medium">RO JEMBER</span>
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
                            <span class="text-purple-100 text-xs">Owner</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <!-- Sidebar & Main Content -->
    <div class="flex">
        <!-- Sidebar -->
        @include('components.owner-sidebar')

        <!-- Main Content -->
        <div class="flex-1 p-8 ml-64">
            <!-- Statistik Cards Row 1 -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <!-- Total Bahan Baku -->
                <div
                    class="bg-white rounded-xl shadow-md p-6 border-l-4 border-blue-500 hover:shadow-lg transition-shadow duration-300">
                    <div class="flex items-center">
                        <div class="p-3 bg-blue-100 rounded-lg">
                            <i class="fas fa-boxes text-blue-600 text-xl"></i>
                        </div>
                        <div class="ml-4">
                            <h3 class="text-sm font-medium text-gray-600">Total Bahan Baku</h3>
                            <p class="text-2xl font-bold text-gray-800">{{ $totalMaterials }}</p>
                            <p class="text-xs text-gray-500 mt-1">Stok: {{ number_format($totalMaterialStock) }} unit
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Total Produk -->
                <div
                    class="bg-white rounded-xl shadow-md p-6 border-l-4 border-green-500 hover:shadow-lg transition-shadow duration-300">
                    <div class="flex items-center">
                        <div class="p-3 bg-green-100 rounded-lg">
                            <i class="fas fa-cube text-green-600 text-xl"></i>
                        </div>
                        <div class="ml-4">
                            <h3 class="text-sm font-medium text-gray-600">Total Produk Jadi</h3>
                            <p class="text-2xl font-bold text-gray-800">{{ $totalProducts }}</p>
                            <p class="text-xs text-gray-500 mt-1">Stok: {{ number_format($totalProductStock) }} pcs</p>
                        </div>
                    </div>
                </div>

                <!-- Total Produksi -->
                <div
                    class="bg-white rounded-xl shadow-md p-6 border-l-4 border-purple-500 hover:shadow-lg transition-shadow duration-300">
                    <div class="flex items-center">
                        <div class="p-3 bg-purple-100 rounded-lg">
                            <i class="fas fa-industry text-purple-600 text-xl"></i>
                        </div>
                        <div class="ml-4">
                            <h3 class="text-sm font-medium text-gray-600">Total Produksi</h3>
                            <p class="text-2xl font-bold text-gray-800">{{ $totalProductions }}</p>
                            <p class="text-xs text-gray-500 mt-1">Efisiensi: {{ number_format($avgEfficiency, 1) }}%</p>
                        </div>
                    </div>
                </div>

                <!-- Total Distribusi -->
                <div
                    class="bg-white rounded-xl shadow-md p-6 border-l-4 border-orange-500 hover:shadow-lg transition-shadow duration-300">
                    <div class="flex items-center">
                        <div class="p-3 bg-orange-100 rounded-lg">
                            <i class="fas fa-truck text-orange-600 text-xl"></i>
                        </div>
                        <div class="ml-4">
                            <h3 class="text-sm font-medium text-gray-600">Total Distribusi</h3>
                            <p class="text-2xl font-bold text-gray-800">{{ $totalDistributions }}</p>
                            <p class="text-xs text-gray-500 mt-1">7 hari terakhir</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Statistik Cards Row 2 - Inventory Status -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <!-- Stok Menipis -->
                <div class="bg-white rounded-xl shadow-md p-6 border-l-4 border-yellow-500">
                    <div class="flex items-center">
                        <div class="p-3 bg-yellow-100 rounded-lg">
                            <i class="fas fa-exclamation-triangle text-yellow-600 text-xl"></i>
                        </div>
                        <div class="ml-4">
                            <h3 class="text-sm font-medium text-gray-600">Stok Menipis</h3>
                            <p class="text-2xl font-bold text-gray-800">{{ $totalLowStock }}</p>
                            <p class="text-xs text-gray-500 mt-1">Bahan baku</p>
                        </div>
                    </div>
                </div>

                <!-- Stok Habis -->
                <div class="bg-white rounded-xl shadow-md p-6 border-l-4 border-red-500">
                    <div class="flex items-center">
                        <div class="p-3 bg-red-100 rounded-lg">
                            <i class="fas fa-times-circle text-red-600 text-xl"></i>
                        </div>
                        <div class="ml-4">
                            <h3 class="text-sm font-medium text-gray-600">Stok Habis</h3>
                            <p class="text-2xl font-bold text-gray-800">{{ $totalOutOfStock }}</p>
                            <p class="text-xs text-gray-500 mt-1">Perlu restock</p>
                        </div>
                    </div>
                </div>

                <!-- Nilai Bahan Baku -->
                <div class="bg-white rounded-xl shadow-md p-6 border-l-4 border-teal-500">
                    <div class="flex items-center">
                        <div class="p-3 bg-teal-100 rounded-lg">
                            <i class="fas fa-money-bill-wave text-teal-600 text-xl"></i>
                        </div>
                        <div class="ml-4">
                            <h3 class="text-sm font-medium text-gray-600">Nilai Bahan Baku</h3>
                            <p class="text-2xl font-bold text-gray-800">Rp
                                {{ number_format($totalMaterialValue, 0, ',', '.') }}</p>
                            <p class="text-xs text-gray-500 mt-1">Total aset</p>
                        </div>
                    </div>
                </div>

                <!-- Nilai Produk Jadi -->
                <div class="bg-white rounded-xl shadow-md p-6 border-l-4 border-indigo-500">
                    <div class="flex items-center">
                        <div class="p-3 bg-indigo-100 rounded-lg">
                            <i class="fas fa-coins text-indigo-600 text-xl"></i>
                        </div>
                        <div class="ml-4">
                            <h3 class="text-sm font-medium text-gray-600">Nilai Produk Jadi</h3>
                            <p class="text-2xl font-bold text-gray-800">Rp
                                {{ number_format($totalProductValue, 0, ',', '.') }}</p>
                            <p class="text-xs text-gray-500 mt-1">Total aset</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Charts & Alerts Section -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
                <!-- Chart Stok Bahan Baku -->
                <div class="bg-white rounded-xl shadow-md p-6">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-semibold text-gray-800">Stok Bahan Baku (Top 5)</h3>
                        <i class="fas fa-chart-bar text-blue-500"></i>
                    </div>
                    <div class="h-64">
                        <canvas id="materialStockChart"></canvas>
                    </div>
                </div>

                <!-- Chart Stok Produk Jadi -->
                <div class="bg-white rounded-xl shadow-md p-6">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-semibold text-gray-800">Stok Produk Jadi (Top 5)</h3>
                        <i class="fas fa-chart-bar text-green-500"></i>
                    </div>
                    <div class="h-64">
                        <canvas id="productStockChart"></canvas>
                    </div>
                </div>

                <!-- Bahan Baku Menipis -->
                <div class="bg-white rounded-xl shadow-md p-6">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-semibold text-gray-800">Bahan Baku Menipis</h3>
                        <span class="px-3 py-1 bg-yellow-100 text-yellow-800 text-xs font-medium rounded-full">
                            {{ $lowStockMaterials->count() }} Item
                        </span>
                    </div>
                    <div class="space-y-3 max-h-64 overflow-y-auto">
                        @forelse($lowStockMaterials as $material)
                            <div
                                class="flex items-center justify-between p-3 bg-yellow-50 rounded-lg border border-yellow-200">
                                <div class="flex-1">
                                    <h4 class="font-medium text-gray-800">{{ $material->name }}</h4>
                                    <p class="text-sm text-gray-600">Stok: {{ $material->stock }}
                                        {{ $material->unit }}</p>
                                </div>
                                <span class="px-2 py-1 bg-yellow-500 text-white text-xs rounded-full">Menipis</span>
                            </div>
                        @empty
                            <div class="text-center py-8 text-gray-500">
                                <i class="fas fa-check-circle text-3xl text-green-400 mb-2"></i>
                                <p>Semua stok bahan baku aman</p>
                            </div>
                        @endforelse
                    </div>
                </div>

                <!-- Produk Jadi Menipis -->
                <div class="bg-white rounded-xl shadow-md p-6">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-semibold text-gray-800">Produk Jadi Menipis</h3>
                        <span class="px-3 py-1 bg-yellow-100 text-yellow-800 text-xs font-medium rounded-full">
                            {{ $lowStockProducts->count() }} Item
                        </span>
                    </div>
                    <div class="space-y-3 max-h-64 overflow-y-auto">
                        @forelse($lowStockProducts as $product)
                            <div
                                class="flex items-center justify-between p-3 bg-yellow-50 rounded-lg border border-yellow-200">
                                <div class="flex-1">
                                    <h4 class="font-medium text-gray-800">{{ $product->name }}</h4>
                                    <p class="text-sm text-gray-600">Stok: {{ $product->stock }} pcs</p>
                                </div>
                                <span class="px-2 py-1 bg-yellow-500 text-white text-xs rounded-full">Menipis</span>
                            </div>
                        @empty
                            <div class="text-center py-8 text-gray-500">
                                <i class="fas fa-check-circle text-3xl text-green-400 mb-2"></i>
                                <p>Semua stok produk jadi aman</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>

            <!-- Recent Production -->
            <div class="bg-white rounded-xl shadow-md p-6 mb-8">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-semibold text-gray-800">Produksi Terbaru (7 Hari Terakhir)</h3>
                    <i class="fas fa-industry text-purple-500"></i>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr class="bg-gray-50">
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tanggal
                                </th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Produk</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Bahan Baku
                                </th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Qty
                                    Digunakan</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Qty
                                    Diproduksi</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Operator
                                </th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Efisiensi
                                </th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @forelse($recentProductions as $production)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-4 py-3 text-sm text-gray-800">
                                        {{ \Carbon\Carbon::parse($production->production_date)->format('d M Y') }}
                                    </td>
                                    <td class="px-4 py-3 text-sm font-medium text-gray-800">
                                        {{ $production->product->name }}
                                    </td>
                                    <td class="px-4 py-3 text-sm text-gray-600">
                                        {{ $production->material->name }}
                                    </td>
                                    <td class="px-4 py-3 text-sm text-gray-800">
                                        {{ $production->quantity_used }} {{ $production->material->unit }}
                                    </td>
                                    <td class="px-4 py-3 text-sm">
                                        <span
                                            class="bg-green-100 text-green-800 px-2 py-1 rounded-full text-xs font-medium">
                                            {{ $production->quantity_produced }} pcs
                                        </span>
                                    </td>
                                    <td class="px-4 py-3 text-sm text-gray-600">
                                        {{ $production->user->name }}
                                    </td>
                                    <td class="px-4 py-3 text-sm">
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
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="px-4 py-8 text-center text-gray-500">
                                        <i class="fas fa-inbox text-3xl text-gray-300 mb-2"></i>
                                        <p>Tidak ada data produksi 7 hari terakhir</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Recent Distribution -->
            <div class="bg-white rounded-xl shadow-md p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-semibold text-gray-800">Distribusi Terbaru (7 Hari Terakhir)</h3>
                    <i class="fas fa-truck text-orange-500"></i>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr class="bg-gray-50">
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tanggal
                                </th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Produk</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tujuan</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Quantity
                                </th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Operator
                                </th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @forelse($recentDistributions as $distribution)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-4 py-3 text-sm text-gray-800">
                                        {{ \Carbon\Carbon::parse($distribution->created_at)->format('d M Y') }}
                                    </td>
                                    <td class="px-4 py-3 text-sm font-medium text-gray-800">
                                        {{ $distribution->product->name }}
                                    </td>
                                    <td class="px-4 py-3 text-sm text-gray-600">
                                        {{ $distribution->destination }}
                                    </td>
                                    <td class="px-4 py-3 text-sm">
                                        <span
                                            class="bg-blue-100 text-blue-800 px-2 py-1 rounded-full text-xs font-medium">
                                            {{ $distribution->quantity }} pcs
                                        </span>
                                    </td>
                                    <td class="px-4 py-3 text-sm text-gray-600">
                                        {{ $distribution->user->name }}
                                    </td>
                                    <td class="px-4 py-3 text-sm">
                                        @if ($distribution->status === 'pending')
                                            <span
                                                class="px-2 py-1 bg-yellow-100 text-yellow-800 text-xs font-medium rounded-full">
                                                Pending
                                            </span>
                                        @elseif($distribution->status === 'delivered')
                                            <span
                                                class="px-2 py-1 bg-green-100 text-green-800 text-xs font-medium rounded-full">
                                                Terkirim
                                            </span>
                                        @else
                                            <span
                                                class="px-2 py-1 bg-blue-100 text-blue-800 text-xs font-medium rounded-full">
                                                {{ ucfirst($distribution->status) }}
                                            </span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-4 py-8 text-center text-gray-500">
                                        <i class="fas fa-inbox text-3xl text-gray-300 mb-2"></i>
                                        <p>Tidak ada data distribusi 7 hari terakhir</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Chart Stok Bahan Baku
        const materialCtx = document.getElementById('materialStockChart').getContext('2d');
        new Chart(materialCtx, {
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
                    borderWidth: 2,
                    borderRadius: 8
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    }
                },
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
        });

        // Chart Stok Produk Jadi
        const productCtx = document.getElementById('productStockChart').getContext('2d');
        new Chart(productCtx, {
            type: 'bar',
            data: {
                labels: @json($products->pluck('name')),
                datasets: [{
                    label: 'Stok Tersedia',
                    data: @json($products->pluck('stock')),
                    backgroundColor: [
                        'rgba(34, 197, 94, 0.8)',
                        'rgba(59, 130, 246, 0.8)',
                        'rgba(245, 158, 11, 0.8)',
                        'rgba(239, 68, 68, 0.8)',
                        'rgba(168, 85, 247, 0.8)',
                    ],
                    borderColor: [
                        'rgb(34, 197, 94)',
                        'rgb(59, 130, 246)',
                        'rgb(245, 158, 11)',
                        'rgb(239, 68, 68)',
                        'rgb(168, 85, 247)',
                    ],
                    borderWidth: 2,
                    borderRadius: 8
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Jumlah Stok (pcs)'
                        }
                    }
                }
            }
        });
    </script>
</body>

</html>
