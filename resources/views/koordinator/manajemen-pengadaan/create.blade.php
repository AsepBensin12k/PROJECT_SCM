<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buat Pengadaan</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<body class="bg-gray-100">
    <nav class="bg-gradient-to-r from-amber-500 to-orange-500 shadow-xl sticky top-0 z-50 border-b border-amber-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex justify-between items-center">
            <div class="flex items-center space-x-3">
                <div class="bg-white/20 p-2 rounded-xl border border-white/30">
                    <i class="fas fa-plus text-white text-lg"></i>
                </div>
                <span class="text-white font-bold text-lg">Tambah Pengadaan</span>
            </div>
        </div>
    </nav>

    <div class="flex">
        @include('components.koordinator-sidebar')

        <main class="flex-1 p-8 ml-64">
            <div class="bg-white rounded-xl shadow-md p-8 max-w-3xl mx-auto">
                <h1 class="text-2xl font-bold text-amber-700 mb-6">🧾 Tambah Pengadaan</h1>

                <form action="{{ route('koordinator.procurements.store') }}" method="POST" class="space-y-5"
                    id="formPengadaan">
                    @csrf

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Bahan Baku</label>
                        <select name="material_id" id="materialSelect" class="w-full border rounded-lg p-2">
                            <option value="">-- Pilih Bahan Baku --</option>
                            @foreach ($materials as $m)
                                <option value="{{ $m->id }}" data-price="{{ $m->price }}">{{ $m->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Supplier</label>
                        <select name="supplier_id" class="w-full border rounded-lg p-2">
                            @foreach ($suppliers as $s)
                                <option value="{{ $s->id }}">{{ $s->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Tanggal Datang</label>
                            <input type="date" name="tanggal_datang" class="w-full border rounded-lg p-2" required>
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Quantity</label>
                            <input type="number" name="qty" id="qtyInput" class="w-full border rounded-lg p-2"
                                min="1" required>
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Total Harga (Rp)</label>
                        <input type="number" name="total_harga" id="totalHarga"
                            class="w-full border rounded-lg p-2 bg-gray-50" readonly>
                    </div>

                    <div class="flex justify-end gap-3 mt-6">
                        <a href="{{ route('koordinator.procurements') }}"
                            class="px-4 py-2 bg-gray-200 hover:bg-gray-300 rounded-lg">Batal</a>
                        <button type="submit"
                            class="px-4 py-2 bg-amber-600 hover:bg-amber-700 text-white rounded-lg">Simpan</button>
                    </div>
                </form>
            </div>
        </main>
    </div>

    <script>
        const materialSelect = document.getElementById('materialSelect');
        const qtyInput = document.getElementById('qtyInput');
        const totalHarga = document.getElementById('totalHarga');

        function updateTotal() {
            const selectedOption = materialSelect.options[materialSelect.selectedIndex];
            const harga = selectedOption ? parseFloat(selectedOption.getAttribute('data-price')) || 0 : 0;
            const qty = parseInt(qtyInput.value) || 0;
            totalHarga.value = harga * qty;
        }

        materialSelect.addEventListener('change', updateTotal);
        qtyInput.addEventListener('input', updateTotal);
    </script>
</body>

</html>
