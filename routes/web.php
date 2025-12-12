<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\VaPaymentController;
use App\Http\Controllers\WalletController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\Seller\StoreController;
use App\Http\Controllers\Seller\CategoryController;
use App\Http\Controllers\Seller\ProductController as SellerProductController;
use App\Http\Controllers\Seller\OrderController as SellerOrderController;
use App\Http\Controllers\Seller\BalanceController;

/*
|--------------------------------------------------------------------------
| PUBLIC PAGE
|--------------------------------------------------------------------------
*/
Route::get('/', [ProductController::class, 'index'])->name('homepage');

// 🔥 Tambahan penting BIAR SEARCH BAR & LIST PRODUK NGGAK ERROR
Route::get('/products', [ProductController::class, 'index'])->name('products.index');

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

    Route::get('/wallet/topup/va', [WalletController::class, 'showTopupVA'])->name('wallet.topup.va');

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

    return redirect('/');
})->middleware(['auth'])->name('dashboard');


/*
|--------------------------------------------------------------------------
| ADMIN PAGE
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin/dashboard', [\App\Http\Controllers\AdminController::class, 'index'])->name('admin.dashboard');

    // Verifikasi Toko
    Route::get('/admin/verification', [\App\Http\Controllers\AdminController::class, 'verification'])->name('admin.verification');
    Route::post('/admin/verification/{store}/verify', [\App\Http\Controllers\AdminController::class, 'verifyStore'])->name('admin.verification.verify');
    Route::post('/admin/verification/{store}/reject', [\App\Http\Controllers\AdminController::class, 'rejectStore'])->name('admin.verification.reject');

    // Manajemen User & Toko
    Route::get('/admin/users', [\App\Http\Controllers\AdminController::class, 'users'])->name('admin.users');
});


/*
|--------------------------------------------------------------------------
| SELLER PAGE
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:member'])->group(function () {

    Route::get('/store/register', [StoreController::class, 'create'])->name('store.register');
    Route::post('/store/register', [StoreController::class, 'store'])->name('store.store');

    Route::get('/seller/dashboard', function () {
        if (!auth()->user()->store) {
            return redirect()->route('store.register');
        }
        return view('seller.dashboard');
    })->name('seller.dashboard');

    Route::get('/seller/profile', [StoreController::class, 'edit'])->name('seller.profile');
    Route::put('/seller/profile', [StoreController::class, 'update'])->name('seller.profile.update');

    Route::resource('/seller/categories', CategoryController::class)->names('seller.categories');

    Route::resource('/seller/products', SellerProductController::class)->names('seller.products');

    Route::delete('/seller/products/images/{image}', [SellerProductController::class, 'deleteImage'])->name('seller.products.images.destroy');
    Route::patch('/seller/products/images/{image}/thumbnail', [SellerProductController::class, 'setThumbnail'])->name('seller.products.images.thumbnail');

    Route::resource('/seller/orders', SellerOrderController::class)->only(['index', 'show', 'update'])->names('seller.orders');

    Route::get('/seller/balance', [BalanceController::class, 'index'])->name('seller.balance.index');
    Route::get('/seller/withdrawals', [BalanceController::class, 'withdrawals'])->name('seller.withdrawals.index');
    Route::get('/seller/withdrawals/create', [BalanceController::class, 'createWithdrawal'])->name('seller.withdrawals.create');
    Route::post('/seller/withdrawals', [BalanceController::class, 'storeWithdrawal'])->name('seller.withdrawals.store');
});


/*
|--------------------------------------------------------------------------
| CUSTOMER PAGE
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:member'])->group(function () {

    Route::get('/customer/purchase', function () {
        return view('customer.purchase');
    })->name('customer.purchase');

    // Riwayat Transaksi Customer
    Route::get('/history', [\App\Http\Controllers\CustomerController::class, 'history'])
        ->name('customer.history');

    Route::get('/wallet/topup', [WalletController::class, 'showTopupForm'])->name('wallet.topup.form');
    Route::post('/wallet/topup', [WalletController::class, 'topup'])->name('wallet.topup');
});


/*
|--------------------------------------------------------------------------
| PRODUCT DETAIL PAGE
|--------------------------------------------------------------------------
*/
Route::get('/product/{slug}', [ProductController::class, 'show'])->name('product.show');


/*
|--------------------------------------------------------------------------
| AUTH ROUTES
|--------------------------------------------------------------------------
*/
require __DIR__.'/auth.php';
