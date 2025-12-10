@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="bg-white rounded-lg shadow-lg overflow-hidden">
        <div class="md:flex">
            <!-- Image Gallery -->
            <div class="md:w-1/2 p-4">
                <div class="mb-4">
                     @if($product->productImages->first())
                        <img id="mainImage" src="{{ Storage::url($product->productImages->first()->image_path) }}" alt="{{ $product->name }}" class="w-full h-96 object-cover rounded-lg">
                    @else
                        <div class="w-full h-96 bg-gray-200 flex items-center justify-center rounded-lg text-gray-500">No Image</div>
                    @endif
                </div>
                <div class="flex gap-2 overflow-x-auto">
                    @foreach($product->productImages as $image)
                        <img src="{{ Storage::url($image->image_path) }}" alt="Product Image" class="w-20 h-20 object-cover rounded cursor-pointer border hover:border-indigo-500" onclick="document.getElementById('mainImage').src='{{ Storage::url($image->image_path) }}'">
                    @endforeach
                </div>
            </div>

            <!-- Product Info -->
            <div class="md:w-1/2 p-8">
                <h1 class="text-3xl font-bold text-gray-900 mb-2">{{ $product->name }}</h1>
                <p class="text-sm text-gray-500 mb-4">Category: {{ $product->productCategory->name ?? 'Uncategorized' }}</p>
                
                <div class="text-2xl font-bold text-indigo-600 mb-6">Rp {{ number_format($product->price, 0, ',', '.') }}</div>

                <div class="mb-6">
                    <h3 class="text-lg font-semibold mb-2">Description</h3>
                    <p class="text-gray-700 leading-relaxed">{{ $product->description }}</p>
                </div>

                <div class="mb-6">
                    <h3 class="text-lg font-semibold mb-2">Store Info</h3>
                    <div class="flex items-center">
                        <div class="w-10 h-10 bg-indigo-100 rounded-full flex items-center justify-center text-indigo-600 font-bold mr-3">
                            {{ substr($product->store->name, 0, 1) }}
                        </div>
                        <div>
                            <p class="font-medium">{{ $product->store->name }}</p>
                            <p class="text-sm text-green-500">Verified Store</p>
                        </div>
                    </div>
                </div>

                <!-- Action Button -->
                <div class="border-t pt-6">
                    <form action="{{ route('checkout.index') }}" method="GET">
                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                        <div class="flex items-center gap-4 mb-4">
                            <label for="qty" class="font-medium text-gray-700">Quantity:</label>
                            <input type="number" name="qty" id="qty" value="1" min="1" max="{{ $product->stock }}" class="w-20 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200">
                            <span class="text-sm text-gray-500">Stock: {{ $product->stock }}</span>
                        </div>
                        <button type="submit" class="w-full bg-indigo-600 text-white font-bold py-3 px-4 rounded-lg hover:bg-indigo-700 transition-colors shadow-lg">
                            Buy Now
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Reviews Section -->
    <div class="mt-8 bg-white rounded-lg shadow-lg p-6">
        <h2 class="text-2xl font-bold mb-6">Customer Reviews ({{ $product->productReviews->count() }})</h2>
        @forelse($product->productReviews as $review)
            <div class="border-b last:border-0 py-4">
                <div class="flex items-center mb-2">
                    <div class="font-medium mr-2">{{ $review->user->name }}</div>
                    <div class="text-yellow-400">
                        @for($i = 0; $i < $review->rating; $i++) ★ @endfor
                        @for($i = $review->rating; $i < 5; $i++) <span class="text-gray-300">★</span> @endfor
                    </div>
                    <span class="text-gray-400 text-sm ml-auto">{{ $review->created_at->diffForHumans() }}</span>
                </div>
                <p class="text-gray-700">{{ $review->comment }}</p>
            </div>
        @empty
            <p class="text-gray-500 italic">No reviews yet.</p>
        @endforelse
    </div>
</div>
@endsection
