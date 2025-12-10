<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\WalletTopup;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class WalletController extends Controller
{
    public function topup()
    {
        return view('customer.topup');
    }

    public function storeTopup(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:10000',
        ]);

        WalletTopup::create([
            'user_id' => Auth::id(),
            'amount' => $request->amount,
            // 'payment_method' => 'bank_transfer', // Default or from input
             'payment_method' => 'Bank Transfer',
            'virtual_account_number' => 'VA-' . rand(10000000, 99999999),
            'status' => 'pending',
        ]);

        return redirect()->route('customer.history')->with('success', 'Topup request submitted. Please pay via VA.');
    }
}
