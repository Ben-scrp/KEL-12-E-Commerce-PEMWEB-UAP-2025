<!DOCTYPE html>
<html>
<head>
    <title>Topup Wallet</title>
</head>
<body>
    <h1>Topup Saldo</h1>

    <form action="/wallet/topup" method="POST">
        @csrf
        <label>Jumlah Topup:</label>
        <input type="number" name="amount" required>
        <button type="submit">Topup</button>
    </form>

    <hr>
    <h3>Test Bayar Dengan Wallet</h3>

    <form action="/wallet/pay" method="POST">
        @csrf
        <input type="number" name="total" placeholder="Total pembayaran" required>
        <button type="submit">Bayar Dengan Wallet</button>
    </form>


</body>
</html>
