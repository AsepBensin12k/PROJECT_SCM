<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }} - @yield('title', 'Dashboard')</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Custom Styles -->
    @stack('styles')
</head>

<body class="font-sans antialiased bg-gray-100">
    <div class="min-h-screen">
        <!-- Navigation Bar -->
        @auth
            @if (Auth::user()->hasRole('owner'))
                <!-- Owner Navigation -->
                <nav
                    class="bg-gradient-to-r from-purple-600 to-indigo-600 shadow-xl sticky top-0 z-50 border-b border-purple-200">
                    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                        <div class="flex justify-between items-center h-16">
                            <!-- Logo & Brand -->
                            <div class="flex items-center space-x-3">
                                <div class="bg-white/20 p-2 rounded-xl backdrop-blur-sm border border-white/30">
                                    <i class="fas fa-crown text-white text-lg"></i>
                                </div>
                                <div class="flex flex-col">
                                    <span class="text-white font-bold text-lg tracking-tight">Dashboard Owner</span>
                                    <span class="text-purple-100 text-xs font-medium">RO JEMBER</span>
                                </div>
                            </div>

                            <!-- User Info -->
                            <div class="flex items-center space-x-4">
                                <div
                                    class="flex items-center space-x-3 bg-white/20 px-4 py-2 rounded-xl backdrop-blur-sm border border-white/30">
                                    <div class="bg-white/30 p-1.5 rounded-full">
                                        <i class="fas fa-user text-white text-sm"></i>
                                    </div>
                                    <div class="flex flex-col">
                                        <span
                                            class="text-white text-sm font-semibold leading-none">{{ Auth::user()->name }}</span>
                                        <span class="text-purple-100 text-xs">Owner</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </nav>
            @elseif(Auth::user()->hasRole('koordinator'))
                <!-- Koordinator Navigation -->
                <nav
                    class="bg-gradient-to-r from-amber-500 to-orange-500 shadow-xl sticky top-0 z-50 border-b border-amber-200">
                    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                        <div class="flex justify-between items-center h-16">
                            <!-- Logo & Brand -->
                            <div class="flex items-center space-x-3">
                                <div class="bg-white/20 p-2 rounded-xl backdrop-blur-sm border border-white/30">
                                    <i class="fas fa-chart-line text-white text-lg"></i>
                                </div>
                                <div class="flex flex-col">
                                    <span class="text-white font-bold text-lg tracking-tight">Dashboard Koordinator</span>
                                    <span class="text-amber-100 text-xs font-medium">RO JEMBER</span>
                                </div>
                            </div>

                            <!-- User Info -->
                            <div class="flex items-center space-x-4">
                                <div
                                    class="flex items-center space-x-3 bg-white/20 px-4 py-2 rounded-xl backdrop-blur-sm border border-white/30">
                                    <div class="bg-white/30 p-1.5 rounded-full">
                                        <i class="fas fa-user text-white text-sm"></i>
                                    </div>
                                    <div class="flex flex-col">
                                        <span
                                            class="text-white text-sm font-semibold leading-none">{{ Auth::user()->name }}</span>
                                        <span class="text-amber-100 text-xs">Online</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </nav>
            @endif
        @endauth

        <!-- Main Layout with Sidebar -->
        <div class="flex">
            <!-- Dynamic Sidebar based on Role -->
            @auth
                @if (Auth::user()->hasRole('owner'))
                    <x-owner-sidebar />
                @elseif(Auth::user()->hasRole('koordinator'))
                    <x-koordinator-sidebar />
                @endif
            @endauth

            <!-- Main Content -->
            <main class="flex-1 ml-64 p-8">
                <!-- Page Header -->
                @if (isset($header))
                    <div class="mb-6">
                        {{ $header }}
                    </div>
                @endif

                <!-- Flash Messages -->
                @if (session('success'))
                    <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg relative"
                        role="alert">
                        <span class="block sm:inline">{{ session('success') }}</span>
                    </div>
                @endif

                @if (session('error'))
                    <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg relative"
                        role="alert">
                        <span class="block sm:inline">{{ session('error') }}</span>
                    </div>
                @endif

                <!-- Page Content -->
                {{ $slot }}
            </main>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    @stack('scripts')
</body>

</html>
