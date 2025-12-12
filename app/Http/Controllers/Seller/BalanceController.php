<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\StoreBalance;
use App\Models\StoreBalanceHistory;
use App\Models\Withdrawal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class BalanceController extends Controller
{
    public function index()
    {
        $storeId = Auth::user()->store->id;
        
        $balance = StoreBalance::firstOrCreate(
            ['store_id' => $storeId],
            ['balance' => 0]
        );

        $history = $balance->storeBalanceHistories()->latest()->paginate(10);

        return view('seller.balance.index', compact('balance', 'history'));
    }

    public function withdrawals()
    {
        $storeId = Auth::user()->store->id;
        $balance = StoreBalance::firstOrCreate(['store_id' => $storeId], ['balance' => 0]);
        
        $withdrawals = $balance->withdrawals()->latest()->paginate(10);

        return view('seller.withdrawals.index', compact('balance', 'withdrawals'));
    }

    public function createWithdrawal()
    {
        $storeId = Auth::user()->store->id;
        $balance = StoreBalance::firstOrCreate(['store_id' => $storeId], ['balance' => 0]);
        return view('seller.withdrawals.create', compact('balance'));
    }

    public function storeWithdrawal(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:10000',
            'bank_name' => 'required|string',
            'bank_account_number' => 'required|string',
            'bank_account_name' => 'required|string',
        ]);

        $storeId = Auth::user()->store->id;
        $balance = StoreBalance::firstOrCreate(['store_id' => $storeId], ['balance' => 0]);

        if ($balance->balance < $request->amount) {
            return back()->with('error', 'Saldo tidak mencukupi.');
        }

        DB::transaction(function () use ($balance, $request) {
            // Deduct balance
            $balance->decrement('balance', $request->amount);

            // Create record
            $withdrawal = Withdrawal::create([
                'store_balance_id' => $balance->id,
                'amount' => $request->amount,
                'bank_name' => $request->bank_name,
                'bank_account_number' => $request->bank_account_number,
                'bank_account_name' => $request->bank_account_name,
                'status' => 'pending',
            ]);

            // History
            StoreBalanceHistory::create([
                'store_balance_id' => $balance->id,
                'type' => 'debit',
                'amount' => $request->amount,
                'reference_type' => Withdrawal::class,
                'reference_id' => $withdrawal->id,
                'remarks' => 'Penarikan Dana',
            ]);
        });

        return redirect()->route('seller.withdrawals.index')->with('success', 'Permintaan penarikan berhasil diajukan.');
    }
}
