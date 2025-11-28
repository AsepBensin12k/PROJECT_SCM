<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Supplier - ROJEMBER</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
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
                        <i class="fas fa-truck-loading text-white text-lg"></i>
                    </div>
                    <div class="flex flex-col">
                        <span class="text-white font-bold text-lg tracking-tight">Manajemen Supplier</span>
                        <span class="text-purple-100 text-xs font-medium">ROJEMBER</span>
                    </div>
                </div>

                <!-- User -->
                <div class="flex items-center space-x-4">
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

    <!-- Sidebar & Content -->
    <div class="flex">
        @include('components.owner-sidebar')

        <div class="flex-1 p-8 ml-64">
            <!-- Header -->
            <div class="mb-6 flex justify-between items-center">
                <div>
                    <h1 class="text-3xl font-bold text-gray-800 flex items-center">
                        <i class="fas fa-truck-loading text-purple-600 mr-3"></i> Manajemen Supplier
                    </h1>
                    <p class="text-gray-500 text-sm mt-1">Kelola data supplier bahan baku untuk produksi</p>
                </div>
                <div class="text-right">
                    <p class="text-sm text-gray-500">Terakhir diperbarui</p>
                    <p class="text-sm font-semibold text-gray-700">{{ now()->format('d M Y, H:i') }}</p>
                </div>
            </div>

            <!-- Alert -->
            @if (session('success'))
                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded mb-6 flex items-center">
                    <i class="fas fa-check-circle mr-3 text-xl"></i>
                    <div>
                        <p class="font-bold">Berhasil!</p>
                        <p class="text-sm">{{ session('success') }}</p>
                    </div>
                </div>
            @endif

            @if (session('error'))
                <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded mb-6 flex items-center">
                    <i class="fas fa-exclamation-circle mr-3 text-xl"></i>
                    <div>
                        <p class="font-bold">Gagal!</p>
                        <p class="text-sm">{{ session('error') }}</p>
                    </div>
                </div>
            @endif

            <!-- Statistik -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                <div class="bg-gradient-to-br from-purple-500 to-purple-600 rounded-lg shadow-lg p-6 text-white">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-purple-100 text-sm font-medium mb-1">Total Supplier</p>
                            <p class="text-4xl font-bold">{{ $suppliers->count() }}</p>
                            <p class="text-purple-100 text-xs mt-2">Semua supplier terdaftar</p>
                        </div>
                        <div class="bg-white bg-opacity-20 p-4 rounded-full">
                            <i class="fas fa-truck-loading text-4xl"></i>
                        </div>
                    </div>
                </div>

                <div class="bg-gradient-to-br from-green-500 to-green-600 rounded-lg shadow-lg p-6 text-white">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-green-100 text-sm font-medium mb-1">Supplier Aktif</p>
                            <p class="text-4xl font-bold">{{ $activeSuppliers }}</p>
                            <p class="text-green-100 text-xs mt-2">Siap untuk supply</p>
                        </div>
                        <div class="bg-white bg-opacity-20 p-4 rounded-full">
                            <i class="fas fa-check-circle text-4xl"></i>
                        </div>
                    </div>
                </div>

                <div class="bg-gradient-to-br from-red-500 to-red-600 rounded-lg shadow-lg p-6 text-white">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-red-100 text-sm font-medium mb-1">Supplier Non-Aktif</p>
                            <p class="text-4xl font-bold">{{ $inactiveSuppliers }}</p>
                            <p class="text-red-100 text-xs mt-2">Tidak beroperasi</p>
                        </div>
                        <div class="bg-white bg-opacity-20 p-4 rounded-full">
                            <i class="fas fa-times-circle text-4xl"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Action Bar -->
            <div
                class="bg-white rounded-xl shadow-md mb-6 p-4 flex flex-col md:flex-row justify-between items-center gap-4">
                <div class="flex flex-wrap gap-2">
                    <button onclick="filterSuppliers('all')" id="btn-all"
                        class="px-5 py-2.5 bg-purple-600 text-white rounded-lg shadow-md hover:bg-purple-700 transition duration-200 font-medium">
                        <i class="fas fa-list mr-2"></i>Semua
                    </button>
                    <button onclick="filterSuppliers('aktif')" id="btn-aktif"
                        class="px-5 py-2.5 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition duration-200 font-medium">
                        <i class="fas fa-check-circle mr-2"></i>Aktif
                    </button>
                    <button onclick="filterSuppliers('non-aktif')" id="btn-non-aktif"
                        class="px-5 py-2.5 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition duration-200 font-medium">
                        <i class="fas fa-times-circle mr-2"></i>Non-Aktif
                    </button>
                </div>

                <!-- Tombol Tambah Supplier -->
                <a href="{{ route('owner.suppliers.create') }}"
                    class="px-5 py-2.5 bg-gradient-to-r from-purple-600 to-purple-700 text-white rounded-lg hover:from-purple-700 hover:to-purple-800 transition duration-200 font-medium shadow-md">
                    <i class="fas fa-plus mr-2"></i>Tambah Supplier
                </a>
            </div>

            <!-- Tabel -->
            <div class="bg-white rounded-xl shadow-md overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 text-sm">
                        <thead class="bg-gradient-to-r from-purple-600 to-purple-700 text-white">
                            <tr>
                                <th class="px-6 py-3 text-left font-semibold uppercase tracking-wider">No</th>
                                <th class="px-6 py-3 text-left font-semibold uppercase tracking-wider">Nama Supplier
                                </th>
                                <th class="px-6 py-3 text-left font-semibold uppercase tracking-wider">Asal</th>
                                <th class="px-6 py-3 text-left font-semibold uppercase tracking-wider">Kontak</th>
                                <th class="px-6 py-3 text-left font-semibold uppercase tracking-wider">Status</th>
                                <th class="px-6 py-3 text-left font-semibold uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($suppliers as $index => $supplier)
                                <tr class="hover:bg-gray-50 transition duration-150 supplier-row"
                                    data-status="{{ $supplier->status }}">
                                    <td class="px-6 py-4">{{ $index + 1 }}</td>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center">
                                            <div
                                                class="h-10 w-10 bg-purple-100 rounded-full flex items-center justify-center">
                                                <i class="fas fa-truck-loading text-purple-600"></i>
                                            </div>
                                            <div class="ml-3">
                                                <p class="font-semibold text-gray-800">{{ $supplier->name }}</p>
                                                <p class="text-xs text-gray-500">ID:
                                                    #SUP{{ str_pad($supplier->id, 4, '0', STR_PAD_LEFT) }}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-gray-700">
                                        <i
                                            class="fas fa-map-marker-alt text-gray-400 mr-1"></i>{{ $supplier->origin ?? '-' }}
                                    </td>
                                    <td class="px-6 py-4 text-gray-700">
                                        <i class="fas fa-phone text-gray-400 mr-1"></i>{{ $supplier->contact ?? '-' }}
                                    </td>
                                    <td class="px-6 py-4">
                                        @if ($supplier->status === 'aktif')
                                            <span
                                                class="px-3 py-1 bg-green-100 text-green-800 text-xs font-bold rounded-full">
                                                <i class="fas fa-check-circle mr-1"></i>Aktif
                                            </span>
                                        @else
                                            <span
                                                class="px-3 py-1 bg-red-100 text-red-800 text-xs font-bold rounded-full">
                                                <i class="fas fa-times-circle mr-1"></i>Non-Aktif
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex space-x-3">
                                            <!-- Tombol Edit -->
                                            <a href="{{ route('owner.suppliers.edit', $supplier->id) }}"
                                                class="text-blue-600 hover:text-blue-800">
                                                <i class="fas fa-edit"></i>
                                            </a>

                                            <!-- Toggle -->
                                            <form action="{{ route('owner.suppliers.toggle', $supplier->id) }}"
                                                method="POST" class="inline">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="text-yellow-600 hover:text-yellow-800"
                                                    onclick="return confirm('Ubah status supplier ini?')">
                                                    <i class="fas fa-toggle-on"></i>
                                                </button>
                                            </form>

                                            <!-- Hapus -->
                                            <form action="{{ route('owner.suppliers.destroy', $supplier->id) }}"
                                                method="POST" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-800"
                                                    onclick="return confirm('Hapus supplier ini?')">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center py-8 text-gray-500">
                                        <i class="fas fa-inbox text-4xl text-gray-300 mb-2"></i>
                                        <p>Belum ada data supplier</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Script -->
    <script>
        function filterSuppliers(status) {
            const rows = document.querySelectorAll('.supplier-row');
            const buttons = {
                all: document.getElementById('btn-all'),
                aktif: document.getElementById('btn-aktif'),
                'non-aktif': document.getElementById('btn-non-aktif')
            };
            Object.values(buttons).forEach(btn => btn.classList.remove('bg-purple-600', 'text-white', 'shadow-md'));
            Object.values(buttons).forEach(btn => btn.classList.add('bg-gray-200', 'text-gray-700'));

            if (status === 'all') {
                buttons.all.classList.add('bg-purple-600', 'text-white', 'shadow-md');
                rows.forEach(row => row.style.display = '');
            } else {
                buttons[status].classList.add('bg-purple-600', 'text-white', 'shadow-md');
                rows.forEach(row => row.style.display = (row.dataset.status === status) ? '' : 'none');
            }
        }
    </script>
</body>

</html>
