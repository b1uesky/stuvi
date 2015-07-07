<?php

use Illuminate\Database\Seeder;
use Faker\Factory;

use App\Address;
use App\User;

class AddressTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('addresses')->delete();

        $buyer = User::where('email', '=', 'buyer@stuvi.com')->first();

        $faker = Factory::create();

         for ($i = 0; $i < 10; $i++)
         {
             Address::create(array(
                 'user_id' => $buyer->id,
                 'is_default' => false,
                 'addressee' => $faker->name,
                 'address_line1' => $faker->streetAddress,
                 'address_line2' => $faker->secondaryAddress,
                 'city' => $faker->city,
                 'state_a2' => $faker->stateAbbr,
                 'state_name' => $faker->state,
                 'zip' => $faker->postcode,
                 'country_a2' => 'US',
                 'country_name' => 'United States of America',
                 'phone_number' => $faker->phoneNumber
             ));
         }
        Address::find(1) -> is_default = true;
    }
}
