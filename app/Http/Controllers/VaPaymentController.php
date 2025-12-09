<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\VirtualAccount;


class VaPaymentController extends Controller
{

        public function confirmPayment($vaNumber)
    {
        $va = VirtualAccount::where('va_number', $vaNumber)->first();

        if (!$va) {
            return back()->with('error', 'VA tidak ditemukan.');
        }

        // update status VA
        $va->is_paid = true;
        $va->save();

        // update transaksi
        $va->transaction->status = 'paid';
        $va->transaction->save();

        return back()->with('success', "Pembayaran VA $vaNumber berhasil dikonfirmasi!");
    }


}

