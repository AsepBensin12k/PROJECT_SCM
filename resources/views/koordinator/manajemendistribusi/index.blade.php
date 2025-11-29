<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Distribusi</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<body class="bg-amber-50">
    <!-- Navbar -->
    <nav class="bg-gradient-to-r from-amber-500 to-orange-500 shadow-xl sticky top-0 z-50 border-b border-amber-200">
        <div class="max-w-7xl mx-auto px-6 flex justify-between items-center h-16">
            <div class="flex items-center space-x-3">
                <div class="bg-white/20 p-2 rounded-xl border border-white/30">
                    <i class="fas fa-truck text-white"></i>
                </div>
                <span class="text-white font-bold text-lg">Manajemen Distribusi</span>
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
            <div class="flex justify-between items-center mb-8">
                <h1 class="text-3xl font-bold text-amber-800">📦 Daftar Distribusi</h1>
                <a href="{{ route('koordinator.distributions.create') }}"
                    class="bg-amber-500 hover:bg-amber-600 text-white px-4 py-2 rounded-lg shadow transition">
                    <i class="fas fa-plus mr-2"></i>Tambah Distribusi
                </a>
            </div>

            @if (session('success'))
                <div class="bg-green-100 border border-green-300 text-green-700 px-4 py-3 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white rounded-xl shadow overflow-hidden border border-amber-100">
                <table class="w-full">
                    <thead class="bg-amber-100 text-amber-900 text-xs font-semibold uppercase">
                        <tr>
                            <th class="px-6 py-3 text-left">Kode</th>
                            <th class="px-6 py-3 text-left">Produk</th>
                            <th class="px-6 py-3 text-left">Tujuan</th>
                            <th class="px-6 py-3 text-left">Kuantitas</th>
                            <th class="px-6 py-3 text-left">Status</th>
                            <th class="px-6 py-3 text-left">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-amber-100">
                        @forelse($distributions as $d)
                            <tr class="hover:bg-amber-50 transition">
                                <td class="px-6 py-3 font-medium">{{ $d->code }}</td>
                                <td class="px-6 py-3">{{ $d->product->name }}</td>
                                <td class="px-6 py-3">{{ $d->destination }}</td>
                                <td class="px-6 py-3">{{ $d->quantity }} pcs</td>
                                <td class="px-6 py-3">
                                    @php
                                        $colors = [
                                            'diproses' => 'bg-yellow-100 text-yellow-800',
                                            'dikirim' => 'bg-blue-100 text-blue-800',
                                            'selesai' => 'bg-green-100 text-green-800',
                                            'dibatalkan' => 'bg-red-100 text-red-800',
                                        ];
                                    @endphp
                                    <span
                                        class="px-3 py-1 rounded-full text-xs font-semibold {{ $colors[$d->status] ?? 'bg-gray-100 text-gray-800' }}">
                                        {{ ucfirst($d->status) }}
                                    </span>
                                </td>
                                <td class="px-6 py-3 text-sm space-x-3">
                                    <a href="{{ route('koordinator.distributions.show', $d->id) }}"
                                        class="text-blue-600 hover:text-blue-800">
                                        <i class="fas fa-eye mr-1"></i>Detail
                                    </a>
                                    @if ($d->status !== 'selesai')
                                        <a href="{{ route('koordinator.distributions.edit', $d->id) }}"
                                            class="text-amber-600 hover:text-amber-800">
                                            <i class="fas fa-edit mr-1"></i>Edit
                                        </a>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-6 text-center text-gray-500 italic">Belum ada data
                                    distribusi.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </main>
    </div>
</body>

</html>
