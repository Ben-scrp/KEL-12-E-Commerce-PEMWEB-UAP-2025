Total price: 50.000
<form action="/checkout/va" method="POST">
    @csrf
    <input type="hidden" name="total_price" value="50000">
    <button type="submit">Bayar dengan VA</button>
</form>

<form action="/wallet/pay" method="POST">
    @csrf
    <input type="hidden" name="total_price" value="50000">
    <button type="submit">Bayar dengan Wallet</button>
</form>
