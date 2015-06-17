<?php namespace App\Http\Controllers\Textbook;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use Auth;
use Input;
use Config;

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
        return view('product.create', [
			'book'		    => $book,
			'conditions'	=> Config::get('product.conditions')
			]);
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(Request $request)
	{
        $this->validate($request, [
            'highlights'        =>  'required|integer',
            'notes'             =>  'required|integer',
            'num_damaged_pages' =>  'required|integer',
            'broken_spine'      =>  'required|integer',
            'broken_binding'    =>  'required|integer',
            'water_damage'      =>  'required|integer',
            'stains'            =>  'required|integer',
            'burns'             =>  'required|integer',
            'rips'              =>  'required|integer',
            'price'             =>  'required|numeric'
        ]);

        $product = new Product();
        $product->price     = Input::get('price');
        $product->book_id   = Input::get('book_id');
        $product->seller_id = Auth::user()->id;
        $product->save();

		$condition = new ProductCondition();
		$condition->product_id          = $product->id;
		$condition->highlights          = Input::get('highlights');
		$condition->notes               = Input::get('notes');
		$condition->num_damaged_pages   = Input::get('num_damaged_pages');
		$condition->broken_spine        = Input::get('broken_spine');
		$condition->broken_binding      = Input::get('broken_binding');
		$condition->water_damage        = Input::get('water_damage');
		$condition->stains              = Input::get('stains');
		$condition->burns               = Input::get('burns');
		$condition->rips                = Input::get('rips');
		$condition->description         = Input::get('description');
		$condition->save();

		// save multiple product images
		$images = Input::file('images');
		$title = Input::get('book_title');
		$folder = Config::get('upload.image.product');

		foreach ($images as $image) {
			$file_uploader = new FileUploader($image, $title, $folder, $product->id);
            $file_uploader->saveProductImage();
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
		return view('product.show', [
			'product' 	=> $product,
			'condition'	=> $product->condition,
			'book' 		=> $product->book,
			'seller' 	=> $product->seller,
			'images'	=> $product->images,
			'conditions'	=>	Config::get('product.conditions')
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
