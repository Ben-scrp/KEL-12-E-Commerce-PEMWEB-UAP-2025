<?php

namespace App\Http\Controllers;

use App\Models\VirtualAccount;
use Illuminate\Http\Request;

class VaPaymentController extends Controller
{
    public function confirmPayment($vaNumber)
    {
        $va = VirtualAccount::where('va_number', $vaNumber)->firstOrFail();

        $va->update([
            'is_paid' => true
        ]);

        // ubah status transaksi
        $va->transaction->update([
            'status' => 'paid'
        ]);

        return response()->json([
            'message' => 'Pembayaran VA berhasil diverifikasi.',
            'transaction_id' => $va->transaction_id
        ]);
    }
}
