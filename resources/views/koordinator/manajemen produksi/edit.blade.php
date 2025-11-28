<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Produksi</title>
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
                    <a href="{{ route('manajemenproduksi') }}" class="group flex items-center space-x-2 bg-white/15 hover:bg-white/25 backdrop-blur-sm px-4 py-2 rounded-xl border border-white/20 hover:border-white/40 transition-all duration-300">
                        <i class="fas fa-arrow-left text-white text-sm group-hover:-translate-x-1 transition-transform duration-300"></i>
                        <span class="text-white text-sm font-semibold">Kembali</span>
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

    <div class="max-w-4xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
        <div class="bg-white rounded-xl shadow-md p-6">
            <h1 class="text-2xl font-bold text-gray-800 mb-6">Edit Data Produksi</h1>

            <form action="{{ route('manajemenproduksi.update', $production->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Product Selection -->
                    <div>
                        <label for="product_id" class="block text-sm font-medium text-gray-700 mb-2">Produk</label>
                        <select name="product_id" id="product_id" required
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500 transition duration-200">
                            <option value="">Pilih Produk</option>
                            @foreach($products as $product)
                            <option value="{{ $product->id }}" {{ $production->product_id == $product->id ? 'selected' : '' }}>
                                {{ $product->name }} - Stock: {{ $product->stock }}
                            </option>
                            @endforeach
                        </select>
                        @error('product_id')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Material Selection -->
                    <div>
                        <label for="material_id" class="block text-sm font-medium text-gray-700 mb-2">Bahan Baku</label>
                        <select name="material_id" id="material_id" required
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500 transition duration-200">
                            <option value="">Pilih Bahan Baku</option>
                            @foreach($materials as $material)
                            <option value="{{ $material->id }}" {{ $production->material_id == $material->id ? 'selected' : '' }}>
                                {{ $material->name }} - Stock: {{ $material->stock }} {{ $material->unit }}
                            </option>
                            @endforeach
                        </select>
                        @error('material_id')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Operator Selection -->
                    <div>
                        <label for="user_id" class="block text-sm font-medium text-gray-700 mb-2">Operator</label>
                        <select name="user_id" id="user_id" required
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500 transition duration-200">
                            <option value="">Pilih Operator</option>
                            @foreach($users as $user)
                            <option value="{{ $user->id }}" {{ $production->user_id == $user->id ? 'selected' : '' }}>
                                {{ $user->name }}
                            </option>
                            @endforeach
                        </select>
                        @error('user_id')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Production Date -->
                    <div>
                        <label for="production_date" class="block text-sm font-medium text-gray-700 mb-2">Tanggal Produksi</label>
                        <input type="date" name="production_date" id="production_date" required
                               value="{{ \Carbon\Carbon::parse($production->production_date)->format('Y-m-d') }}"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500 transition duration-200">
                        @error('production_date')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Quantity Used -->
                    <div>
                        <label for="quantity_used" class="block text-sm font-medium text-gray-700 mb-2">Quantity Bahan Baku Digunakan</label>
                        <input type="number" name="quantity_used" id="quantity_used" required min="1"
                               value="{{ $production->quantity_used }}" step="0.01"
                               placeholder="Masukkan quantity bahan baku"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500 transition duration-200">
                        @error('quantity_used')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Quantity Produced -->
                    <div>
                        <label for="quantity_produced" class="block text-sm font-medium text-gray-700 mb-2">Quantity Produk Dihasilkan</label>
                        <input type="number" name="quantity_produced" id="quantity_produced" required min="1"
                               value="{{ $production->quantity_produced }}"
                               placeholder="Masukkan quantity produk"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500 transition duration-200">
                        @error('quantity_produced')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Efficiency Preview -->
                <div class="mt-6 p-4 bg-gray-50 rounded-lg">
                    <h3 class="text-sm font-medium text-gray-700 mb-2">Preview Efisiensi</h3>
                    <div class="flex items-center space-x-4">
                        <span class="text-sm text-gray-600">Efisiensi: </span>
                        <span id="efficiency-preview" class="px-3 py-1 text-sm font-medium bg-green-100 text-green-800 rounded-full">
                            @php
                                $efficiency = ($production->quantity_produced / $production->quantity_used) * 100;
                            @endphp
                            {{ number_format($efficiency, 1) }}%
                        </span>
                        <span class="text-sm text-gray-500">(Output / Input × 100%)</span>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="mt-8 flex justify-end space-x-4">
                    <a href="{{ route('manajemenproduksi.edit', $production->id) }}"
                       class="px-6 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition duration-200">
                        Batal
                    </a>
                    <button type="submit"
                            class="px-6 py-2 bg-yellow-500 text-white rounded-lg hover:bg-yellow-600 transition duration-200 flex items-center">
                        <i class="fas fa-save mr-2"></i> Update Produksi
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Calculate efficiency in real-time
        function calculateEfficiency() {
            const quantityUsed = parseFloat(document.getElementById('quantity_used').value) || 0;
            const quantityProduced = parseFloat(document.getElementById('quantity_produced').value) || 0;

            if (quantityUsed > 0 && quantityProduced > 0) {
                const efficiency = (quantityProduced / quantityUsed) * 100;
                const efficiencyElement = document.getElementById('efficiency-preview');

                efficiencyElement.textContent = efficiency.toFixed(1) + '%';

                // Change color based on efficiency
                if (efficiency >= 80) {
                    efficiencyElement.className = 'px-3 py-1 text-sm font-medium bg-green-100 text-green-800 rounded-full';
                } else if (efficiency >= 60) {
                    efficiencyElement.className = 'px-3 py-1 text-sm font-medium bg-yellow-100 text-yellow-800 rounded-full';
                } else {
                    efficiencyElement.className = 'px-3 py-1 text-sm font-medium bg-red-100 text-red-800 rounded-full';
                }
            }
        }

        document.getElementById('quantity_used').addEventListener('input', calculateEfficiency);
        document.getElementById('quantity_produced').addEventListener('input', calculateEfficiency);
    </script>
</body>
</html>
