<x-app-layout>
    <div class="p-6">
        <h2 class="text-xl font-bold mb-4">Topup Wallet - Virtual Account</h2>

        <div class="bg-white p-4 rounded shadow">
            <p><strong>Nomor VA:</strong> {{ $record->va_number }}</p>
            <p><strong>Jumlah Topup: Rp {{ number_format($topup_amount) }}</p>
            <p><strong>Status:</strong> {{ $record->is_paid ? 'PAID' : 'UNPAID' }}</p>
        </div>

        <p class="mt-4 text-gray-600">
            Silakan transfer sesuai nominal untuk menyelesaikan topup saldo.
        </p>
    </div>
</x-app-layout>
