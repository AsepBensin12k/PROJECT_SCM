<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\{
    ProfileController,
    RoleController,
    UserController,
    SupplierController,
    MaterialController,
    ProductController,
    StockController,
    ProductionController,
    DistributionController,
    ForecastController,
    LoginController,
    KoordinatorController,
    OwnerController
};

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('auth.login');
});

/*
|--------------------------------------------------------------------------
| Authentication Routes
|--------------------------------------------------------------------------
*/

Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('login', [LoginController::class, 'login']);

Route::post('/logout', function (Illuminate\Http\Request $request) {
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    return redirect('/');
})->name('logout');



Route::middleware(['auth'])->prefix('koordinator')->group(function () {
    
    // Dashboard
    Route::get('dashboardkoordinator/index', [KoordinatorController::class, 'index'])->name('koordinator.dashboard');
    
    // Profile
    Route::get('/profile', [KoordinatorController::class, 'profile'])->name('koordinator.profile');
    Route::get('/profile/edit', [KoordinatorController::class, 'editProfile'])->name('koordinator.profile.edit');
    Route::put('/profile', [KoordinatorController::class, 'updateProfile'])->name('koordinator.profile.update');
    
    // Materials Management
    Route::get('/materials', [KoordinatorController::class, 'materials'])->name('koordinator.materials');
    Route::get('/materials/create', [KoordinatorController::class, 'createMaterial'])->name('koordinator.materials.create');
    Route::post('/materials', [KoordinatorController::class, 'storeMaterial'])->name('koordinator.materials.store');
    Route::get('/materials/{material}', [KoordinatorController::class, 'editMaterial'])->name('koordinator.materials.edit');
    Route::put('/materials/{material}', [KoordinatorController::class, 'updateMaterial'])->name('koordinator.materials.update');
    Route::delete('/materials/{material}', [KoordinatorController::class, 'destroyMaterial'])->name('koordinator.materials.destroy');
    
    // Products Management
    Route::get('/products', [KoordinatorController::class, 'products'])->name('koordinator.products');
    Route::get('/products/create', [KoordinatorController::class, 'createProduct'])->name('koordinator.products.create');
    Route::post('/products', [KoordinatorController::class, 'storeProduct'])->name('koordinator.products.store');
    Route::get('/products/{product}/edit', [KoordinatorController::class, 'editProduct'])->name('koordinator.products.edit');
    Route::put('/products/{product}', [KoordinatorController::class, 'updateProduct'])->name('koordinator.products.update');
    Route::delete('/products/{product}', [KoordinatorController::class, 'destroyProduct'])->name('koordinator.products.destroy');
    
    // Production Management
    Route::get('manajemenproduksi/index', [KoordinatorController::class, 'production'])->name('manajemenproduksi');
    Route::get('manajemenproduksi/create', [KoordinatorController::class, 'createProduction'])->name('manajemenproduksi.create');
    Route::post('manajemenproduksi/store', [KoordinatorController::class, 'storeProduction'])->name('manajemenproduksi.store');
    Route::get('/{id}/edit', [KoordinatorController::class, 'editProduction'])->name('manajemenproduksi.edit');
    Route::put('/manajemenproduksi/{production}', [KoordinatorController::class, 'updateProduction'])->name('manajemenproduksi.update');
    Route::delete('/production/{production}', [KoordinatorController::class, 'destroyProduction'])->name('koordinator.production.destroy');
    
    // Distribution Management
    Route::get('/distributions', [KoordinatorController::class, 'distributions'])->name('koordinator.distributions');
    Route::get('/distributions/create', [KoordinatorController::class, 'createDistribution'])->name('koordinator.distributions.create');
    Route::post('/distributions', [KoordinatorController::class, 'storeDistribution'])->name('koordinator.distributions.store');
    Route::get('/distributions/{distribution}/edit', [KoordinatorController::class, 'editDistribution'])->name('koordinator.distributions.edit');
    Route::put('/distributions/{distribution}', [KoordinatorController::class, 'updateDistribution'])->name('koordinator.distributions.update');
    Route::delete('/distributions/{distribution}', [KoordinatorController::class, 'destroyDistribution'])->name('koordinator.distributions.destroy');
});



Route::middleware(['auth'])->prefix('owner')->name('owner.')->group(function () {
    
    // Dashboard
    Route::get('/dashboard', [OwnerController::class, 'index'])->name('dashboard');

    // ==========================================
    // Supplier Management Routes - FULL ACCESS
    // ==========================================
    Route::get('/suppliers', [OwnerController::class, 'suppliers'])->name('suppliers');
    Route::get('/suppliers/create', [OwnerController::class, 'createSupplier'])->name('suppliers.create');
    Route::post('/suppliers/store', [OwnerController::class, 'storeSupplier'])->name('suppliers.store');
    Route::get('/suppliers/{id}/edit', [OwnerController::class, 'editSupplier'])->name('suppliers.edit');
    Route::put('/suppliers/{id}', [OwnerController::class, 'updateSupplier'])->name('suppliers.update');
    Route::patch('/suppliers/{id}/toggle', [OwnerController::class, 'toggleSupplierStatus'])->name('suppliers.toggle');
    Route::delete('/suppliers/{id}', [OwnerController::class, 'destroySupplier'])->name('suppliers.destroy');


    Route::get('/laporan-bahan-baku', [OwnerController::class, 'laporanBahanBaku'])->name('laporan.bahanbaku');

// 🧱 LAPORAN PRODUK JADI
    Route::get('/laporan-stok-barang-jadi', [OwnerController::class, 'laporanProdukJadi'])->name('laporan.produkjadi');
    Route::get('/laporan-stok-barang-jadi/{id}', [OwnerController::class, 'detailProdukJadi'])->name('laporan.produkjadi.show');

    // // ==========================================
    // // Product Management Routes - VIEW ONLY
    // // ==========================================
    // Route::get('/products', [OwnerController::class, 'products'])->name('products');
    // Route::get('/products/{id}', [OwnerController::class, 'showProduct'])->name('products.show');

  // 🏭 LAPORAN PRODUKSI
    Route::get('/laporan-produksi', [OwnerController::class, 'laporanProduksi'])->name('laporan.produksi');
    Route::get('/laporan-produksi/{id}', [OwnerController::class, 'detailProduksi'])->name('laporan.produksi.show');

    // 🚚 LAPORAN DISTRIBUSI
    Route::get('/laporan-distribusi', [OwnerController::class, 'laporanDistribusi'])->name('laporan.distribusi');
    Route::get('/laporan-distribusi/{id}', [OwnerController::class, 'detailDistribusi'])->name('laporan.distribusi.show');

    // ==========================================
    // Forecasting Routes - VIEW ONLY
    // ==========================================
    Route::get('/forecasts', [OwnerController::class, 'forecasts'])->name('forecasts');

    // ==========================================
    // Reports Routes - VIEW ONLY
    // ==========================================
    Route::get('/reports', [OwnerController::class, 'reports'])->name('reports');
    Route::get('/reports/export', [OwnerController::class, 'exportReport'])->name('reports.export');

    // Profile Owner
    Route::get('/profile', [OwnerController::class, 'profile'])->name('profile');
    Route::get('/profile/edit', [OwnerController::class, 'editProfile'])->name('profile.edit');
    Route::put('/profile/update', [OwnerController::class, 'updateProfile'])->name('profile.update');
    Route::put('/profile/password', [OwnerController::class, 'updatePassword'])->name('profile.password');

});


require __DIR__.'/auth.php';