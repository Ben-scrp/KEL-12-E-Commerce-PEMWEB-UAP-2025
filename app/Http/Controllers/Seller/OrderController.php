<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function index()
    {
        // Get transactions for the logged-in seller's store
        $storeId = Auth::user()->store->id;
        
        $orders = Transaction::where('store_id', $storeId)
            ->with(['buyer', 'details.product'])
            ->latest()
            ->paginate(10);
            
        return view('seller.orders.index', compact('orders'));
    }

    public function show(Transaction $order)
    {
        if ($order->store_id !== Auth::user()->store->id) {
            abort(403);
        }
        return view('seller.orders.show', compact('order'));
    }

    public function update(Request $request, Transaction $order)
    {
        if ($order->store_id !== Auth::user()->store->id) {
            abort(403);
        }

        $request->validate([
            'delivery_status' => 'required|in:pending,shipping,shipped,delivered,cancelled', // shipping/shipped? Let's use 'shipped'.
            'tracking_number' => 'nullable|string|max:255',
        ]);

        $order->update([
            'delivery_status' => $request->delivery_status,
            'tracking_number' => $request->tracking_number,
        ]);

        return back()->with('success', 'Status pesanan berhasil diperbarui.');
    }
}
