<x-app-layout>

    {{-- HEADER --}}
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Checkout Produk
        </h2>
    </x-slot>

    {{-- PAGE CONTENT --}}
    <div class="py-8">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white p-6 rounded-lg shadow">

                {{-- PRODUK --}}
                <div class="flex gap-6 mb-6">

                    {{-- GAMBAR --}}
                    <img src="{{ asset('storage/' . $product->productImages->first()->image) }}"
                         class="w-48 h-48 object-cover rounded">

                    {{-- DETAIL --}}
                    <div>
                        <h1 class="text-2xl font-bold">{{ $product->name }}</h1>
                        <p class="text-gray-700">Toko: {{ $product->store->name }}</p>

                        <p class="text-green-600 text-xl mt-3">
                            Rp {{ number_format($product->price, 0, ',', '.') }}
                        </p>

                        <p class="text-gray-700 mt-2">
                            {{ $product->description }}
                        </p>
                    </div>
                </div>

                {{-- FORM CHECKOUT --}}
                <form action="{{ route('checkout.process') }}" method="POST">
                    @csrf

                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                    <input type="hidden" name="price" value="{{ $product->price }}">
                    <input type="hidden" name="total_price" value="{{ $product->price + 10000 }}"> 

                    {{-- ALAMAT --}}
                    <h3 class="text-lg font-bold mt-4">Alamat Pengiriman</h3>

                    <input name="address"
                           class="w-full p-2 border rounded mt-2"
                           placeholder="Alamat lengkap"
                           required>

                    <div class="grid grid-cols-2 gap-4 mt-2">
                        <input name="city" class="p-2 border rounded" placeholder="Kota" required>
                        <input name="postal_code" class="p-2 border rounded" placeholder="Kode Pos" required>
                    </div>

                    {{-- SHIPPING --}}
                    <h3 class="text-lg font-bold mt-6">Metode Shipping</h3>
                    <select name="shipping_type" class="p-2 border rounded w-full mt-2">
                        <option value="regular">Regular</option>
                        <option value="express">Express</option>
                    </select>

                    {{-- PAYMENT --}}
                    <h3 class="text-lg font-bold mt-6">Metode Pembayaran</h3>
                    <select name="payment_method" class="p-2 border rounded w-full mt-2">
                        <option value="va">Transfer Virtual Account</option>
                        <option value="saldo">Saldo Dompet</option>
                    </select>

                    {{-- BUTTON --}}
                    <button class="w-full bg-green-600 text-white py-3 rounded mt-8 text-lg font-semibold">
                        Lanjutkan Pembayaran
                    </button>

                </form>

            </div>
        </div>
    </div>

</x-app-layout>
