<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $product->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 flex flex-col md:flex-row gap-8">
                    
                    {{-- LEFT: IMAGES --}}
                    <div class="w-full md:w-1/3">
                        @php
                            $thumbnail = $product->productImages->where('is_thumbnail', true)->first();
                            // Fallback if no thumbnail but images exist
                            if(!$thumbnail && $product->productImages->count() > 0) {
                                $thumbnail = $product->productImages->first();
                            }
                            $mainImage = $thumbnail ? asset('storage/' . $thumbnail->image) : 'https://via.placeholder.com/400';
                        @endphp
                        <div class="w-full h-80 bg-gray-200 rounded-lg overflow-hidden mb-4">
                            <img src="{{ $mainImage }}" alt="{{ $product->name }}" class="w-full h-full object-cover">
                        </div>
                        <div class="flex gap-2 overflow-x-auto">
                            @foreach($product->productImages as $img)
                                <div class="w-20 h-20 bg-gray-100 rounded overflow-hidden cursor-pointer border hover:border-blue-500">
                                    <img src="{{ asset('storage/' . $img->image) }}" class="w-full h-full object-cover">
                                </div>
                            @endforeach
                        </div>
                    </div>

                    {{-- RIGHT: INFO --}}
                    <div class="w-full md:w-2/3">
                        <h1 class="text-3xl font-bold mb-2">{{ $product->name }}</h1>
                        <p class="text-gray-500 mb-4">Kategori: {{ $product->productCategory->name ?? '-' }} | Kondisi: {{ $product->condition }} | Berat: {{ $product->weight }}g</p>
                        
                        <div class="text-4xl font-bold text-green-600 mb-6">
                            Rp {{ number_format($product->price, 0, ',', '.') }}
                        </div>

                        {{-- ACTIONS --}}
                        <div class="flex gap-4 mb-8">
                            <form action="{{ route('checkout.index') }}" method="GET">
                                <input type="hidden" name="product_id" value="{{ $product->id }}">
                                <button type="submit" class="bg-blue-600 text-white px-8 py-3 rounded-lg font-bold hover:bg-blue-700 text-lg">
                                    Beli Sekarang
                                </button>
                            </form>
                        </div>

                        {{-- DESCRIPTION --}}
                        <div class="mb-8">
                            <h3 class="font-bold text-lg mb-2">Deskripsi Produk</h3>
                            <div class="prose max-w-none text-gray-700">
                                {!! nl2br(e($product->description)) !!}
                            </div>
                        </div>

                        {{-- STORE INFO --}}
                        <div class="border-t pt-6 mb-8">
                            <div class="flex items-center gap-4">
                                <div class="w-12 h-12 bg-gray-300 rounded-full flex items-center justify-center font-bold text-xl text-gray-600">
                                    {{ substr($product->store->name ?? 'T', 0, 1) }}
                                </div>
                                <div>
                                    <p class="font-bold">{{ $product->store->name ?? 'Nama Toko' }}</p>
                                    <p class="text-sm text-gray-500">Lokasi: Unknown</p>
                                </div>
                            </div>
                        </div>
                        
                        {{-- REVIEWS --}}
                        <div class="border-t pt-6">
                            <h3 class="font-bold text-lg mb-4">Ulasan ({{ $product->productReviews->count() }})</h3>
                            @forelse($product->productReviews as $review)
                                <div class="mb-4 border-b pb-4">
                                    <p class="font-bold text-sm">{{ $review->user->name ?? 'User' }}</p>
                                    <p class="text-yellow-500 text-sm">★ {{ $review->rating }}</p>
                                    <p class="text-gray-700 italic">"{{ $review->comment }}"</p>
                                </div>
                            @empty
                                <p class="text-gray-500">Belum ada ulasan.</p>
                            @endforelse
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
