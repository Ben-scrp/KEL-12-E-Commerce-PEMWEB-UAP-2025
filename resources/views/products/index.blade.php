<x-app-layout>

<style>
    body {
        background: #f5f7fa;
    }
    .product-card {
        background: white;
        border-radius: 12px;
        padding: 16px;
        transition: 0.2s ease-in-out;
        border: 1px solid #e6e6e6;
        cursor: pointer;
    }
    .product-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 6px 18px rgba(0,0,0,0.08);
    }

    .product-image {
        width: 100%;
        height: 180px;
        object-fit: cover;
        border-radius: 10px;
        background: #eee;
    }

    .price {
        font-size: 18px;
        font-weight: bold;
        color: #1f8f4c;
    }

    .category-badge {
        font-size: 12px;
        padding: 4px 8px;
        background: #e8f5e9;
        color: #1b5e20;
        border-radius: 6px;
        display: inline-block;
        margin-bottom: 6px;
    }

    .store-name {
        font-size: 14px;
        color: #777;
    }
</style>

<div class="container mx-auto px-8 py-10">

    <h1 class="text-3xl font-bold mb-6">Semua Produk</h1>
    
    <!-- ========== SEARCH BAR ========== -->
    <div class="mb-6">
        <form action="{{ route('products.index') }}" method="GET">
            <div class="flex items-center bg-white shadow rounded-full px-4 py-3 border border-gray-200">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                    stroke-width="1.5" stroke="currentColor" class="w-6 h-6 text-gray-500">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M21 21l-4.35-4.35m0 0A7.5 7.5 0 105.4 5.4a7.5 7.5 0 0011.31 11.31z" />
                </svg>

                <input type="text" 
                    name="search"
                    placeholder="Cari produk terbaik..."
                    class="w-full ml-3 focus:outline-none text-gray-600"
                    value="{{ request('search') }}">
            </div>
        </form>
    </div>
    <!-- ========== END SEARCH ========== -->

    {{-- ========== JIKA KOSONG ========== --}}
    @if($products->isEmpty())
        <div class="text-center py-10">
            <img src="https://cdn-icons-png.flaticon.com/512/7486/7486742.png" 
                 class="mx-auto mb-4" width="120">
            <h2 class="text-2xl font-semibold text-gray-600">Produk tidak ditemukan</h2>
            <p class="text-gray-500 mt-1">Coba kata kunci lain ya!</p>
        </div>
    @else

    {{-- ========== LIST PRODUK ========== --}}
    <div class="grid grid-cols-4 gap-6">

        @foreach($products as $product)
        <div class="product-card">

            {{-- Kategori --}}
            @if($product->productCategory)
                <div class="category-badge">
                    {{ $product->productCategory->name }}
                </div>
            @endif

            {{-- Gambar produk --}}
            @php
                $img = $product->productImages->first();
            @endphp

            @if($img)
                <img src="{{ asset('storage/' . $img->image) }}" class="product-image">
            @else
                <img src="https://via.placeholder.com/300" class="product-image">
            @endif

            {{-- Nama Produk --}}
            <h2 class="text-lg font-semibold mt-3">{{ $product->name }}</h2>

            {{-- Harga --}}
            <div class="price mt-1">Rp {{ number_format($product->price, 0, ',', '.') }}</div>

            {{-- Nama Toko --}}
            @if($product->store)
                <div class="store-name">Toko: {{ $product->store->name }}</div>
            @endif

            {{-- Tombol Lihat Produk --}}
            <a href="{{ route('product.show', $product->slug) }}" 
            class="mt-3 inline-block w-full text-center py-2 rounded bg-green-600 text-white hover:bg-green-700">
                Lihat Produk
            </a>

        </div>
        @endforeach

    </div>

    @endif
    {{-- ========== END EMPTY CHECK ========== --}}

</div>

</x-app-layout>

