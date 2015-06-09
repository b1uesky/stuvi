<?php

use Illuminate\Database\Seeder;
use App\Product;
use App\ProductCondition;
use App\ProductImage;
use App\Book;
use App\User;

class ProductTableSeeder extends Seeder {

    public function run()
    {
        DB::table('product_conditions')->delete();
        DB::table('products')->delete();

        $book_algorithms = Book::where('title', '=', 'Algorithms')->get()->first();
        $book_mechanics = Book::where('title', '=', 'Principles of solid mechanics')->get()->first();
        $book_pp = Book::where('title', '=', 'Programming Problems: Advanced Algorithms (Volume 2)')->get()->first();
        $seller = User::where('email', '=', 'seller@stuvi.com')->get()->first();
        $folder = '/img/product/';

        $pd0 = ProductCondition::create([
            'highlights'        =>  0,
            'notes'             =>  0,
            'num_damaged_pages' =>  0,
            'broken_spine'      =>  0,
            'broken_binding'    =>  0,
            'water_damage'      =>  0,
            'stains'            =>  0,
            'burns'             =>  0,
            'rips'              =>  0
            ]);

        $pd1 = ProductCondition::create([
            'highlights'        =>  1,
            'notes'             =>  1,
            'num_damaged_pages' =>  1,
            'broken_spine'      =>  1,
            'broken_binding'    =>  1,
            'water_damage'      =>  1,
            'stains'            =>  1,
            'burns'             =>  1,
            'rips'              =>  1
            ]);

        $pd2 = ProductCondition::create([
            'highlights'        =>  2,
            'notes'             =>  2,
            'num_damaged_pages' =>  2,
            'broken_spine'      =>  2,
            'broken_binding'    =>  2,
            'water_damage'      =>  2,
            'stains'            =>  2,
            'burns'             =>  2,
            'rips'              =>  2
            ]);

        // Algorithms
        $p_alg0 = Product::create([
            'price'             =>  49.99,
            'book_id'           =>  $book_algorithms->id,
            'seller_id'         =>  $seller->id,
            'condition_id'      =>  $pd0->id
        ]);

        $p_alg1 = Product::create([
            'price'             =>  39.99,
            'book_id'           =>  $book_algorithms->id,
            'seller_id'         =>  $seller->id,
            'condition_id'      =>  $pd1->id
        ]);

        $p_alg2 = Product::create([
            'price'             =>  29.99,
            'book_id'           =>  $book_algorithms->id,
            'seller_id'         =>  $seller->id,
            'condition_id'      =>  $pd2->id
        ]);

        // Programming Problems
        $p_pp0 = Product::create([
            'price'             =>  49.99,
            'book_id'           =>  $book_pp->id,
            'seller_id'         =>  $seller->id,
            'condition_id'      =>  $pd0->id
        ]);

        $p_pp1 = Product::create([
            'price'             =>  39.99,
            'book_id'           =>  $book_pp->id,
            'seller_id'         =>  $seller->id,
            'condition_id'      =>  $pd1->id
        ]);

        $p_pp2 = Product::create([
            'price'             =>  29.99,
            'book_id'           =>  $book_pp->id,
            'seller_id'         =>  $seller->id,
            'condition_id'      =>  $pd2->id
        ]);

        // Principles of solid mechanics
        $p_mech0 = Product::create([
            'price'             =>  129.99,
            'book_id'           =>  $book_mechanics->id,
            'seller_id'         =>  $seller->id,
            'condition_id'      =>  $pd0->id
        ]);

        $p_mech1 = Product::create([
            'price'             =>  109.99,
            'book_id'           =>  $book_mechanics->id,
            'seller_id'         =>  $seller->id,
            'condition_id'      =>  $pd1->id
        ]);

        $p_mech2 = Product::create([
            'price'             =>  89.99,
            'book_id'           =>  $book_mechanics->id,
            'seller_id'         =>  $seller->id,
            'condition_id'      =>  $pd2->id
        ]);

        ProductImage::create([
            'image'             =>  $folder . 'Algorithms.png',
            'product_id'        =>  $p_alg0->id
            ]);

        ProductImage::create([
            'image'             =>  $folder . 'Algorithms.png',
            'product_id'        =>  $p_alg1->id
            ]);

        ProductImage::create([
            'image'             =>  $folder . 'Algorithms.png',
            'product_id'        =>  $p_alg2->id
            ]);

        ProductImage::create([
            'image'             =>  $folder . 'Programming-Problems.png',
            'product_id'        =>  $p_pp0->id
            ]);

        ProductImage::create([
            'image'             =>  $folder . 'Programming-Problems.png',
            'product_id'        =>  $p_pp1->id
            ]);

        ProductImage::create([
            'image'             =>  $folder . 'Programming-Problems.png',
            'product_id'        =>  $p_pp2->id
            ]);

        ProductImage::create([
            'image'             =>  $folder . 'Principles-of-solid-mechanics.png',
            'product_id'        =>  $p_mech0->id
            ]);

        ProductImage::create([
            'image'             =>  $folder . 'Principles-of-solid-mechanics.png',
            'product_id'        =>  $p_mech1->id
            ]);

        ProductImage::create([
            'image'             =>  $folder . 'Principles-of-solid-mechanics.png',
            'product_id'        =>  $p_mech2->id
            ]);
    }

}
