<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

use App\User;
use App\Book;
use App\Product;

class DatabaseSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		Model::unguard();

		// $this->call('UserTableSeeder');

        // create some test instances.
        $seller = User::create([    'username'  => 'seller',
                                    'email'     => 'seller@stuvi.com',
                                    'password'  => bcrypt('123456')
        ]);
        $buyer = User::create([ 'username'  => 'buyer',
                                'email'     => 'buyer@stuvi.com',
                                'password'  => bcrypt('123456')
        ]);

        $book = Book::create([  'title'     => 'Advanced Algorithm',
                                'author'    => 'Snyder Wayne',
                                'isbn'      => '1010101010',
                                'publisher' => 'Boston University',
                                'manufacturer'  => 'Boston University',
                                'num_pages' => 1122
        ]);

        $product = Product::create(['price'     => 99.99,
                                    'book_id'   => $book->id,
                                    'seller_id' => $seller->id
        ]);
		$this->call('UserTableSeeder');

	}

}
