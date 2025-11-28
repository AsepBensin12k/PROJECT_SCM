<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile Saya</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-100">
    <!-- Navigation -->
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
            <!-- Success Message -->
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg mb-6">
                    {{ session('success') }}
                </div>
            @endif

            <div class="max-w-4xl mx-auto">
                <!-- Header -->
                <div class="mb-8">
                    <h1 class="text-3xl font-bold text-gray-800">Profile Saya</h1>
                    <p class="text-gray-600 mt-2">Lihat dan kelola informasi profile Anda</p>
                </div>

                <!-- Profile Info Card -->
                <div class="bg-white rounded-xl shadow-md overflow-hidden mb-6">
                    <div class="p-8">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Nama -->
                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Nama Lengkap</label>
                                <div class="px-4 py-3 border border-gray-300 rounded-lg bg-gray-50 text-gray-800">
                                    {{ $user->name }}
                                </div>
                            </div>

                            <!-- Email -->
                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                                <div class="px-4 py-3 border border-gray-300 rounded-lg bg-gray-50 text-gray-800">
                                    {{ $user->email }}
                                </div>
                            </div>

                            <!-- Phone -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Nomor Telepon</label>
                                <div class="px-4 py-3 border border-gray-300 rounded-lg bg-gray-50 text-gray-800">
                                    {{ $user->phone ?? '-' }}
                                </div>
                            </div>

                            <!-- Role -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Role</label>
                                <div class="px-4 py-3 border border-gray-300 rounded-lg bg-gray-50 text-gray-800">
                                    {{ $user->role->name ?? 'Koordinator' }}
                                </div>
                            </div>

                            <!-- Address -->
                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Alamat</label>
                                <div class="px-4 py-3 border border-gray-300 rounded-lg bg-gray-50 text-gray-800 min-h-[80px]">
                                    {{ $user->address ?? '-' }}
                                </div>
                            </div>

                            <!-- Joined Date -->
                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Bergabung Sejak</label>
                                <div class="px-4 py-3 border border-gray-300 rounded-lg bg-gray-50 text-gray-800">
                                    {{ \Carbon\Carbon::parse($user->created_at)->format('d F Y') }}
                                </div>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="mt-8 flex justify-end space-x-4">
                            <a href="{{ route('koordinator.profile.edit') }}"
                               class="bg-yellow-500 hover:bg-yellow-600 text-white px-6 py-3 rounded-lg transition duration-200 font-medium flex items-center">
                                <i class="fas fa-edit mr-2"></i> Edit Profile
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Additional Info Card -->
                <div class="bg-white rounded-xl shadow-md p-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Informasi Akun</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="text-sm font-medium text-gray-600">User ID</label>
                            <p class="text-gray-800">{{ $user->id }}</p>
                        </div>
                        <div>
                            <label class="text-sm font-medium text-gray-600">Terakhir Update</label>
                            <p class="text-gray-800">{{ \Carbon\Carbon::parse($user->updated_at)->format('d M Y H:i') }}</p>
                        </div>
                    </div>
                </div>
                <!-- Logout Button -->
                <form method="POST" action="{{ route('logout') }}" class="mt-6">
                    @csrf
                    <button type="submit" class="group bg-red-500/90 hover:bg-red-600 backdrop-blur-sm px-4 py-2 rounded-xl border border-red-400/50 hover:border-red-300 transition-all duration-300 hover:scale-105 shadow-lg hover:shadow-red-500/25 flex items-center space-x-2">
                        <i class="fas fa-sign-out-alt text-white text-sm group-hover:translate-x-1 transition-transform duration-300"></i>
                        <span class="text-white font-semibold text-sm">Logout</span>
                    </button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
