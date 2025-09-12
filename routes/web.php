<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\UserProfileController;
use App\Http\Controllers\ResetPassword;
use App\Http\Controllers\ChangePassword;
use App\Http\Controllers\JenisBarangController;
use App\Http\Controllers\KeranjangController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\LayananController;
use App\Http\Controllers\AntrianController;
use App\Http\Controllers\UserController;

Route::get('/', [HomeController::class, 'index'])->name('index');
Route::get('/produk', [HomeController::class, 'produk'])->name('produk');
Route::get('/etalase/{id}', [BarangController::class, 'showEtalase'])->name('etalase.detail');
Route::get('/layanan', [HomeController::class, 'layanan'])->name('layanan');
Route::get('/layanan/{id}', [LayananController::class, 'show'])->name('layanan.detail');
Route::get('/kontak', [HomeController::class, 'index'])->name('kontak');

Route::get('/register', [RegisterController::class, 'create'])->middleware('guest')->name('register');
Route::post('/register', [RegisterController::class, 'store'])->middleware('guest')->name('register.perform');
Route::get('/login', [LoginController::class, 'show'])->middleware('guest')->name('login');
Route::post('/login', [LoginController::class, 'login'])->middleware('guest')->name('login.perform');
Route::get('/reset-password', [ResetPassword::class, 'show'])->middleware('guest')->name('reset-password');
Route::post('/reset-password', [ResetPassword::class, 'send'])->middleware('guest')->name('reset.perform');
Route::get('/change-password', [ChangePassword::class, 'show'])->middleware('guest')->name('change-password');
Route::post('/change-password', [ChangePassword::class, 'update'])->middleware('guest')->name('change.perform');
Route::get('/dashboard', [HomeController::class, 'dashboard'])->middleware('auth')->name('home');
Route::patch('/queues/{queue}/status', [HomeController::class, 'updateStatus'])->name('queues.updateStatus');

Route::get('/kategori/{slug}', [BarangController::class, 'byJenis'])->name('barang.byJenis');

Route::get('/keranjang', [KeranjangController::class, 'index'])->name('keranjang.index');
Route::post('/keranjang/tambah', [KeranjangController::class, 'tambah'])->name('keranjang.tambah');
Route::delete('/keranjang/{id}', [KeranjangController::class, 'hapus'])->name('keranjang.hapus');

Route::get('/checkout', [KeranjangController::class, 'checkout'])->name('checkout');
Route::post('/checkout', [KeranjangController::class, 'prosesCheckout'])->name('checkout.process');

Route::group(['middleware' => 'auth'], function () {
    Route::resource('barang', BarangController::class);
    Route::resource('jenis-barang', JenisBarangController::class);
    Route::resource('layanans', LayananController::class);

    // Antrian
    Route::post('/antrian', [AntrianController::class, 'store'])->name('antrian.store');

    // Lihat tiket antrian
    Route::get('/tiket-antrian', [AntrianController::class, 'tiket'])->name('antrian.tiket');

    Route::resource('transaksi', TransaksiController::class);
    Route::put('/transaksi/{id}/konfirmasi', [TransaksiController::class, 'konfirmasi'])->name('transaksi.konfirmasi');

    Route::resource('user-management', UserController::class);

    Route::get('/virtual-reality', [PageController::class, 'vr'])->name('virtual-reality');
    Route::get('/rtl', [PageController::class, 'rtl'])->name('rtl');
    Route::get('/profile', [UserProfileController::class, 'show'])->name('profile');
    Route::post('/profile', [UserProfileController::class, 'update'])->name('profile.update');
    Route::get('/profile-static', [PageController::class, 'profile'])->name('profile-static');
    Route::get('/sign-in-static', [PageController::class, 'signin'])->name('sign-in-static');
    Route::get('/sign-up-static', [PageController::class, 'signup'])->name('sign-up-static');
    Route::get('/{page}', [PageController::class, 'index'])->name('page');
    Route::post('logout', [LoginController::class, 'logout'])->name('logout');
});
