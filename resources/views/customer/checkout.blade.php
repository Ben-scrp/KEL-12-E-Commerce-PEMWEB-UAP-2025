@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold mb-8">Checkout</h1>
    
    @if($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
            <ul class="list-disc list-inside">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('checkout.store') }}" method="POST" class="lg:flex gap-8">
        @csrf
        <input type="hidden" name="product_id" value="{{ $product->id }}">
        
        <!-- Shipping Details -->
        <div class="lg:w-2/3">
            <div class="bg-white rounded-lg shadow-lg p-6 mb-6">
                <h2 class="text-xl font-bold mb-4">Shipping Address</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="col-span-full">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Full Address</label>
                        <textarea name="address" rows="3" class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200" required></textarea>
                    </div>
                    <div>
                        <label class="block text-gray-700 text-sm font-bold mb-2">City</label>
                        <input type="text" name="city" class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200" required>
                    </div>
                    <div>
                         <label class="block text-gray-700 text-sm font-bold mb-2">Postal Code</label>
                        <input type="text" name="postal_code" class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200" required>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-lg p-6 mb-6">
                <h2 class="text-xl font-bold mb-4">Shipping Method</h2>
                <div class="space-y-2">
                    <label class="flex items-center p-3 border rounded-lg cursor-pointer hover:bg-gray-50">
                        <input type="radio" name="shipping_type" value="regular" class="text-indigo-600 focus:ring-indigo-500" checked onchange="updateTotal()">
                        <div class="ml-3">
                            <span class="block font-medium">Regular Shipping</span>
                            <span class="block text-sm text-gray-500">Estimasi 3-5 hari - Rp 20.000</span>
                        </div>
                    </label>
                     <label class="flex items-center p-3 border rounded-lg cursor-pointer hover:bg-gray-50">
                        <input type="radio" name="shipping_type" value="express" class="text-indigo-600 focus:ring-indigo-500" onchange="updateTotal()">
                        <div class="ml-3">
                            <span class="block font-medium">Express Shipping</span>
                            <span class="block text-sm text-gray-500">Estimasi 1-2 hari - Rp 50.000</span>
                        </div>
                    </label>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-lg p-6">
                <h2 class="text-xl font-bold mb-4">Payment Method</h2>
                 <div class="space-y-2">
                    <label class="flex items-center p-3 border rounded-lg cursor-pointer hover:bg-gray-50">
                        <input type="radio" name="payment_method" value="transfer_va" class="text-indigo-600 focus:ring-indigo-500" checked>
                         <div class="ml-3">
                            <span class="block font-medium">Virtual Account Transfer</span>
                            <span class="block text-sm text-gray-500">Bank Transfer via VA</span>
                        </div>
                    </label>
                     <label class="flex items-center p-3 border rounded-lg cursor-pointer hover:bg-gray-50">
                         <input type="radio" name="payment_method" value="saldo" class="text-indigo-600 focus:ring-indigo-500">
                        <div class="ml-3">
                            <span class="block font-medium">Wallet Balance</span>
                            <span class="block text-sm text-gray-500">Current Balance: Rp {{ number_format(Auth::user()->balance->balance ?? 0, 0, ',', '.') }}</span>
                        </div>
                    </label>
                </div>
            </div>
        </div>

        <!-- Order Summary -->
        <div class="lg:w-1/3 mt-8 lg:mt-0">
            <div class="bg-white rounded-lg shadow-lg p-6 sticky top-8">
                <h2 class="text-xl font-bold mb-6">Order Summary</h2>
                
                <div class="flex items-center mb-4">
                     @if($product->productImages->first())
                        <img src="{{ Storage::url($product->productImages->first()->image_path) }}" class="w-16 h-16 object-cover rounded mr-4">
                    @else
                         <div class="w-16 h-16 bg-gray-200 rounded mr-4 flex items-center justify-center text-xs">No Img</div>
                    @endif
                    <div>
                        <h4 class="font-medium line-clamp-1">{{ $product->name }}</h4>
                        <div class="flex items-center text-sm text-gray-500">
                            <span>{{ $qty }} x Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                            <input type="hidden" name="qty" value="{{ $qty }}">
                        </div>
                    </div>
                </div>

                <div class="border-t pt-4 space-y-2 text-sm">
                    <div class="flex justify-between">
                        <span class="text-gray-600">Subtotal</span>
                        <span class="font-medium">Rp {{ number_format($product->price * $qty, 0, ',', '.') }}</span>
                    </div>
                     <div class="flex justify-between">
                        <span class="text-gray-600">Shipping</span>
                        <span class="font-medium" id="shippingDisplay">Rp 20.000</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Tax (11%)</span>
                        <span class="font-medium" id="taxDisplay">Rp {{ number_format(($product->price * $qty) * 0.11, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between text-lg font-bold border-t pt-2 mt-2">
                        <span>Total</span>
                        <span class="text-indigo-600" id="totalDisplay">Calculating...</span>
                    </div>
                </div>

                <button type="submit" class="w-full bg-indigo-600 text-white font-bold py-3 rounded-lg mt-6 hover:bg-indigo-700 transition-colors shadow-lg">
                    Confirm Purchase
                </button>
            </div>
        </div>
    </form>
</div>

<script>
    const productPrice = {{ $product->price }};
    const qty = {{ $qty }};
    const subtotal = productPrice * qty;
    
    function updateTotal() {
        const shippingType = document.querySelector('input[name="shipping_type"]:checked').value;
        const shippingCost = shippingType === 'express' ? 50000 : 20000;
        
        document.getElementById('shippingDisplay').innerText = 'Rp ' + new Intl.NumberFormat('id-ID').format(shippingCost);
        
        const tax = subtotal * 0.11;
        const total = subtotal + shippingCost + tax;
        
        document.getElementById('totalDisplay').innerText = 'Rp ' + new Intl.NumberFormat('id-ID').format(total);
    }
    
    // Init
    updateTotal();
</script>
@endsection
