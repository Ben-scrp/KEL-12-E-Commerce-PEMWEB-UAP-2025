<?php

namespace App\Http\Controllers;

use App\Models\Transaction;

class CustomerController extends Controller
{
    public function history()
    {
        $transactions = Transaction::with('details.product')
            ->where('buyer_id', auth()->id())
            ->orderBy('created_at', 'desc')
            ->get();

        return view('customer.history', compact('transactions'));
    }
}
