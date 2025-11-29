<!-- Sidebar Owner -->
<div class="w-64 bg-white shadow-xl min-h-screen fixed top-16 left-0 overflow-y-auto border-r border-purple-100">
    <div class="p-5">

        <!-- Header / Role Info -->
        <div class="mb-6 bg-gradient-to-r from-purple-50 to-indigo-50 rounded-2xl border border-purple-200 p-4">
            <div class="flex items-center gap-2 mb-1">
                <i class="fas fa-crown text-purple-600"></i>
                <span class="text-sm font-semibold text-purple-900">Owner Sistem</span>
            </div>
            <p class="text-xs text-purple-600">Hak akses penuh manajemen</p>
        </div>

        <!-- Navigation Menu -->
        <ul class="space-y-2 text-[15px] font-medium">

            <!-- Dashboard -->
            <li>
                <a href="{{ route('owner.dashboard') }}"
                    class="flex items-center p-3 rounded-xl transition-all duration-200
                    {{ request()->routeIs('owner.dashboard')
                        ? 'bg-purple-50 border-l-4 border-purple-600 text-purple-900 font-semibold'
                        : 'text-gray-700 hover:bg-gray-50' }}">
                    <i
                        class="fas fa-tachometer-alt mr-3 {{ request()->routeIs('owner.dashboard') ? 'text-purple-600' : 'text-gray-500' }}"></i>
                    Dashboard
                </a>
            </li>

            <!-- Supplier -->
            <li class="pt-4 pb-1 text-xs uppercase font-semibold text-gray-400 tracking-wide">Manajemen</li>
            <li>
                <a href="{{ route('owner.suppliers') }}"
                    class="flex items-center p-3 rounded-xl transition-all duration-200
                    {{ request()->routeIs('owner.suppliers*')
                        ? 'bg-purple-50 border-l-4 border-purple-600 text-purple-900 font-semibold'
                        : 'text-gray-700 hover:bg-gray-50' }}">
                    <i
                        class="fas fa-truck-loading mr-3 {{ request()->routeIs('owner.suppliers*') ? 'text-purple-600' : 'text-gray-500' }}"></i>
                    Supplier
                </a>
            </li>

            <!-- Laporan -->
            <li class="pt-4 pb-1 text-xs uppercase font-semibold text-gray-400 tracking-wide">Laporan</li>

            <li>
                <a href="{{ route('owner.laporan.bahanbaku') }}"
                    class="flex items-center p-3 rounded-xl transition-all duration-200
                    {{ request()->routeIs('owner.laporan.bahanbaku*')
                        ? 'bg-purple-50 border-l-4 border-purple-600 text-purple-900 font-semibold'
                        : 'text-gray-700 hover:bg-gray-50' }}">
                    <i
                        class="fas fa-boxes mr-3 {{ request()->routeIs('owner.laporan.bahanbaku*') ? 'text-purple-600' : 'text-gray-500' }}"></i>
                    Bahan Baku
                </a>
            </li>

            <li>
                <a href="{{ route('owner.laporan.produkjadi') }}"
                    class="flex items-center p-3 rounded-xl transition-all duration-200
                    {{ request()->routeIs('owner.laporan.produkjadi*')
                        ? 'bg-purple-50 border-l-4 border-purple-600 text-purple-900 font-semibold'
                        : 'text-gray-700 hover:bg-gray-50' }}">
                    <i
                        class="fas fa-cube mr-3 {{ request()->routeIs('owner.laporan.produkjadi*') ? 'text-purple-600' : 'text-gray-500' }}"></i>
                    Produk Jadi
                </a>
            </li>

            <li>
                <a href="{{ route('owner.laporan.produksi') }}"
                    class="flex items-center p-3 rounded-xl transition-all duration-200
                    {{ request()->routeIs('owner.laporan.produksi*')
                        ? 'bg-purple-50 border-l-4 border-purple-600 text-purple-900 font-semibold'
                        : 'text-gray-700 hover:bg-gray-50' }}">
                    <i
                        class="fas fa-industry mr-3 {{ request()->routeIs('owner.laporan.produksi*') ? 'text-purple-600' : 'text-gray-500' }}"></i>
                    Produksi
                </a>
            </li>

            <li>
                <a href="{{ route('owner.laporan.distribusi') }}"
                    class="flex items-center p-3 rounded-xl transition-all duration-200
                    {{ request()->routeIs('owner.laporan.distribusi*')
                        ? 'bg-purple-50 border-l-4 border-purple-600 text-purple-900 font-semibold'
                        : 'text-gray-700 hover:bg-gray-50' }}">
                    <i
                        class="fas fa-truck mr-3 {{ request()->routeIs('owner.laporan.distribusi*') ? 'text-purple-600' : 'text-gray-500' }}"></i>
                    Distribusi
                </a>
            </li>

            <!-- Forecasting -->
            <li class="pt-4 pb-1 text-xs uppercase font-semibold text-gray-400 tracking-wide">Analisis</li>
            <li>
                <a href="{{ route('owner.forecasts') }}"
                    class="flex items-center p-3 rounded-xl transition-all duration-200
                    {{ request()->routeIs('owner.forecasts*')
                        ? 'bg-purple-50 border-l-4 border-purple-600 text-purple-900 font-semibold'
                        : 'text-gray-700 hover:bg-gray-50' }}">
                    <i
                        class="fas fa-chart-line mr-3 {{ request()->routeIs('owner.forecasts*') ? 'text-purple-600' : 'text-gray-500' }}"></i>
                    Forecasting Bahan Baku
                </a>
            </li>

            <!-- Profile -->
            <li class="pt-4 pb-1 text-xs uppercase font-semibold text-gray-400 tracking-wide">Akun</li>
            <li>
                <a href="{{ route('owner.profile') }}"
                    class="flex items-center p-3 rounded-xl transition-all duration-200
                    {{ request()->routeIs('owner.profile*')
                        ? 'bg-purple-50 border-l-4 border-purple-600 text-purple-900 font-semibold'
                        : 'text-gray-700 hover:bg-gray-50' }}">
                    <i
                        class="fas fa-user mr-3 {{ request()->routeIs('owner.profile*') ? 'text-purple-600' : 'text-gray-500' }}"></i>
                    Profile
                </a>
            </li>

            <!-- Logout -->
            <li>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                        class="w-full flex items-center p-3 text-gray-700 hover:bg-red-50 hover:text-red-600 rounded-xl transition-all duration-200">
                        <i class="fas fa-sign-out-alt mr-3 text-red-500"></i>
                        Logout
                    </button>
                </form>
            </li>
        </ul>
    </div>
</div>
