<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Supplier - RO JEMBER</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<body class="bg-gray-100 font-sans antialiased">
    <!-- Navbar -->
    <nav class="bg-gradient-to-r from-purple-600 to-indigo-600 shadow-lg sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <div class="flex items-center space-x-3">
                    <div class="bg-white/20 p-2 rounded-xl border border-white/30">
                        <i class="fas fa-truck-loading text-white text-lg"></i>
                    </div>
                    <div>
                        <span class="text-white font-bold text-lg tracking-tight">Edit Supplier</span>
                        <p class="text-purple-100 text-xs">RO JEMBER</p>
                    </div>
                </div>
                <div class="flex items-center bg-white/20 px-3 py-1.5 rounded-lg space-x-2">
                    <i class="fas fa-user text-white text-sm"></i>
                    <span class="text-white text-sm">{{ Auth::user()->name }}</span>
                </div>
            </div>
        </div>
    </nav>

    <!-- Layout -->
    <div class="flex">
        @include('components.owner-sidebar')

        <main class="flex-1 ml-64 p-8">
            <!-- Header -->
            <div class="mb-6 flex justify-between items-center">
                <div>
                    <h1 class="text-3xl font-bold text-gray-800 flex items-center">
                        <i class="fas fa-user-edit text-purple-600 mr-3"></i> Edit Supplier
                    </h1>
                    <p class="text-gray-500 text-sm mt-1">Ubah data supplier yang sudah ada</p>
                </div>
                <a href="{{ route('owner.suppliers') }}"
                    class="flex items-center px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-800 rounded-lg font-medium transition duration-200">
                    <i class="fas fa-arrow-left mr-2"></i>Kembali
                </a>
            </div>

            <!-- Alert -->
            @if ($errors->any())
                <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded mb-6">
                    <p class="font-bold mb-1">Terjadi Kesalahan:</p>
                    <ul class="list-disc list-inside text-sm">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Form -->
            <form action="{{ route('owner.suppliers.update', $supplier->id) }}" method="POST"
                class="bg-white shadow-lg rounded-xl p-8 max-w-2xl mx-auto border border-gray-100">
                @csrf
                @method('PUT')

                <div class="space-y-6">
                    <!-- Nama Supplier -->
                    <div>
                        <label for="name" class="block text-sm font-semibold text-gray-700 mb-2">
                            <i class="fas fa-user mr-2 text-purple-600"></i>Nama Supplier
                        </label>
                        <input type="text" name="name" id="name" required
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:outline-none transition-all"
                            placeholder="Masukkan nama supplier" value="{{ old('name', $supplier->name) }}">
                    </div>

                    <!-- Asal -->
                    <div>
                        <label for="origin" class="block text-sm font-semibold text-gray-700 mb-2">
                            <i class="fas fa-map-marker-alt mr-2 text-purple-600"></i>Asal
                        </label>
                        <input type="text" name="origin" id="origin"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:outline-none transition-all"
                            placeholder="Masukkan asal supplier" value="{{ old('origin', $supplier->origin) }}">
                    </div>

                    <!-- Kontak -->
                    <div>
                        <label for="contact" class="block text-sm font-semibold text-gray-700 mb-2">
                            <i class="fas fa-phone mr-2 text-purple-600"></i>Kontak
                        </label>
                        <input type="text" name="contact" id="contact"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:outline-none transition-all"
                            placeholder="Masukkan nomor atau email" value="{{ old('contact', $supplier->contact) }}">
                    </div>

                    <!-- Status -->
                    <div>
                        <label for="status" class="block text-sm font-semibold text-gray-700 mb-2">
                            <i class="fas fa-toggle-on mr-2 text-purple-600"></i>Status
                        </label>
                        <select name="status" id="status" required
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:outline-none transition-all">
                            <option value="">-- Pilih Status --</option>
                            <option value="aktif" {{ old('status', $supplier->status) === 'aktif' ? 'selected' : '' }}>
                                Aktif</option>
                            <option value="non-aktif"
                                {{ old('status', $supplier->status) === 'non-aktif' ? 'selected' : '' }}>Non-Aktif
                            </option>
                        </select>
                    </div>
                </div>

                <div class="mt-8 flex justify-end space-x-4">
                    <a href="{{ route('owner.suppliers') }}"
                        class="px-5 py-2.5 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 font-medium transition duration-200">
                        <i class="fas fa-times mr-2"></i>Batal
                    </a>
                    <button type="submit"
                        class="px-5 py-2.5 bg-gradient-to-r from-purple-600 to-indigo-600 text-white rounded-lg hover:from-purple-700 hover:to-indigo-700 font-medium shadow-md transition duration-200">
                        <i class="fas fa-save mr-2"></i>Update
                    </button>
                </div>
            </form>

            <!-- Info -->
            <div class="mt-8 bg-purple-50 border-l-4 border-purple-600 p-4 rounded-lg max-w-2xl mx-auto">
                <div class="flex">
                    <i class="fas fa-info-circle text-purple-600 mr-3 mt-0.5"></i>
                    <div>
                        <p class="text-sm font-semibold text-purple-900">Petunjuk:</p>
                        <ul class="text-sm text-purple-700 mt-1 list-disc list-inside space-y-1">
                            <li>Periksa kembali informasi sebelum menyimpan perubahan</li>
                            <li>Status “Non-Aktif” menonaktifkan supplier dari sistem</li>
                            <li>Tombol batal akan mengembalikan ke halaman daftar supplier</li>
                        </ul>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <!-- Interaksi Animasi -->
    <script>
        // Efek fokus input
        document.querySelectorAll("input, select").forEach(el => {
            el.addEventListener("focus", () => {
                el.classList.add("ring-2", "ring-purple-400");
            });
            el.addEventListener("blur", () => {
                el.classList.remove("ring-2", "ring-purple-400");
            });
        });

        // Auto hide alert
        const alertBox = document.querySelector('.bg-red-100');
        if (alertBox) {
            setTimeout(() => alertBox.classList.add('hidden'), 5000);
        }
    </script>
</body>

</html>
