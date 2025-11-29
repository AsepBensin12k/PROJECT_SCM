<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buat Jadwal Produksi</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<body class="bg-gray-100">
    <nav class="bg-gradient-to-r from-amber-500 to-orange-500 shadow-xl sticky top-0 z-50 border-b border-amber-200">
        <div class="max-w-7xl mx-auto px-6 flex justify-between items-center h-16">
            <div class="flex items-center space-x-3">
                <div class="bg-white/20 p-2 rounded-xl border border-white/30">
                    <i class="fas fa-plus text-white"></i>
                </div>
                <span class="text-white font-bold text-lg">Tambah Jadwal Produksi</span>
            </div>
        </div>
    </nav>

    <div class="flex">
        @include('components.koordinator-sidebar')

        <main class="flex-1 p-8 ml-64">
            <div class="bg-white rounded-xl shadow-md p-8 max-w-3xl mx-auto">
                <h1 class="text-2xl font-bold text-amber-700 mb-6">🧾 Buat Jadwal Produksi</h1>

                <form action="{{ route('manajemenproduksi.store') }}" method="POST" id="formProduksi"
                    class="space-y-6">
                    @csrf
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Produk</label>
                        <select name="product_id" class="w-full border rounded-lg p-2" required>
                            <option value="">-- Pilih Produk --</option>
                            @foreach ($products as $product)
                                <option value="{{ $product->id }}">{{ $product->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Tanggal Produksi</label>
                        <input type="date" name="production_date" class="w-full border rounded-lg p-2" required>
                    </div>

                    <div id="bahanContainer">
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Bahan Baku Digunakan</label>
                    </div>

                    <button type="button" id="tambahBahan" class="text-amber-600 text-sm font-semibold mb-4">
                        <i class="fas fa-plus"></i> Tambah Bahan
                    </button>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Jumlah Produk Dihasilkan</label>
                        <input type="number" name="quantity_produced" class="w-full border rounded-lg p-2"
                            min="1" required>
                    </div>

                    <div class="flex justify-end gap-3">
                        <a href="{{ route('koordinator.productions.index') }}"
                            class="px-4 py-2 bg-gray-200 hover:bg-gray-300 rounded-lg">Batal</a>
                        <button type="submit"
                            class="px-4 py-2 bg-amber-600 hover:bg-amber-700 text-white rounded-lg">Simpan</button>
                    </div>
                </form>
            </div>
        </main>
    </div>

    <script>
        const materials = @json($materials);
        const bahanContainer = document.getElementById('bahanContainer');
        const tambahBahanBtn = document.getElementById('tambahBahan');

        function updateDropdownOptions() {
            const selected = Array.from(document.querySelectorAll('select[name="materials[]"]')).map(s => s.value);

            document.querySelectorAll('select[name="materials[]"]').forEach(select => {
                const current = select.value;
                select.innerHTML = '<option value="">-- Pilih Bahan --</option>';
                materials.forEach(mat => {
                    if (!selected.includes(mat.id.toString()) || mat.id.toString() === current) {
                        const opt = document.createElement('option');
                        opt.value = mat.id;
                        opt.textContent = mat.name;
                        if (mat.id.toString() === current) opt.selected = true;
                        select.appendChild(opt);
                    }
                });
            });
        }

        tambahBahanBtn.addEventListener('click', () => {
            const div = document.createElement('div');
            div.className = 'flex items-center gap-3 mb-2 bahan-item';

            const select = document.createElement('select');
            select.name = 'materials[]';
            select.className = 'w-2/3 border rounded-lg p-2';
            select.innerHTML = '<option value="">-- Pilih Bahan --</option>';
            materials.forEach(mat => {
                select.innerHTML += `<option value="${mat.id}">${mat.name}</option>`;
            });

            const qty = document.createElement('input');
            qty.type = 'number';
            qty.name = 'quantities[]';
            qty.placeholder = 'Qty';
            qty.min = '1';
            qty.className = 'w-1/3 border rounded-lg p-2';

            const removeBtn = document.createElement('button');
            removeBtn.type = 'button';
            removeBtn.innerHTML = '<i class="fas fa-trash text-red-500"></i>';
            removeBtn.onclick = () => {
                div.remove();
                updateDropdownOptions();
            };

            select.addEventListener('change', updateDropdownOptions);

            div.append(select, qty, removeBtn);
            bahanContainer.appendChild(div);

            updateDropdownOptions();
        });
    </script>
</body>

</html>
