<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{
    public function index()
    {
        $transactions = Transaction::with(['transactionDetails.product', 'store'])
            ->where('buyer_id', Auth::id())
            ->latest()
            ->get();

        return view('customer.history', compact('transactions'));
    }
}
