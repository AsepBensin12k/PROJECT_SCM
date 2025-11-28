<!-- Sidebar -->
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
</div>
