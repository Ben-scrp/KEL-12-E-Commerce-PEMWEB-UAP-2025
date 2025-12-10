<x-app-layout>

    <div class="max-w-4xl mx-auto py-10">

        {{-- Gambar --}}
        @php
            $img = $product->productImages->first();
        @endphp

        <img src="{{ $img ? asset('storage/' . $img->image) : 'https://via.placeholder.com/500' }}" 
             class="w-full rounded-lg shadow">

        {{-- Nama --}}
        <h1 class="text-3xl font-bold mt-6">{{ $product->name }}</h1>

         {{-- Nama Toko --}}
        @if($product->store)
            <p class="text-gray-600 text-md mb-4">
                Toko: <span class="font-semibold">{{ $product->store->name }}</span>
            </p>
        @endif

        {{-- Harga --}}
        <div class="text-2xl text-green-600 font-semibold mt-2">
            Rp {{ number_format($product->price, 0, ',', '.') }}
        </div>

        {{-- Deskripsi --}}
        <p class="mt-4 text-gray-600">
            {{ $product->description }}
        </p>

        {{-- Tombol beli --}}
        <a href="{{ route('checkout', ['product' => $product->slug]) }}" 
        class="w-full text-center bg-green-700 text-white py-3 rounded-lg hover:bg-green-800 block">
            Beli Sekarang
        </a>

        </a>
        {{-- REVIEWS --}}
        <h2 class="text-2xl font-bold mb-4 mt-8">Review Produk</h2>

        @if($product->productReviews->count() > 0)

            @foreach ($product->productReviews as $review)
                <div class="review-box">
                    <p class="font-semibold">{{ $review->user->name }}</p>
                    <p class="text-gray-700">{{ $review->review }}</p>
                </div>
            @endforeach

        @else
            <p class="text-gray-500">Belum ada review untuk produk ini.</p>
        @endif
    </div>

</x-app-layout>
