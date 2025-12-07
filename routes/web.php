<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');


// =============================
//   RBAC: Role Based Access Control
// =============================

// --- ADMIN ONLY ---
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin/dashboard', function () {
        return "Halaman Dashboard Admin";
    })->name('admin.dashboard');
});

Route::middleware(['auth', 'seller'])->group(function () {
    Route::get('/seller/dashboard', function () {
        return "Dashboard Seller";
    });
});

Route::middleware(['auth', 'role:member'])->group(function () {
    Route::get('/member/home', function () {
        return "Halaman Member / Customer";
    })->name('member.home');
});


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
