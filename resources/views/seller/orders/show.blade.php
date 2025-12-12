<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Detail Pesanan') }} #{{ $order->code }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <a href="{{ route('seller.orders.index') }}" class="mb-4 inline-block text-indigo-600 hover:text-indigo-800">&larr; Kembali ke Daftar Pesanan</a>

             @if(session('success'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                
                {{-- Detail Produk --}}
                <div class="md:col-span-2 space-y-6">
                     <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 text-gray-900">
                            <h3 class="text-lg font-semibold mb-4">Item Pesanan</h3>
                            <div class="divide-y divide-gray-200">
                                @foreach($order->details as $detail)
                                    <div class="py-4 flex items-center">
                                        <div class="h-16 w-16 flex-shrink-0 overflow-hidden rounded-md border border-gray-200">
                                            @php
                                                $img = $detail->product->productImages->where('is_thumbnail', true)->first() ?? $detail->product->productImages->first();
                                            @endphp
                                            @if($img)
                                                <img src="{{ Storage::url($img->image) }}" alt="{{ $detail->product->name }}" class="h-full w-full object-cover object-center">
                                            @else
                                                <div class="h-full w-full bg-gray-100 flex items-center justify-center text-gray-400 text-xs">No Img</div>
                                            @endif
                                        </div>
                                        <div class="ml-4 flex-1">
                                            <h4 class="text-sm font-medium text-gray-900">{{ $detail->product->name }}</h4>
                                            <p class="text-sm text-gray-500">{{ $detail->quantity }} x Rp {{ number_format($detail->price, 0, ',', '.') }}</p>
                                        </div>
                                        <div class="ml-4">
                                            <p class="text-sm font-medium text-gray-900">Rp {{ number_format($detail->subtotal, 0, ',', '.') }}</p>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <div class="border-t mt-4 pt-4 flex justify-between items-center font-bold text-lg">
                                <span>Total Belanja</span>
                                <span>Rp {{ number_format($order->grand_total, 0, ',', '.') }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 text-gray-900">
                            <h3 class="text-lg font-semibold mb-4">Informasi Pengiriman</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                                <div>
                                    <p class="text-gray-500">Penerima</p>
                                    <p class="font-medium">{{ $order->buyer->name }}</p>
                                </div>
                                <div>
                                    <p class="text-gray-500">Alamat</p>
                                    <p class="font-medium">{{ $order->address }}</p>
                                    <p>{{ $order->city }}, {{ $order->postal_code }}</p>
                                </div>
                                <div>
                                    <p class="text-gray-500">Kurir / Layanan</p>
                                    <p class="font-medium uppercase">{{ $order->shipping }} - {{ $order->shipping_type }}</p>
                                </div>
                                <div>
                                    <p class="text-gray-500">Ongkos Kirim</p>
                                    <p class="font-medium">Rp {{ number_format($order->shipping_cost, 0, ',', '.') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Status & Aksi --}}
                <div class="md:col-span-1">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 text-gray-900">
                            <h3 class="text-lg font-semibold mb-4">Status Pesanan</h3>
                            
                            <form action="{{ route('seller.orders.update', $order) }}" method="POST">
                                @csrf
                                @method('PUT')

                                <div class="mb-4">
                                    <label class="block text-sm font-medium text-gray-700">Status Pembayaran</label>
                                    <div class="mt-1">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                                {{ $order->payment_status === 'paid' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                            {{ ucfirst($order->payment_status) }}
                                        </span>
                                    </div>
                                </div>

                                <div class="mb-4">
                                    <label for="delivery_status" class="block text-sm font-medium text-gray-700">Status Pengiriman</label>
                                    <select name="delivery_status" id="delivery_status" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                        <option value="pending" {{ $order->delivery_status == 'pending' ? 'selected' : '' }}>Pending</option>
                                        <option value="shipping" {{ $order->delivery_status == 'shipping' ? 'selected' : '' }}>Diproses (Packing)</option>
                                        <option value="shipped" {{ $order->delivery_status == 'shipped' ? 'selected' : '' }}>Dikirim (Shipped)</option>
                                        <option value="delivered" {{ $order->delivery_status == 'delivered' ? 'selected' : '' }}>Selesai (Delivered)</option>
                                        <option value="cancelled" {{ $order->delivery_status == 'cancelled' ? 'selected' : '' }}>Dibatalkan</option>
                                    </select>
                                </div>

                                <div class="mb-6">
                                    <label for="tracking_number" class="block text-sm font-medium text-gray-700">No. Resi (Tracking Number)</label>
                                    <input type="text" name="tracking_number" id="tracking_number" value="{{ old('tracking_number', $order->tracking_number) }}"
                                           placeholder="Input resi pengiriman"
                                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                </div>

                                <button type="submit" class="w-full px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700">
                                    Update Status
                                </button>
                            </form>

                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
