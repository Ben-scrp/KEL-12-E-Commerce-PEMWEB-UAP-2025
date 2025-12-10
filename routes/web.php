<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\VaPaymentController;
use App\Http\Controllers\WalletController;


// =========================
// PUBLIC PAGE
// =========================
Route::get('/', function () {
    return view('welcome');
});

// =========================
// AUTHENTICATED USER
// =========================
Route::middleware('auth')->group(function () {

    // PROFILE
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // CUSTOMER DASHBOARD
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->middleware('verified')->name('dashboard');
    //======================
   //      WALLET ROUTES
    // =======================

    // Halaman utama wallet
    Route::get('/wallet', [WalletController::class, 'index'])->name('wallet.index');

    // Form topup
    Route::get('/wallet/topup', [WalletController::class, 'showTopupForm'])->name('wallet.topup.form');

    // Proses topup
    Route::post('/wallet/topup', [WalletController::class, 'topup'])->name('wallet.topup');

    // Proses pembayaran dengan wallet
    Route::post('/wallet/pay', [WalletController::class, 'payWithWallet'])->name('wallet.pay');


    // =======================
    //      VA PAYMENT
    // =======================
    Route::post('/checkout/va', [CheckoutController::class, 'payWithVA']);
    Route::post('/va/confirm/{vaNumber}', [VaPaymentController::class, 'confirmPayment']);
});

// =========================
// ADMIN PAGE (ROLE: admin)
// =========================
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin/dashboard', function () {
        return view('admin.dashboard');
    });
});

// =========================
// SELLER PAGE (ROLE: member + punya store)
// =========================
Route::middleware(['auth', 'role:member'])->group(function () {
    Route::get('/seller/dashboard', function () {

        // WAJIB PUNYA STORE
        if (!auth()->user()->store) {
            abort(403, 'ANDA BELUM MEMBUAT TOKO.');
        }

        return view('seller.dashboard');
    });
});

// =========================
// CUSTOMER PAGE (ROLE: member)
// =========================
Route::middleware(['auth', 'role:member'])->group(function () {

    // Halaman pembelian
    Route::get('/customer/purchase', function () {
        return view('customer.purchase');
    })->name('customer.purchase');

    // Halaman riwayat pembelian
    Route::get('/customer/history', function () {
        return view('customer.history');
    })->name('customer.history');

});


// =========================
// AUTH ROUTES (LOGIN, REGISTER)
// =========================
require __DIR__.'/auth.php';
