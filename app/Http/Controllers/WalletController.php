<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\UserBalance;
use App\Models\VirtualAccount;  // <-- WAJIB ditambahkan
use App\Helpers\VaGenerator;    // <-- biar lebih rapih

class WalletController extends Controller
{
    // HALAMAN UTAMA WALLET
    public function index(Request $request)
    {
        $balance = UserBalance::where('user_id', auth()->id())->first();

        return view('wallet.index', [
            'balance'        => $balance,
            'transaction_id' => $request->transaction_id,  // data dari checkout
            'total'          => $request->total            // total tagihan
        ]);
    }


    /**
     * TAMPILKAN FORM TOPUP WALLET
     */
    public function showTopupForm()
    {
        return view('wallet.topup'); 
    }

    /**
     * PROSES TOPUP SALDO
     */
    public function topup(Request $request)
{
    $request->validate([
        'amount' => 'required|numeric|min:1000'
    ]);

    // Generate VA unik topup
    $va = \App\Helpers\VaGenerator::generate();

     // SIMPAN NOMINAL TOPUP KE SESSION (WAJIB)
    session(['topup_amount' => $request->amount]);

    // Simpan VA ke database dengan tipe topup
    VirtualAccount::create([
        'transaction_id' => auth()->id(), 
        'va_number'      => $va,
        'is_paid'        => false,
        'amount'         => $request->amount,   // WAJIB
        'type'           => 'topup',            // Tambahkan kolom type
    ]);

    return redirect()->route('wallet.topup.va', ['va' => $va]);
}

    /**
     * PEMBAYARAN PAKAI WALLET
     */
    public function payWithWallet(Request $request)
{
    $request->validate([
        'transaction_id' => 'required|numeric',
        'amount' => 'required|numeric|min:1'
    ]);

    // Ambil transaksi yg mau dibayar
    $transaction = \App\Models\Transaction::findOrFail($request->transaction_id);

    // 1. Cek nominal harus sama
    if ($request->amount != $transaction->grand_total) {
        return back()->withErrors("Nominal pembayaran tidak sesuai total tagihan.");
    }

    // 2. Ambil saldo user
    $wallet = UserBalance::firstOrCreate(
        ['user_id' => auth()->id()],
        ['balance' => 0]
    );

    if ($wallet->balance < $transaction->grand_total) {
        return back()->withErrors("Saldo tidak mencukupi.");
    }

    // 3. Kurangi saldo
    $wallet->decrement('balance', $transaction->grand_total);

    // 4. Update transaksi jadi paid
    $transaction->update([
        'payment_status' => 'paid'
    ]);

    // 5. Masukkan uang ke seller (jika ada store id)
    if ($transaction->store_id) {
        $storeBalance = \App\Models\StoreBalance::firstOrCreate(
            ['store_id' => $transaction->store_id],
            ['balance' => 0]
        );

        $storeBalance->increment('balance', $transaction->grand_total);
    }

    return redirect()->route('wallet.index')
        ->with('success', 'Pembayaran berhasil dengan wallet!');
}


    public function showTopupVA(Request $request)
    {
        $va_number = $request->va;

        $topup_amount = session('topup_amount', 0); // default 0 kalau tidak ada

        return view('wallet.topup_va', compact('va_number', 'topup_amount'));
    }

    public function payTopup(Request $request)
{
    $va = VirtualAccount::where('va_number', $request->va_number)
                        ->whereNull('transaction_id') // topup
                        ->first();

    if (!$va) {
        return back()->withErrors("VA tidak ditemukan.");
    }

    // ambil nominal topup dari session
    $amount = session('topup_amount');

    if (!$amount) {
        return back()->withErrors("Nominal topup tidak ditemukan.");
    }

    // tandai VA sudah dibayar
    $va->is_paid = true;
    $va->save();

    // proses saldo
    $wallet = UserBalance::firstOrCreate(
        ['user_id' => auth()->id()],
        ['balance' => 0]
    );

    $wallet->balance += $amount;
    $wallet->save();

    // hapus session setelah sukses
    session()->forget('topup_amount');

    return redirect()->route('wallet.index')
                     ->with('success', 'Topup berhasil! Saldo bertambah.');
}


}
