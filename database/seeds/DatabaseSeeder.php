<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

use App\User;
use App\Book;
use App\Product;
use App\University;

class DatabaseSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		Model::unguard();

        $this->call('UserTableSeeder');

        // create some test instances.
        $BU = University::create([  'name'  => 'BOSTON UNIVERSITY',
                                    'abbreviation'  => 'BU',
                                    'email_suffix'  => 'bu.edu'
        ]);

        $MIT = University::create([  'name'  => 'Massachusetts Institute of Technology',
                                    'abbreviation'  => 'MIT',
                                    'email_suffix'  => 'mit.edu'
        ]);

        $seller = User::create([    'username'  => 'seller',
                                    'email'     => 'seller@stuvi.com',
                                    'password'  => bcrypt('123456'),
                                    'university_id' =>  $BU->id
        ]);
        $buyer = User::create([ 'username'  => 'buyer',
                                'email'     => 'buyer@stuvi.com',
                                'password'  => bcrypt('123456'),
                                'university_id' =>  $BU->id
        ]);

        $book0 = Book::create([  'title'     => 'Advanced Algorithm 0',
                                'author'    => 'Snyder Wayne',
                                'isbn'      => '1010101010',
                                'publisher' => 'Boston University',
                                'manufacturer'  => 'Boston University',
                                'num_pages' => 1122
        ]);

        $book1 = Book::create([  'title'     => 'Advanced Algorithm 1',
                                'author'    => 'Snyder Wayne',
                                'isbn'      => '1010101011',
                                'publisher' => 'Boston University',
                                'manufacturer'  => 'Boston University',
                                'num_pages' => 1122
        ]);

        $book2 = Book::create([  'title'     => 'Advanced Algorithm 2',
                                'author'    => 'Snyder Wayne',
                                'isbn'      => '10101010102',
                                'publisher' => 'Boston University',
                                'manufacturer'  => 'Boston University',
                                'num_pages' => 1122
        ]);

        $product = Product::create(['price'     => 99.99,
                                    'book_id'   => $book0->id,
                                    'seller_id' => $seller->id
        ]);
	}

}
