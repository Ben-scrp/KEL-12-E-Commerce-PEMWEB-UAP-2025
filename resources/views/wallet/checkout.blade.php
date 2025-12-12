<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Checkout
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-3xl mx-auto bg-white p-6 rounded shadow">

            {{-- DETAIL PRODUK --}}
            <h3 class="text-xl font-bold mb-4">Ringkasan Pembelian</h3>

            <p><strong>Produk:</strong> {{ $product->name }}</p>
            <p><strong>Harga Produk:</strong> Rp {{ number_format($product->price, 0, ',', '.') }}</p>
            <p><strong>Shipping:</strong> {{ $shipping_type }} (Rp {{ number_format($shipping_cost, 0, ',', '.') }})</p>
            <p><strong>Pajak:</strong> Rp {{ number_format($tax, 0, ',', '.') }}</p>

            <hr class="my-3">

            <p class="text-lg font-bold">
                Total Price: 
                <span class="text-green-700">
                    Rp {{ number_format($grand_total, 0, ',', '.') }}
                </span>
            </p>

            <hr class="my-4">


            {{-- FORM PEMBAYARAN DENGAN VA --}}
            <form action="{{ route('checkout.va') }}" method="POST" class="mb-4">
                @csrf

                <input type="hidden" name="transaction_id" value="{{ $transaction->id }}">
                <input type="hidden" name="total_price" value="{{ $grand_total }}">

                <button class="w-full bg-blue-600 text-white py-2 rounded hover:bg-blue-700">
                    Bayar dengan Virtual Account
                </button>
            </form>


            {{-- FORM PEMBAYARAN DENGAN WALLET --}}
            <form action="{{ route('wallet.pay') }}" method="POST">
                @csrf

                <input type="hidden" name="transaction_id" value="{{ $transaction->id }}">
                <input type="hidden" name="amount" value="{{ $grand_total }}">

                <button class="w-full bg-green-600 text-white py-2 rounded hover:bg-green-700">
                    Bayar dengan Wallet
                </button>
            </form>

        </div>
    </div>
</x-app-layout>
