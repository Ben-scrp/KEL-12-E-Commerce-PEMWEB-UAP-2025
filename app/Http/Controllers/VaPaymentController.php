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
        // 1. Ambil VA dari 3 kemungkinan input
        $vaInput = $request->va_number 
                    ?? $request->query('va');

        // Jika GET tanpa parameter → balik ke halaman input
        if ($request->isMethod('get') && !$vaInput) {
            return redirect()->route('payment.index');
        }

        // Jika POST, lakukan validasi
        if ($request->isMethod('post')) {
            $request->validate([
                'va_number' => 'required|numeric'
            ]);
        }

        // 2. Ambil VA dari database
        $va = VirtualAccount::where('va_number', $vaInput)
                ->where('is_paid', false)
                ->first();

        if (!$va) {
            return back()->with('error', 'Nomor VA tidak ditemukan atau sudah dibayar.');
        }

        // 3. Kirim ke view confirm
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

        // 1. Validasi nominal
        if ($request->amount != $transaction->grand_total) {
            return redirect()
                ->to('/payment/check?va=' . $request->va_number)
                ->with('error', 'Nominal yang Anda masukkan tidak sesuai total tagihan.')
                ->withInput();
        }

        // 2. Update status VA & transaksi
        $va->update(['is_paid' => true]);
        $transaction->update(['payment_status' => 'paid']);

        // 3. Tambah saldo toko
        if ($transaction->store_id) {
            $storeBalance = \App\Models\StoreBalance::firstOrCreate(
                ['store_id' => $transaction->store_id],
                ['balance' => 0]
            );
            $storeBalance->increment('balance', $transaction->grand_total);
        }

        return redirect()->route('payment.success')
                        ->with('success', 'Pembayaran berhasil!');
    }


}

