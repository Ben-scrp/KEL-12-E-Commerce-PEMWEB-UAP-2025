<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Konfirmasi Pembayaran
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow sm:rounded-lg p-6">

                <h3 class="text-lg font-bold mb-4">Detail Tagihan</h3>

                <p><strong>Nomor VA:</strong> {{ $va->va_number }}</p>
                <p><strong>Total Tagihan:</strong> Rp {{ number_format($va->transaction->grand_total) }}</p>
                <p><strong>Status:</strong> 
                    <span class="{{ $va->is_paid ? 'text-green-600' : 'text-red-600' }}">
                        {{ $va->is_paid ? 'PAID' : 'UNPAID' }}
                    </span>
                </p>

                <hr class="my-4">

                <h3 class="text-lg font-bold mb-2">Simulasi Nominal Transfer</h3>


                {{-- ALERT ERROR --}}
                @if (session('error'))
                    <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                        {{ session('error') }}
                    </div>
                @endif

                <form action="{{ route('payment.pay') }}" method="POST">
                    @csrf

                    <input type="hidden" name="va_number" value="{{ $va->va_number }}">

                    <input type="number" 
                    name="amount" 
                    placeholder="Masukkan nominal"
                    class="border p-2 w-full rounded mb-3"
                    value="{{ old('amount') }}"
                    required>


                    <button class="w-full bg-green-600 text-white py-2 rounded hover:bg-green-700">
                        Konfirmasi Pembayaran
                    </button>
                </form>

            </div>
        </div>
    </div>

</x-app-layout>
