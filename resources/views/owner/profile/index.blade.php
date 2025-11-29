<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Owner - RO JEMBER</title>
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
                        <i class="fas fa-user text-white text-lg"></i>
                    </div>
                    <div class="flex flex-col">
                        <span class="text-white font-bold text-lg tracking-tight">Profil Owner</span>
                        <span class="text-purple-100 text-xs font-medium">ROJEMBER</span>
                    </div>
                </div>

                <!-- User -->
                <div class="flex items-center space-x-4">
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
        </div>
    </nav>

    <div class="flex">
        @include('components.owner-sidebar')

        <main class="flex-1 p-8 ml-64">
            <div class="max-w-3xl mx-auto bg-white shadow-lg rounded-xl p-8">
                <div class="flex items-center mb-6">
                    <div class="bg-purple-100 text-purple-600 p-3 rounded-full">
                        <i class="fas fa-user text-2xl"></i>
                    </div>
                    <div class="ml-4">
                        <h2 class="text-2xl font-bold text-gray-800">{{ $user->name }}</h2>
                        <p class="text-gray-500 text-sm">{{ $user->role->name }}</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <p class="text-sm text-gray-500">Email</p>
                        <p class="font-semibold text-gray-800">{{ $user->email }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Nomor Telepon</p>
                        <p class="font-semibold text-gray-800">{{ $user->phone ?? '-' }}</p>
                    </div>
                    <div class="md:col-span-2">
                        <p class="text-sm text-gray-500">Alamat</p>
                        <p class="font-semibold text-gray-800">{{ $user->address ?? '-' }}</p>
                    </div>
                </div>

                <div class="mt-8 flex justify-end space-x-4">
                    <a href="{{ route('owner.profile.edit') }}"
                        class="px-5 py-2 bg-purple-600 hover:bg-purple-700 text-white rounded-lg font-medium transition">
                        <i class="fas fa-edit mr-2"></i> Edit Profil
                    </a>
                </div>
            </div>
        </main>
    </div>
</body>

</html>
