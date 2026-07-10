
<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\StokController;
use App\Http\Controllers\KeuanganController;
use App\Http\Controllers\BlockchainController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\MasterDataController;

/*
|--------------------------------------------------------------------------
| Redirect Awal
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    if (auth()->check()) {
        return redirect()->route('dashboard.index');
    }
    return redirect()->route('login');
});

/*
|--------------------------------------------------------------------------
| Auth
|--------------------------------------------------------------------------
*/
Route::middleware(['guest'])->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');
    
    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.post');
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

/*
|--------------------------------------------------------------------------
| Protected Routes
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {

    /*
    |--------------------------------------------------------------------------
    | Dashboard
    |--------------------------------------------------------------------------
    */
    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard.index');

    // Profile
    Route::get('/profile', [AuthController::class, 'profile'])->name('profile.show');
    Route::post('/profile', [AuthController::class, 'updateProfile'])->name('profile.update');
    Route::post('/profile/password', [AuthController::class, 'updatePassword'])->name('profile.password');

    Route::get('/dashboard/content/{page}', [DashboardController::class, 'load'])
        ->name('dashboard.load');

Route::post('/keuangan/tambah-saldo', [KeuanganController::class, 'tambahSaldo'])->name('keuangan.tambahSaldo');
Route::get('/keuangan/fragment-saldo', [KeuanganController::class, 'fragmentSaldo']);
    /*
    |--------------------------------------------------------------------------
    | Grafik (API KHUSUS)
    |--------------------------------------------------------------------------
    | ⛔ WAJIB DI SINI, JANGAN DICAMPUR VIEW
    */
    Route::get('/dashboard/grafik-keuangan', 
        [KeuanganController::class, 'getGrafikBulanan']
    )->name('grafik.keuangan');

    Route::get('/dashboard/grafik-stok', 
        [StokController::class, 'grafik']
    )->name('grafik.stok');

    /*
    |--------------------------------------------------------------------------
    | Stok
    |--------------------------------------------------------------------------
    */
    Route::get('/dashboard/stok', [StokController::class, 'index'])->name('stok.index');
    Route::get('/dashboard/stok/create', [StokController::class, 'create'])->name('stok.create');
    Route::post('/dashboard/stok/store', [StokController::class, 'store'])->name('stok.store');
    Route::get('/dashboard/stok/{id}/edit', [StokController::class, 'edit'])->name('stok.edit');
    Route::put('/dashboard/stok/{id}', [StokController::class, 'update'])->name('stok.update');
    Route::delete('/dashboard/stok/{id}', [StokController::class, 'destroy'])->name('stok.destroy');
    Route::get('/dashboard/stok/{id}/struk', [StokController::class, 'cetakStruk'])->name('stok.struk');
Route::post('/stok', [StokController::class, 'store'])->name('stok.store');

    Route::post('/dashboard/stok/jual', 
        [StokController::class, 'jualGlobal']
    )->name('stok.jual.global');

   /*
|--------------------------------------------------------------------------
| Keuangan
|--------------------------------------------------------------------------
*/
Route::prefix('dashboard')->middleware('auth')->group(function() {
    // Route utama keuangan
    Route::get('/keuangan', [KeuanganController::class, 'index'])->name('keuangan.index');

    // Route API data tabel
    Route::get('/keuangan/data', [KeuanganController::class, 'getData'])->name('keuangan.data');

    // Route grafik bulanan
    Route::get('/keuangan/grafik', [KeuanganController::class, 'getGrafikBulanan'])->name('keuangan.grafik');

    // Export Excel
    Route::get('/keuangan/export', [KeuanganController::class, 'exportExcel'])->name('keuangan.export');

    // Tambah Saldo
    Route::post('/keuangan/tambah-saldo', [KeuanganController::class, 'tambahSaldo'])->name('keuangan.tambahSaldo');

    Route::post('/keuangan/tambah-modal', [KeuanganController::class, 'tambahModal'])->name('keuangan.tambahModal');
    
    // Cetak Struk Keuangan
    Route::get('/keuangan/{id}/struk', [KeuanganController::class, 'cetakStruk'])->name('keuangan.struk');
    // ...existing code...
});

/*
|--------------------------------------------------------------------------
| Blockchain
|--------------------------------------------------------------------------
*/
Route::get('/blocks', [BlockchainController::class, 'index'])->name('blocks.index');
Route::delete('/blocks/{id}', [BlockchainController::class, 'destroy'])->name('blocks.destroy');
Route::get('/blocks/validate', [BlockchainController::class, 'validateChain'])->name('blocks.validate');
Route::get('/blockchain/validate', [BlockchainController::class, 'validateChain']);

/*
|--------------------------------------------------------------------------
| User Management (Admin Only)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:admin'])->prefix('users')->group(function () {
    Route::get('/', [UserController::class, 'index'])->name('users.index');
    Route::get('/create', [UserController::class, 'create'])->name('users.create');
    Route::post('/', [UserController::class, 'store'])->name('users.store');
    Route::get('/{id}/edit', [UserController::class, 'edit'])->name('users.edit');
    Route::put('/{id}', [UserController::class, 'update'])->name('users.update');
    Route::delete('/{id}', [UserController::class, 'destroy'])->name('users.destroy');
});

/*
|--------------------------------------------------------------------------
| Master Data (Admin Only)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:admin'])->prefix('dashboard')->group(function () {
    Route::post('/master-barang', [MasterDataController::class, 'storeBarang'])->name('master.barang.store');
    Route::put('/master-barang/{id}', [MasterDataController::class, 'updateBarang'])->name('master.barang.update');
    Route::delete('/master-barang/{id}', [MasterDataController::class, 'destroyBarang'])->name('master.barang.destroy');

    Route::post('/master-petani', [MasterDataController::class, 'storePetani'])->name('master.petani.store');
    Route::put('/master-petani/{id}', [MasterDataController::class, 'updatePetani'])->name('master.petani.update');
    Route::delete('/master-petani/{id}', [MasterDataController::class, 'destroyPetani'])->name('master.petani.destroy');
});

/*
|--------------------------------------------------------------------------
| Laporan
|--------------------------------------------------------------------------
*/
Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan.index');
Route::get('/laporan/export', [LaporanController::class, 'exportExcel'])->name('laporan.export');

}); // <--- TUTUP auth middleware group
