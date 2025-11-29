<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Stok Produk Jadi</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
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
                    <span class="text-white text-lg font-bold tracking-tight">Tambah Produk Baru</span>
                </div>

                <div class="flex items-center space-x-4">
                    <a href="{{ route('koordinator.products') }}"
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

    <div class="max-w-3xl mx-auto mt-10 bg-white p-8 rounded-xl shadow-xl">
        <h1 class="text-2xl font-bold text-gray-800 mb-6">Form Tambah Produk</h1>
        <form action="{{ route('koordinator.products.store') }}" method="POST">
            @csrf
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nama Produk *</label>
                    <input type="text" name="name" required
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-amber-400">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Deskripsi</label>
                    <textarea name="description" rows="3"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-amber-400"></textarea>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Harga (Rp)</label>
                    <input type="number" name="price" min="0" step="0.01" required
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-amber-400">
                </div>
            </div>
            <div class="mt-8 flex justify-end space-x-4">
                <a href="{{ route('koordinator.products') }}"
                    class="bg-gray-300 hover:bg-gray-400 px-6 py-3 rounded-lg font-medium text-gray-700 transition">Batal</a>
                <button type="submit"
                    class="bg-amber-500 hover:bg-amber-600 text-white px-6 py-3 rounded-lg shadow-md font-medium transition">
                    <i class="fas fa-save mr-2"></i> Simpan Produk
                </button>
            </div>
        </form>
    </div>
</body>

</html>
