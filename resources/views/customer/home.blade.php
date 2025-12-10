@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <!-- Hero / Banner -->
    <div class="bg-indigo-600 rounded-lg shadow-lg p-8 mb-8 text-white">
        <h1 class="text-4xl font-bold mb-4">Welcome to Our Store</h1>
        <p class="text-xl">Discover the best products at amazing prices.</p>
    </div>

    <!-- Filter Categories -->
    <div class="mb-8 flex flex-wrap gap-2">
        <a href="{{ route('index') }}" class="px-4 py-2 rounded-full border {{ !request('category') || request('category') == 'all' ? 'bg-indigo-600 text-white border-indigo-600' : 'bg-white text-gray-700 border-gray-300 hover:border-indigo-500' }}">All</a>
        @foreach($categories as $category)
            <a href="{{ route('index', ['category' => $category->slug]) }}" class="px-4 py-2 rounded-full border {{ request('category') == $category->slug ? 'bg-indigo-600 text-white border-indigo-600' : 'bg-white text-gray-700 border-gray-300 hover:border-indigo-500' }}">
                {{ $category->name }}
            </a>
        @endforeach
    </div>

    <!-- Product Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
        @forelse($products as $product)
            <div class="bg-white rounded-lg shadow-md hover:shadow-xl transition-shadow duration-300 overflow-hidden group">
                <div class="aspect-w-1 aspect-h-1 w-full overflow-hidden bg-gray-200 xl:aspect-w-7 xl:aspect-h-8">
                     @if($product->productImages->first())
                        <img src="{{ Storage::url($product->productImages->first()->image_path) }}" alt="{{ $product->name }}" class="h-48 w-full object-cover group-hover:opacity-75">
                    @else
                        <div class="h-48 w-full bg-gray-300 flex items-center justify-center text-gray-500">No Image</div>
                    @endif
                </div>
                <div class="p-4">
                    <h3 class="text-lg font-semibold text-gray-900 mb-1 truncate">{{ $product->name }}</h3>
                    <p class="text-sm text-gray-500 mb-2">{{ $product->productCategory->name ?? 'Category' }}</p>
                    <div class="flex items-center justify-between">
                        <span class="text-indigo-600 font-bold">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                        <a href="{{ route('product.show', $product->slug) }}" class="inline-block bg-indigo-600 text-white px-3 py-1 rounded text-sm hover:bg-indigo-700 transition-colors">
                            Detail
                        </a>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-full text-center py-12">
                <p class="text-gray-500 text-lg">No products found.</p>
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    <div class="mt-8">
        {{ $products->links() }}
    </div>
</div>
@endsection
