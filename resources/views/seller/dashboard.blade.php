<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Seller Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    {{-- Info --}}
                    <h3 class="text-lg font-semibold mb-3">Welcome, Seller!</h3>
                    <p class="mb-5">Anda sekarang berada di halaman dashboard khusus seller.</p>

                    {{-- Tombol Navigasi --}}
                    <div class="flex flex-wrap gap-4">

                        <a href="/dashboard"
                           class="px-4 py-2 bg-gray-700 text-white rounded hover:bg-gray-800">
                            Kembali ke Dashboard Utama
                        </a>

                        <a href="/seller/products"
                           class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                            Kelola Produk
                        </a>

                        <a href="/seller/orders"
                           class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">
                            Lihat Pesanan Masuk
                        </a>

                        <a href="/seller/profile"
                           class="px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700">
                            Pengaturan Toko
                        </a>

                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
