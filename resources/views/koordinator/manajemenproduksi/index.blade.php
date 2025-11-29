<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Jadwal Produksi</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<body class="bg-gray-100">
    <nav class="bg-gradient-to-r from-amber-500 to-orange-500 shadow-xl sticky top-0 z-50 border-b border-amber-200">
        <div class="max-w-7xl mx-auto px-6 flex justify-between items-center h-16">
            <div class="flex items-center space-x-3">
                <div class="bg-white/20 p-2 rounded-xl border border-white/30">
                    <i class="fas fa-calendar-alt text-white"></i>
                </div>
                <span class="text-white font-bold text-lg">Jadwal Produksi</span>
            </div>
        </div>
    </nav>

    <div class="flex">
        @include('components.koordinator-sidebar')

        <main class="flex-1 p-8 ml-64">
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-2xl font-bold text-amber-700">📅 Manajemen Produksi</h1>
                <a href="{{ route('koordinator.productions.create') }}"
                    class="bg-amber-500 hover:bg-amber-600 text-white px-4 py-2 rounded-lg flex items-center">
                    <i class="fas fa-plus mr-2"></i> Tambah Jadwal
                </a>
            </div>

            @if (session('success'))
                <div class="mb-4 p-3 bg-green-100 border border-green-400 text-green-700 rounded-lg">
                    <i class="fas fa-check-circle mr-2"></i>{{ session('success') }}
                </div>
            @endif

            <div class="bg-white rounded-xl shadow-md overflow-hidden">
                <table class="min-w-full text-sm text-left">
                    <thead class="bg-amber-100 text-amber-800">
                        <tr>
                            <th class="px-6 py-3 font-medium">Kode</th>
                            <th class="px-6 py-3 font-medium">Tanggal Produksi</th>
                            <th class="px-6 py-3 font-medium">Produk</th>
                            <th class="px-6 py-3 font-medium">Operator</th>
                            <th class="px-6 py-3 font-medium">Status</th>
                            <th class="px-6 py-3 font-medium text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse($productions as $p)
                            <tr class="hover:bg-amber-50 transition">
                                <td class="px-6 py-3 font-semibold text-gray-800">{{ $p->code }}</td>
                                <td class="px-6 py-3">{{ \Carbon\Carbon::parse($p->production_date)->format('d M Y') }}
                                </td>
                                <td class="px-6 py-3">{{ $p->product->name }}</td>
                                <td class="px-6 py-3">{{ $p->operator ?? 'Bagian Produksi' }}</td>
                                <td class="px-6 py-3">
                                    <span
                                        class="px-2 py-1 rounded-full text-xs font-semibold
                    {{ $p->status == 'selesai'
                        ? 'bg-green-100 text-green-700'
                        : ($p->status == 'pending'
                            ? 'bg-yellow-100 text-yellow-700'
                            : ($p->status == 'dibatalkan'
                                ? 'bg-gray-200 text-gray-600 line-through'
                                : 'bg-blue-100 text-blue-700')) }}">
                                        {{ ucfirst($p->status) }}
                                    </span>
                                </td>
                                <td class="px-6 py-3 text-center">
                                    <a href="{{ route('koordinator.productions.show', $p->id) }}"
                                        class="text-amber-600 hover:text-amber-700 font-semibold">
                                        <i class="fas fa-eye mr-1"></i> Lihat Detail
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-6 text-gray-500 italic">Belum ada jadwal
                                    produksi</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </main>
    </div>
</body>

</html>
