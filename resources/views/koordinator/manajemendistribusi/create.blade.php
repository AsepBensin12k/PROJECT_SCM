<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Distribusi</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-100">
    <nav class="bg-gradient-to-r from-amber-500 to-orange-500 shadow-xl sticky top-0 z-50 border-b border-amber-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <!-- Logo & Brand -->
                <div class="flex items-center space-x-3">
                    <div class="bg-white/20 p-2 rounded-xl border border-white/30">
                        <i class="fas fa-industry text-white text-lg"></i>
                    </div>
                    <div class="flex flex-col">
                        <a href="{{ route('koordinator.dashboard') }}" class="text-white font-bold text-lg tracking-tight hover:text-amber-100 transition duration-200">
                            Manajemen Distribusi
                        </a>
                    </div>
                </div>

                <!-- User Info & Actions -->
                <div class="flex items-center space-x-4">
                    <!-- Back to Dashboard Button -->
                    <a href="{{ route('koordinator.dashboard') }}" class="flex items-center space-x-2 bg-white/20 px-4 py-2 rounded-xl border border-white/30 hover:bg-white/30 transition-all duration-200 group">
                        <i class="fas fa-arrow-left text-white text-sm group-hover:-translate-x-1 transition-transform duration-200"></i>
                        <span class="text-white text-sm font-semibold">Kembali ke Dashboard</span>
                    </a>

                    <!-- User Profile -->
                    <div class="flex items-center space-x-3 bg-white/20 px-4 py-2 rounded-xl border border-white/30">
                        <div class="bg-white/30 p-1.5 rounded-full">
                            <i class="fas fa-user-tie text-white text-sm"></i>
                        </div>
                        <div class="flex flex-col">
                            <span class="text-white text-sm font-semibold leading-none">{{ Auth::user()->name }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="max-w-4xl mx-auto py-8 px-4">
        <div class="bg-white rounded-xl shadow-md p-8">
            <!-- Header -->
            <div class="mb-8">
                <h1 class="text-3xl font-bold text-gray-800">Tambah Distribusi Baru</h1>
                <p class="text-gray-600 mt-2">Isi form berikut untuk menambahkan data distribusi baru</p>
            </div>

            <!-- Form -->
            <form action="{{ route('koordinator.distributions.store') }}" method="POST">
                @csrf

                <div class="grid grid-cols-1 gap-6">
                    <!-- Produk -->
                    <div>
                        <label for="product_id" class="block text-sm font-medium text-gray-700 mb-2">Produk *</label>
                        <select id="product_id"
                                name="product_id"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500 transition duration-200"
                                required>
                            <option value="">Pilih Produk</option>
                            @foreach($products as $product)
                                <option value="{{ $product->id }}" {{ old('product_id') == $product->id ? 'selected' : '' }}>
                                    {{ $product->name }} (Stok: {{ $product->stock }} pcs)
                                </option>
                            @endforeach
                        </select>
                        @error('product_id')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Tujuan Distribusi -->
                    <div>
                        <label for="destination" class="block text-sm font-medium text-gray-700 mb-2">Tujuan Distribusi *</label>
                        <input type="text"
                               id="destination"
                               name="destination"
                               value="{{ old('destination') }}"
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500 transition duration-200"
                               placeholder="Masukkan tujuan distribusi"
                               required>
                        @error('destination')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Quantity -->
                        <div>
                            <label for="quantity" class="block text-sm font-medium text-gray-700 mb-2">Quantity *</label>
                            <input type="number"
                                   id="quantity"
                                   name="quantity"
                                   value="{{ old('quantity') }}"
                                   min="1"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500 transition duration-200"
                                   placeholder="0"
                                   required>
                            @error('quantity')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Tanggal Distribusi -->
                        <div>
                            <label for="distribution_date" class="block text-sm font-medium text-gray-700 mb-2">Tanggal Distribusi *</label>
                            <input type="date"
                                   id="distribution_date"
                                   name="distribution_date"
                                   value="{{ old('distribution_date', date('Y-m-d')) }}"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500 transition duration-200"
                                   required>
                            @error('distribution_date')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Status -->
                        <div>
                            <label for="status" class="block text-sm font-medium text-gray-700 mb-2">Status *</label>
                            <select id="status"
                                    name="status"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500 transition duration-200"
                                    required>
                                <option value="diproses" {{ old('status') == 'diproses' ? 'selected' : '' }}>Diproses</option>
                                <option value="dikirim" {{ old('status') == 'dikirim' ? 'selected' : '' }}>Dikirim</option>
                                <option value="selesai" {{ old('status') == 'selesai' ? 'selected' : '' }}>Selesai</option>
                                <option value="dibatalkan" {{ old('status') == 'dibatalkan' ? 'selected' : '' }}>Dibatalkan</option>
                            </select>
                            @error('status')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Catatan -->
                    <div>
                        <label for="notes" class="block text-sm font-medium text-gray-700 mb-2">Catatan</label>
                        <textarea id="notes"
                                  name="notes"
                                  rows="3"
                                  class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500 transition duration-200"
                                  placeholder="Masukkan catatan tambahan (opsional)">{{ old('notes') }}</textarea>
                        @error('notes')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="mt-8 flex justify-end space-x-4">
                    <a href="{{ route('koordinator.distributions') }}"
                       class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-6 py-3 rounded-lg transition duration-200 font-medium">
                        Batal
                    </a>
                    <button type="submit"
                            class="bg-yellow-500 hover:bg-yellow-600 text-white px-6 py-3 rounded-lg transition duration-200 font-medium flex items-center">
                        <i class="fas fa-save mr-2"></i> Simpan Distribusi
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Real-time stock validation
        document.getElementById('product_id').addEventListener('change', function() {
            const productId = this.value;
            const quantityInput = document.getElementById('quantity');

            if (productId) {
                // In a real application, you might want to fetch current stock via AJAX
                // For now, we'll rely on the stock info in the option text
                const selectedOption = this.options[this.selectedIndex];
                const stockText = selectedOption.text.match(/Stok: (\d+)/);
                if (stockText) {
                    const currentStock = parseInt(stockText[1]);
                    quantityInput.setAttribute('max', currentStock);

                    if (quantityInput.value > currentStock) {
                        quantityInput.value = currentStock;
                    }
                }
            }
        });
    </script>
</body>
</html>
