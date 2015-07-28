<?php namespace App\Http\Controllers\Textbook;

use App\Helpers\FileUploader;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Product;
use App\ProductImage;
use App\ProductCondition;
use App\Helpers\AmazonLookUp;

use Auth;
use Config;
use Input;
use Validator;
use Session;
use URL;

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
        // validation
        $v = Validator::make(Input::all(), Product::rules(Input::file('extra-images')));

        if ($v->fails())
        {
            return redirect()->back()
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

		foreach ($images as $image) {
            // create product image instance
            $product_image = new ProductImage();
            $product_image->product_id = $product->id;
            $product_image->save();

            // save product image paths with different sizes
            $product_image->small_image = $product_image->generateFilename('small', $image);
            $product_image->medium_image = $product_image->generateFilename('medium', $image);
            $product_image->large_image = $product_image->generateFilename('large', $image);
            $product_image->save();

            // resize image
            $product_image->resize($image);

            // upload image with different sizes to aws s3
            $product_image->uploadToAWS();
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
		return view('product.show')->withProduct($product);
	}
}
