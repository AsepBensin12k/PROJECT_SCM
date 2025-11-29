<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Produksi | ROJEMBER</title>
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
                        <i class="fas fa-industry text-white text-lg"></i>
                    </div>
                    <div class="flex flex-col">
                        <span class="text-white font-bold text-lg tracking-tight">Laporan Produksi</span>
                        <span class="text-purple-100 text-xs font-medium">ROJEMBER</span>
                    </div>
                </div>

                <!-- User -->
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
    </nav>

    <div class="flex">
        @include('components.owner-sidebar')

        <main class="flex-1 p-8 ml-64">
            <!-- Header -->
            <div class="mb-6 flex justify-between items-center">
                <div>
                    <h2 class="text-3xl font-bold text-gray-800 flex items-center">
                        <i class="fas fa-calendar-check text-purple-600 mr-3"></i>
                        Produksi: {{ $production->product->name }}
                    </h2>
                    <p class="text-gray-500 mt-1 text-sm">Detail kegiatan produksi dan bahan yang digunakan</p>
                </div>
                <a href="{{ route('owner.laporan.produksi') }}"
                    class="px-4 py-2 bg-purple-600 text-white rounded-lg shadow hover:bg-purple-700 transition">
                    <i class="fas fa-arrow-left mr-2"></i> Kembali
                </a>
            </div>

            <!-- Informasi Produksi -->
            <div class="bg-white rounded-xl shadow-md p-6 space-y-4">
                <div class="grid md:grid-cols-2 gap-6">
                    <div>
                        <p class="text-sm text-gray-500">Tanggal Produksi</p>
                        <p class="font-semibold text-gray-800">
                            {{ \Carbon\Carbon::parse($production->production_date)->format('d F Y') }}
                        </p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Produk Dihasilkan</p>
                        <p class="font-semibold text-gray-800">{{ $production->product->name }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Jumlah Diproduksi</p>
                        <p class="font-semibold text-gray-800">{{ $production->quantity_produced }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Operator</p>
                        <p class="font-semibold text-gray-800">{{ $production->operator ?? 'Bagian Produksi' }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Status</p>
                        <p class="font-semibold text-gray-800 capitalize">
                            {{ $production->status ?? 'selesai' }}
                        </p>
                    </div>
                </div>
            </div>

            <!-- Bahan Baku yang Digunakan -->
            <div class="bg-white rounded-xl shadow-md p-6 mt-8">
                <h3 class="text-lg font-semibold mb-4 text-gray-800 flex items-center">
                    <i class="fas fa-boxes text-purple-600 mr-2"></i> Bahan Baku yang Digunakan
                </h3>

                <table class="min-w-full divide-y divide-gray-200 text-sm">
                    <thead class="bg-gradient-to-r from-purple-600 to-indigo-600 text-white">
                        <tr>
                            <th class="px-6 py-3 text-left font-semibold uppercase tracking-wider">Nama Bahan</th>
                            <th class="px-6 py-3 text-left font-semibold uppercase tracking-wider">Jumlah Digunakan</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse ($production->materials as $m)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-6 py-3">{{ $m->name }}</td>
                                <td class="px-6 py-3">{{ $m->pivot->quantity_used }} {{ $m->unit }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="2" class="px-6 py-4 text-center text-gray-500">
                                    Tidak ada data bahan baku tercatat.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Info -->
            <div class="mt-8 bg-purple-50 border-l-4 border-purple-600 p-4 rounded-lg">
                <div class="flex items-start">
                    <i class="fas fa-info-circle text-purple-600 mr-2 mt-0.5"></i>
                    <div>
                        <p class="text-sm font-semibold text-purple-900">Informasi:</p>
                        <ul class="list-disc list-inside text-purple-700 text-sm space-y-1 mt-1">
                            <li>Data diambil dari sistem pencatatan produksi terkini.</li>
                            <li>Daftar bahan baku di atas menunjukkan total penggunaan per produksi.</li>
                            <li>“Bagian Produksi” mengacu pada operator atau tim yang melaksanakan proses.</li>
                        </ul>
                    </div>
                </div>
            </div>
        </main>
    </div>
</body>

</html>
