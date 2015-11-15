<?php namespace App;

use App\Helpers\FileUploader;
use App\Helpers\Price;
use Aws\Laravel\AwsFacade;
use Aws\S3\Exception\S3Exception;
use DB;
use File;
use Illuminate\Database\Eloquent\Model;
use Intervention\Image\Facades\Image;

class Book extends Model
{

    protected $table = 'books';
    protected $guarded = [];

    /**
     * Get textbook authors
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function authors()
    {
        return $this->hasMany('App\BookAuthor');
    }

    /**
     * Get textbook image set
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function imageSet()
    {
        return $this->hasOne('App\BookImageSet');
    }

    /**
     * Get textbook products
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function products()
    {
        return $this->hasMany('App\Product');
    }

    /**
     * Get all products of this book that are not sold yet.
     *
     * @return mixed
     */
    public function availableProducts()
    {
        $products = $this->products()
            ->where('verified', true)
            ->where('sold', false)
            ->whereNull('deleted_at')
            ->join('product_conditions as cond', 'products.id', '=', 'cond.product_id')
            ->orderBy('cond.general_condition')
            ->select('products.*')
            ->get();

        return $products;
    }

    /**
     * Get lowest price in two decimal places.
     *
     * @return string
     */
    public function decimalLowestPrice()
    {
        return Price::convertIntegerToDecimal($this->lowest_price);
    }

    /**
     * Get highest price in two decimal places.
     *
     * @return string
     */
    public function decimalHighestPrice()
    {
        return Price::convertIntegerToDecimal($this->highest_price);
    }

    /**
     * Update book price range for adding a product price.
     * Used for adding new product or cancelling a seller order.
     *
     * @param integer $price
     * @return bool
     */
    public function addPrice($price)
    {
        // if both are not set, set them to the same price
        if ($this->lowest_price == null && $this->highest_price == null) {
            $this->update([
                'lowest_price' => $price,
                'highest_price' => $price
            ]);

            return true;
        }

        // update lowest price
        if ($this->lowest_price && $price < $this->lowest_price) {
            $this->update(['lowest_price' => $price]);
        }
        // update highest price
        if ($this->highest_price && $price > $this->highest_price) {
            $this->update(['highest_price' => $price]);
        }

        return false;
    }

    /**
     * Update book price range for removing a product price.
     * Used for deleting a product or selling a product.
     *
     * @param $price
     * @return bool
     */
    public function removePrice($price)

    {
        // update the lowest price
        if ($price == $this->lowest_price)
        {
            $this->update(['lowest_price' => $this->products()->where('sold', false)->get()->min('price')]);

        }

        // update the highest price
        if ($price == $this->highest_price)
        {
            $this->update(['highest_price' => $this->products()->where('sold', false)->get()->max('price')]);

        }

        // do nothing
        return true;
    }

    /**
     * Search books by query.
     *
     * @param $query
     * @return mixed
     */
    public static function searchByQuery($query)
    {
        // if empty query
        if (trim($query) == '')
        {
            // search for all books
            $books = Book::where('is_verified', true)
                ->orderBy('created_at', 'desc')
                ->take(50)
                ->get();
        }
        else
        {
            // full text search against the query
            $books = Book::whereRaw(
                "MATCH(title, isbn10, isbn13) AGAINST(? IN BOOLEAN MODE)" .
                "OR MATCH(a.full_name) AGAINST(? IN BOOLEAN MODE)",
                // wildcard can only append to the word, i.e.,'*word'
                // is not allowed in MySQL full text search
                [$query . '*', $query . '*']
            )
                ->join('book_authors as a', 'a.book_id', '=', 'books.id')
                ->where('books.is_verified', true)
                ->select('books.*')
                ->distinct()
                ->take(20)
                ->get();
        }

        return $books;
    }

    /**
     * @deprecated
     * Search for books that can be delivered to buyer's university given query title and buyer id.
     *
     * @param $query
     * @param $buyer_id
     * @return mixed
     */
    public static function queryWithBuyerID($query, $buyer_id)
    {
        return Book::queryBooks($query, $buyer_id, 'buyer_id');
    }

    /**
     * @deprecated
     * Search for books that can be delivered to a specific university given query title and university id.
     *
     * @param $query
     * @param $university_id
     * @return mixed
     */
    public static function queryWithUniversityID($query, $university_id)
    {
        return Book::queryBooks($query, $university_id, 'university_id');
    }

    /**
     * @deprecated
     * Buy book search query.
     *
     * @param $query
     * @param $id
     * @param $type
     * @return mixed
     */
    protected static function queryBooks($query, $id, $type)
    {
        if (trim($query) == '')
        {
            // search for all books
            $books = Book::join('book_authors as a', 'a.book_id', '=', 'books.id')
                ->join('products as p', 'p.book_id', '=', 'books.id')
                ->join('users as seller', 'seller.id', '=', 'p.seller_id')
                ->where('is_verified', true)
                ->whereIn('seller.university_id', function ($q) {
                    $q->select('id')
                        ->from('universities')
                        ->where('is_public', '=', true);
                })
                ->whereIn('seller.university_id', function ($q) use ($id, $type) {
                    if ($type == 'buyer_id')
                    {
                        $q->select('uu.from_uid')
                            ->from(DB::raw('users as buyer, university_university as uu'))
                            ->where('buyer.id', '=', $id);
                    }

                    if ($type == 'university_id')
                    {
                        $q->select('from_uid')->distinct()
                            ->from('university_university')
                            ->where('to_uid', '=', $id);
                    }
                })
                ->select('books.*')->distinct()->get();
        }
        else
        {
            // full text search against the query
            $books = Book::whereRaw(
                "MATCH(title, isbn10, isbn13) AGAINST(? IN BOOLEAN MODE)" .
                "OR MATCH(a.full_name) AGAINST(? IN BOOLEAN MODE)",
                // wildcard can only append to the word, i.e.,'*word'
                // is not allowed in MySQL full text search
                [$query . '*', $query . '*']
            )
                ->join('book_authors as a', 'a.book_id', '=', 'books.id')
                ->join('products as p', 'p.book_id', '=', 'books.id')
                ->join('users as seller', 'seller.id', '=', 'p.seller_id')
                ->where('is_verified', true)
                ->whereIn('seller.university_id', function ($q) {
                    $q->select('id')
                        ->from('universities')
                        ->where('is_public', '=', true);
                })
                ->whereIn('seller.university_id', function ($q) use ($id, $type) {
                    if ($type == 'buyer_id')
                    {
                        $q->select('uu.from_uid')
                            ->from(DB::raw('users as buyer, university_university as uu'))
                            ->where('buyer.id', '=', $id);
                    }

                    if ($type == 'university_id')
                    {
                        $q->select('from_uid')->distinct()
                            ->from('university_university')
                            ->where('to_uid', '=', $id);
                    }
                })
                ->select('books.*')->distinct()->get();
        }

        return $books;
    }

    /**
     * Create a book according to the data from Google Book API.
     *
     * @param $google_book
     *
     * @return Book
     */
    public static function createFromGoogleBook($google_book)
    {
        $temp_path = config('image.temp_path');
        $image_url = $google_book->getThumbnail();
        $title = $google_book->getTitle();

        if ($image_url)
        {
            $image_path = $temp_path . 'temp.jpeg';
            $image = Image::make($image_url)->save($image_path);
            $image_filename = FileUploader::generateFilename($size=null, $image, $title);

            $s3 = AwsFacade::createClient('s3');
            $bucket = app()->environment('production') ? config('aws.buckets.book_image') : config('aws.buckets.test_book_image');

            try
            {
                // upload images to amazon s3
                $s3->putObject(array(
                    'Bucket'        => $bucket,
                    'Key'           => $image_filename,
                    'SourceFile'    => $image_path,
                    'ACL'           => 'public-read'
                ));

                // delete temp file
                File::delete($image_path);
            }
            catch (S3Exception $e)
            {
                echo $e->getMessage();
            }

            // save this book to our database
            $book = Book::create([
                'isbn10'        => $google_book->getIsbn10(),
                'isbn13'        => $google_book->getIsbn13(),
                'title'         => $google_book->getTitle(),
                'language'      => $google_book->getLanguage(),
                'num_pages'     => $google_book->getPageCount(),
                'description'   => $google_book->getDescription(),
            ]);

            // create book images
            BookImageSet::create([
                'book_id'       => $book->id,
                'small_image'   => $image_filename,
                'medium_image'  => $image_filename,
                'large_image'   => $image_filename
            ]);
        }
        else
        {
            // save this book to our database
            $book = Book::create([
                'isbn10'        => $google_book->getIsbn10(),
                'isbn13'        => $google_book->getIsbn13(),
                'title'         => $google_book->getTitle(),
                'language'      => $google_book->getLanguage(),
                'num_pages'     => $google_book->getPageCount(),
                'description'   => $google_book->getDescription(),
            ]);

            // create book images
            BookImageSet::create([
                'book_id'       => $book->id,
                'small_image'   => null,
                'medium_image'  => null,
                'large_image'   => null
            ]);
        }

        // save book authors
        foreach ($google_book->getAuthors() as $author_name) {
            BookAuthor::create([
                'book_id'   => $book->id,
                'full_name' => $author_name
            ]);
        }

        return $book;
    }

    /**
     * Validation rules
     *
     * @return array
     */
    public static function rules()
    {
        $rules = array(
            'isbn'      => 'required',
            'title'     => 'required|string',
            'authors'   => 'required|string',
            'edition'   => 'required|integer|min:1',
            'num_pages' => 'required|integer|min:1',
            'language'  => 'required|string'
        );

        $rules['image'] = 'required|mimes:jpeg,png|max:5120';

        return $rules;
    }

    public static function updateRules()
    {
        $rules = array(
            'title'     => 'required|string',
            'edition'   => 'required|integer|min:1',
            'num_pages' => 'required|integer|min:1',
            'language'  => 'required|string',
            'is_verified'   => 'required|boolean'
        );

        return $rules;
    }
}
