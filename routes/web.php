<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Customer\HomeController;
use App\Http\Controllers\Customer\ProductController;
use App\Http\Controllers\Customer\CheckoutController;
use App\Http\Controllers\Customer\TransactionController;
use App\Http\Controllers\Customer\WalletController;

// =========================
// PUBLIC PAGE (HOMEPAGE & PRODUCT)
// =========================
Route::get('/', [HomeController::class, 'index'])->name('index');
Route::get('/product/{slug}', [ProductController::class, 'show'])->name('product.show');

// =========================
// AUTHENTICATED CUSTOMER ROUTES
// =========================
Route::middleware(['auth', 'verified'])->group(function () {

    // CHECKOUT
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');

    // HISTORY
    Route::get('/history', [TransactionController::class, 'index'])->name('customer.history');

    // WALLET TOPUP
    Route::get('/wallet/topup', [WalletController::class, 'topup'])->name('wallet.topup');
    Route::post('/wallet/topup', [WalletController::class, 'storeTopup'])->name('wallet.storeTopup');

    // PROFILE
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // DASHBOARD (Optional/Legacy)
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});

// =========================
// AUTH ROUTES (LOGIN, REGISTER)
// =========================
require __DIR__.'/auth.php';
