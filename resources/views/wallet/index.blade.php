<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Wallet</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f5f6fa;
            margin: 0;
            padding: 20px;
        }

        .container {
            max-width: 500px;
            margin: auto;
            background: white;
            padding: 25px;
            border-radius: 12px;
            box-shadow: 0 3px 12px rgba(0,0,0,0.1);
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        .balance-box {
            padding: 15px;
            background: #3498db;
            color: white;
            border-radius: 10px;
            text-align: center;
            margin-bottom: 25px;
            font-size: 20px;
        }

        form {
            margin-bottom: 20px;
        }

        input[type="number"] {
            width: 100%;
            padding: 12px;
            margin-bottom: 12px;
            border: 1px solid #ccc;
            border-radius: 6px;
            font-size: 16px;
        }

        button {
            width: 100%;
            padding: 12px;
            border: none;
            background: #2ecc71;
            color: white;
            font-size: 16px;
            border-radius: 6px;
            cursor: pointer;
        }

        button:hover {
            background: #27ae60;
        }

        .danger {
            background: #e74c3c !important;
        }

        .alert {
            padding: 12px;
            border-radius: 6px;
            margin-bottom: 15px;
            font-weight: bold;
            text-align: center;
        }

        .alert-success {
            background: #2ecc71;
            color: white;
        }

        .alert-error {
            background: #e74c3c;
            color: white;
        }

        .subtitle {
            font-weight: bold;
            margin-bottom: 8px;
        }

        hr {
            margin: 25px 0;
        }
    </style>
</head>
<body>

<div class="container">

    <h2>💳 My Wallet</h2>

    {{-- ALERT SUCCESS --}}
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    {{-- ALERT ERROR --}}
    @if($errors->any())
        <div class="alert alert-error">{{ $errors->first() }}</div>
    @endif

    {{-- SALDO USER --}}
    <div class="balance-box">
        Saldo Anda: <br>
        <b>Rp {{ number_format($balance->balance ?? 0, 0, ',', '.') }}</b>
    </div>

    {{-- FORM TOPUP --}}
    <div>
        <div class="subtitle">Top Up Saldo</div>

        <form action="/wallet/topup" method="POST">
            @csrf
            <input type="number" name="amount" placeholder="Masukkan nominal topup" required>
            <button type="submit">Top Up</button>
        </form>
    </div>

    <hr>

    {{-- FORM PEMBAYARAN --}}
    <div>
        <div class="subtitle">Bayar Dengan Wallet</div>

        <form action="/wallet/pay" method="POST">
            @csrf
            <input type="number" name="total" placeholder="Total pembayaran" required>
            <button class="danger" type="submit">Bayar Sekarang</button>
        </form>
    </div>

</div>

</body>
</html>
