<?php

use Illuminate\Database\Seeder;

use App\SellerOrder;
use Carbon\Carbon;

class SellerOrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('seller_orders')->delete();

        for ($i = 1; $i < 5; $i++)
        {
            SellerOrder::create([
                'product_id'    => $i,
                'buyer_order_id'=> $i
            ]);
        }

        for ($i = 1; $i < 10; $i++)
        {
            SellerOrder::create([
                'product_id'    => $i,
                'cancelled'     => false,
                'scheduled_pickup_time' => Carbon::now(),
                'pickup_code'   => 1234,
                'buyer_order_id'=> $i,
                'address_id'    => $i
            ]);

            SellerOrder::create([
                'product_id'    => $i,
                'cancelled'     => false,
                'scheduled_pickup_time' => Carbon::now(),
                'pickup_code'   => 1234,
                'buyer_order_id'=> $i,
                'address_id'    => $i
            ]);
        }
    }
}
