<x-app-layout>
    <h2>Kode VA untuk Pembayaran</h2>

    <h1>{{ $va }}</h1>

    <p>Total yang harus dibayar: Rp {{ number_format($total) }}</p>

    <form action="/va/confirm/{{ $va }}" method="POST">
        @csrf
        <button style="padding:10px;background:#4CAF50;color:white;border:none;">
            Saya Sudah Transfer
        </button>
    </form>

    @if(session('success'))
        <p style="color: green">{{ session('success') }}</p>
    @endif
</x-app-layout>
