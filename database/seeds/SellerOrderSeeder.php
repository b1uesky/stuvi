<?php

use Illuminate\Database\Seeder;

use App\User;
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
        $courier = User::where('email', '=', 'courier@stuvi.com')->first();
        $date = date('Y-m-d H:i:s');

        for ($i = 1; $i < 10; $i++)
        {
            SellerOrder::create([
                'product_id'    => $i,
                'cancelled'     => false,
                'scheduled_pickup_time' => $date,
                'pickup_code'   => 1234,
                'courier_id'    => $courier->id,
                'buyer_order_id'=> $i,
                'address_id'    => $i
            ]);

            SellerOrder::create([
                'product_id'    => $i,
                'cancelled'     => false,
                'scheduled_pickup_time' => $date,
                'pickup_code'   => 1234,
                'courier_id'    => $courier->id,
                'buyer_order_id'=> $i,
                'address_id'    => $i
            ]);
        }
    }
}
