@extends('layouts.app')

@section('content')
<div class="container" style="max-width: 500px">

    <h2>Checkout Produk</h2>

    {{-- Sukses --}}
    @if(session('success'))
        <div style="padding: 10px; background: #d4edda; margin-bottom: 10px;">
            {{ session('success') }}
        </div>
    @endif

    {{-- Error --}}
    @if($errors->any())
        <div style="padding: 10px; background: #f8d7da; margin-bottom: 10px;">
            {{ $errors->first() }}
        </div>
    @endif

    <p>
        Total Belanja: <strong>Rp 50.000</strong>
    </p>

    <form action="{{ route('wallet.pay') }}" method="POST">
        @csrf

        <input type="hidden" name="total" value="50000">

        <button type="submit" class="btn btn-success">
            Bayar Dengan Wallet
        </button>
    </form>

</div>
@endsection
