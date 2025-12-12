<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Seller Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white shadow sm:rounded-lg">
                <div class="p-6">

                    <h1 class="text-2xl font-bold text-gray-800 mb-1">Welcome, Seller!</h1>

                    <p class="text-gray-600 mb-4">
                        Kelola seluruh kebutuhan toko Anda melalui menu berikut:
                    </p>

                    <!-- MENU GRID -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">

                        <!-- Kembali ke Dashboard -->
                        <a href="/dashboard"
                           class="block p-5 rounded-xl shadow font-semibold text-center text-white"
                           style="background:#374151 !important;">
                            Kembali ke Dashboard Utama
                        </a>

                        <!-- Kelola Produk -->
                        <a href="/seller/products"
                           class="block p-5 rounded-xl shadow font-semibold text-center text-white"
                           style="background:#2563eb !important;">
                            Kelola Produk
                        </a>

                        <!-- Lihat Pesanan -->
                        <a href="/seller/orders"
                           class="block p-5 rounded-xl shadow font-semibold text-center text-white"
                           style="background:#16a34a !important;">
                            Lihat Pesanan Masuk
                        </a>

                        <!-- Pengaturan Toko -->
                        <a href="/seller/profile"
                           class="block p-5 rounded-xl shadow font-semibold text-center text-white"
                           style="background:#4f46e5 !important;">
                            Pengaturan Toko
                        </a>

                        <!-- Kelola Kategori (FIX PUTIH) -->
                        <a href="{{ route('seller.categories.index') }}"
                           class="block p-5 rounded-xl shadow font-semibold text-center"
                           style="background:#eab308 !important; color:#000 !important; border:1px solid #c59f08 !important;">
                            Kelola Kategori
                        </a>

                        <!-- Saldo Toko (FIX PUTIH) -->
                        <a href="{{ route('seller.balance.index') }}"
                           class="block p-5 rounded-xl shadow font-semibold text-center"
                           style="background:#fb923c !important; color:#000 !important; border:1px solid #dd7f2f !important;">
                            Saldo Toko
                        </a>

                        <!-- Penarikan -->
                        <a href="{{ route('seller.withdrawals.index') }}"
                           class="block p-5 rounded-xl shadow font-semibold text-center text-white"
                           style="background:#dc2626 !important;">
                            Penarikan Dana
                        </a>

                    </div>

                </div>
            </div>

        </div>
    </div>
</x-app-layout>

