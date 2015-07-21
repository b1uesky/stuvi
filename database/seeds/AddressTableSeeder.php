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

        $faker = Factory::create();


         for ($i = 1; $i < User::count(); $i++)
         {
             for ($j = 0; $j < 3; $j++)
             {
                 Address::create(array(
                     'user_id' => $i,
                     'is_default' => ($j == 0 ? true : false),
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

         }
    }
}
