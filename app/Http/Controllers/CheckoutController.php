<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\VirtualAccount;
use App\Helpers\VaGenerator;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CheckoutController extends Controller
{
    public function payWithVA(Request $request)
    {
        // Validasi input
        $request->validate([
            'total_price' => 'required|numeric'
        ]);

        // 1. Buat Transaksi (Unpaid)
        $transaction = Transaction::create([
            'buyer_id'        => auth()->id(),
            'store_id'        => null,   // ← WAJIB NULL karena checkout bisa dilakukan semua member
            'address'         => 'alamat belum diisi',
            'address_id'      => 0,
            'city'            => 'unknown',
            'postal_code'     => '00000',

            // INFORMASI SHIPPING
            'shipping'        => 'courier',
            'shipping_type'   => 'regular',
            'shipping_cost'   => 0,

            // NOMOR TRACKING
            'tracking_number' => '',

            // INFORMASI TRANSAKSI
            'grand_total'     => $request->total_price,
            'tax'             => 0,
            'payment_status'  => 'unpaid',

            // KODE UNIK TRANSAKSI
            'code'            => Str::upper(Str::random(10)),
        ]);

        // 2. Generate VA Number
        $vaNumber = VaGenerator::generate();

        // 3. Simpan ke tabel VirtualAccount
        VirtualAccount::create([
            'transaction_id' => $transaction->id,
            'va_number' => $vaNumber,
            'is_paid' => false
        ]);

        // 4. Redirect ke halaman Payment dengan membawa VA Number
        return redirect()->route('payment.index', ['va' => $vaNumber])
            ->with('success', 'Silakan lakukan pembayaran ke Virtual Account berikut.');
    }

}