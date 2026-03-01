<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Public\HomeController;
use App\Http\Controllers\Public\UmkmController as PublicUmkmController;
use App\Http\Controllers\Public\ProductController as PublicProductController;
use App\Http\Controllers\Customer\DashboardController as CustomerDashboard;
use App\Http\Controllers\Customer\OrderController as CustomerOrder;
use App\Http\Controllers\Customer\WishlistController;
use App\Http\Controllers\Customer\ReviewController;
use App\Http\Controllers\Customer\ProfileController as CustomerProfile;
use App\Http\Controllers\Umkm\DashboardController as UmkmDashboard;
use App\Http\Controllers\Umkm\ProductController as UmkmProduct;
use App\Http\Controllers\Umkm\OrderController as UmkmOrder;
use App\Http\Controllers\Umkm\ProfileController as UmkmProfile;
use App\Http\Controllers\Umkm\ReportController as UmkmReport;
use App\Http\Controllers\Admin\DashboardController as AdminDashboard;
use App\Http\Controllers\Admin\UmkmController as AdminUmkm;
use App\Http\Controllers\Admin\UserController as AdminUser;
use App\Http\Controllers\Admin\CategoryController as AdminCategory;
use App\Http\Controllers\Admin\BannerController as AdminBanner;
use App\Http\Controllers\Admin\VerifikasiController as AdminVerifikasi;
use App\Http\Controllers\Dinas\DashboardController as DinasDashboard;

/*
|--------------------------------------------------------------------------
| PUBLIC ROUTES
|--------------------------------------------------------------------------
*/
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/katalog', [PublicProductController::class, 'index'])->name('katalog');
Route::get('/katalog/{slug}', [PublicProductController::class, 'show'])->name('katalog.show');
Route::get('/umkm', [PublicUmkmController::class, 'index'])->name('umkm.index');
Route::get('/umkm/{slug}', [PublicUmkmController::class, 'show'])->name('umkm.show');
Route::get('/peta', [HomeController::class, 'peta'])->name('peta');
Route::get('/tentang', [HomeController::class, 'tentang'])->name('tentang');

/*
|--------------------------------------------------------------------------
| AUTH ROUTES
|--------------------------------------------------------------------------
*/
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
    Route::get('/register', [RegisterController::class, 'showForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register']);
    Route::get('/register/umkm', [RegisterController::class, 'showUmkmForm'])->name('register.umkm');
    Route::post('/register/umkm', [RegisterController::class, 'registerUmkm']);
});
Route::post('/logout', [LoginController::class, 'logout'])->name('logout')->middleware('auth');

/*
|--------------------------------------------------------------------------
| CUSTOMER ROUTES
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:customer'])->prefix('pelanggan')->name('customer.')->group(function () {
    Route::get('/dashboard', [CustomerDashboard::class, 'index'])->name('dashboard');
    Route::get('/profil', [CustomerProfile::class, 'edit'])->name('profil.edit');
    Route::put('/profil', [CustomerProfile::class, 'update'])->name('profil.update');

    // Pesanan
    Route::get('/pesanan', [CustomerOrder::class, 'index'])->name('pesanan.index');
    Route::get('/pesanan/{order}', [CustomerOrder::class, 'show'])->name('pesanan.show');
    Route::post('/pesanan', [CustomerOrder::class, 'store'])->name('pesanan.store');
    Route::patch('/pesanan/{order}/terima', [CustomerOrder::class, 'terima'])->name('pesanan.terima');
    Route::patch('/pesanan/{order}/batal', [CustomerOrder::class, 'batal'])->name('pesanan.batal');

    // Wishlist
    Route::get('/wishlist', [WishlistController::class, 'index'])->name('wishlist.index');
    Route::post('/wishlist/{product}', [WishlistController::class, 'toggle'])->name('wishlist.toggle');

    // Ulasan
    Route::post('/ulasan/{orderItem}', [ReviewController::class, 'store'])->name('ulasan.store');
});

/*
|--------------------------------------------------------------------------
| UMKM ROUTES
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:umkm'])->prefix('toko')->name('umkm.')->group(function () {
    Route::get('/dashboard', [UmkmDashboard::class, 'index'])->name('dashboard');

    // Profil UMKM
    Route::get('/profil', [UmkmProfile::class, 'edit'])->name('profil.edit');
    Route::put('/profil', [UmkmProfile::class, 'update'])->name('profil.update');

    // Produk
    Route::resource('produk', UmkmProduct::class);
    Route::patch('/produk/{product}/toggle', [UmkmProduct::class, 'toggleAvailable'])->name('produk.toggle');

    // Pesanan
    Route::get('/pesanan', [UmkmOrder::class, 'index'])->name('pesanan.index');
    Route::get('/pesanan/{order}', [UmkmOrder::class, 'show'])->name('pesanan.show');
    Route::patch('/pesanan/{order}/konfirmasi', [UmkmOrder::class, 'konfirmasi'])->name('pesanan.konfirmasi');
    Route::patch('/pesanan/{order}/kirim', [UmkmOrder::class, 'kirim'])->name('pesanan.kirim');

    // Laporan
    Route::get('/laporan', [UmkmReport::class, 'index'])->name('laporan');
});

/*
|--------------------------------------------------------------------------
| ADMIN ROUTES
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboard::class, 'index'])->name('dashboard');

    // Kelola UMKM
    Route::resource('umkm', AdminUmkm::class);

    // Verifikasi UMKM
    Route::get('/verifikasi', [AdminVerifikasi::class, 'index'])->name('verifikasi.index');
    Route::patch('/verifikasi/{umkm}/approve', [AdminVerifikasi::class, 'approve'])->name('verifikasi.approve');
    Route::patch('/verifikasi/{umkm}/reject', [AdminVerifikasi::class, 'reject'])->name('verifikasi.reject');

    // Pengguna
    Route::resource('pengguna', AdminUser::class);
    Route::patch('/pengguna/{user}/toggle', [AdminUser::class, 'toggle'])->name('pengguna.toggle');

    // Kategori
    Route::resource('kategori', AdminCategory::class);

    // Banner
    Route::resource('banner', AdminBanner::class);
    Route::patch('/banner/{banner}/toggle', [AdminBanner::class, 'toggle'])->name('banner.toggle');

    // Laporan
    Route::get('/laporan', [AdminDashboard::class, 'laporan'])->name('laporan');
});

/*
|--------------------------------------------------------------------------
| DINAS ROUTES
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:dinas'])->prefix('dinas')->name('dinas.')->group(function () {
    Route::get('/dashboard', [DinasDashboard::class, 'index'])->name('dashboard');
    Route::get('/statistik', [DinasDashboard::class, 'statistik'])->name('statistik');
    Route::get('/peta', [DinasDashboard::class, 'peta'])->name('peta');
    Route::get('/laporan', [DinasDashboard::class, 'laporan'])->name('laporan');
    Route::get('/laporan/export', [DinasDashboard::class, 'export'])->name('laporan.export');
});