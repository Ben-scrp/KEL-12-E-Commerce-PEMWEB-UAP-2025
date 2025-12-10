@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-md mx-auto bg-white rounded-lg shadow-lg overflow-hidden">
        <div class="bg-indigo-600 p-4 text-white text-center">
            <h1 class="text-2xl font-bold">Top Up Wallet</h1>
            <p class="opacity-90">Add balance to your account</p>
        </div>
        
        <div class="p-6">
            <div class="mb-6 text-center">
                <p class="text-gray-600 mb-2">Current Balance</p>
                <p class="text-3xl font-bold text-gray-900">
                    Rp {{ number_format(Auth::user()->balance->balance ?? 0, 0, ',', '.') }}
                </p>
            </div>

            <form action="{{ route('wallet.storeTopup') }}" method="POST">
                @csrf
                <div class="mb-6">
                    <label for="amount" class="block text-gray-700 font-bold mb-2">Amount (Rp)</label>
                    <div class="relative rounded-md shadow-sm">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <span class="text-gray-500 sm:text-sm">Rp</span>
                        </div>
                        <input type="number" name="amount" id="amount" class="focus:ring-indigo-500 focus:border-indigo-500 block w-full pl-10 pr-12 sm:text-lg border-gray-300 rounded-md" placeholder="100000" min="10000" required>
                    </div>
                     <p class="text-xs text-gray-500 mt-1">Minimum top up Rp 10.000</p>
                </div>
                
                <div class="mb-6">
                    <label class="block text-gray-700 font-bold mb-2">Payment Instruction</label>
                    <div class="bg-gray-50 p-3 rounded text-sm text-gray-600">
                        <p class="mb-2">1. Masukkan nominal top up.</p>
                        <p class="mb-2">2. Klik tombol "Top Up Now".</p>
                        <p>3. Anda akan mendapatkan Nomor VA untuk transfer.</p>
                    </div>
                </div>

                <button type="submit" class="w-full bg-indigo-600 text-white font-bold py-3 rounded-lg hover:bg-indigo-700 transition-colors shadow-md">
                    Top Up Now
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
