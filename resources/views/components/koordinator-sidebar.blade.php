{{-- <!-- Sidebar Koordinator -->
<div class="w-64 bg-white shadow-xl min-h-screen fixed top-16 left-0 overflow-y-auto border-r border-amber-100">
    <div class="p-5">
        <!-- Header / Role Info -->
        <div class="mb-6 bg-gradient-to-r from-amber-50 to-orange-50 rounded-2xl border border-amber-200 p-4">
            <div class="flex items-center gap-2 mb-1">
                <i class="fas fa-user-tie text-amber-600"></i>
                <span class="text-sm font-semibold text-amber-900">Koordinator Sistem</span>
            </div>
            <p class="text-xs text-amber-600">Hak akses penuh operasional</p>
        </div>

        <!-- Navigation Menu -->
        <ul class="space-y-2 text-[15px] font-medium">
            <!-- Dashboard -->
            <li>
                <a href="{{ route('koordinator.dashboard') }}"
                    class="flex items-center p-3 rounded-xl transition-all duration-200
                   {{ request()->routeIs('koordinator.dashboard')
                       ? 'bg-amber-50 border-l-4 border-amber-600 text-amber-900 font-semibold'
                       : 'text-gray-700 hover:bg-gray-50' }}">
                    <i
                        class="fas fa-tachometer-alt mr-3 
                        {{ request()->routeIs('koordinator.dashboard') ? 'text-amber-600' : 'text-gray-500' }}"></i>
                    Dashboard
                </a>
            </li>

            <!-- Procurement -->
            <li class="pt-4 pb-1 text-xs uppercase font-semibold text-gray-400 tracking-wide">Procurement</li>
            <li>
                <a href="{{ route('koordinator.procurements') }}"
                    class="flex items-center p-3 rounded-xl transition-all duration-200
                   {{ request()->routeIs('koordinator.procurements*')
                       ? 'bg-amber-50 border-l-4 border-amber-600 text-amber-900 font-semibold'
                       : 'text-gray-700 hover:bg-gray-50' }}">
                    <i
                        class="fas fa-clipboard-list mr-3 
                        {{ request()->routeIs('koordinator.procurements*') ? 'text-amber-600' : 'text-gray-500' }}"></i>
                    Pengadaan
                </a>
            </li>

            <!-- Inventory -->
            <li class="pt-4 pb-1 text-xs uppercase font-semibold text-gray-400 tracking-wide">Inventory</li>

            <li>
                <a href="{{ route('koordinator.materials') }}"
                    class="flex items-center p-3 rounded-xl transition-all duration-200
                   {{ request()->routeIs('koordinator.materials*')
                       ? 'bg-amber-50 border-l-4 border-amber-600 text-amber-900 font-semibold'
                       : 'text-gray-700 hover:bg-gray-50' }}">
                    <i
                        class="fas fa-boxes mr-3 
                        {{ request()->routeIs('koordinator.materials*') ? 'text-amber-600' : 'text-gray-500' }}"></i>
                    Bahan Baku
                </a>
            </li>

            <li>
                <a href="{{ route('koordinator.products') }}"
                    class="flex items-center p-3 rounded-xl transition-all duration-200
                   {{ request()->routeIs('koordinator.products*')
                       ? 'bg-amber-50 border-l-4 border-amber-600 text-amber-900 font-semibold'
                       : 'text-gray-700 hover:bg-gray-50' }}">
                    <i
                        class="fas fa-cube mr-3 
                        {{ request()->routeIs('koordinator.products*') ? 'text-amber-600' : 'text-gray-500' }}"></i>
                    Produk Jadi
                </a>
            </li>

            <!-- Operations -->
            <li class="pt-4 pb-1 text-xs uppercase font-semibold text-gray-400 tracking-wide">Operasional</li>

            <li>
                <a href="{{ route('manajemenproduksi') }}"
                    class="flex items-center p-3 rounded-xl transition-all duration-200
                {{ request()->routeIs('manajemenproduksi*') || request()->routeIs('koordinator.productions*')
                    ? 'bg-amber-50 border-l-4 border-amber-600 text-amber-900 font-semibold'
                    : 'text-gray-700 hover:bg-gray-50' }}">
                    <i
                        class="fas fa-calendar-alt mr-3 
                        {{ request()->routeIs('manajemenproduksi*') || request()->routeIs('koordinator.productions*')
                            ? 'text-amber-600'
                            : 'text-gray-500' }}"></i>
                    Jadwal Produksi
                </a>
            </li>


            <li>
                <a href="{{ route('koordinator.distributions') }}"
                    class="flex items-center p-3 rounded-xl transition-all duration-200
                   {{ request()->routeIs('koordinator.distributions*')
                       ? 'bg-amber-50 border-l-4 border-amber-600 text-amber-900 font-semibold'
                       : 'text-gray-700 hover:bg-gray-50' }}">
                    <i
                        class="fas fa-truck mr-3 
                        {{ request()->routeIs('koordinator.distributions*') ? 'text-amber-600' : 'text-gray-500' }}"></i>
                    Distribusi
                </a>
            </li>

            <!-- Account -->
            <li class="pt-4 pb-1 text-xs uppercase font-semibold text-gray-400 tracking-wide">Akun</li>

            <li>
                <a href="{{ route('koordinator.profile') }}"
                    class="flex items-center p-3 rounded-xl transition-all duration-200
                   {{ request()->routeIs('koordinator.profile*')
                       ? 'bg-amber-50 border-l-4 border-amber-600 text-amber-900 font-semibold'
                       : 'text-gray-700 hover:bg-gray-50' }}">
                    <i
                        class="fas fa-user mr-3 
                        {{ request()->routeIs('koordinator.profile*') ? 'text-amber-600' : 'text-gray-500' }}"></i>
                    Profile
                </a>
            </li>

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

        <!-- Info Box -->
        <div class="mt-8 bg-gradient-to-r from-amber-50 to-orange-50 border border-amber-200 rounded-2xl p-4">
            <div class="flex items-start gap-2">
                <i class="fas fa-info-circle text-amber-600 mt-0.5"></i>
                <div>
                    <p class="text-xs font-semibold text-amber-900">Full Management</p>
                    <p class="text-xs text-amber-700 mt-1 leading-snug">
                        Anda memiliki akses penuh untuk mengelola semua data produksi dan distribusi.
                    </p>
                </div>
            </div>
        </div>
    </div>
</div> --}}

<!-- Sidebar Koordinator -->
<div x-data="{ open: true }"
    class="w-64 bg-white shadow-xl min-h-screen fixed top-16 left-0 overflow-y-auto border-r border-amber-100 transition-all duration-300"
    :class="open ? 'translate-x-0' : '-translate-x-full'">

    <div class="p-5">

        <!-- Header -->
        <div class="mb-6 bg-gradient-to-r from-amber-50 to-orange-50 rounded-2xl border border-amber-200 p-4">
            <div class="flex items-center gap-2 mb-1">
                <i class="fas fa-user-tie text-amber-600"></i>
                <span class="text-sm font-semibold text-amber-900">Koordinator Sistem</span>
            </div>
            <p class="text-xs text-amber-600">Hak akses penuh operasional</p>
        </div>

        <!-- Navigation Menu -->
        <ul class="space-y-2 text-[15px] font-medium">

            <!-- Dashboard -->
            <li>
                <a href="{{ route('koordinator.dashboard') }}"
                    class="flex items-center p-3 rounded-xl transition-all duration-200
                    {{ request()->routeIs('koordinator.dashboard')
                        ? 'bg-amber-50 border-l-4 border-amber-600 text-amber-900 font-semibold'
                        : 'text-gray-700 hover:bg-gray-50' }}">
                    <i
                        class="fas fa-tachometer-alt mr-3 
                        {{ request()->routeIs('koordinator.dashboard') ? 'text-amber-600' : 'text-gray-500' }}"></i>
                    Dashboard
                </a>
            </li>

            <!-- Procurement -->
            <li class="pt-4 pb-1 text-xs uppercase font-semibold text-gray-400 tracking-wide">Procurement</li>
            <li>
                <a href="{{ route('koordinator.procurements') }}"
                    class="flex items-center p-3 rounded-xl transition-all duration-200
                    {{ request()->routeIs('koordinator.procurements*')
                        ? 'bg-amber-50 border-l-4 border-amber-600 text-amber-900 font-semibold'
                        : 'text-gray-700 hover:bg-gray-50' }}">
                    <i
                        class="fas fa-clipboard-list mr-3 
                        {{ request()->routeIs('koordinator.procurements*') ? 'text-amber-600' : 'text-gray-500' }}"></i>
                    Pengadaan
                </a>
            </li>

            <!-- Inventory -->
            <li class="pt-4 pb-1 text-xs uppercase font-semibold text-gray-400 tracking-wide">Inventory</li>

            <li>
                <a href="{{ route('koordinator.materials') }}"
                    class="flex items-center p-3 rounded-xl transition-all duration-200
                    {{ request()->routeIs('koordinator.materials*')
                        ? 'bg-amber-50 border-l-4 border-amber-600 text-amber-900 font-semibold'
                        : 'text-gray-700 hover:bg-gray-50' }}">
                    <i
                        class="fas fa-boxes mr-3 
                        {{ request()->routeIs('koordinator.materials*') ? 'text-amber-600' : 'text-gray-500' }}"></i>
                    Bahan Baku
                </a>
            </li>

            <li>
                <a href="{{ route('koordinator.products') }}"
                    class="flex items-center p-3 rounded-xl transition-all duration-200
                    {{ request()->routeIs('koordinator.products*')
                        ? 'bg-amber-50 border-l-4 border-amber-600 text-amber-900 font-semibold'
                        : 'text-gray-700 hover:bg-gray-50' }}">
                    <i
                        class="fas fa-cube mr-3 
                        {{ request()->routeIs('koordinator.products*') ? 'text-amber-600' : 'text-gray-500' }}"></i>
                    Produk Jadi
                </a>
            </li>

            <!-- Operations -->
            <li class="pt-4 pb-1 text-xs uppercase font-semibold text-gray-400 tracking-wide">Operasional</li>

            <!-- Jadwal Produksi -->
            <li>
                <a href="{{ route('manajemenproduksi') }}"
                    class="flex items-center p-3 rounded-xl transition-all duration-200
                    {{ request()->routeIs('manajemenproduksi*') || request()->routeIs('koordinator.productions*')
                        ? 'bg-amber-50 border-l-4 border-amber-600 text-amber-900 font-semibold'
                        : 'text-gray-700 hover:bg-gray-50' }}">
                    <i
                        class="fas fa-calendar-alt mr-3 
                        {{ request()->routeIs('manajemenproduksi*') || request()->routeIs('koordinator.productions*')
                            ? 'text-amber-600'
                            : 'text-gray-500' }}"></i>
                    Jadwal Produksi
                </a>
            </li>

            <!-- Distribusi -->
            <li>
                <a href="{{ route('koordinator.distributions') }}"
                    class="flex items-center p-3 rounded-xl transition-all duration-200
                    {{ request()->routeIs('koordinator.distributions*')
                        ? 'bg-amber-50 border-l-4 border-amber-600 text-amber-900 font-semibold'
                        : 'text-gray-700 hover:bg-gray-50' }}">
                    <i
                        class="fas fa-truck mr-3 
                        {{ request()->routeIs('koordinator.distributions*') ? 'text-amber-600' : 'text-gray-500' }}"></i>
                    Distribusi
                </a>
            </li>

            <!-- Account -->
            <li class="pt-4 pb-1 text-xs uppercase font-semibold text-gray-400 tracking-wide">Akun</li>

            <li>
                <a href="{{ route('koordinator.profile') }}"
                    class="flex items-center p-3 rounded-xl transition-all duration-200
                    {{ request()->routeIs('koordinator.profile*')
                        ? 'bg-amber-50 border-l-4 border-amber-600 text-amber-900 font-semibold'
                        : 'text-gray-700 hover:bg-gray-50' }}">
                    <i
                        class="fas fa-user mr-3 
                        {{ request()->routeIs('koordinator.profile*') ? 'text-amber-600' : 'text-gray-500' }}"></i>
                    Profil
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

        <!-- Info Box -->
        <div class="mt-8 bg-gradient-to-r from-amber-50 to-orange-50 border border-amber-200 rounded-2xl p-4">
            <div class="flex items-start gap-2">
                <i class="fas fa-info-circle text-amber-600 mt-0.5"></i>
                <div>
                    <p class="text-xs font-semibold text-amber-900">Full Management</p>
                    <p class="text-xs text-amber-700 mt-1 leading-snug">
                        Anda memiliki akses penuh untuk mengelola semua data produksi dan distribusi.
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Toggle Button (optional for mobile) -->
    <button x-on:click="open = !open"
        class="absolute -right-3 top-6 bg-amber-500 text-white rounded-full p-1 shadow-lg hover:bg-amber-600 transition-all duration-200">
        <i :class="open ? 'fas fa-chevron-left' : 'fas fa-chevron-right'"></i>
    </button>
</div>

<!-- Optional Script -->
@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const links = document.querySelectorAll('.sidebar a');
            links.forEach(link => {
                link.addEventListener('mouseenter', () => link.classList.add('scale-[1.02]'));
                link.addEventListener('mouseleave', () => link.classList.remove('scale-[1.02]'));
            });
        });
    </script>
@endpush
