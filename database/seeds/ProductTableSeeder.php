<?php

use Illuminate\Database\Seeder;
use App\Product;
use App\ProductCondition;
use App\Book;
use App\User;

class ProductTableSeeder extends Seeder {

public function run()
{
    DB::table('product_conditions')->delete();
    DB::table('products')->delete();

    $book_algorithms = Book::where('title', '=', 'Algorithms')->get()->first();
    $book_mechanics = Book::where('title', '=', 'Principles of solid mechanics')->get()->first();
    $seller = User::where('email', '=', 'seller@stuvi.com')->get()->first();

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

    Product::create([
        'price'             =>  49.99,
        'book_id'           =>  $book_algorithms->id,
        'seller_id'         =>  $seller->id,
        'condition_id'      =>  $pd0->id
    ]);

    Product::create([
        'price'             =>  39.99,
        'book_id'           =>  $book_algorithms->id,
        'seller_id'         =>  $seller->id,
        'condition_id'      =>  $pd1->id
    ]);

    Product::create([
        'price'             =>  29.99,
        'book_id'           =>  $book_algorithms->id,
        'seller_id'         =>  $seller->id,
        'condition_id'      =>  $pd2->id
    ]);

    // Principles of solid mechanics

    Product::create([
        'price'             =>  129.99,
        'book_id'           =>  $book_mechanics->id,
        'seller_id'         =>  $seller->id,
        'condition_id'      =>  $pd0->id
    ]);

    Product::create([
        'price'             =>  109.99,
        'book_id'           =>  $book_mechanics->id,
        'seller_id'         =>  $seller->id,
        'condition_id'      =>  $pd1->id
    ]);

    Product::create([
        'price'             =>  89.99,
        'book_id'           =>  $book_mechanics->id,
        'seller_id'         =>  $seller->id,
        'condition_id'      =>  $pd2->id
    ]);
}

}
