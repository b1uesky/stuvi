<?php

use Illuminate\Database\Seeder;

use App\BuyerPayment;

class BuyerPaymentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('buyer_payments')->delete();

        for ($i = 1; $i < 11; $i++)
        {
            BuyerPayment::create([
                'buyer_order_id'    => $i,
                'amount'            => 2999,
                'object'            => $i,
                'charge_id'         => $i,
                'card_id'           => $i,
                'card_last4'        => '1234',
                'card_brand'        => 'visa',
                'card_fingerprint'  => 'fp'
            ]);
        }
    }
}
