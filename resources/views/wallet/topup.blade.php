<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-bold">Topup Saldo</h2>
    </x-slot>

    <div class="p-6">
        <form action="{{ route('wallet.topup') }}" method="POST">
            @csrf

            <label class="block mb-2">Nominal Topup</label>
            <input type="number" name="amount" class="border p-2 rounded w-full" required>

            <button class="mt-4 bg-green-600 text-white px-4 py-2 rounded">
                Generate VA Untuk Topup
            </button>
        </form>
    </div>

</x-app-layout>
