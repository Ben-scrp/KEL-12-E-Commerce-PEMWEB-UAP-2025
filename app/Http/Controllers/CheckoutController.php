<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\VirtualAccount;
use App\Helpers\VaGenerator;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Product;

class CheckoutController extends Controller
{
        public function index(Request $request)
    {
        // ambil product_id dari URL
        $productId = $request->product_id;

        // Ambil data produk
        $product = Product::with(['store', 'productImages'])
                    ->where('id', $productId)
                    ->firstOrFail();

        return view('checkout.index', compact('product'));
    }


        public function process(Request $request)
    {
        // Validasi input
        $request->validate([
            'address' => 'required',
            'city' => 'required',
            'postal_code' => 'required',
            'shipping_type' => 'required',
            'payment_method' => 'required',
            'product_id' => 'required',
            'price' => 'required|numeric'
        ]);
        $product = Product::findOrFail($request->product_id);

        // 1. Buat transaksi
        $transaction = Transaction::create([
            'buyer_id'       => auth()->id(),
            'store_id'       =>  $product->store_id,
            'address_id'     => 0, // FIX WAJIB ADA
            'address'        => $request->address,
            'city'           => $request->city,
            'postal_code'    => $request->postal_code,
            'shipping'       => 'courier',
            'shipping_type'  => $request->shipping_type,
            'shipping_cost'  => 10000,
            'grand_total'    => $request->total_price,
            'tax'            => 40000,
            'payment_status' => 'unpaid',
            'code'           => Str::upper(Str::random(10)),
        ]);

         $subtotal = $request->price * 1;

        // 2. Simpan transaction_details
        \App\Models\TransactionDetail::create([
            'transaction_id' => $transaction->id,
            'product_id' => $request->product_id,
            'qty' => 1,
            'price' => $request->price,
            'subtotal' => $subtotal,
            ]);

        // 3. Jika pilih VA → generate VA
        if ($request->payment_method == 'va') {

            $va = \App\Helpers\VaGenerator::generate();

            \App\Models\VirtualAccount::create([
                'transaction_id' => $transaction->id,
                'va_number' => $va,
                'is_paid' => false,
            ]);

            return redirect()->route('payment.index', ['va' => $va]);
        }

        return redirect()->route('wallet.index')
            ->with('success', 'Pembayaran menggunakan saldo');
    }



        
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