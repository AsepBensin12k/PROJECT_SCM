<?php

use Illuminate\Support\Facades\Route;

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
    KoordinatorController
};

Route::get('/', function () {
    return view('auth/login');
});

Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('login', [LoginController::class, 'login']);

// routes/web.php
Route::put('/{id}', [KoordinatorDashboardController::class, 'updateProduction'])->name('update');
Route::get('koordinator/dashboardkoordinator/index', [KoordinatorController::class, 'index'])->name('koordinator.dashboard');
Route::get('koordinator/manajemenproduksi/index', [KoordinatorController::class, 'production'])->name('manajemenproduksi');
// Rute untuk menampilkan FORMULIR pembuatan produksi (GET)
Route::get('koordinator/manajemenproduksi/create', [KoordinatorController::class, 'createProduction'])->name('manajemenproduksi.create');
Route::get('/{id}/edit', [KoordinatorController::class, 'editProduction'])->name('manajemenproduksi.edit');
Route::put('/manajemenproduksi/{production}', [KoordinatorController::class, 'updateProduction'])->name('manajemenproduksi.update');
Route::delete('/koordinator/production/{production}', [KoordinatorController::class, 'destroyProduction'])->name('koordinator.production.destroy');

// 1. Index (READ - Menampilkan semua material)
Route::get('/koordinator/materials', [KoordinatorController::class, 'materials'])
    ->name('koordinator.materials');

// 2. Store (CREATE - Menyimpan material baru)
Route::post('/koordinator/materials', [KoordinatorController::class, 'storeMaterial'])
    ->name('koordinator.materials.store');
Route::get
('/koordinator/materials/create', [KoordinatorController::class, 'createMaterial'])
    ->name('koordinator.materials.create');
// 3. Update (UPDATE - Memperbarui material)
// Asumsi Anda akan menggunakan form edit yang menunjuk ke route ini
Route::put('/koordinator/materials/{material}', [KoordinatorController::class, 'updateMaterial'])
    ->name('koordinator.materials.update');
Route::get('/koordinator/materials/{material}', [KoordinatorController::class, 'editMaterial'])
    ->name('koordinator.materials.edit');
// 4. Destroy (DELETE - Menghapus material)
Route::delete('/koordinator/materials/{material}', [KoordinatorController::class, 'destroyMaterial'])
    ->name('koordinator.materials.destroy');
// Rute untuk MENYIMPAN DATA produksi baru (POST)
Route::post('koordinator/manajemenproduksi/store', [KoordinatorController::class, 'storeProduction'])->name('manajemenproduksi.store');

//stokjadi
Route::get('/products', [KoordinatorController::class, 'products'])->name('koordinator.products');
Route::get('/products/create', [KoordinatorController::class, 'createProduct'])->name('koordinator.products.create');
Route::post('/products', [KoordinatorController::class, 'storeProduct'])->name('koordinator.products.store');
Route::get('/products/{product}/edit', [KoordinatorController::class, 'editProduct'])->name('koordinator.products.edit');
Route::put('/products/{product}', [KoordinatorController::class, 'updateProduct'])->name('koordinator.products.update');
Route::delete('/products/{product}', [KoordinatorController::class, 'destroyProduct'])->name('koordinator.products.destroy');

// Distribution Routes
Route::get('/distributions', [KoordinatorController::class, 'distributions'])->name('koordinator.distributions');
Route::get('/distributions/create', [KoordinatorController::class, 'createDistribution'])->name('koordinator.distributions.create');
Route::post('/distributions', [KoordinatorController::class, 'storeDistribution'])->name('koordinator.distributions.store');
Route::get('/distributions/{distribution}/edit', [KoordinatorController::class, 'editDistribution'])->name('koordinator.distributions.edit');
Route::put('/distributions/{distribution}', [KoordinatorController::class, 'updateDistribution'])->name('koordinator.distributions.update');
Route::delete('/distributions/{distribution}', [KoordinatorController::class, 'destroyDistribution'])->name('koordinator.distributions.destroy');

// Profile Routes
Route::get('/koordinator/profile', [KoordinatorController::class, 'profile'])->name('koordinator.profile');
Route::get('/koordinator/profile/edit', [KoordinatorController::class, 'editProfile'])->name('koordinator.profile.edit');
Route::put('/koordinator/profile', [KoordinatorController::class, 'updateProfile'])->name('koordinator.profile.update');

// Dashboard Routes (bisa diakses semua role)
// Route::get('/dashboard', [CoordinatorDashboardController::class, 'index'])->name('dashboard');

// // Materials CRUD (bisa diakses semua role)
// Route::get('/materials', [CoordinatorDashboardController::class, 'materials'])->name('materials');
// Route::post('/materials', [CoordinatorDashboardController::class, 'storeMaterial'])->name('materials.store');
// Route::put('/materials/{id}', [CoordinatorDashboardController::class, 'updateMaterial'])->name('materials.update');
// Route::delete('/materials/{id}', [CoordinatorDashboardController::class, 'destroyMaterial'])->name('materials.destroy');

// // Products CRUD (bisa diakses semua role)
// Route::get('/products', [CoordinatorDashboardController::class, 'products'])->name('products');
// Route::post('/products', [CoordinatorDashboardController::class, 'storeProduct'])->name('products.store');
// Route::put('/products/{id}', [CoordinatorDashboardController::class, 'updateProduct'])->name('products.update');
// Route::delete('/products/{id}', [CoordinatorDashboardController::class, 'destroyProduct'])->name('products.destroy');

// // Production Schedule (bisa diakses semua role)
// Route::get('/production', [CoordinatorDashboardController::class, 'production'])->name('production');
// Route::post('/production', [CoordinatorDashboardController::class, 'storeProduction'])->name('production.store');
// Route::put('/production/{id}', [CoordinatorDashboardController::class, 'updateProduction'])->name('production.update');
// Route::delete('/production/{id}', [CoordinatorDashboardController::class, 'destroyProduction'])->name('production.destroy');

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');


// Route::middleware('auth')->group(function () {

//     Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
//     Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
//     Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

//     Route::resource('roles', RoleController::class);
//     Route::resource('users', UserController::class);
//     Route::resource('suppliers', SupplierController::class);
//     Route::resource('materials', MaterialController::class);
//     Route::resource('products', ProductController::class);
//     Route::resource('stocks', StockController::class);
//     Route::resource('productions', ProductionController::class);
//     Route::resource('distributions', DistributionController::class);
//     Route::resource('forecasts', ForecastController::class);
// });

Route::post('/logout', function (Illuminate\Http\Request $request) {
    Auth::logout(); // Log user keluar

    $request->session()->invalidate(); // Membatalkan session
    $request->session()->regenerateToken(); // Meregenerasi token CSRF

    return redirect('/'); // Arahkan user kembali ke halaman utama atau login
})->name('logout');
require __DIR__.'/auth.php';
