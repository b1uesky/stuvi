<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use Auth;
use Input;

use App\Product;
use App\ProductCondition;
use App\ProductImage;
use App\Book;
use App\User;

use App\Helpers\FileUploader;

class ProductController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		//
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create($book)
	{
        return view('product.create')->withBook($book);
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
        $condition = new ProductCondition();
        $condition->highlights = Input::get('highlights');
        $condition->notes = Input::get('notes');
        $condition->num_damaged_pages = Input::get('num_damaged_pages');
        $condition->broken_spine = Input::get('broken_spine');
        $condition->broken_binding = Input::get('broken_binding');
        $condition->water_damage = Input::get('water_damage');
        $condition->stains = Input::get('stains');
        $condition->burns = Input::get('burns');
        $condition->rips = Input::get('rips');
        $condition->save();

        $product = new Product();
        $product->price = Input::get('price');
        $product->book_id = Input::get('book_id');
        $product->seller_id = Auth::user()->id;
        $product->condition_id = $condition->id;
        $product->sold = false;
        $product->save();

		// save multiple product images
		$images = Input::file('images');
		$title = Input::get('book_title');
		$folder = '/img/product/';

		foreach ($images as $image) {
			$file_uploader = new FileUploader($image, $title, $folder);

			$product_image = new ProductImage();
			$product_image->image = $file_uploader->path;
			$product_image->product_id = $product->id;
			$product_image->save();

			$file_uploader->saveFile();
		}

        return $this->show($product);
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  Product
	 * @return Response
	 */
	public function show($product)
	{
		$book = Book::find($product->book_id);
		$seller = User::find($product->seller_id);
		$images = ProductImage::where('product_id', '=', $product->id)->get();

		return view('product.show', [
			'product' 	=> $product,
			'book' 		=> $book,
			'seller' 	=> $seller,
			'images'	=> $images
		]);
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}

}
