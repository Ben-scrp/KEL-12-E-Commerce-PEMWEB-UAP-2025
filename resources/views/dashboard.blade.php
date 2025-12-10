<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="overflow-hidden shadow-sm sm:rounded-lg" style="background-color: #FFFDD0;">
                <div class="p-6 text-gray-900">

                    {{ __("You're logged in!") }}

                    <div class="mt-4 flex gap-4">
                        <a href="/admin/dashboard" class="px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700">
                            Halaman Admin
                        </a>
                        <a href="/seller/dashboard" class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">
                            Halaman Seller
                        </a>
                    </div>

                    {{-- ========================= --}}
                    {{-- TOMBOL CHECKOUT VIA VA     --}}
                    {{-- ========================= --}}
                    <div class="mt-6">
                        <form action="/checkout/va" method="POST">
                            @csrf
                            <input type="hidden" name="total_price" value="50000">
                            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded">
                                Bayar dengan Virtual Account (VA)
                            </button>
                        </form>

                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
