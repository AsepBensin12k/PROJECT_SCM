<!-- Sidebar Owner -->
<div class="w-64 bg-white shadow-lg min-h-screen fixed top-16 left-0 overflow-y-auto border-r border-purple-100">
    <div class="p-4">
        <!-- Owner Badge -->
        <div class="mb-4 p-3 bg-gradient-to-r from-purple-50 to-indigo-50 rounded-lg border border-purple-200">
            <div class="flex items-center space-x-2">
                <i class="fas fa-crown text-purple-600"></i>
                <span class="text-sm font-semibold text-purple-900">Owner Access</span>
            </div>
            <p class="text-xs text-purple-600 mt-1">Full Management</p>
        </div>

        <ul class="space-y-2">
            <!-- Dashboard -->
            <li>
                <a href="{{ route('owner.dashboard') }}"
                    class="flex items-center p-3 text-gray-700 {{ request()->routeIs('owner.dashboard') ? 'bg-purple-50 border-l-4 border-purple-600' : 'hover:bg-gray-100' }} rounded-lg transition-all duration-200">
                    <i
                        class="fas fa-tachometer-alt mr-3 {{ request()->routeIs('owner.dashboard') ? 'text-purple-600' : 'text-gray-500' }}"></i>
                    <span
                        class="{{ request()->routeIs('owner.dashboard') ? 'font-semibold text-purple-900' : '' }}">Dashboard</span>
                </a>
            </li>

            <!-- Suppliers - Full Access -->
            <li>
                <a href="{{ route('owner.suppliers') }}"
                    class="flex items-center p-3 text-gray-700 {{ request()->routeIs('owner.suppliers*') ? 'bg-purple-50 border-l-4 border-purple-600' : 'hover:bg-gray-100' }} rounded-lg transition-all duration-200">
                    <i
                        class="fas fa-truck-loading mr-3 {{ request()->routeIs('owner.suppliers*') ? 'text-purple-600' : 'text-gray-500' }}"></i>
                    <span
                        class="{{ request()->routeIs('owner.suppliers*') ? 'font-semibold text-purple-900' : '' }}">Kelola
                        Supplier</span>
                    <i class="fas fa-edit ml-auto text-xs text-purple-400"></i>
                </a>
            </li>

            <!-- Bahan Baku -->
            <li>
                <a href="{{ route('owner.materials') }}"
                    class="flex items-center p-3 text-gray-700 {{ request()->routeIs('owner.materials*') ? 'bg-purple-50 border-l-4 border-purple-600' : 'hover:bg-gray-100' }} rounded-lg transition-all duration-200">
                    <i
                        class="fas fa-boxes mr-3 {{ request()->routeIs('owner.materials*') ? 'text-purple-600' : 'text-gray-500' }}"></i>
                    <span
                        class="{{ request()->routeIs('owner.materials*') ? 'font-semibold text-purple-900' : '' }}">Bahan
                        Baku</span>

                </a>
            </li>

            <!-- Produk Jadi -->
            <li>
                <a href="{{ route('owner.products') }}"
                    class="flex items-center p-3 text-gray-700 {{ request()->routeIs('owner.products*') ? 'bg-purple-50 border-l-4 border-purple-600' : 'hover:bg-gray-100' }} rounded-lg transition-all duration-200">
                    <i
                        class="fas fa-cube mr-3 {{ request()->routeIs('owner.products*') ? 'text-purple-600' : 'text-gray-500' }}"></i>
                    <span
                        class="{{ request()->routeIs('owner.products*') ? 'font-semibold text-purple-900' : '' }}">Produk
                        Jadi</span>
                    
                </a>
            </li>

            <!-- Produksi -->
            <li>
                <a href="{{ route('owner.productions') }}"
                    class="flex items-center p-3 text-gray-700 {{ request()->routeIs('owner.productions*') ? 'bg-purple-50 border-l-4 border-purple-600' : 'hover:bg-gray-100' }} rounded-lg transition-all duration-200">
                    <i
                        class="fas fa-industry mr-3 {{ request()->routeIs('owner.productions*') ? 'text-purple-600' : 'text-gray-500' }}"></i>
                    <span
                        class="{{ request()->routeIs('owner.productions*') ? 'font-semibold text-purple-900' : '' }}">Produksi</span>

                </a>
            </li>

            <!-- Distribusi -->
            <li>
                <a href="{{ route('owner.distributions') }}"
                    class="flex items-center p-3 text-gray-700 {{ request()->routeIs('owner.distributions*') ? 'bg-purple-50 border-l-4 border-purple-600' : 'hover:bg-gray-100' }} rounded-lg transition-all duration-200">
                    <i
                        class="fas fa-truck mr-3 {{ request()->routeIs('owner.distributions*') ? 'text-purple-600' : 'text-gray-500' }}"></i>
                    <span
                        class="{{ request()->routeIs('owner.distributions*') ? 'font-semibold text-purple-900' : '' }}">Distribusi</span>
                </a>
            </li>

            <!-- Forecasting -->
            <li>
                <a href="{{ route('owner.forecasts') }}"
                    class="flex items-center p-3 text-gray-700 {{ request()->routeIs('owner.forecasts*') ? 'bg-purple-50 border-l-4 border-purple-600' : 'hover:bg-gray-100' }} rounded-lg transition-all duration-200">
                    <i
                        class="fas fa-chart-line mr-3 {{ request()->routeIs('owner.forecasts*') ? 'text-purple-600' : 'text-gray-500' }}"></i>
                    <span
                        class="{{ request()->routeIs('owner.forecasts*') ? 'font-semibold text-purple-900' : '' }}">Forecasting</span>
                </a>
            </li>

            <!-- Laporan -->
            <li>
                <a href="{{ route('owner.reports') }}"
                    class="flex items-center p-3 text-gray-700 {{ request()->routeIs('owner.reports*') ? 'bg-purple-50 border-l-4 border-purple-600' : 'hover:bg-gray-100' }} rounded-lg transition-all duration-200">
                    <i
                        class="fas fa-file-alt mr-3 {{ request()->routeIs('owner.reports*') ? 'text-purple-600' : 'text-gray-500' }}"></i>
                    <span
                        class="{{ request()->routeIs('owner.reports*') ? 'font-semibold text-purple-900' : '' }}">Laporan</span>
                </a>
            </li>

            <!-- Profile -->
            <li>
                <a href="{{ route('owner.profile') }}"
                    class="flex items-center p-3 text-gray-700 {{ request()->routeIs('owner.profile*') ? 'bg-purple-50 border-l-4 border-purple-600' : 'hover:bg-gray-100' }} rounded-lg transition-all duration-200">
                    <i
                        class="fas fa-user mr-3 {{ request()->routeIs('owner.profile*') ? 'text-purple-600' : 'text-gray-500' }}"></i>
                    <span
                        class="{{ request()->routeIs('owner.profile*') ? 'font-semibold text-purple-900' : '' }}">Profile</span>
                </a>
            </li>

            {{-- <!-- Logout -->
            <li>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                        class="w-full flex items-center p-3 text-gray-700 hover:bg-red-50 rounded-lg transition-all duration-200">
                        <i class="fas fa-sign-out-alt mr-3 text-red-500"></i>
                        <span class="text-red-600">Logout</span>
                    </button>
                </form>
            </li> --}}
        </ul>

        <!-- Info Box -->
        <div class="mt-6 p-3 bg-purple-50 rounded-lg border border-purple-200">
            <div class="flex items-start space-x-2">
                <i class="fas fa-info-circle text-purple-600 mt-0.5"></i>
                <div>
                    <p class="text-xs text-purple-900 font-medium">Access Level</p>
                    <p class="text-xs text-purple-600 mt-1">Full access untuk Supplier. View-only untuk operasional.</p>
                </div>
            </div>
        </div>
    </div>
</div>
