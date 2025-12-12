<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\UserBalance;
use App\Models\Transaction;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class WalletPaymentTransactionTest extends TestCase
{
    use RefreshDatabase;

    public function test_wallet_payment_updates_transaction_status()
    {
        // 1. Setup User & Balance
        $user = User::factory()->create();
        
        $initialBalance = 500000;
        UserBalance::create([
            'user_id' => $user->id,
            'balance' => $initialBalance,
        ]);

        // 2. Setup Transaction
        $transaction = Transaction::create([
            'buyer_id'       => $user->id,
            'store_id'       => null,
            'address_id'     => 1,
            'address'        => 'Test Address',
            'city'           => 'Test City',
            'postal_code'    => '12345',
            'shipping'       => 'courier',
            'shipping_type'  => 'regular',
            'shipping_cost'  => 10000,
            'grand_total'    => 100000,
            'tax'            => 0,
            'payment_status' => 'unpaid',
            'code'           => 'TRANS001',
        ]);

        // 3. Act as User and Pay
        $response = $this->actingAs($user)
            ->post(route('wallet.pay'), [
                'total' => 100000,
                'transaction_id' => $transaction->id,
            ]);

        // 4. Assert Redirect and Success
        $response->assertRedirect();
        $response->assertSessionHas('success');

        // 5. Assert Database Changes
        $this->assertDatabaseHas('transactions', [
            'id' => $transaction->id,
            'payment_status' => 'paid',
        ]);

        $this->assertDatabaseHas('user_balances', [
            'user_id' => $user->id,
            'balance' => $initialBalance - 100000,
        ]);
    }


}
