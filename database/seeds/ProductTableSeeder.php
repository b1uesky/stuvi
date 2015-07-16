<?php

use Illuminate\Database\Seeder;
use App\Product;
use App\ProductCondition;
use App\ProductImage;
use App\Book;
use App\User;

use Faker\Factory;

use Illuminate\Config\Repository;

class ProductTableSeeder extends Seeder {

    public function run()
    {
        DB::table('product_conditions')->delete();
        DB::table('products')->delete();

        $faker = Factory::create();
        $folder = Config::get('upload.image.product');
        $num_users = User::count();
        $books = Book::all();

        foreach ($books as $book)
        {
            // create some products
            for ($i = 0; $i < $faker->numberBetween(3, 10); $i++)
            {
                $product = Product::create([
                    'book_id'   => $book->id,
                    'seller_id' => $faker->numberBetween(1, $num_users),
                    'price'     => $faker->randomFloat(2, 10, 200),
                ]);

                ProductCondition::create([
                    'product_id'            =>  $product->id,
                    'general_condition'     =>  $faker->numberBetween(0, 3),
                    'highlights_and_notes'  =>  $faker->numberBetween(0, 2),
                    'damaged_pages'         =>  $faker->numberBetween(0, 1),
                    'description'           =>  $faker->randomElement([
                        'Brand New!',
                        'Excellent!',
                        'Good.'
                    ])
                ]);

                // create some product images
                for ($i = 0; $i < $faker->numberBetween(1, 5); $i++)
                {
                    ProductImage::create([
                        'product_id'        =>  $product->id,
                        'small_image'       =>  $faker->imageUrl(60, 60),
                        'medium_image'      =>  $faker->imageUrl(220, 340),
                        'large_image'       =>  $faker->imageUrl(768, 1000)
                    ]);
                }
            }
        }
    }

}
