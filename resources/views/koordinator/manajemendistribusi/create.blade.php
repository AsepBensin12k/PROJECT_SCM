<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Distribusi</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<body class="bg-amber-50">
    <nav class="bg-gradient-to-r from-amber-500 to-orange-500 shadow-xl sticky top-0 z-50 border-b border-amber-200">
        <div class="max-w-7xl mx-auto px-6 flex justify-between items-center h-16">
            <div class="flex items-center space-x-3 text-white font-bold text-lg">
                <i class="fas fa-plus-circle"></i>
                <span>Tambah Distribusi</span>
            </div>
            <div class="flex items-center space-x-3 bg-white/20 px-4 py-2 rounded-xl border border-white/30">
                <i class="fas fa-user-tie text-white"></i>
                <span class="text-white text-sm">{{ Auth::user()->name }}</span>
            </div>
        </div>
    </nav>

    <div class="flex">
        @include('components.koordinator-sidebar')

        <main class="flex-1 ml-64 p-8">
            <div class="max-w-3xl mx-auto bg-white rounded-xl shadow p-8 border border-amber-100">
                <h2 class="text-2xl font-bold text-amber-800 mb-6"><i class="fas fa-plus mr-2"></i> Tambah Distribusi
                    Baru</h2>

                <form action="{{ route('koordinator.distributions.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="status" value="diproses">

                    <div class="mb-4">
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Produk</label>
                        <select name="product_id" required
                            class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-amber-400">
                            <option value="">-- Pilih Produk --</option>
                            @foreach ($products as $p)
                                <option value="{{ $p->id }}">{{ $p->name }} (Stok: {{ $p->stock }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Tujuan Distribusi</label>
                        <input type="text" name="destination" required
                            class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-amber-400">
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Jumlah Barang</label>
                        <input type="number" name="quantity" min="1" required
                            class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-amber-400">
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Catatan (Opsional)</label>
                        <textarea name="notes" rows="3" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-amber-400"></textarea>
                    </div>

                    <div class="flex justify-end space-x-3">
                        <a href="{{ route('koordinator.distributions') }}"
                            class="bg-gray-200 hover:bg-gray-300 text-gray-800 px-5 py-2 rounded-lg">
                            Batal
                        </a>
                        <button type="submit"
                            class="bg-amber-500 hover:bg-amber-600 text-white px-6 py-2 rounded-lg flex items-center">
                            <i class="fas fa-save mr-2"></i> Simpan
                        </button>
                    </div>
                </form>
            </div>
        </main>
    </div>
</body>

</html>
