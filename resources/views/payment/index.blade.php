<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Payment Center
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-bold mb-4">Masukkan Nomor Virtual Account</h3>

                    <form action="{{ route('payment.check') }}" method="POST">
                        @csrf
                        <div class="mb-4">
                            <label for="va_number" class="block text-gray-700">Nomor VA</label>
                            <input type="text" name="va_number" id="va_number" 
                                value="{{ request('va') }}"
                                class="w-full border-gray-300 rounded-md shadow-sm" required>

                        </div>

                        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                            Cek Tagihan
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
