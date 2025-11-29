<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Jadwal Produksi</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<body class="bg-gray-100">
    <nav class="bg-gradient-to-r from-amber-500 to-orange-500 shadow-xl sticky top-0 z-50 border-b border-amber-200">
        <div class="max-w-7xl mx-auto px-6 flex justify-between items-center h-16">
            <div class="flex items-center space-x-3">
                <div class="bg-white/20 p-2 rounded-xl border border-white/30">
                    <i class="fas fa-edit text-white"></i>
                </div>
                <span class="text-white font-bold text-lg">Edit Jadwal Produksi</span>
            </div>
        </div>
    </nav>

    <div class="flex">
        @include('components.koordinator-sidebar')

        <main class="flex-1 p-8 ml-64">
            <div class="bg-white rounded-xl shadow-md p-8 max-w-3xl mx-auto">
                <h1 class="text-2xl font-bold text-amber-700 mb-6">✏️ Edit Jadwal Produksi</h1>

                <form action="{{ route('manajemenproduksi.update', $production->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Tanggal Produksi</label>
                        <input type="date" name="production_date" value="{{ $production->production_date }}"
                            class="w-full border rounded-lg p-2">
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Jumlah Produk Dihasilkan</label>
                        <input type="number" name="quantity_produced" value="{{ $production->quantity_produced }}"
                            class="w-full border rounded-lg p-2">
                    </div>

                    <div class="flex justify-end gap-3 mt-6">
                        <a href="{{ route('koordinator.productions.index') }}"
                            class="px-4 py-2 bg-gray-200 hover:bg-gray-300 rounded-lg">Batal</a>
                        <button type="submit"
                            class="px-4 py-2 bg-amber-600 hover:bg-amber-700 text-white rounded-lg">Simpan
                            Perubahan</button>
                    </div>
                </form>
            </div>
        </main>
    </div>
</body>

</html>
