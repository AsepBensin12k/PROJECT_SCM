<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Distribusi</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<body class="bg-amber-50">
    <nav class="bg-gradient-to-r from-amber-500 to-orange-500 shadow-xl sticky top-0 z-50 border-b border-amber-200">
        <div class="max-w-7xl mx-auto px-6 flex justify-between items-center h-16">
            <div class="flex items-center space-x-3 text-white font-bold text-lg">
                <i class="fas fa-edit"></i>
                <span>Edit Distribusi</span>
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
                    <i class="fas fa-edit mr-2"></i> Edit {{ $distribution->code }}
                </h2>

                <form action="{{ route('koordinator.distributions.update', $distribution->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-4">
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Produk</label>
                        <input type="text" value="{{ $distribution->product->name }}" readonly
                            class="w-full bg-gray-100 border border-gray-200 rounded-lg px-4 py-2">
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Tujuan</label>
                        <input type="text" value="{{ $distribution->destination }}" readonly
                            class="w-full bg-gray-100 border border-gray-200 rounded-lg px-4 py-2">
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Kuantitas</label>
                        <input type="number" name="quantity" value="{{ $distribution->quantity }}" min="1"
                            class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-amber-400">
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Status Distribusi</label>
                        <select name="status"
                            class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-amber-400">
                            <option value="diproses" {{ $distribution->status == 'diproses' ? 'selected' : '' }}>
                                Diproses
                            </option>
                            <option value="dikirim" {{ $distribution->status == 'dikirim' ? 'selected' : '' }}>Dikirim
                            </option>
                            <option value="selesai" {{ $distribution->status == 'selesai' ? 'selected' : '' }}>Selesai
                            </option>
                            <option value="dibatalkan" {{ $distribution->status == 'dibatalkan' ? 'selected' : '' }}>
                                Dibatalkan</option>
                        </select>
                    </div>

                    <div class="flex justify-between mt-6">
                        <a href="{{ route('koordinator.distributions') }}"
                            class="bg-gray-200 hover:bg-gray-300 text-gray-800 px-5 py-2 rounded-lg">
                            Kembali
                        </a>
                        <button type="submit"
                            class="bg-amber-500 hover:bg-amber-600 text-white px-6 py-2 rounded-lg flex items-center">
                            <i class="fas fa-save mr-2"></i> Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </main>
    </div>
</body>

</html>
