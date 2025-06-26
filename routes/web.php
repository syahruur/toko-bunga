<?php

use App\Livewire\Settings\Appearance;
use App\Livewire\Settings\Password;
use App\Livewire\Settings\Profile;
use Illuminate\Support\Facades\Route;
use App\Livewire\Admin\Users as AdminUsers;
use App\Livewire\Admin\Products as AdminProducts;
use App\Livewire\Admin\Orders as AdminOrders;
use App\Livewire\Cart\Index as CartIndex;
use App\Livewire\Orders\History as OrderHistory;
use App\Livewire\Orders\Track as OrderTrack;
use App\Livewire\Products\Index as ProductsIndex;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Route::get('settings/profile', Profile::class)->name('settings.profile');
    Route::get('settings/password', Password::class)->name('settings.password');
    Route::get('settings/appearance', Appearance::class)->name('settings.appearance');
});

// Public routes
Route::get('/produk', ProductsIndex::class)->name('produk.index'); // Daftar produk

// Customer routes
Route::middleware(['auth'])->group(function () {
    Route::get('/keranjang', CartIndex::class)->name('keranjang.index'); // Keranjang belanja
    Route::get('/pesanan/riwayat', OrderHistory::class)->name('pesanan.riwayat'); // Riwayat pesanan
    Route::get('/pesanan/lacak', OrderTrack::class)->name('pesanan.lacak'); // Lacak pesanan
});

// Admin routes
Route::middleware(['auth', \App\Http\Middleware\RedirectPropperRole::class])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/pengguna', AdminUsers::class)->name('pengguna'); // Manajemen pengguna
    Route::get('/produk', AdminProducts::class)->name('produk'); // Manajemen produk
    Route::get('/pesanan', AdminOrders::class)->name('pesanan'); // Manajemen pesanan
});

require __DIR__.'/auth.php';
