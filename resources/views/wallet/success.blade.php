@extends('layouts.app')

@section('content')
<div class="container" style="max-width: 500px; padding: 20px;">
    <h2>Pembayaran Berhasil!</h2>
    <p>{{ session('message') }}</p>

    <a href="/dashboard" class="btn btn-primary">Kembali</a>
</div>
@endsection
