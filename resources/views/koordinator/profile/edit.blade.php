<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile - Manajemen Produksi</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-100">
    <nav class="bg-gradient-to-r from-amber-500 to-orange-500 shadow-xl sticky top-0 z-50 backdrop-blur-sm border-b border-amber-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">

                <!-- Logo & Brand -->
                <div class="flex items-center space-x-3">
                    <div class="bg-white/20 p-2 rounded-xl backdrop-blur-sm border border-white/30 shadow-lg">
                        <i class="fas fa-industry text-white text-lg"></i>
                    </div>
                    <div class="flex flex-col">
                        <a href="{{ route('koordinator.dashboard') }}" class="text-base font-bold text-white tracking-tight hover:text-amber-100 transition-all duration-300">
                            Profile
                        </a>
                    </div>
                </div>

                <!-- User Info & Actions -->
                <div class="flex items-center space-x-4">

                    <!-- Back to Dashboard -->
                    <a href="{{ route('koordinator.dashboard') }}" class="group flex items-center space-x-2 bg-white/15 hover:bg-white/25 backdrop-blur-sm px-4 py-2 rounded-xl border border-white/20 hover:border-white/40 transition-all duration-300">
                        <i class="fas fa-arrow-left text-white text-sm group-hover:-translate-x-1 transition-transform duration-300"></i>
                        <span class="text-white font-semibold text-sm">Kembali ke Dashboard</span>
                    </a>

                    <!-- User Profile -->
                    <div class="flex items-center space-x-3 bg-white/15 backdrop-blur-sm px-4 py-2 rounded-xl border border-white/20 shadow-lg">
                        <div class="bg-white/25 p-1.5 rounded-full border border-white/30">
                            <i class="fas fa-user-tie text-white text-xs"></i>
                        </div>
                        <div class="flex flex-col">
                            <span class="text-white font-bold text-sm leading-tight">{{ Auth::user()->name }}</span>
                            <span class="text-amber-100/80 text-[10px] font-medium leading-none">Koordinator</span>
                        </div>
                    </div>

                    <!-- Logout Button -->
                    <form method="POST" action="{{ route('logout') }}" class="m-0">
                        @csrf
                        <button type="submit" class="group bg-red-500/90 hover:bg-red-600 backdrop-blur-sm px-4 py-2 rounded-xl border border-red-400/50 hover:border-red-300 transition-all duration-300 hover:scale-105 shadow-lg hover:shadow-red-500/25 flex items-center space-x-2">
                            <i class="fas fa-sign-out-alt text-white text-sm group-hover:translate-x-1 transition-transform duration-300"></i>
                            <span class="text-white font-semibold text-sm">Logout</span>
                        </button>
                    </form>

                </div>
            </div>
        </div>
    </nav>

    <!-- Sidebar & Main Content -->
    <div class="flex">
        <!-- Include Sidebar -->
        @include('components.sidebar')

        <!-- Main Content -->
        <div class="flex-1 p-8 ml-64">
            <div class="max-w-4xl mx-auto">
                <!-- Header -->
                <div class="mb-8">
                    <h1 class="text-3xl font-bold text-gray-800">Edit Profile</h1>
                    <p class="text-gray-600 mt-2">Perbarui informasi profile Anda</p>
                </div>

                <!-- Edit Form Card -->
                <div class="bg-white rounded-xl shadow-md overflow-hidden">
                    <div class="p-8">
                        <!-- Success Message -->
                        @if(session('success'))
                            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg mb-6">
                                {{ session('success') }}
                            </div>
                        @endif

                        <form action="{{ route('koordinator.profile.update') }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <!-- Nama -->
                                <div class="md:col-span-2">
                                    <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Nama Lengkap *</label>
                                    <input type="text"
                                           id="name"
                                           name="name"
                                           value="{{ old('name', $user->name) }}"
                                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500 transition duration-200"
                                           required>
                                    @error('name')
                                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Email -->
                                <div class="md:col-span-2">
                                    <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email *</label>
                                    <input type="email"
                                           id="email"
                                           name="email"
                                           value="{{ old('email', $user->email) }}"
                                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500 transition duration-200"
                                           required>
                                    @error('email')
                                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Phone -->
                                <div>
                                    <label for="phone" class="block text-sm font-medium text-gray-700 mb-2">Nomor Telepon</label>
                                    <input type="text"
                                           id="phone"
                                           name="phone"
                                           value="{{ old('phone', $user->phone) }}"
                                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500 transition duration-200"
                                           placeholder="Contoh: 081234567890">
                                    @error('phone')
                                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Role (Readonly) -->
                                <div>
                                    <label for="role" class="block text-sm font-medium text-gray-700 mb-2">Role</label>
                                    <input type="text"
                                           id="role"
                                           value="{{ $user->role->name ?? 'Koordinator' }}"
                                           class="w-full px-4 py-3 border border-gray-300 rounded-lg bg-gray-50 text-gray-500"
                                           readonly
                                           disabled>
                                    <p class="text-xs text-gray-500 mt-1">Role tidak dapat diubah</p>
                                </div>

                                <!-- Address -->
                                <div class="md:col-span-2">
                                    <label for="address" class="block text-sm font-medium text-gray-700 mb-2">Alamat</label>
                                    <textarea id="address"
                                              name="address"
                                              rows="3"
                                              class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500 transition duration-200"
                                              placeholder="Masukkan alamat lengkap">{{ old('address', $user->address) }}</textarea>
                                    @error('address')
                                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <!-- Action Buttons -->
                            <div class="mt-8 flex justify-end space-x-4">
                                <a href="{{ route('koordinator.profile') }}"
                                   class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-6 py-3 rounded-lg transition duration-200 font-medium">
                                    Batal
                                </a>
                                <button type="submit"
                                        class="bg-yellow-500 hover:bg-yellow-600 text-white px-6 py-3 rounded-lg transition duration-200 font-medium flex items-center">
                                    <i class="fas fa-save mr-2"></i> Update Profile
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Script untuk real-time validation
        document.addEventListener('DOMContentLoaded', function() {
            console.log('Edit profile page loaded');
        });
    </script>
</body>
</html>
