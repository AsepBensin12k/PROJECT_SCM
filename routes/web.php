<?php

// use Illuminate\Support\Facades\Route;
// use Illuminate\Support\Facades\Auth;
// use Illuminate\Http\Request;

// use App\Http\Controllers\{
//     ProfileController,
//     RoleController,
//     UserController,
//     SupplierController,
//     MaterialController,
//     ProductController,
//     StockController,
//     ProductionController,
//     DistributionController,
//     ForecastController,
//     LoginController,
//     KoordinatorController,
//     ProductionScheduleController,
//     OwnerController
// };

// /*
// |--------------------------------------------------------------------------
// | Public Routes
// |--------------------------------------------------------------------------
// */

// Route::get('/', function () {
//     return view('auth.login');
// });

// /*
// |--------------------------------------------------------------------------
// | Authentication Routes
// |--------------------------------------------------------------------------
// */

// Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
// Route::post('login', [LoginController::class, 'login']);

// // ✅ SOLUSI 1: Gunakan fully qualified namespace
// Route::post('/logout', function (\Illuminate\Http\Request $request) {
//     Auth::logout();
//     $request->session()->invalidate();
//     $request->session()->regenerateToken();
//     return redirect('/login');
// })->name('logout');

// // ✅ SOLUSI 2 (LEBIH BAIK): Gunakan LoginController
// // Route::post('/logout', [LoginController::class, 'logout'])->name('logout');


// /*
// |--------------------------------------------------------------------------
// | KOORDINATOR ROUTES
// |--------------------------------------------------------------------------
// */
// Route::middleware(['auth'])->prefix('koordinator')->group(function () {

//     // 🏠 Dashboard
//     Route::get('dashboardkoordinator/index', [KoordinatorController::class, 'index'])
//         ->name('koordinator.dashboard');

//     // 📦 Procurement Management
//     Route::get('/procurements', [KoordinatorController::class, 'procurements'])->name('koordinator.procurements');
//     Route::get('/procurements/create', [KoordinatorController::class, 'createProcurement'])->name('koordinator.procurements.create');
//     Route::post('/procurements', [KoordinatorController::class, 'storeProcurement'])->name('koordinator.procurements.store');
//     Route::get('/procurements/{id}/edit', [KoordinatorController::class, 'editProcurement'])->name('koordinator.procurements.edit');
//     Route::put('/procurements/{id}', [KoordinatorController::class, 'updateProcurement'])->name('koordinator.procurements.update');
//     Route::delete('/procurements/{id}', [KoordinatorController::class, 'destroyProcurement'])->name('koordinator.procurements.destroy');

//     // 👤 Profile
//     Route::get('/profile', [KoordinatorController::class, 'profile'])->name('koordinator.profile');
//     Route::get('/profile/edit', [KoordinatorController::class, 'editProfile'])->name('koordinator.profile.edit');
//     Route::put('/profile', [KoordinatorController::class, 'updateProfile'])->name('koordinator.profile.update');

//     // 🧱 Materials Management
//     Route::get('/materials', [KoordinatorController::class, 'materials'])->name('koordinator.materials');
//     Route::get('/materials/create', [KoordinatorController::class, 'createMaterial'])->name('koordinator.materials.create');
//     Route::post('/materials', [KoordinatorController::class, 'storeMaterial'])->name('koordinator.materials.store');
//     Route::put('/materials/{material}', [KoordinatorController::class, 'updateMaterial'])->name('koordinator.materials.update');
//     Route::delete('/materials/{material}', [KoordinatorController::class, 'destroyMaterial'])->name('koordinator.materials.destroy');

//     // 📦 Products Management
//     Route::get('/products', [KoordinatorController::class, 'products'])->name('koordinator.products');
//     Route::get('/products/create', [KoordinatorController::class, 'createProduct'])->name('koordinator.products.create');
//     Route::post('/products', [KoordinatorController::class, 'storeProduct'])->name('koordinator.products.store');
//     Route::put('/products/{product}', [KoordinatorController::class, 'updateProduct'])->name('koordinator.products.update');

//     // 🏭 Manajemen Jadwal Produksi
//     Route::get('/productions', [ProductionScheduleController::class, 'index'])->name('koordinator.productions.index');
//     Route::get('/productions/create', [ProductionScheduleController::class, 'create'])->name('koordinator.productions.create');
//     Route::post('/productions', [ProductionScheduleController::class, 'store'])->name('koordinator.productions.store');
//     Route::get('/productions/{id}', [ProductionScheduleController::class, 'show'])->name('koordinator.productions.show');
//     Route::put('/productions/{id}/status', [ProductionScheduleController::class, 'updateStatus'])->name('koordinator.productions.updateStatus');

//     // ⚙️ Production Management
//     Route::get('manajemenproduksi/index', [KoordinatorController::class, 'production'])->name('manajemenproduksi');
//     Route::get('manajemenproduksi/create', [KoordinatorController::class, 'createProduction'])->name('manajemenproduksi.create');
//     Route::post('manajemenproduksi/store', [KoordinatorController::class, 'storeProduction'])->name('manajemenproduksi.store');
//     Route::get('/{id}/edit', [KoordinatorController::class, 'editProduction'])->name('manajemenproduksi.edit');
//     Route::put('/manajemenproduksi/{production}', [KoordinatorController::class, 'updateProduction'])->name('manajemenproduksi.update');
//     Route::delete('/production/{production}', [KoordinatorController::class, 'destroyProduction'])->name('koordinator.production.destroy');


//     // 🚚 DISTRIBUTION MANAGEMENT (revised full version)
//     Route::prefix('distributions')->group(function () {

//         // 📋 Daftar distribusi
//         Route::get('/', [KoordinatorController::class, 'distributions'])
//             ->name('koordinator.distributions');

//         // ➕ Tambah distribusi
//         Route::get('/create', [KoordinatorController::class, 'createDistribution'])
//             ->name('koordinator.distributions.create');
//         Route::post('/', [KoordinatorController::class, 'storeDistribution'])
//             ->name('koordinator.distributions.store');

//         // 🔍 Lihat detail distribusi
//         Route::get('/{distribution}', [KoordinatorController::class, 'showDistribution'])
//             ->name('koordinator.distributions.show');

//         // ✏️ Edit distribusi
//         Route::get('/{distribution}/edit', [KoordinatorController::class, 'editDistribution'])
//             ->name('koordinator.distributions.edit');
//         Route::put('/{distribution}', [KoordinatorController::class, 'updateDistribution'])
//             ->name('koordinator.distributions.update');
//     });
// });


// /*
// |--------------------------------------------------------------------------
// | OWNER ROUTES
// |--------------------------------------------------------------------------
// */
// Route::middleware(['auth'])->prefix('owner')->name('owner.')->group(function () {

//     // 🏠 Dashboard
//     Route::get('/dashboard', [OwnerController::class, 'index'])->name('dashboard');

//     // 📦 Supplier Management
//     Route::get('/suppliers', [OwnerController::class, 'suppliers'])->name('suppliers');
//     Route::get('/suppliers/create', [OwnerController::class, 'createSupplier'])->name('suppliers.create');
//     Route::post('/suppliers/store', [OwnerController::class, 'storeSupplier'])->name('suppliers.store');
//     Route::get('/suppliers/{id}/edit', [OwnerController::class, 'editSupplier'])->name('suppliers.edit');
//     Route::put('/suppliers/{id}', [OwnerController::class, 'updateSupplier'])->name('suppliers.update');
//     Route::patch('/suppliers/{id}/toggle', [OwnerController::class, 'toggleSupplierStatus'])->name('suppliers.toggle');
//     Route::delete('/suppliers/{id}', [OwnerController::class, 'destroySupplier'])->name('suppliers.destroy');

//     // 📊 Laporan
//     Route::get('/laporan-bahan-baku', [OwnerController::class, 'laporanBahanBaku'])->name('laporan.bahanbaku');
//     Route::get('/laporan-stok-barang-jadi', [OwnerController::class, 'laporanProdukJadi'])->name('laporan.produkjadi');
//     Route::get('/laporan-stok-barang-jadi/{id}', [OwnerController::class, 'detailProdukJadi'])->name('laporan.produkjadi.show');
//     Route::get('/laporan-produksi', [OwnerController::class, 'laporanProduksi'])->name('laporan.produksi');
//     Route::get('/laporan-produksi/{id}', [OwnerController::class, 'detailProduksi'])->name('laporan.produksi.show');
//     Route::get('/laporan-distribusi', [OwnerController::class, 'laporanDistribusi'])->name('laporan.distribusi');
//     Route::get('/laporan-distribusi/{id}', [OwnerController::class, 'detailDistribusi'])->name('laporan.distribusi.show');

//     // 🔮 FORECASTING (Weighted Moving Average)
//     Route::prefix('forecasts')->group(function () {
//         Route::get('/', [ForecastController::class, 'index'])->name('forecasts');
//         Route::post('/generate', [ForecastController::class, 'generate'])->name('forecasts.generate');
//     });

//     // 👤 Profile Owner
//     Route::get('/profile', [OwnerController::class, 'profile'])->name('profile');   
//     Route::get('/profile/edit', [OwnerController::class, 'editProfile'])->name('profile.edit');
//     Route::put('/profile/update', [OwnerController::class, 'updateProfile'])->name('profile.update');
//     Route::put('/profile/password', [OwnerController::class, 'updatePassword'])->name('profile.password');
// });

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\KoordinatorController;
use App\Http\Controllers\ProductionScheduleController;
use App\Http\Controllers\OwnerController;
use App\Http\Controllers\ForecastController;

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
Route::post('logout', [LoginController::class, 'logout'])->name('logout');


/*
|--------------------------------------------------------------------------
| KOORDINATOR ROUTES
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->prefix('koordinator')->group(function () {

    // Dashboard
    Route::get('dashboardkoordinator/index', [KoordinatorController::class, 'index'])
        ->name('koordinator.dashboard');

    // Procurement Management
    Route::get('/procurements', [KoordinatorController::class, 'procurements'])->name('koordinator.procurements');
    Route::get('/procurements/create', [KoordinatorController::class, 'createProcurement'])->name('koordinator.procurements.create');
    Route::post('/procurements', [KoordinatorController::class, 'storeProcurement'])->name('koordinator.procurements.store');
    Route::get('/procurements/{id}/edit', [KoordinatorController::class, 'editProcurement'])->name('koordinator.procurements.edit');
    Route::put('/procurements/{id}', [KoordinatorController::class, 'updateProcurement'])->name('koordinator.procurements.update');
    Route::delete('/procurements/{id}', [KoordinatorController::class, 'destroyProcurement'])->name('koordinator.procurements.destroy');

    // Profile
    Route::get('/profile', [KoordinatorController::class, 'profile'])->name('koordinator.profile');
    Route::get('/profile/edit', [KoordinatorController::class, 'editProfile'])->name('koordinator.profile.edit');
    Route::put('/profile', [KoordinatorController::class, 'updateProfile'])->name('koordinator.profile.update');

    // Materials Management
    Route::get('/materials', [KoordinatorController::class, 'materials'])->name('koordinator.materials');
    Route::get('/materials/create', [KoordinatorController::class, 'createMaterial'])->name('koordinator.materials.create');
    Route::post('/materials', [KoordinatorController::class, 'storeMaterial'])->name('koordinator.materials.store');
    Route::put('/materials/{material}', [KoordinatorController::class, 'updateMaterial'])->name('koordinator.materials.update');
    Route::delete('/materials/{material}', [KoordinatorController::class, 'destroyMaterial'])->name('koordinator.materials.destroy');

    // Products Management
    Route::get('/products', [KoordinatorController::class, 'products'])->name('koordinator.products');
    Route::get('/products/create', [KoordinatorController::class, 'createProduct'])->name('koordinator.products.create');
    Route::post('/products', [KoordinatorController::class, 'storeProduct'])->name('koordinator.products.store');
    Route::put('/products/{product}', [KoordinatorController::class, 'updateProduct'])->name('koordinator.products.update');

    // Production Schedule
    Route::get('/productions', [ProductionScheduleController::class, 'index'])->name('koordinator.productions.index');
    Route::get('/productions/create', [ProductionScheduleController::class, 'create'])->name('koordinator.productions.create');
    Route::post('/productions', [ProductionScheduleController::class, 'store'])->name('koordinator.productions.store');
    Route::get('/productions/{id}', [ProductionScheduleController::class, 'show'])->name('koordinator.productions.show');
    Route::put('/productions/{id}/status', [ProductionScheduleController::class, 'updateStatus'])->name('koordinator.productions.updateStatus');

    // Production Management
    Route::get('manajemenproduksi/index', [KoordinatorController::class, 'production'])->name('manajemenproduksi');
    Route::get('manajemenproduksi/create', [KoordinatorController::class, 'createProduction'])->name('manajemenproduksi.create');
    Route::post('manajemenproduksi/store', [KoordinatorController::class, 'storeProduction'])->name('manajemenproduksi.store');
    Route::get('/{id}/edit', [KoordinatorController::class, 'editProduction'])->name('manajemenproduksi.edit');
    Route::put('/manajemenproduksi/{production}', [KoordinatorController::class, 'updateProduction'])->name('manajemenproduksi.update');
    Route::delete('/production/{production}', [KoordinatorController::class, 'destroyProduction'])->name('koordinator.production.destroy');

    // Distribution Management
    Route::prefix('distributions')->group(function () {
        Route::get('/', [KoordinatorController::class, 'distributions'])->name('koordinator.distributions');
        Route::get('/create', [KoordinatorController::class, 'createDistribution'])->name('koordinator.distributions.create');
        Route::post('/', [KoordinatorController::class, 'storeDistribution'])->name('koordinator.distributions.store');
        Route::get('/{distribution}', [KoordinatorController::class, 'showDistribution'])->name('koordinator.distributions.show');
        Route::get('/{distribution}/edit', [KoordinatorController::class, 'editDistribution'])->name('koordinator.distributions.edit');
        Route::put('/{distribution}', [KoordinatorController::class, 'updateDistribution'])->name('koordinator.distributions.update');
    });
});


/*
|--------------------------------------------------------------------------
| OWNER ROUTES
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->prefix('owner')->name('owner.')->group(function () {

    // Dashboard
    Route::get('/dashboard', [OwnerController::class, 'index'])->name('dashboard');

    // Supplier Management
    Route::get('/suppliers', [OwnerController::class, 'suppliers'])->name('suppliers');
    Route::get('/suppliers/create', [OwnerController::class, 'createSupplier'])->name('suppliers.create');
    Route::post('/suppliers/store', [OwnerController::class, 'storeSupplier'])->name('suppliers.store');
    Route::get('/suppliers/{id}/edit', [OwnerController::class, 'editSupplier'])->name('suppliers.edit');
    Route::put('/suppliers/{id}', [OwnerController::class, 'updateSupplier'])->name('suppliers.update');
    Route::patch('/suppliers/{id}/toggle', [OwnerController::class, 'toggleSupplierStatus'])->name('suppliers.toggle');
    Route::delete('/suppliers/{id}', [OwnerController::class, 'destroySupplier'])->name('suppliers.destroy');

    // Laporan
    Route::get('/laporan-bahan-baku', [OwnerController::class, 'laporanBahanBaku'])->name('laporan.bahanbaku');
    Route::get('/laporan-stok-barang-jadi', [OwnerController::class, 'laporanProdukJadi'])->name('laporan.produkjadi');
    Route::get('/laporan-stok-barang-jadi/{id}', [OwnerController::class, 'detailProdukJadi'])->name('laporan.produkjadi.show');
    Route::get('/laporan-produksi', [OwnerController::class, 'laporanProduksi'])->name('laporan.produksi');
    Route::get('/laporan-produksi/{id}', [OwnerController::class, 'detailProduksi'])->name('laporan.produksi.show');
    Route::get('/laporan-distribusi', [OwnerController::class, 'laporanDistribusi'])->name('laporan.distribusi');
    Route::get('/laporan-distribusi/{id}', [OwnerController::class, 'detailDistribusi'])->name('laporan.distribusi.show');

    // Forecasting
    Route::prefix('forecasts')->group(function () {
        Route::get('/', [ForecastController::class, 'index'])->name('forecasts');
        Route::post('/generate', [ForecastController::class, 'generate'])->name('forecasts.generate');
    });

    // Profile Owner
    Route::get('/profile', [OwnerController::class, 'profile'])->name('profile');   
    Route::get('/profile/edit', [OwnerController::class, 'editProfile'])->name('profile.edit');
    Route::put('/profile/update', [OwnerController::class, 'updateProfile'])->name('profile.update');
    Route::put('/profile/password', [OwnerController::class, 'updatePassword'])->name('profile.password');
});


// require __DIR__.'/auth.php';

require __DIR__.'/auth.php';