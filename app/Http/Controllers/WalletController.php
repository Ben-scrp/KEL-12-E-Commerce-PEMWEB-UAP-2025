<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserBalance;


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

        // Ambil saldo user (atau buat baru)
        $balance = UserBalance::firstOrCreate(
            ['user_id' => auth()->id()],
            ['balance' => 0]
        );

        // Tambah saldo
        $balance->balance += $request->amount;
        $balance->save();

        return back()->with('success', 'Topup berhasil! Saldo Anda saat ini: ' . $balance->balance);
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
}
