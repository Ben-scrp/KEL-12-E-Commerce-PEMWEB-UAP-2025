<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl">Riwayat Transaksi</h2>
    </x-slot>

    <div class="p-6">

        @forelse($transactions as $trx)
            <div class="border p-4 rounded mb-4 bg-white">
                <p><b>Kode Transaksi:</b> {{ $trx->code }}</p>
                <p><b>Total:</b> Rp {{ number_format($trx->grand_total) }}</p>
                <p><b>Status:</b> {{ strtoupper($trx->payment_status) }}</p>

                <h4 class="font-semibold mt-3">Produk Dibeli:</h4>
                <ul class="list-disc ml-6">
                    @foreach($trx->details as $detail)
                        <li>{{ $detail->product->name }} (Qty: {{ $detail->qty }})</li>
                    @endforeach
                </ul>
            </div>

        @empty
            <p>Belum ada transaksi.</p>
        @endforelse

    </div>

</x-app-layout>
