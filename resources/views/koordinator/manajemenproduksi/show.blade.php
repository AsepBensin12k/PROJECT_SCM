<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Produksi</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<body class="bg-gray-100">
    <!-- Navbar -->
    <nav class="bg-gradient-to-r from-amber-500 to-orange-500 shadow-xl sticky top-0 z-50 border-b border-amber-200">
        <div class="max-w-7xl mx-auto px-6 flex justify-between items-center h-16">
            <div class="flex items-center space-x-3">
                <div class="bg-white/20 p-2 rounded-xl border border-white/30">
                    <i class="fas fa-eye text-white"></i>
                </div>
                <span class="text-white font-bold text-lg">Detail Jadwal Produksi</span>
            </div>
        </div>
    </nav>

    <div class="flex">
        @include('components.koordinator-sidebar')

        <main class="flex-1 p-8 ml-64">
            <div class="bg-white rounded-xl shadow-md p-8 max-w-4xl mx-auto transition duration-300">
                <!-- Header -->
                <div class="flex justify-between items-center mb-6">
                    <h1 class="text-2xl font-bold text-amber-700">
                        📋 Detail Produksi {{ $production->code }}
                    </h1>
                    <a href="{{ route('koordinator.productions.index') }}"
                        class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-4 py-2 rounded-lg flex items-center gap-2 transition">
                        <i class="fas fa-arrow-left"></i> Kembali
                    </a>
                </div>

                <!-- Informasi Produksi -->
                <div class="grid grid-cols-2 gap-6 mb-6 text-gray-800">
                    <div><strong>Produk:</strong> {{ $production->product->name }}</div>
                    <div><strong>Tanggal:</strong>
                        {{ \Carbon\Carbon::parse($production->production_date)->format('d M Y') }}</div>
                    <div><strong>Operator:</strong> {{ $production->operator }}</div>
                    <div><strong>Jumlah Dihasilkan:</strong> {{ $production->quantity_produced }}</div>
                </div>

                <!-- Status Produksi -->
                <div class="mb-6">
                    <strong>Status Produksi:</strong>
                    @php
                        $statusClasses = [
                            'pending' => 'bg-yellow-100 text-yellow-800',
                            'sedang_diproduksi' => 'bg-blue-100 text-blue-800',
                            'selesai' => 'bg-green-100 text-green-800',
                            'dibatalkan' => 'bg-red-100 text-red-800',
                        ];
                    @endphp
                    <span
                        class="px-3 py-1 text-sm rounded-full font-medium {{ $statusClasses[$production->status] ?? 'bg-gray-100 text-gray-700' }}">
                        {{ ucfirst(str_replace('_', ' ', $production->status)) }}
                    </span>
                </div>

                <!-- Bahan Baku -->
                <h2 class="text-lg font-semibold text-amber-700 mb-3">Bahan Baku Digunakan</h2>
                <table class="min-w-full border border-gray-200 rounded-lg mb-8">
                    <thead class="bg-amber-100 text-amber-800">
                        <tr>
                            <th class="px-4 py-2 text-left">Bahan</th>
                            <th class="px-4 py-2 text-left">Qty</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach ($production->materials as $mat)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-4 py-2">{{ $mat->name }}</td>
                                <td class="px-4 py-2">{{ $mat->pivot->quantity_used }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <!-- Form Ubah Status -->
                @if ($production->status !== 'selesai')
                    <form action="{{ route('koordinator.productions.updateStatus', $production->id) }}" method="POST"
                        class="flex items-center gap-3">
                        @csrf
                        @method('PUT')
                        <label class="text-sm font-semibold text-gray-700">Ubah Status Produksi:</label>
                        <select name="status"
                            class="border rounded-lg p-2 focus:ring-amber-500 focus:border-amber-500">
                            <option value="pending" {{ $production->status == 'pending' ? 'selected' : '' }}>Pending
                            </option>
                            <option value="sedang_diproduksi"
                                {{ $production->status == 'sedang_diproduksi' ? 'selected' : '' }}>Sedang Diproduksi
                            </option>
                            <option value="selesai" {{ $production->status == 'selesai' ? 'selected' : '' }}>Selesai
                            </option>
                            <option value="dibatalkan" {{ $production->status == 'dibatalkan' ? 'selected' : '' }}>
                                Dibatalkan</option>
                        </select>
                        <button type="submit"
                            class="bg-amber-600 hover:bg-amber-700 text-white px-4 py-2 rounded-lg transition flex items-center gap-2">
                            <i class="fas fa-sync-alt"></i> Ubah Status
                        </button>
                    </form>
                @else
                    <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg text-sm">
                        <i class="fas fa-check-circle"></i> Produksi ini sudah <strong>selesai</strong> dan tidak dapat
                        diubah lagi.
                    </div>
                @endif
            </div>
        </main>
    </div>
</body>

</html>
