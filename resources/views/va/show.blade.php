<h2>Virtual Account Anda</h2>
<p>Nomor VA: {{ $va_number }}</p>
<p>Total: {{ $total }}</p>
<p>Status: Pending</p>

<form action="/va/confirm/{{ $va_number }}" method="POST">
    @csrf
    <button type="submit">Saya Sudah Transfer</button>
</form>
