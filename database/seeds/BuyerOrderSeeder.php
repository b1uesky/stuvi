<?php

use Illuminate\Database\Seeder;

use App\User;
use App\BuyerOrder;
use Faker\Factory;

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

        $faker = Factory::create();

        for ($i = 1; $i < 30; $i++)
        {
            BuyerOrder::create([
                'buyer_id'  => $faker->numberBetween(1, User::count()),
                'cancelled' => false,
                'shipping_address_id' => $i
            ]);
        }
    }
}
