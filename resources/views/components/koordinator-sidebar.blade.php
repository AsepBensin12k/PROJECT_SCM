{{-- <!-- Sidebar -->
<div class="w-64 bg-white shadow-lg min-h-screen fixed top-16 left-0 overflow-y-auto">
    <div class="p-4">
        <ul class="space-y-2">
            <li>
                <a href="{{ route('koordinator.dashboard') }}"
                   class="flex items-center p-3 text-gray-700 {{ request()->routeIs('koordinator.dashboard') ? 'bg-yellow-50' : 'hover:bg-gray-100' }} rounded-lg">
                    <i class="fas fa-tachometer-alt mr-3 {{ request()->routeIs('koordinator.dashboard') ? 'text-yellow-600' : '' }}"></i>
                    Dashboard
                </a>
            </li>
            <li>
                <a href="{{ route('koordinator.profile') }}"
                   class="flex items-center p-3 text-gray-700 {{ request()->routeIs('koordinator.profile') ? 'bg-yellow-50' : 'hover:bg-gray-100' }} rounded-lg">
                    <i class="fas fa-user mr-3 {{ request()->routeIs('koordinator.profile') ? 'text-yellow-600' : '' }}"></i>
                    Profile
                </a>
            </li>
            <li>
                <a href="{{ route('koordinator.materials') }}"
                   class="flex items-center p-3 text-gray-700 {{ request()->routeIs('koordinator.materials') ? 'bg-yellow-50' : 'hover:bg-gray-100' }} rounded-lg">
                    <i class="fas fa-boxes mr-3 {{ request()->routeIs('koordinator.materials') ? 'text-yellow-600' : '' }}"></i>
                    Bahan Baku
                </a>
            </li>
            <li>
                <a href="{{ route('koordinator.products') }}"
                   class="flex items-center p-3 text-gray-700 {{ request()->routeIs('koordinator.products') ? 'bg-yellow-50' : 'hover:bg-gray-100' }} rounded-lg">
                    <i class="fas fa-cube mr-3 {{ request()->routeIs('koordinator.products') ? 'text-yellow-600' : '' }}"></i>
                    Produk
                </a>
            </li>
            <li>
                <a href="{{ route('manajemenproduksi') }}"
                   class="flex items-center p-3 text-gray-700 {{ request()->routeIs('manajemenproduksi') ? 'bg-yellow-50' : 'hover:bg-gray-100' }} rounded-lg">
                    <i class="fas fa-calendar-alt mr-3 {{ request()->routeIs('manajemenproduksi') ? 'text-yellow-600' : '' }}"></i>
                    Jadwal Produksi
                </a>
            </li>
            <li>
                <a href="{{ route('koordinator.distributions') }}"
                   class="flex items-center p-3 text-gray-700 {{ request()->routeIs('koordinator.distributions') ? 'bg-yellow-50' : 'hover:bg-gray-100' }} rounded-lg">
                    <i class="fas fa-truck mr-3 {{ request()->routeIs('koordinator.distributions') ? 'text-yellow-600' : '' }}"></i>
                    Distribusi
                </a>
            </li>
        </ul>
    </div>
</div> --}}


<!-- Sidebar Koordinator -->
<div class="w-64 bg-white shadow-lg min-h-screen fixed top-16 left-0 overflow-y-auto border-r border-amber-100">
    <div class="p-4">
        <!-- Koordinator Badge -->
        <div class="mb-4 p-3 bg-gradient-to-r from-amber-50 to-orange-50 rounded-lg border border-amber-200">
            <div class="flex items-center space-x-2">
                <i class="fas fa-user-tie text-amber-600"></i>
                <span class="text-sm font-semibold text-amber-900">Koordinator Access</span>
            </div>
            <p class="text-xs text-amber-600 mt-1">Full Management</p>
        </div>

        <ul class="space-y-2">
            <!-- Dashboard -->
            <li>
                <a href="{{ route('koordinator.dashboard') }}"
                    class="flex items-center p-3 text-gray-700 {{ request()->routeIs('koordinator.dashboard') ? 'bg-amber-50 border-l-4 border-amber-600' : 'hover:bg-gray-100' }} rounded-lg transition-all duration-200">
                    <i
                        class="fas fa-tachometer-alt mr-3 {{ request()->routeIs('koordinator.dashboard') ? 'text-amber-600' : 'text-gray-500' }}"></i>
                    <span
                        class="{{ request()->routeIs('koordinator.dashboard') ? 'font-semibold text-amber-900' : '' }}">Dashboard</span>
                </a>
            </li>

            <!-- Divider -->
            <li class="pt-4 pb-2">
                <span class="text-xs font-semibold text-gray-400 uppercase px-3">Inventory</span>
            </li>

            <!-- Bahan Baku -->
            <li>
                <a href="{{ route('koordinator.materials') }}"
                    class="flex items-center p-3 text-gray-700 {{ request()->routeIs('koordinator.materials*') ? 'bg-amber-50 border-l-4 border-amber-600' : 'hover:bg-gray-100' }} rounded-lg transition-all duration-200">
                    <i
                        class="fas fa-boxes mr-3 {{ request()->routeIs('koordinator.materials*') ? 'text-amber-600' : 'text-gray-500' }}"></i>
                    <span
                        class="{{ request()->routeIs('koordinator.materials*') ? 'font-semibold text-amber-900' : '' }}">Bahan
                        Baku</span>
                </a>
            </li>

            <!-- Produk Jadi -->
            <li>
                <a href="{{ route('koordinator.products') }}"
                    class="flex items-center p-3 text-gray-700 {{ request()->routeIs('koordinator.products*') ? 'bg-amber-50 border-l-4 border-amber-600' : 'hover:bg-gray-100' }} rounded-lg transition-all duration-200">
                    <i
                        class="fas fa-cube mr-3 {{ request()->routeIs('koordinator.products*') ? 'text-amber-600' : 'text-gray-500' }}"></i>
                    <span
                        class="{{ request()->routeIs('koordinator.products*') ? 'font-semibold text-amber-900' : '' }}">Produk
                        Jadi</span>
                </a>
            </li>

            <!-- Divider -->
            <li class="pt-4 pb-2">
                <span class="text-xs font-semibold text-gray-400 uppercase px-3">Operations</span>
            </li>

            <!-- Jadwal Produksi -->
            <li>
                <a href="{{ route('manajemenproduksi') }}"
                    class="flex items-center p-3 text-gray-700 {{ request()->routeIs('manajemenproduksi*') ? 'bg-amber-50 border-l-4 border-amber-600' : 'hover:bg-gray-100' }} rounded-lg transition-all duration-200">
                    <i
                        class="fas fa-calendar-alt mr-3 {{ request()->routeIs('manajemenproduksi*') ? 'text-amber-600' : 'text-gray-500' }}"></i>
                    <span
                        class="{{ request()->routeIs('manajemenproduksi*') ? 'font-semibold text-amber-900' : '' }}">Jadwal
                        Produksi</span>
                </a>
            </li>

            <!-- Distribusi -->
            <li>
                <a href="{{ route('koordinator.distributions') }}"
                    class="flex items-center p-3 text-gray-700 {{ request()->routeIs('koordinator.distributions*') ? 'bg-amber-50 border-l-4 border-amber-600' : 'hover:bg-gray-100' }} rounded-lg transition-all duration-200">
                    <i
                        class="fas fa-truck mr-3 {{ request()->routeIs('koordinator.distributions*') ? 'text-amber-600' : 'text-gray-500' }}"></i>
                    <span
                        class="{{ request()->routeIs('koordinator.distributions*') ? 'font-semibold text-amber-900' : '' }}">Distribusi</span>
                </a>
            </li>

            <!-- Divider -->
            <li class="pt-4 pb-2">
                <span class="text-xs font-semibold text-gray-400 uppercase px-3">Account</span>
            </li>

            <!-- Profile -->
            <li>
                <a href="{{ route('koordinator.profile') }}"
                    class="flex items-center p-3 text-gray-700 {{ request()->routeIs('koordinator.profile*') ? 'bg-amber-50 border-l-4 border-amber-600' : 'hover:bg-gray-100' }} rounded-lg transition-all duration-200">
                    <i
                        class="fas fa-user mr-3 {{ request()->routeIs('koordinator.profile*') ? 'text-amber-600' : 'text-gray-500' }}"></i>
                    <span
                        class="{{ request()->routeIs('koordinator.profile*') ? 'font-semibold text-amber-900' : '' }}">Profile</span>
                </a>
            </li>

            <!-- Logout -->
            <li>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                        class="w-full flex items-center p-3 text-gray-700 hover:bg-red-50 rounded-lg transition-all duration-200">
                        <i class="fas fa-sign-out-alt mr-3 text-red-500"></i>
                        <span class="text-red-600">Logout</span>
                    </button>
                </form>
            </li>
        </ul>

        <!-- Info Box -->
        <div class="mt-6 p-3 bg-amber-50 rounded-lg border border-amber-200">
            <div class="flex items-start space-x-2">
                <i class="fas fa-info-circle text-amber-600 mt-0.5"></i>
                <div>
                    <p class="text-xs text-amber-900 font-medium">Full Management</p>
                    <p class="text-xs text-amber-600 mt-1">Anda memiliki akses penuh untuk mengelola sistem.</p>
                </div>
            </div>
        </div>
    </div>
</div>
