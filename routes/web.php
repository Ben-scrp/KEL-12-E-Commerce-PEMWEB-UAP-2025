<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\VaPaymentController;
use App\Http\Controllers\WalletController;
use App\Http\Controllers\ProductController;

/*
|--------------------------------------------------------------------------
| PUBLIC PAGE
|--------------------------------------------------------------------------
*/

// Homepage untuk semua user (guest & login)
Route::get('/', [ProductController::class, 'index'])->name('homepage');

/*
|--------------------------------------------------------------------------
| AUTHENTICATED USER
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {

    // Payment success
    Route::get('/payment/success', function () {
        return view('payment.success');
    })->name('payment.success');

    // PROFILE
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    /*
    |--------------------------------------------------------------------------
    | WALLET
    |--------------------------------------------------------------------------
    */
    Route::get('/wallet', [WalletController::class, 'index'])->name('wallet.index');
    Route::get('/wallet/topup', [WalletController::class, 'showTopupForm'])->name('wallet.topup.form');
    Route::post('/wallet/topup', [WalletController::class, 'topup'])->name('wallet.topup');
    Route::post('/wallet/pay', [WalletController::class, 'payWithWallet'])->name('wallet.pay');

    /*
    |--------------------------------------------------------------------------
    | VA PAYMENT & PAGE
    |--------------------------------------------------------------------------
    */
    Route::post('/checkout/va', [CheckoutController::class, 'payWithVA']);
    Route::get('/payment', [VaPaymentController::class, 'index'])->name('payment.index');
    Route::post('/payment/check', [VaPaymentController::class, 'check'])->name('payment.check');
    Route::post('/payment/pay', [VaPaymentController::class, 'pay'])->name('payment.pay');
});

/*
|--------------------------------------------------------------------------
| ADMIN PAGE
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin/dashboard', function () {
        return view('admin.dashboard');
    })->name('admin.dashboard');
});

/*
|--------------------------------------------------------------------------
| SELLER PAGE
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:member'])->group(function () {
    Route::get('/seller/dashboard', function () {

        if (!auth()->user()->store) {
            abort(403, 'Anda belum membuat toko.');
        }

        return view('seller.dashboard');
    })->name('seller.dashboard');
});

/*
|--------------------------------------------------------------------------
| CUSTOMER PAGE (member)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:member'])->group(function () {

    Route::get('/customer/purchase', function () {
        return view('customer.purchase');
    })->name('customer.purchase');

    Route::get('/customer/history', function () {
        return view('customer.history');
    })->name('customer.history');
});

/*
|--------------------------------------------------------------------------
| AUTH ROUTES
|--------------------------------------------------------------------------
*/
require __DIR__.'/auth.php';