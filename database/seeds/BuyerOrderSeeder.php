<?php

use Illuminate\Database\Seeder;
use Faker\Factory;

use App\User;
use App\BuyerOrder;

class BuyerOrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('buyer_orders')->delete();

        $buyer = User::where('email', '=', 'buyer@stuvi.com')->first();

        for ($i = 1; $i < 11; $i++)
        {
            BuyerOrder::create([
                'buyer_id'  => $buyer->id,
                'cancelled' => false,
                'shipping_address_id' => $i
            ]);
        }
    }
}
