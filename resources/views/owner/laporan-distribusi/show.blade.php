<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Distribusi | RO JEMBER</title>
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
                        <i class="fas fa-truck text-white text-lg"></i>
                    </div>
                    <div class="flex flex-col">
                        <span class="text-white font-bold text-lg tracking-tight">Laporan Distribusi</span>
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
            <div class="mb-6 flex justify-between items-center">
                <div>
                    <h2 class="text-3xl font-bold text-gray-800 flex items-center">
                        <i class="fas fa-box text-purple-600 mr-3"></i>
                        Distribusi: {{ $distribution->product->name }}
                    </h2>
                    <p class="text-gray-500 mt-1 text-sm">Detail pengiriman dan status distribusi</p>
                </div>
                <a href="{{ route('owner.laporan.distribusi') }}"
                    class="px-4 py-2 bg-purple-600 text-white rounded-lg shadow hover:bg-purple-700 transition">
                    <i class="fas fa-arrow-left mr-2"></i> Kembali
                </a>
            </div>

            <div class="bg-white rounded-xl shadow-md p-6 space-y-4">
                <div class="grid md:grid-cols-2 gap-6">
                    <div>
                        <p class="text-sm text-gray-500">Tanggal Distribusi</p>
                        <p class="font-semibold text-gray-800">
                            {{ \Carbon\Carbon::parse($distribution->created_at)->format('d F Y') }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Produk</p>
                        <p class="font-semibold text-gray-800">{{ $distribution->product->name }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Tujuan</p>
                        <p class="font-semibold text-gray-800">{{ $distribution->destination }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Jumlah</p>
                        <p class="font-semibold text-gray-800">{{ $distribution->quantity }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Status</p>
                        <span
                            class="px-3 py-1 rounded-lg text-sm font-semibold
                            @if ($distribution->status == 'selesai') bg-green-100 text-green-700
                            @elseif($distribution->status == 'diproses') bg-yellow-100 text-yellow-700
                            @else bg-indigo-100 text-indigo-700 @endif">
                            {{ ucfirst($distribution->status) }}
                        </span>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Petugas Distribusi</p>
                        <p class="font-semibold text-gray-800">{{ $distribution->user->name ?? 'Bagian Distribusi' }}
                        </p>
                    </div>
                </div>
            </div>

            <div class="mt-8 bg-purple-50 border-l-4 border-purple-600 p-4 rounded-lg">
                <div class="flex items-start">
                    <i class="fas fa-info-circle text-purple-600 mr-2 mt-0.5"></i>
                    <div>
                        <p class="text-sm font-semibold text-purple-900">Informasi:</p>
                        <ul class="list-disc list-inside text-purple-700 text-sm space-y-1 mt-1">
                            <li>Data diambil dari sistem distribusi internal RO JEMBER.</li>
                            <li>Status “dikirim” menandakan pengiriman sedang dalam perjalanan.</li>
                            <li>Bagian Distribusi bertanggung jawab atas pengiriman dan penerimaan laporan.</li>
                        </ul>
                    </div>
                </div>
            </div>
        </main>
    </div>
</body>

</html>
