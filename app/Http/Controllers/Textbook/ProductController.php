<?php namespace App\Http\Controllers\Textbook;

use App\Helpers\FileUploader;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Product;
use App\ProductCondition;
use Auth;
use Config;
use Input;
use Validator;

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
	public function store()
	{
        // validation
        $v = Validator::make(Input::all(), Product::rules());

        if ($v->fails())
        {
            redirect()->back()
                ->withErrors($v->errors())
                ->withInput(Input::all());
        }

        $product = new Product();
        $product->price     = Input::get('price');
        $product->book_id   = Input::get('book_id');
        $product->seller_id = Auth::user()->id;
        $product->save();

		$condition = new ProductCondition();
		$condition->product_id              = $product->id;
        $condition->general_condition       = Input::get('general_condition');
		$condition->highlights_and_notes    = Input::get('highlights_and_notes');
		$condition->damaged_pages           = Input::get('damaged_pages');
		$condition->broken_binding          = Input::get('broken_binding');
		$condition->description             = Input::get('description');
		$condition->save();

		// save multiple product images
        $images = array(
            Input::file('front-cover-image'),
            Input::file('back-cover-image'),
            Input::file('page-image')
        );

        $title = Input::get('book_title');
        $folder = Config::get('upload.image.product');

		foreach ($images as $image) {
			$file_uploader = new FileUploader($image, $title, $folder, $product->id);
            $file_uploader->saveProductImage();
		}

        return redirect('textbook/buy/product/'.$product->id);
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
