<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Konfirmasi Pembayaran
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    {{-- ALERT ERROR --}}
                    @if (session('error'))
                        <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                            {{ session('error') }}
                        </div>
                    @endif


                    <div class="mb-6 border-b pb-4">
                        <h3 class="text-lg font-bold">Detail Tagihan</h3>
                        <p>Nomor VA: <strong>{{ $va->va_number }}</strong></p>
                        <p>Total Tagihan: <strong>Rp {{ number_format($transaction->grand_total, 0, ',', '.') }}</strong></p>
                        <p>Status: 
                            <span class="uppercase font-bold text-yellow-600">
                                {{ $transaction->payment_status }}
                            </span>
                        </p>
                    </div>

                    <form action="{{ route('payment.pay') }}" method="POST">
                        @csrf
                        <input type="hidden" name="va_number" value="{{ $va->va_number }}">

                        <div class="mb-4">
                            <label for="amount" class="block text-gray-700 font-bold">
                                Simulasi Nominal Transfer
                            </label>
                            <p class="text-sm text-gray-500 mb-2">
                                Masukkan nominal sesuai tagihan untuk mensimulasikan pembayaran.
                            </p>

                            <input 
                                type="number" 
                                name="amount" 
                                id="amount"
                                class="w-full border-gray-300 rounded-md shadow-sm"
                                required
                                value="{{ old('amount') }}"
                            >

                            @error('amount')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
                            Konfirmasi Pembayaran
                        </button>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
