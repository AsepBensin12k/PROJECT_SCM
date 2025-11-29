<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Pengadaan</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<body class="bg-gray-100">
    <nav
        class="bg-gradient-to-r from-amber-500 to-orange-500 shadow-xl sticky top-0 z-50 backdrop-blur-sm border-b border-amber-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex justify-between items-center">
            <div class="flex items-center space-x-3">
                <div class="bg-white/20 p-2 rounded-xl border border-white/30">
                    <i class="fas fa-edit text-white text-lg"></i>
                </div>
                <span class="text-white font-bold text-lg">Edit Pengadaan</span>
            </div>
        </div>
    </nav>

    <div class="flex">
        @include('components.koordinator-sidebar')

        <main class="flex-1 p-8 ml-64">
            <div class="bg-white rounded-xl shadow-md p-8 max-w-3xl mx-auto">
                <h1 class="text-2xl font-bold text-amber-700 mb-6">✏️ Edit Pengadaan</h1>

                <form action="{{ route('koordinator.procurements.update', $procurement->id) }}" method="POST"
                    class="space-y-5">
                    @csrf
                    @method('PUT')

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Bahan Baku</label>
                        <select name="material_id" class="w-full border rounded-lg p-2">
                            @foreach ($materials as $m)
                                <option value="{{ $m->id }}"
                                    {{ $m->id == $procurement->material_id ? 'selected' : '' }}>
                                    {{ $m->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Supplier</label>
                        <select name="supplier_id" class="w-full border rounded-lg p-2">
                            @foreach ($suppliers as $s)
                                <option value="{{ $s->id }}"
                                    {{ $s->id == $procurement->supplier_id ? 'selected' : '' }}>
                                    {{ $s->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Tanggal Datang</label>
                            <input type="date" name="tanggal_datang"
                                value="{{ \Carbon\Carbon::parse($procurement->tanggal_datang)->format('Y-m-d') }}"
                                class="w-full border rounded-lg p-2">
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Quantity</label>
                            <input type="number" name="qty" value="{{ $procurement->qty }}"
                                class="w-full border rounded-lg p-2">
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Total Harga (Rp)</label>
                        <input type="number" name="total_harga" value="{{ $procurement->total_harga }}"
                            class="w-full border rounded-lg p-2">
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Status</label>
                        <select name="status" class="w-full border rounded-lg p-2">
                            <option value="diproses" {{ $procurement->status === 'diproses' ? 'selected' : '' }}>
                                Diproses</option>
                            <option value="dikirim" {{ $procurement->status === 'dikirim' ? 'selected' : '' }}>Dikirim
                            </option>
                            <option value="sampai" {{ $procurement->status === 'sampai' ? 'selected' : '' }}>Sampai
                            </option>
                            <option value="dibatalkan" {{ $procurement->status === 'dibatalkan' ? 'selected' : '' }}>
                                Dibatalkan</option>
                        </select>
                    </div>

                    <div class="flex justify-end gap-3 mt-6">
                        <a href="{{ route('koordinator.procurements') }}"
                            class="px-4 py-2 bg-gray-200 hover:bg-gray-300 rounded-lg">Batal</a>
                        <button type="submit"
                            class="px-4 py-2 bg-amber-600 hover:bg-amber-700 text-white rounded-lg">Perbarui</button>
                    </div>
                </form>
            </div>
        </main>
    </div>
</body>

</html>
