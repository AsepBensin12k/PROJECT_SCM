<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profil Owner | RO JEMBER</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<body class="bg-gray-100 font-sans antialiased">
    <!-- Navbar -->
    <nav class="bg-gradient-to-r from-purple-600 to-indigo-600 shadow-xl sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-6 flex justify-between items-center h-16 text-white">
            <div class="flex items-center space-x-3">
                <i class="fas fa-user-cog text-2xl"></i>
                <div>
                    <h1 class="font-bold">Edit Profil</h1>
                    <p class="text-sm text-purple-100">RO JEMBER</p>
                </div>
            </div>
            <div class="text-sm">{{ Auth::user()->name }}</div>
        </div>
    </nav>

    <div class="flex">
        <!-- Sidebar -->
        @include('components.owner-sidebar')

        <!-- Main Content -->
        <main class="flex-1 p-8 ml-64">
            <h2 class="text-3xl font-bold text-gray-800 mb-6 flex items-center">
                <i class="fas fa-user-edit text-purple-600 mr-3"></i> Edit Profil Owner
            </h2>

            @if (session('success'))
                <div class="mb-6 bg-green-50 border border-green-400 text-green-700 p-4 rounded-lg">
                    <i class="fas fa-check-circle mr-2"></i> {{ session('success') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="mb-6 bg-red-50 border border-red-400 text-red-700 p-4 rounded-lg">
                    <ul class="list-disc list-inside text-sm">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Card Edit Profil -->
            <div class="bg-white rounded-xl shadow-md p-8 mb-10">
                <h3 class="text-xl font-semibold mb-4 text-gray-800 flex items-center">
                    <i class="fas fa-id-card text-purple-600 mr-2"></i> Informasi Pribadi
                </h3>

                <form method="POST" action="{{ route('owner.profile.update') }}" class="space-y-5">
                    @csrf
                    @method('PUT')

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Nama Lengkap</label>
                        <input type="text" name="name" value="{{ old('name', $user->name) }}"
                            class="w-full mt-1 p-3 border rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500"
                            required>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Email</label>
                        <input type="email" name="email" value="{{ old('email', $user->email) }}"
                            class="w-full mt-1 p-3 border rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500"
                            required>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Nomor Telepon</label>
                        <input type="text" name="phone" value="{{ old('phone', $user->phone) }}"
                            class="w-full mt-1 p-3 border rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Alamat</label>
                        <textarea name="address" rows="3"
                            class="w-full mt-1 p-3 border rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500">{{ old('address', $user->address) }}</textarea>
                    </div>

                    <div class="flex justify-end mt-6">
                        <a href="{{ route('owner.profile') }}"
                            class="px-5 py-2 bg-gray-200 hover:bg-gray-300 rounded-lg text-gray-800 font-medium transition">
                            <i class="fas fa-arrow-left mr-1"></i> Batal
                        </a>
                        <button type="submit"
                            class="ml-3 px-5 py-2 bg-purple-600 hover:bg-purple-700 text-white rounded-lg font-medium transition">
                            <i class="fas fa-save mr-2"></i> Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>

            <!-- Card Ganti Password -->
            <div class="bg-white rounded-xl shadow-md p-8">
                <h3 class="text-xl font-semibold mb-4 text-gray-800 flex items-center">
                    <i class="fas fa-key text-indigo-600 mr-2"></i> Ganti Password
                </h3>

                <form method="POST" action="{{ route('owner.profile.password') }}" class="space-y-5">
                    @csrf
                    @method('PUT')

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Password Lama</label>
                        <input type="password" name="current_password"
                            class="w-full mt-1 p-3 border rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                            required>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Password Baru</label>
                        <input type="password" name="new_password"
                            class="w-full mt-1 p-3 border rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                            required>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Konfirmasi Password Baru</label>
                        <input type="password" name="new_password_confirmation"
                            class="w-full mt-1 p-3 border rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                            required>
                    </div>

                    <div class="flex justify-end mt-6">
                        <button type="submit"
                            class="px-5 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg font-medium transition">
                            <i class="fas fa-key mr-2"></i> Ganti Password
                        </button>
                    </div>
                </form>
            </div>
        </main>
    </div>
</body>

</html>
