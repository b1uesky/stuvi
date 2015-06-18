<?php

use Illuminate\Database\Seeder;
use App\Product;
use App\ProductCondition;
use App\ProductImage;
use App\Book;
use App\User;

use Illuminate\Config\Repository;

class ProductTableSeeder extends Seeder {

    public function run()
    {
        DB::table('product_conditions')->delete();
        DB::table('products')->delete();

        $book_algorithms = Book::where('title', 'LIKE', '%Algorithms%')->get()->first();
        $book_mechanics = Book::where('title', 'LIKE', '%Principles of solid mechanics%')->get()->first();
        $book_pp = Book::where('title', 'LIKE', '%Programming Problems: Advanced Algorithms (Volume 2)%')->get()->first();
        $seller = User::where('email', '=', 'seller@stuvi.com')->get()->first();
        $folder = Config::get('upload.image.product');

        // Algorithms
        $p_alg0 = Product::create([
            'price'             =>  49.99,
            'book_id'           =>  $book_algorithms->id,
            'seller_id'         =>  $seller->id
        ]);

        $p_alg1 = Product::create([
            'price'             =>  39.99,
            'book_id'           =>  $book_algorithms->id,
            'seller_id'         =>  $seller->id
        ]);

        $p_alg2 = Product::create([
            'price'             =>  29.99,
            'book_id'           =>  $book_algorithms->id,
            'seller_id'         =>  $seller->id
        ]);

        // Programming Problems
        $p_pp0 = Product::create([
            'price'             =>  49.99,
            'book_id'           =>  $book_pp->id,
            'seller_id'         =>  $seller->id
        ]);

        $p_pp1 = Product::create([
            'price'             =>  39.99,
            'book_id'           =>  $book_pp->id,
            'seller_id'         =>  $seller->id
        ]);

        $p_pp2 = Product::create([
            'price'             =>  29.99,
            'book_id'           =>  $book_pp->id,
            'seller_id'         =>  $seller->id
        ]);

        // Principles of solid mechanics
        $p_mech0 = Product::create([
            'price'             =>  129.99,
            'book_id'           =>  $book_mechanics->id,
            'seller_id'         =>  $seller->id
        ]);

        $p_mech1 = Product::create([
            'price'             =>  109.99,
            'book_id'           =>  $book_mechanics->id,
            'seller_id'         =>  $seller->id
        ]);

        $p_mech2 = Product::create([
            'price'             =>  89.99,
            'book_id'           =>  $book_mechanics->id,
            'seller_id'         =>  $seller->id
        ]);

        ProductCondition::create([
            'product_id'            =>  $p_alg0->id,
            'general_condition'     =>  0,
            'highlights_and_notes'  =>  0,
            'damaged_pages'         =>  0,
            'description'       =>  'Brand new!'
            ]);

        ProductCondition::create([
            'product_id'        =>  $p_alg1->id,
            'general_condition'     =>  1,
            'highlights_and_notes'  =>  1,
            'damaged_pages'         =>  1,
            'description'       =>  'Excellent!'
            ]);

        ProductCondition::create([
            'product_id'        =>  $p_alg2->id,
            'general_condition'     =>  2,
            'highlights_and_notes'  =>  2,
            'damaged_pages'         =>  2,
            'description'       =>  'Good.'
            ]);

        ProductCondition::create([
            'product_id'            =>  $p_pp0->id,
            'general_condition'     =>  0,
            'highlights_and_notes'  =>  0,
            'damaged_pages'         =>  0,
            'description'       =>  'Brand new!'
        ]);

        ProductCondition::create([
            'product_id'        =>  $p_pp1->id,
            'general_condition'     =>  1,
            'highlights_and_notes'  =>  1,
            'damaged_pages'         =>  1,
            'description'       =>  'Excellent!'
        ]);

        ProductCondition::create([
            'product_id'        =>  $p_pp2->id,
            'general_condition'     =>  2,
            'highlights_and_notes'  =>  2,
            'damaged_pages'         =>  2,
            'description'       =>  'Good.'
        ]);

        ProductCondition::create([
            'product_id'            =>  $p_mech0->id,
            'general_condition'     =>  0,
            'highlights_and_notes'  =>  0,
            'damaged_pages'         =>  0,
            'description'       =>  'Brand new!'
        ]);

        ProductCondition::create([
            'product_id'        =>  $p_mech1->id,
            'general_condition'     =>  1,
            'highlights_and_notes'  =>  1,
            'damaged_pages'         =>  1,
            'description'       =>  'Excellent!'
        ]);

        ProductCondition::create([
            'product_id'        =>  $p_mech2->id,
            'general_condition'     =>  2,
            'highlights_and_notes'  =>  2,
            'damaged_pages'         =>  2,
            'description'       =>  'Good.'
        ]);

        ProductImage::create([
            'path'             =>  $folder . 'Algorithms.png',
            'product_id'        =>  $p_alg0->id
            ]);

        ProductImage::create([
            'path'             =>  $folder . 'Algorithms.png',
            'product_id'        =>  $p_alg1->id
            ]);

        ProductImage::create([
            'path'             =>  $folder . 'Algorithms.png',
            'product_id'        =>  $p_alg2->id
            ]);

        ProductImage::create([
            'path'             =>  $folder . 'Programming-Problems.jpg',
            'product_id'        =>  $p_pp0->id
            ]);

        ProductImage::create([
            'path'             =>  $folder . 'Programming-Problems.jpg',
            'product_id'        =>  $p_pp1->id
            ]);

        ProductImage::create([
            'path'             =>  $folder . 'Programming-Problems.jpg',
            'product_id'        =>  $p_pp2->id
            ]);

        ProductImage::create([
            'path'             =>  $folder . 'Principles-of-solid-mechanics.jpg',
            'product_id'        =>  $p_mech0->id
            ]);

        ProductImage::create([
            'path'             =>  $folder . 'Principles-of-solid-mechanics.jpg',
            'product_id'        =>  $p_mech1->id
            ]);

        ProductImage::create([
            'path'             =>  $folder . 'Principles-of-solid-mechanics.jpg',
            'product_id'        =>  $p_mech2->id
            ]);
    }

}
