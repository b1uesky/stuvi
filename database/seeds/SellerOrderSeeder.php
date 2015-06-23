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

        for ($i = 1; $i < 10; $i++)
        {
            SellerOrder::create([
                'product_id'    => $i,
                'cancelled'     => false,
                'buyer_order_id'=> $i
            ]);
        }
    }
}
