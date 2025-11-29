<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Stok Produk Jadi</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .fade-in {
            animation: fadeIn 0.8s ease-in-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(8px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</head>

<body class="bg-gray-100 min-h-screen">

    <!-- 🔸 Navbar -->
    <nav
        class="bg-gradient-to-r from-amber-500 to-orange-500 shadow-xl sticky top-0 z-50 backdrop-blur-sm border-b border-amber-200">
        <div class="max-w-7xl mx-auto px-6">
            <div class="flex justify-between items-center h-16">
                <div class="flex items-center space-x-3">
                    <div class="bg-white/20 p-2 rounded-xl border border-white/30">
                        <i class="fas fa-cube text-white text-lg"></i>
                    </div>
                    <span class="text-white text-lg font-bold tracking-tight">Manajemen Stok Barang Jadi</span>
                </div>

                <div class="flex items-center space-x-4">
                    <a href="{{ route('koordinator.dashboard') }}"
                        class="flex items-center bg-white/20 hover:bg-white/30 px-4 py-2 rounded-lg text-white text-sm font-semibold transition">
                        <i class="fas fa-arrow-left mr-2"></i>Kembali
                    </a>
                    <div
                        class="bg-white/15 px-4 py-2 rounded-xl border border-white/30 text-white font-semibold text-sm">
                        <i class="fas fa-user mr-2 text-white/80"></i>{{ Auth::user()->name }}
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <div class="flex">
        @include('components.koordinator-sidebar')

        <main class="flex-1 p-8 ml-64 fade-in">
            <div class="flex justify-between items-center mb-6">
                <div>
                    <h1 class="text-3xl font-bold text-gray-800">Gudang Produk Jadi</h1>
                    <p class="text-gray-600 text-sm">Produk dari hasil produksi yang siap distribusi.</p>
                </div>

                <a href="{{ route('koordinator.products.create') }}"
                    class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded-lg shadow-md flex items-center transition">
                    <i class="fas fa-plus mr-2"></i> Tambah Produk Baru
                </a>
            </div>

            <!-- Search -->
            <div class="relative mb-4">
                <input id="searchInput" type="text" placeholder="Cari produk..."
                    class="w-full md:w-1/3 px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-amber-400 focus:outline-none">
                <i class="fas fa-search absolute right-3 top-3 text-gray-400"></i>
            </div>

            <!-- Tabel Produk -->
            <div class="bg-white rounded-xl shadow-lg overflow-hidden fade-in">
                <table class="w-full text-sm">
                    <thead class="bg-gray-50 border-b">
                        <tr>
                            <th class="px-6 py-3 text-left font-semibold text-gray-600">Nama Produk</th>
                            <th class="px-6 py-3 text-left font-semibold text-gray-600">Deskripsi</th>
                            <th class="px-6 py-3 text-left font-semibold text-gray-600">Harga</th>
                            <th class="px-6 py-3 text-left font-semibold text-gray-600">Stok</th>
                            <th class="px-6 py-3 text-left font-semibold text-gray-600">Status</th>
                        </tr>
                    </thead>
                    <tbody id="productTable" class="divide-y divide-gray-200">
                        @forelse($products as $product)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-6 py-4 font-medium text-gray-900">{{ $product->name }}</td>
                                <td class="px-6 py-4 text-gray-700">{{ $product->description ?? '-' }}</td>
                                <td class="px-6 py-4 text-gray-900">Rp {{ number_format($product->price, 0, ',', '.') }}
                                </td>
                                <td class="px-6 py-4">
                                    <span
                                        class="px-2 py-1 text-xs font-semibold rounded-full
                                    {{ $product->stock > 50
                                        ? 'bg-green-100 text-green-700'
                                        : ($product->stock > 10
                                            ? 'bg-yellow-100 text-yellow-700'
                                            : 'bg-red-100 text-red-700') }}">
                                        {{ $product->stock }} pcs
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    <span
                                        class="px-2 py-1 text-xs font-semibold rounded-full
                                    {{ $product->stock > 0 ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                                        {{ $product->stock > 0 ? 'Tersedia' : 'Habis' }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="py-8 text-center text-gray-500">
                                    <i class="fas fa-cube text-4xl text-gray-300 mb-2"></i>
                                    <p class="text-gray-500 mt-2">Belum ada produk terdaftar.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </main>
    </div>

    <!--  Script pencarian -->
    <script>
        const searchInput = document.getElementById('searchInput');
        const productTable = document.getElementById('productTable');

        searchInput.addEventListener('input', () => {
            const searchValue = searchInput.value.toLowerCase();
            Array.from(productTable.getElementsByTagName('tr')).forEach(row => {
                const nameCell = row.cells[0]?.textContent.toLowerCase();
                row.style.display = nameCell?.includes(searchValue) ? '' : 'none';
            });
        });
    </script>
</body>

</html>
