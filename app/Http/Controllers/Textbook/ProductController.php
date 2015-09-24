<?php namespace App\Http\Controllers\Textbook;

use App\Helpers\Price;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Product;
use App\ProductCondition;
use App\ProductImage;
use Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Input;
use Response;
use Session;
use URL;
use Validator;

class ProductController extends Controller
{
    /**
     * The page for book confirmation after sell search.
     *
     * @param $book
     * @return \Illuminate\View\View
     */
    public function confirm($book)
    {
        return view('product.confirm')
            ->withBook($book);
    }

    /**
     * Show the form for creating a new product.
     *
     * @return Response
     */
    public function create($book)
    {
        if (Auth::check())
        {
            return view('product.create')
                ->withBook($book)
                ->withPaypal(Auth::user()->profile->paypal);
        }
        else
        {
            Session::flash('warning', 'Please login or signup to sell your book.');

            return view('product.create')
                ->withBook($book);
        }

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

        // update user's Paypal email address
        Auth::user()->profile->update([
            'paypal'    => Input::get('paypal')
        ]);

        $int_price = Price::ConvertDecimalToInteger(Input::get('price'));

        $product = Product::create([
            'price' => $int_price,
            'book_id' => Input::get('book_id'),
            'seller_id' => Auth::user()->id,
        ]);

        $product->book->addPrice($int_price);

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
        return view('product.show')
            ->withProduct($product)
            ->withQuery(Input::get('query'))
            ->with('university_id', Input::get('university_id'));
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
                ->with('error', 'Sorry, the product is not found.');
        }
        elseif ($product->sold)
        {
            return back()
                ->with('error', 'Product is sold.');
        }
        elseif ($product->isDeleted())
        {
            return back()
                ->with('error', 'Product is archived.');
        }

        return view('product.edit')
            ->with('book', $product->book)
            ->with('product', $product)
            ->with('paypal', Auth::user()->profile->paypal);
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
            'env'       => app()->environment(),
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
            elseif ($product->isDeleted())
            {
                $v->errors()->add('product', 'The product is archived.');
            }
        });

        if ($v->fails())
        {
            if ($request->ajax())
            {
                return Response::json([
                    'success' => false,
                    'fields' => $v->errors(),
                ]);
            }
            else
            {
                return redirect()->back()
                        ->withErrors($v->errors());
            }

        }

        $int_price = Price::ConvertDecimalToInteger(Input::get('price'));
        $condition = array_filter(Input::only(
            'general_condition',
            'highlights_and_notes',
            'damaged_pages',
            'broken_binding',
            'description'), function($element)
        {
            return !is_null($element);      // filter out null values.
        });

        // update product
        $old_price = $product->price;
        $product->update(['price' => $int_price]);
        $product->condition->update($condition);

        // update book price range
        $product->book->removePrice($old_price);
        $product->book->addPrice($product->price);

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
            return redirect('/textbook/buy/product/' . $product->id)
                ->with('success', 'The product is updated successfully.');
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
                ->with('error', 'Please enter a valid product id.');
        }

        $product = Product::find(Input::get('id'));

        // check if it belongs to the current user.
        if (!($product && $product->isBelongTo(Auth::id())))
        {
            return redirect('/user/bookshelf')
                ->with('error', 'Please enter a valid product id.');
        }

        // check if it is sold.
        if ($product->sold)
        {
            return redirect('/user/bookshelf')
                ->with('error', $product->book->title.' cannot be deleted because it is sold.');
        }

        $book = $product->book;
        $price = $product->price;

        // soft delete.
        $product->update([
            'deleted_at' => Carbon::now(),
                         ]);

        // update book's lowest or highest price if necessary
        $book->removePrice($price);

        return redirect('/user/bookshelf')
            ->with('success', $product->book->title.' has been deleted.');
    }
}
