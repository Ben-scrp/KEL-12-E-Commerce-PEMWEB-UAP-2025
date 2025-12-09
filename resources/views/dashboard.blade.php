<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    {{ __("You're logged in!") }}

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
