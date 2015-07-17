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

         for ($i = 0; $i < 30; $i++)
         {
             Address::create(array(
                 'user_id' => $faker->numberBetween(1, User::count()),
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

        for ($i = 0; $i < 5; $i++)
        {
            Address::create(array(
                'user_id' => 1,
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

        Address::find(1)->update([
            'is_default' => true
        ]);
    }
}
