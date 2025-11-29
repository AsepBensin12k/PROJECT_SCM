<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Distribusi</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<body class="bg-amber-50">
    <nav class="bg-gradient-to-r from-amber-500 to-orange-500 shadow-xl sticky top-0 z-50 border-b border-amber-200">
        <div class="max-w-7xl mx-auto px-6 flex justify-between items-center h-16">
            <div class="flex items-center space-x-3 text-white font-bold text-lg">
                <i class="fas fa-truck"></i>
                <span>Detail Distribusi</span>
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
                <h2 class="text-2xl font-bold text-amber-800 mb-6">
                    <i class="fas fa-truck mr-2"></i> {{ $distribution->code }}
                </h2>

                <div class="space-y-3 text-gray-700">
                    <p><strong>Produk:</strong> {{ $distribution->product->name }}</p>
                    <p><strong>Tujuan:</strong> {{ $distribution->destination }}</p>
                    <p><strong>Kuantitas:</strong> {{ $distribution->quantity }} pcs</p>
                    <p><strong>Status:</strong> <span class="capitalize">{{ $distribution->status }}</span></p>
                    <p><strong>Catatan:</strong> {{ $distribution->notes ?? '-' }}</p>
                </div>

                <div class="mt-8 flex justify-between">
                    <a href="{{ route('koordinator.distributions') }}"
                        class="bg-gray-200 hover:bg-gray-300 text-gray-800 px-4 py-2 rounded-lg">
                        <i class="fas fa-arrow-left mr-2"></i>Kembali
                    </a>

                    @if ($distribution->status !== 'selesai')
                        <a href="{{ route('koordinator.distributions.edit', $distribution->id) }}"
                            class="bg-amber-500 hover:bg-amber-600 text-white px-4 py-2 rounded-lg">
                            <i class="fas fa-edit mr-2"></i>Edit Distribusi
                        </a>
                    @endif
                </div>
            </div>
        </main>
    </div>
</body>

</html>
