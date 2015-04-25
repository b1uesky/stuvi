<?php

use Illuminate\Database\Seeder;
use App\Book;
use Faker\Factory;

class UserTableSeeder extends Seeder {

    public function run()
    {
        DB::table('books')->delete();

        $faker = Factory::create();

        for ($i = 0; $i < 10; $i++)
        {
            $book = Book::create(array(
                'username' => $faker->userName,
            ));
        }
    }

}