{{-- resources/views/wallet/topup_va.blade.php --}}
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Topup Wallet - Virtual Account
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-bold mb-4">
                        Detail Topup
                    </h3>

                    <div class="mb-4">
                        <p><strong>Nomor VA:</strong> {{ $va_number }}</p>
                        <p><strong>Jumlah Topup:</strong> Rp {{ number_format($topup_amount, 0, ',', '.') }}</p>
                        <p><strong>Status:</strong> UNPAID</p>
                    </div>

                    <p class="text-gray-600">
                        Silakan transfer sesuai nominal tersebut ke nomor VA di atas untuk menyelesaikan topup saldo.
                    </p>

                    {{-- nanti kalau mau, di sini bisa ditambah tombol "Simulasikan Pembayaran" --}}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
