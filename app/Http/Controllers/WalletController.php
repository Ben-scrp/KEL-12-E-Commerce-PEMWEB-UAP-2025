<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\UserBalance;
use App\Models\VirtualAccount;  // <-- WAJIB ditambahkan
use App\Helpers\VaGenerator;    // <-- biar lebih rapih

class WalletController extends Controller
{
    // HALAMAN UTAMA WALLET
    public function index()
    {
        $balance = UserBalance::where('user_id', auth()->id())->first();

        return view('wallet.index', compact('balance'));
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
            'total' => 'required|numeric|min:1'
        ]);

        $balance = UserBalance::where('user_id', auth()->id())->first();

        if (!$balance) {
            return back()->withErrors("Anda belum memiliki wallet. Silakan topup dulu.");
        }

        // cek saldo cukup
        if ($balance->balance < $request->total) {
            return back()->withErrors("Saldo tidak cukup.");
        }

        // potong saldo
        $balance->balance -= $request->total;
        $balance->save();

        

        return back()->with('success', 'Pembayaran berhasil! Sisa saldo: ' . $balance->balance);
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
