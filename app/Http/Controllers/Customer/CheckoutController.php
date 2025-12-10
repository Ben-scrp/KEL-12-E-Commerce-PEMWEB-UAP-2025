<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CheckoutController extends Controller
{
    public function index(Request $request)
    {
        // For simplicity in this non-cart system, we assume 1 item from query param or session
        // However, the prompt implies a checkout form. Let's assume standard direct checkout first.
        // If query has product_id, we use that.
        
        $productId = $request->query('product_id');
        $qty = $request->query('qty', 1);

        $product = Product::with('store')->findOrFail($productId);
        
        return view('customer.checkout', compact('product', 'qty'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'address' => 'required|string',
            'city' => 'required|string',
            'postal_code' => 'required|string',
            'shipping_type' => 'required|string',
            'payment_method' => 'required|in:transfer_va,saldo',
            'product_id' => 'required|exists:products,id',
            'qty' => 'required|integer|min:1',
        ]);

        $product = Product::findOrFail($request->product_id);
        $user = Auth::user();

        // Calculate costs
        $shippingCost = $request->shipping_type == 'express' ? 50000 : 20000;
        $subtotal = $product->price * $request->qty;
        $tax = $subtotal * 0.11; // 11% Tax
        $grandTotal = $subtotal + $shippingCost + $tax;

        // Payment Check
        if ($request->payment_method == 'saldo') {
            if (!$user->balance || $user->balance->balance < $grandTotal) {
                return back()->withErrors(['payment_method' => 'Saldo tidak mencukupi']);
            }
        }

        DB::beginTransaction();
        try {
            $transaction = Transaction::create([
                'code' => 'TRX-' . Str::upper(Str::random(10)),
                'buyer_id' => $user->id,
                'store_id' => $product->store_id,
                'address' => $request->address,
                'address_id' => '0', // Dummy
                'city' => $request->city,
                'postal_code' => $request->postal_code,
                'shipping' => 'JNE', // Dummy courier
                'shipping_type' => $request->shipping_type,
                'shipping_cost' => $shippingCost,
                'tax' => $tax,
                'grand_total' => $grandTotal,
                'payment_status' => $request->payment_method == 'saldo' ? 'paid' : 'unpaid',
            ]);

            TransactionDetail::create([
                'transaction_id' => $transaction->id,
                'product_id' => $product->id,
                'qty' => $request->qty,
                'subtotal' => $subtotal,
            ]);

            if ($request->payment_method == 'saldo') {
                $user->balance->decrement('balance', $grandTotal);
            }

            // Decrease Stock
            $product->decrement('stock', $request->qty);

            DB::commit();

            return redirect()->route('customer.history')->with('success', 'Transaksi berhasil dibuat!');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Terjadi kesalahan: ' . $e->getMessage()]);
        }
    }
}
