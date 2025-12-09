<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\VirtualAccount;
use App\Helpers\VaGenerator;
use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    public function payWithVA(Request $request)
    {
        // 1. buat transaksi baru
        $transaction = Transaction::create([
            'user_id' => auth()->id(),
            'total_price' => $request->total_price,
            'status' => 'pending'
        ]);

        // 2. generate VA unik
        $vaNumber = VaGenerator::generate();

        // 3. simpan ke tabel virtual_accounts
        VirtualAccount::create([
            'transaction_id' => $transaction->id,
            'va_number' => $vaNumber,
            'is_paid' => false
        ]);

        return response()->json([
            'message' => 'Virtual Account berhasil dibuat.',
            'transaction_id' => $transaction->id,
            'va_number' => $vaNumber
        ]);
    }
}
