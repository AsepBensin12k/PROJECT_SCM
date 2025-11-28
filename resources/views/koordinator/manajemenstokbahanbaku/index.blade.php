<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Bahan Baku</title>
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
                    <a href="{{ route('koordinator.dashboard') }}" class="text-base font-bold text-white tracking-tight hover:text-amber-100 transition-all duration-300">
                        Manajemen Bahan Baku
                    </a>
                </div>

                <!-- User Info & Actions -->
                <div class="flex items-center space-x-4">

                    <!-- Back to Dashboard Button -->
                    <a href="{{ route('koordinator.dashboard') }}" class="group flex items-center space-x-2 bg-white/15 hover:bg-white/25 backdrop-blur-sm px-4 py-2 rounded-xl border border-white/20 hover:border-white/40 transition-all duration-300">
                        <i class="fas fa-arrow-left text-white text-sm group-hover:-translate-x-1 transition-transform duration-300"></i>
                        <span class="text-white text-sm font-semibold">Kembali ke Dashboard</span>
                    </a>

                    <!-- User Name -->
                    <div class="flex items-center space-x-3 bg-white/15 backdrop-blur-sm px-4 py-2 rounded-xl border border-white/20 shadow-lg">
                        <div class="bg-white/25 p-1.5 rounded-full border border-white/30">
                            <i class="fas fa-user text-white text-xs"></i>
                        </div>
                        <span class="text-white font-bold text-sm leading-tight">{{ Auth::user()->name }}</span>
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
            <!-- Header -->
            <div class="mb-8">
                <h1 class="text-3xl font-bold text-gray-800">Manajemen Bahan Baku</h1>
                <p class="text-gray-600 mt-2">Kelola semua data bahan baku dan stok</p>
            </div>

            <!-- Success Message -->
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg mb-6">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Action Buttons -->
            <div class="mb-6 flex justify-between items-center">
                <div class="flex space-x-4">
                    <a href="{{ route('koordinator.materials.create') }}"
                       class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded-lg transition duration-200 flex items-center">
                        <i class="fas fa-plus mr-2"></i> Tambah Bahan Baku
                    </a>
                </div>

                <!-- Statistics -->
                <div class="flex space-x-4 text-sm">
                    <span class="bg-blue-100 text-blue-800 px-3 py-1 rounded-full">
                        Total: {{ $materials->count() }} Bahan Baku
                    </span>
                </div>
            </div>

            <!-- Materials Table -->
            <div class="bg-white rounded-xl shadow-md overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Bahan</th>
                                <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Supplier</th>
                                <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Unit</th>
                                <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Stok</th>
                                <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Harga</th>
                                <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total Nilai</th>
                                <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($materials as $material)
                            <tr class="hover:bg-gray-50 transition duration-150">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900">{{ $material->name }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">{{ $material->supplier->name }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2 py-1 text-xs font-medium bg-gray-100 text-gray-800 rounded-full">
                                        {{ $material->unit }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2 py-1 text-xs font-medium
                                        {{ $material->stock > 50 ? 'bg-green-100 text-green-800' :
                                           ($material->stock > 10 ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }} rounded-full">
                                        {{ $material->stock }} {{ $material->unit }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900">
                                        Rp {{ number_format($material->price, 0, ',', '.') }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900">
                                        Rp {{ number_format($material->price * $material->stock, 0, ',', '.') }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <div class="flex space-x-2">
                                        <a href="{{ route('koordinator.materials.edit', $material->id) }}"
                                           class="text-blue-600 hover:text-blue-900 transition duration-200">
                                            <i class="fas fa-edit"></i> Edit
                                        </a>
                                        <form action="{{ route('koordinator.materials.destroy', $material->id) }}"
                                              method="POST"
                                              class="inline"
                                              onsubmit="return confirm('Apakah Anda yakin ingin menghapus bahan baku ini?')">
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
                                <td colspan="7" class="px-6 py-4 text-center text-gray-500">
                                    <div class="flex flex-col items-center justify-center py-8">
                                        <i class="fas fa-inbox text-4xl text-gray-300 mb-2"></i>
                                        <p class="text-gray-500">Belum ada data bahan baku</p>
                                        <a href="{{ route('koordinator.materials.create') }}"
                                           class="mt-2 text-yellow-600 hover:text-yellow-700 font-medium">
                                            Tambah bahan baku pertama
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Summary Cards -->
            <div class="mt-8 grid grid-cols-1 md:grid-cols-4 gap-6">
                <!-- Total Materials -->
                <div class="bg-white rounded-xl shadow-md p-6 border-l-4 border-blue-500">
                    <div class="flex items-center">
                        <div class="p-3 bg-blue-100 rounded-lg">
                            <i class="fas fa-boxes text-blue-600 text-xl"></i>
                        </div>
                        <div class="ml-4">
                            <h3 class="text-sm font-medium text-gray-600">Total Bahan Baku</h3>
                            <p class="text-2xl font-bold text-gray-800">{{ $materials->count() }}</p>
                        </div>
                    </div>
                </div>

                <!-- Total Stock -->
                <div class="bg-white rounded-xl shadow-md p-6 border-l-4 border-green-500">
                    <div class="flex items-center">
                        <div class="p-3 bg-green-100 rounded-lg">
                            <i class="fas fa-cubes text-green-600 text-xl"></i>
                        </div>
                        <div class="ml-4">
                            <h3 class="text-sm font-medium text-gray-600">Total Stok</h3>
                            <p class="text-2xl font-bold text-gray-800">
                                {{ $materials->sum('stock') }} Unit
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Total Value -->
                <div class="bg-white rounded-xl shadow-md p-6 border-l-4 border-yellow-500">
                    <div class="flex items-center">
                        <div class="p-3 bg-yellow-100 rounded-lg">
                            <i class="fas fa-money-bill-wave text-yellow-600 text-xl"></i>
                        </div>
                        <div class="ml-4">
                            <h3 class="text-sm font-medium text-gray-600">Total Nilai Stok</h3>
                            <p class="text-2xl font-bold text-gray-800">
                                Rp {{ number_format($materials->sum(function($material) {
                                    return $material->price * $material->stock;
                                }), 0, ',', '.') }}
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Low Stock Alert -->
                <div class="bg-white rounded-xl shadow-md p-6 border-l-4 border-red-500">
                    <div class="flex items-center">
                        <div class="p-3 bg-red-100 rounded-lg">
                            <i class="fas fa-exclamation-triangle text-red-600 text-xl"></i>
                        </div>
                        <div class="ml-4">
                            <h3 class="text-sm font-medium text-gray-600">Stok Rendah</h3>
                            <p class="text-2xl font-bold text-gray-800">
                                {{ $materials->where('stock', '<', 10)->count() }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
