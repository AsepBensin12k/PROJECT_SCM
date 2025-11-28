<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Produksi</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-100">
    <!-- Navigation -->
    <nav class="bg-gradient-to-r from-amber-500 to-orange-500 shadow-xl sticky top-0 z-50 backdrop-blur-sm border-b border-amber-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">

                <!-- Logo & Brand -->
                <div class="flex items-center space-x-3">
                    <div class="bg-white/20 p-2 rounded-xl backdrop-blur-sm border border-white/30 shadow-lg">
                        <i class="fas fa-industry text-white text-lg"></i>
                    </div>
                    <div class="flex flex-col">
                        <span class="text-base font-bold text-white tracking-tight hover:text-amber-100 transition-all duration-300">
                            Manajemen Produksi
                        </span>
                    </div>
                </div>

                <!-- User Info & Actions -->
                <div class="flex items-center space-x-4">

                    <!-- Back to Dashboard Button -->
                    <a href="{{ route('koordinator.dashboard') }}" class="group flex items-center space-x-2 bg-white/15 hover:bg-white/25 backdrop-blur-sm px-4 py-2 rounded-xl border border-white/20 hover:border-white/40 transition-all duration-300">
                        <i class="fas fa-arrow-left text-white text-sm group-hover:-translate-x-1 transition-transform duration-300"></i>
                        <span class="text-white text-sm font-semibold">Kembali ke Dashboard</span>
                    </a>

                    <!-- User Profile -->
                    <div class="flex items-center space-x-3 bg-white/15 backdrop-blur-sm px-4 py-2 rounded-xl border border-white/20 shadow-lg">
                        <div class="bg-white/25 p-1.5 rounded-full border border-white/30">
                            <i class="fas fa-user-tie text-white text-xs"></i>
                        </div>
                        <div class="flex flex-col">
                            <span class="text-white font-bold text-sm leading-tight">{{ Auth::user()->name }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </nav>


        <!-- Sidebar & Main Content -->
    <div class="flex">
    <!-- Sidebar -->
    @include('components.sidebar')

    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8 ml-64">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-800">Manajemen Produksi</h1>
            <p class="text-gray-600 mt-2">Kelola semua data produksi dan jadwal produksi</p>
        </div>

        <!-- Action Buttons -->
        <div class="mb-6 flex justify-between items-center">
            <div class="flex space-x-4">
                <a href="{{ route('manajemenproduksi.create') }}"
                   class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded-lg transition duration-200 flex items-center">
                    <i class="fas fa-plus mr-2"></i> Tambah Produksi
                </a>
            </div>

            <!-- Statistics -->
            <div class="flex space-x-4 text-sm">
                <span class="bg-blue-100 text-blue-800 px-3 py-1 rounded-full">
                    Total: {{ $productions->count() }} Produksi
                </span>
            </div>
        </div>

        <!-- Production Table -->
        <div class="bg-white rounded-xl shadow-md overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal Produksi</th>
                            <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Produk</th>
                            <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Bahan Baku</th>
                            <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Operator</th>
                            <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Qty Used</th>
                            <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Qty Produced</th>
                            <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Efficiency</th>
                            <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($productions as $production)
                        <tr class="hover:bg-gray-50 transition duration-150">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">
                                    {{ \Carbon\Carbon::parse($production->production_date)->format('d M Y') }}
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">{{ $production->product->name }}</div>
                                <div class="text-sm text-gray-500">Price: Rp {{ number_format($production->product->price, 0, ',', '.') }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">{{ $production->material->name }}</div>
                                <div class="text-sm text-gray-500">Stock: {{ $production->material->stock }} {{ $production->material->unit }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">{{ $production->user->name }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 py-1 text-xs font-medium bg-red-100 text-red-800 rounded-full">
                                    {{ $production->quantity_used }} {{ $production->material->unit }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 py-1 text-xs font-medium bg-green-100 text-green-800 rounded-full">
                                    {{ $production->quantity_produced }} pcs
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @php
                                    $efficiency = ($production->quantity_produced / $production->quantity_used) * 100;
                                @endphp
                                <span class="px-2 py-1 text-xs font-medium
                                    {{ $efficiency >= 80 ? 'bg-green-100 text-green-800' :
                                       ($efficiency >= 60 ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }} rounded-full">
                                    {{ number_format($efficiency, 1) }}%
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <div class="flex space-x-2">
                                    <a href="{{ route('manajemenproduksi.edit', $production->id) }}"
                                       class="text-blue-600 hover:text-blue-900 transition duration-200">
                                        <i class="fas fa-edit"></i> Edit
                                    </a>
                                    <form action="{{ route('koordinator.production.destroy', $production->id) }}"
                                          method="POST"
                                          class="inline"
                                          onsubmit="return confirm('Apakah Anda yakin ingin menghapus data produksi ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-900 transition duration-200">
                                            <i class="fas fa-trash"></i> Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="px-6 py-4 text-center text-gray-500">
                                <div class="flex flex-col items-center justify-center py-8">
                                    <i class="fas fa-inbox text-4xl text-gray-300 mb-2"></i>
                                    <p class="text-gray-500">Belum ada data produksi</p>
                                    <a href="{{ route('manajemenproduksi.create') }}"
                                       class="mt-2 text-yellow-600 hover:text-yellow-700 font-medium">
                                        Tambah data produksi pertama
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination (jika diperlukan) -->
            {{-- @if($productions->hasPages())
            <div class="bg-white px-6 py-4 border-t border-gray-200">
                {{ $productions->links() }}
            </div>
            @endif --}}
        </div>

        <!-- Summary Cards -->
        <div class="mt-8 grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- Total Production -->
            <div class="bg-white rounded-xl shadow-md p-6 border-l-4 border-blue-500">
                <div class="flex items-center">
                    <div class="p-3 bg-blue-100 rounded-lg">
                        <i class="fas fa-industry text-blue-600 text-xl"></i>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-sm font-medium text-gray-600">Total Produksi</h3>
                        <p class="text-2xl font-bold text-gray-800">{{ $productions->count() }}</p>
                    </div>
                </div>
            </div>

            <!-- Total Quantity Produced -->
            <div class="bg-white rounded-xl shadow-md p-6 border-l-4 border-green-500">
                <div class="flex items-center">
                    <div class="p-3 bg-green-100 rounded-lg">
                        <i class="fas fa-boxes text-green-600 text-xl"></i>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-sm font-medium text-gray-600">Total Barang Diproduksi</h3>
                        <p class="text-2xl font-bold text-gray-800">
                            {{ $productions->sum('quantity_produced') }} pcs
                        </p>
                    </div>
                </div>
            </div>

            <!-- Average Efficiency -->
            <div class="bg-white rounded-xl shadow-md p-6 border-l-4 border-yellow-500">
                <div class="flex items-center">
                    <div class="p-3 bg-yellow-100 rounded-lg">
                        <i class="fas fa-chart-line text-yellow-600 text-xl"></i>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-sm font-medium text-gray-600">Efisiensi Rata-rata</h3>
                        <p class="text-2xl font-bold text-gray-800">
                            @php
                                $totalEfficiency = 0;
                                $count = $productions->count();
                                foreach($productions as $production) {
                                    $efficiency = ($production->quantity_produced / $production->quantity_used) * 100;
                                    $totalEfficiency += $efficiency;
                                }
                                $averageEfficiency = $count > 0 ? $totalEfficiency / $count : 0;
                            @endphp
                            {{ number_format($averageEfficiency, 1) }}%
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
