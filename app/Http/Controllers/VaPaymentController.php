<?php

namespace App\Http\Controllers;

use App\Models\VirtualAccount;
use Illuminate\Http\Request;

class VaPaymentController extends Controller
{
    public function createVA(Request $request)
    {
        $va = "VA" . rand(10000000, 99999999);

        return response()->json([
            "transaction_id" => 1, // misal dummy dulu
            "va_number" => $va
        ]);
    }

    public function confirmPayment($vaNumber)
    {
        return "Pembayaran VA $vaNumber dikonfirmasi!";
    }
}
