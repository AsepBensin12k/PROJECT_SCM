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
    return view('auth/login');
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

/*
|--------------------------------------------------------------------------
| Koordinator Routes - Full CRUD Access
|--------------------------------------------------------------------------
*/

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

/*
|--------------------------------------------------------------------------
| Owner Routes - Read Only Access
|--------------------------------------------------------------------------
*/

Route::middleware(['auth'])->prefix('owner')->group(function () {
    
    // Dashboard
    Route::get('/dashboard', [OwnerController::class, 'index'])->name('owner.dashboard');
    
    // Materials - View Only
    Route::get('/materials', [OwnerController::class, 'materials'])->name('owner.materials');
    
    // Products - View Only
    Route::get('/products', [OwnerController::class, 'products'])->name('owner.products');
    
    // Productions - View Only
    Route::get('/productions', [OwnerController::class, 'productions'])->name('owner.productions');
    
    // Distributions - View Only
    Route::get('/distributions', [OwnerController::class, 'distributions'])->name('owner.distributions');
    
    // Forecasts - View Only
    Route::get('/forecasts', [OwnerController::class, 'forecasts'])->name('owner.forecasts');
    
    // Reports - View Only
    Route::get('/reports', [OwnerController::class, 'reports'])->name('owner.reports');
    
    // Profile
    Route::get('/profile', [OwnerController::class, 'profile'])->name('owner.profile');
    Route::get('/profile/edit', [OwnerController::class, 'editProfile'])->name('owner.profile.edit');
    Route::put('/profile', [OwnerController::class, 'updateProfile'])->name('owner.profile.update');
});

/*
|--------------------------------------------------------------------------
| Legacy Routes (Optional - Keep if still used)
|--------------------------------------------------------------------------
*/

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

require __DIR__.'/auth.php';