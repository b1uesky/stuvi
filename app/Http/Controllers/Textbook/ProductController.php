<?php namespace App\Http\Controllers\Textbook;

use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Product;
use App\ProductCondition;
use App\ProductImage;
use Auth;
use Config;
use Input;
use Response;
use Session;
use URL;
use Validator;

class ProductController extends Controller
{

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
     * AJAX: Store a product.
     *
     * @return Response
     */
    public function store()
    {
        $images = Input::file('file');
        // validation
        $v = Validator::make(Input::all(), Product::rules($images));

        if ($v->fails())
        {
            return Response::json([
                                      'success' => false,
                                      'fields'  => $v->errors(),
                                  ]);
        }

        $product = Product::create([
                                       'price'     => intval(floatval(Input::get('price')) * 100),
                                       'book_id'   => Input::get('book_id'),
                                       'seller_id' => Auth::user()->id,
                                   ]);

        $condition = ProductCondition::creat([
                                                 'product_id'           => $product->id,
                                                 'general_condition'    => Input::get('general_condition'),
                                                 'highlights_and_notes' => Input::get('highlights_and_notes'),
                                                 'damaged_pages'        => Input::get('damaged_pages'),
                                                 'broken_binding'       => Input::get('broken_binding'),
                                                 'description'          => Input::get('description'),
                                             ]);

        // save multiple product images
        foreach ($images as $image)
        {
            // create product image instance
            $product_image             = new ProductImage();
            $product_image->product_id = $product->id;
            $product_image->save();

            // save product image paths with different sizes
            $product_image->small_image  = $product_image->generateFilename('small', $image);
            $product_image->medium_image = $product_image->generateFilename('medium', $image);
            $product_image->large_image  = $product_image->generateFilename('large', $image);
            $product_image->save();

            // resize image
            $product_image->resize($image);

            // upload image with different sizes to aws s3
            $product_image->uploadToAWS();
        }

        return Response::json([
                                  'success'  => true,
                                  'redirect' => '/textbook/buy/product/' . $product->id,
                              ]);
    }

    /**
     * Display the specified product.
     *
     * @param  Product
     *
     * @return Response
     */
    public function show($product)
    {
        return view('product.show')->withProduct($product);
    }
}
