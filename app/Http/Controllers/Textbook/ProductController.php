<?php namespace App\Http\Controllers\Textbook;

use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Product;
use App\ProductCondition;
use App\ProductImage;
use Auth;
use Config;
use Illuminate\Http\Request;
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
                'fields' => $v->errors()
            ]);
        }

        $product = Product::create([
            'price' => intval(floatval(Input::get('price')) * 100),
            'book_id' => Input::get('book_id'),
            'seller_id' => Auth::user()->id,
        ]);

        $condition = ProductCondition::create([
            'product_id' => $product->id,
            'general_condition' => Input::get('general_condition'),
            'highlights_and_notes' => Input::get('highlights_and_notes'),
            'damaged_pages' => Input::get('damaged_pages'),
            'broken_binding' => Input::get('broken_binding'),
            'description' => Input::get('description'),
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
            'success' => true,
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
     * AJAX: get product images.
     *
     * @return mixed
     */
    public function getImages()
    {
        $product = Product::find(Input::get('product_id'));
        $product_images = $product->images;

        return Response::json([
            'success'   => true,
            'images'    => $product_images
        ]);
    }

    /**
     * AJAX: delete a product image according to the product image ID.
     *
     * @return mixed
     */
    public function deleteImage()
    {
        $product_image = ProductImage::find(Input::get('productImageID'));
        $product_image->deleteFromAWS();
        $product_image->delete();

        return Response::json([
            'success'   => true
        ]);
    }

    /**
     * Update product info.
     *
     * If AJAX, we'll update images.
     *
     * @param Request $request
     * @return mixed
     */
    public function update(Request $request)
    {
        $product = Product::find(Input::get('product_id'));
        $images = Input::file('file');

        // validation
        $v = Validator::make(Input::all(), Product::rulesUpdate($images));

        $v->after(function($v) use ($product)
        {
            if (!($product || $product->isBelongTo(Auth::id())))
            {
                $v->errors()->add('product', 'The product is not found.');
            }
            elseif ($product->sold)
            {
                $v->errors()->add('product', 'The product was sold');
            }
        });

        if ($v->fails())
        {
            return Response::json([
                'success' => false,
                'fields' => $v->errors(),
            ]);
        }

        // update
        $product->update([
             'price' => intval(floatval(Input::get('price')) * 100),
         ]);

        $product->condition->update([
           'general_condition'    => Input::get('general_condition'),
           'highlights_and_notes' => Input::get('highlights_and_notes'),
           'damaged_pages'        => Input::get('damaged_pages'),
           'broken_binding'       => Input::get('broken_binding'),
           'description'          => Input::get('description'),
       ]);

        // if AJAX request, save images
        if ($request->ajax())
        {
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
                'success' => true,
                'redirect' => '/textbook/buy/product/' . $product->id,
            ]);
        }
        else
        {
            // if the request is not AJAX (Dropzone does not contain any image)
            // we do not need to save any image, just redirect to the product page
            return redirect('/textbook/buy/product/' . $product->id);
        }
    }

    /**
     * Delete a product record.
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function destroy()
    {
        if (!Input::has('id'))
        {
            return redirect('/user/bookshelf')
                ->with('message', 'Please enter a valid product id.');
        }

        $product = Product::find(Input::get('id'));

        // check if it belongs to the current user.
        if (!($product && $product->isBelongTo(Auth::id())))
        {
            return redirect('/user/bookshelf')
                ->with('message', 'Please enter a valid product id.');
        }

        // check if it is sold.
        if ($product->sold)
        {
            return redirect('/user/bookshelf')
                ->with('message', $product->book->title.' cannot be deleted because it is sold.');
        }

        // delete safely.
        $product->delete();

        return redirect('/user/bookshelf')
            ->with('message', $product->book->title.' has been deleted.');
    }
}
