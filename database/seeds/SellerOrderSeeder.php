<?php

use Illuminate\Database\Seeder;

use App\SellerOrder;

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
        $date = date('M d, Y  H:i A');

        for ($i = 1; $i < 10; $i++)
        {
            SellerOrder::create([
                'product_id'    => $i,
                'cancelled'     => false,
                'scheduled_pickup_time' => $date,
                'pickup_code'   => 1234,
                'buyer_order_id'=> $i,
                'address_id'    => $i
            ]);

            SellerOrder::create([
                'product_id'    => $i,
                'cancelled'     => false,
                'scheduled_pickup_time' => $date,
                'pickup_code'   => 1234,
                'buyer_order_id'=> $i,
                'address_id'    => $i
            ]);
        }
    }
}
