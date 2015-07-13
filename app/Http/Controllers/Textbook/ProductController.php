<?php namespace App\Http\Controllers\Textbook;

use App\Helpers\FileUploader;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Product;
use App\ProductCondition;
use App\Helpers\AmazonLookUp;

use Auth;
use Config;
use Input;
use Validator;

class ProductController extends Controller {

	/**
	 * Show the form for creating a new product.
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
//        dd(Input::all());
//        dd(Input::file('extra-images'));

        // validation
        $v = Validator::make(Input::all(), Product::rules(Input::file('extra-images')));

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
            Input::file('front-cover-image')
        );

        $extra_images = Input::file('extra-images');

        if ($extra_images)
        {
            foreach ($extra_images as $file)
            {
                array_push($images, $file);
            }
        }

        $title = Input::get('book_title');
        $folder = Config::get('upload.image.product');

		foreach ($images as $image) {
			$file_uploader = new FileUploader($image, $title, $folder, $product->id);
            $file_uploader->saveProductImage();
		}

        return redirect('textbook/buy/product/' . $product->id);
	}

	/**
	 * Display the specified product.
	 *
	 * @param  Product
	 * @return Response
	 */
	public function show($product)
	{

        $book = $product->book;
        $amazon = new AmazonLookUp($book->isbn10, 'ISBN');

        if ($amazon->success())
        {
            $list_price = $amazon->getListPriceFormattedPrice();

            return view('product.show')
                ->withProduct($product)
                ->withListPrice($list_price);
        }

		return view('product.show')->withProduct($product);
	}

}
