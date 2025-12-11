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
Route::get('/', [ProductController::class, 'index'])->name('homepage');
// Checkout page (bisa diakses tanpa login)
Route::get('/checkout', [CheckoutController::class, 'index'])
    ->name('checkout.index');

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


    // Proses checkout (buat transaksi + detail)
    Route::post('/checkout/process', [CheckoutController::class, 'process'])
        ->name('checkout.process');
        
    
    /*
    |--------------------------------------------------------------------------
    | WALLET
    |--------------------------------------------------------------------------
    */
    Route::get('/wallet', [WalletController::class, 'index'])->name('wallet.index');
    Route::get('/wallet/topup/va', [WalletController::class, 'showTopupVA'])
    ->name('wallet.topup.va');

    Route::get('/wallet/topup', [WalletController::class, 'showTopupForm'])
    ->name('wallet.topup.form');
    Route::post('/wallet/topup', [WalletController::class, 'topup'])
        ->name('wallet.topup');
        

    Route::post('/wallet/pay', [WalletController::class, 'payWithWallet'])->name('wallet.pay');

    /*
    |--------------------------------------------------------------------------
    | VA PAYMENT & PAGE
    |--------------------------------------------------------------------------
    */
    

    Route::post('/checkout/va', [CheckoutController::class, 'payWithVA']);
    
    Route::get('/payment', [VaPaymentController::class, 'index'])->name('payment.index');
    Route::get('/payment/check', function () {
    return redirect('/payment');
    });
    Route::post('/payment/check', [VaPaymentController::class, 'check'])->name('payment.check');
    Route::post('/payment/pay', [VaPaymentController::class, 'pay'])->name('payment.pay');
});


/*
|--------------------------------------------------------------------------
| AFTER LOGIN REDIRECT
|--------------------------------------------------------------------------
*/

Route::get('/dashboard', function () {
    $user = auth()->user();

    if ($user->role === 'admin') {
        return redirect('/admin/dashboard');
    }

    if ($user->role === 'member' && $user->store) {
        return redirect('/seller/dashboard');
    }

    return redirect('/'); // customer langsung ke homepage
})->middleware(['auth'])->name('dashboard');


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

    // Riwayat Transaksi Customer
    Route::get('/history', [\App\Http\Controllers\CustomerController::class, 'history'])
        ->name('customer.history');

    // Form Topup Saldo
    Route::get('/wallet/topup', [\App\Http\Controllers\WalletController::class, 'showTopupForm'])
        ->name('wallet.topup.form');

    // Proses Topup Saldo → buat VA
    Route::post('/wallet/topup', [\App\Http\Controllers\WalletController::class, 'topup'])
        ->name('wallet.topup');
});

// =========================
// PRODUCT DETAIL PAGE
// =========================
Route::get('/product/{slug}', [ProductController::class, 'show'])->name('product.show');


/*
|--------------------------------------------------------------------------
| AUTH ROUTES
|--------------------------------------------------------------------------
*/
require __DIR__.'/auth.php';