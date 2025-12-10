<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\VirtualAccount;


class VaPaymentController extends Controller
{

    // 1. Halaman Input VA
    public function index(Request $request)
    {
        $vaParam = $request->query('va');
        return view('payment.index', ['va' => $vaParam]);
    }

    // 2. Cek VA & Tampilkan Detail
    public function check(Request $request)
    {
        $request->validate([
            'va_number' => 'required|numeric'
        ]);

        $va = VirtualAccount::where('va_number', $request->va_number)->where('is_paid', false)->first();

        if (!$va) {
            return back()->with('error', 'Nomor VA tidak ditemukan atau sudah dibayar.');
        }

        return view('payment.confirm', [
            'va' => $va,
            'transaction' => $va->transaction
        ]);
    }

    // 3. Konfirmasi Pembayaran
    public function pay(Request $request)
    {
        $request->validate([
            'va_number' => 'required',
            'amount' => 'required|numeric'
        ]);

        $va = VirtualAccount::where('va_number', $request->va_number)->firstOrFail();
        $transaction = $va->transaction;

        // Validasi Nominal
        if ($request->amount < $transaction->grand_total) {
            return back()->with('error', 'Nomor transfer kurang dari tagihan!');
        }

        // A. Update Status VA
        $va->update(['is_paid' => true]);

        // B. Update Status Transaksi
        $transaction->update(['payment_status' => 'paid']);

        // C. Tambah Saldo ke Toko (jika ada store_id)
        if ($transaction->store_id) {
            $storeBalance = \App\Models\StoreBalance::firstOrCreate(
                ['store_id' => $transaction->store_id],
                ['balance' => 0]
            );
            $storeBalance->increment('balance', $transaction->grand_total);
        }

        // Logic Topup User Balance (Jika tipe transaksi adalah topup - Custom logic)
        // Di sini saya asumsikan jika buyer_id == store_id berarti self-topup, atau logic lain.
        // Tapi sesuai instruksi, kita fokus purchase dulu. 
        // "Untuk Topup: Menambahkan saldo ke user_balances." -> Perlu membedakan trx.
        
        return redirect()->route('payment.success')->with('success', 'Pembayaran berhasil!');

    }


}

