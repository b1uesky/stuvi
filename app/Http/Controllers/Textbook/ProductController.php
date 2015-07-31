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

        $product = new Product();
        $product->price     = Input::get('price');
        $product->book_id   = Input::get('book_id');
        $product->seller_id = Auth::user()->id;
        $product->save();

        $condition                       = new ProductCondition();
        $condition->product_id           = $product->id;
        $condition->general_condition    = Input::get('general_condition');
        $condition->highlights_and_notes = Input::get('highlights_and_notes');
        $condition->damaged_pages        = Input::get('damaged_pages');
        $condition->broken_binding       = Input::get('broken_binding');
        $condition->description          = Input::get('description');
        $condition->save();

        // save multiple product images
        foreach ($images as $image)
        {
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

    /**
     * Show product edit page.
     *
     * @param $id
     *
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function edit($id)
    {
        $product = Product::find($id);

        if (!($product && $product->isBelongTo(Auth::id())))
        {
            return back()
                ->with('message', 'The product is not found.');
        }
        elseif ($product->sold)
        {
            return back()
                ->with('message', 'Product is sold.');
        }

        return view('product.edit')
            ->with('product', $product);
    }

    /**
     * Update product info.
     *
     * @param $id
     *
     * @return \Illuminate\Http\RedirectResponse|Response
     */
    public function update($id)
    {
        $product = Product::find($id);

        if (!($product || $product->isBelongTo(Auth::id())))
        {
            Response::json([
                               'success'  => false,
                               'redirect' => back()->getTargetUrl(),
                               'message'  => 'Product is not found.',
                           ]);
        }
        elseif ($product->sold)
        {
            Response::json([
                               'success'  => false,
                               'redirect' => back()->getTargetUrl(),
                               'message'  => 'This product is sold',
                           ]);
        }

        // TODO: image validation

        // update product info
        $condition            = $product->condition;
        $general_condition    = Input::has('general_condition') ? intval(Input::get('general_condition')) : $condition->general_condition;
        $highlights_and_notes = Input::has('highlights_and_notes') ? intval(Input::get('highlights_and_notes')) : $condition->highlights_and_notes;
        $damaged_pages        = Input::has('damaged_pages') ? intval(Input::get('damaged_pages')) : $condition->damaged_pages;
        $broken_binding       = Input::has('broken_binding') ? intval(Input::get('broken_binding')) : $condition->broken_binding;
        $description          = Input::get('description');

        $product->update([
                             'price' => Input::get('price'),
                         ]);

        $condition->update([
                               'general_condition'    => $general_condition,
                               'highlights_and_notes' => $highlights_and_notes,
                               'damaged_pages'        => $damaged_pages,
                               'broken_binding'       => $broken_binding,
                               'description'          => $description,
                           ]);

        // TODO: update product images.

        Response::json([
                           'success'  => true,
                           'redirect' => '/textbook/buy/product/' . $product->id,
                       ]);
    }
}
