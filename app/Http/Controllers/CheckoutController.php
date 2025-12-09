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
        dd('MASUK CONTROLLER', $request->all());
      

        $transaction = Transaction::create([
            
            // 'id' => 1,
            'buyer_id' => auth()->id(),        // WAJIB
            'store_id' => 1,  // kalau wajib, isi ini
            'grand_total' => $request->total_price, // karena tabel kamu pakai grand_total
            'payment_status' => 'unpaid',
            'code' => Str::upper(Str::random(10)),
            'address' => 'alamat belum diisi',
            'address_id' => ' ',
            'city' => 'unknown',
            'postal_code' => '00000',
            'shipping' => '',
            'shipping_type' => '',
            'shipping_cost' => 0,
            'tracking_number' => '',
            'tax' => 0,
            // 'created_at' => ' ',
            // 'updated_at' => ' ',
        ]);
         $transaction = Transaction::create($data);
        dd($transaction);


        $vaNumber = VaGenerator::generate();
        

        VirtualAccount::create([
            'transaction_id' => $transaction->id,
            'va_number' => $vaNumber,
            'is_paid' => false
        ]);

        return view('va.show', [
            'va_number' => $vaNumber,
            'total' => $request->total_price
        ]);
    }

}