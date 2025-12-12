<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Ajukan Penarikan Dana') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="max-w-md mx-auto">
                
                @if(session('error'))
                    <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                        <span class="block sm:inline">{{ session('error') }}</span>
                    </div>
                @endif

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <div class="mb-6 text-center">
                            <h3 class="text-lg font-medium text-gray-500">Saldo Tersedia</h3>
                            <p class="text-3xl font-bold text-indigo-600">Rp {{ number_format($balance->balance, 0, ',', '.') }}</p>
                        </div>
                        
                        <form action="{{ route('seller.withdrawals.store') }}" method="POST">
                            @csrf

                            <div class="mb-4">
                                <label for="amount" class="block text-sm font-medium text-gray-700">Nominal Penarikan</label>
                                <input type="number" name="amount" id="amount" value="{{ old('amount') }}" required min="10000" max="{{ $balance->balance }}"
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                       placeholder="Min. 10.000">
                                @error('amount')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label for="bank_name" class="block text-sm font-medium text-gray-700">Nama Bank / E-Wallet</label>
                                <input type="text" name="bank_name" id="bank_name" value="{{ old('bank_name') }}" required
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                       placeholder="Contoh: BCA, Mandiri, GoPay">
                                @error('bank_name')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label for="bank_account_number" class="block text-sm font-medium text-gray-700">Nomor Rekening</label>
                                <input type="text" name="bank_account_number" id="bank_account_number" value="{{ old('bank_account_number') }}" required
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                @error('bank_account_number')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label for="bank_account_name" class="block text-sm font-medium text-gray-700">Nama Pemilik Rekening</label>
                                <input type="text" name="bank_account_name" id="bank_account_name" value="{{ old('bank_account_name') }}" required
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                @error('bank_account_name')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="flex justify-end gap-2 mt-6">
                                <a href="{{ route('seller.balance.index') }}" class="px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-600">
                                    Batal
                                </a>
                                <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700">
                                    Ajukan Penarikan
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
