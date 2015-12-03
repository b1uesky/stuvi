<?php namespace App;

use App\Helpers\FileUploader;
use App\Helpers\Price;
use Aws\Laravel\AwsFacade;
use Aws\S3\Exception\S3Exception;
use DB;
use File;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;
use Intervention\Image\Facades\Image;

class Book extends Model
{

    protected $table = 'books';
    protected $guarded = [];

    /*
	|--------------------------------------------------------------------------
	| Relationships
	|--------------------------------------------------------------------------
	*/

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
     * Get all book reminders
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function bookReminders()
    {
        return $this->hasMany('App\BookReminder', 'book_id');
    }

    /*
	|--------------------------------------------------------------------------
	| Accessors & Mutators
	|--------------------------------------------------------------------------
	*/

    public function getLowestPriceAttribute($value)
    {
        return Price::convertIntegerToDecimal($value);
    }

    public function setLowestPriceAttribute($value)
    {
        $this->attributes['lowest_price'] = Price::convertDecimalToInteger($value);
    }

    public function getHighestPriceAttribute($value)
    {
        return Price::convertIntegerToDecimal($value);
    }

    public function setHighestPriceAttribute($value)
    {
        $this->attributes['highest_price'] = Price::convertDecimalToInteger($value);
    }

    public function getListPriceAttribute($value)
    {
        return Price::convertIntegerToDecimal($value);
    }

    public function setListPriceAttribute($value)
    {
        $this->attributes['list_price'] = Price::convertDecimalToInteger($value);
    }

    /*
	|--------------------------------------------------------------------------
	| Query Scopes
	|--------------------------------------------------------------------------
	*/

    /**
     * Get books that are created after a specific date.
     *
     * @param $query
     * @param $date
     * @return mixed
     */
    public function scopeCreatedAfter($query, $date)
    {
        return $query->where('created_at', '>=', $date);
    }

    /**
     * Get the book's authors' names.
     *
     * @return array
     */
    public function getAuthorsNames()
    {
        $names = array();

        foreach ($this->authors as $author)
        {
            array_push($names, $author->full_name);
        }

        return $names;
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
     * Update book price range for adding a product price.
     * Used for adding new product or cancelling a seller order.
     *
     * @param decimal $price
     * @return bool
     */
    public function addPrice($price)
    {
        // if both are not set, set them to the same price
        if ($this->lowest_price == null && $this->highest_price == null) {
            $this->lowest_price = $price;
            $this->highest_price = $price;
            $this->save();

            return true;
        }

        // update lowest price
        if ($this->lowest_price && $price < $this->lowest_price) {
            $this->lowest_price = $price;
            $this->save();
        }
        // update highest price
        if ($this->highest_price && $price > $this->highest_price) {
            $this->highest_price = $price;
            $this->save();
        }

        return false;
    }

    /**
     * Update book price range for removing a product price.
     * Used for deleting a product or selling a product.
     *
     * @param decimal $price
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
     * @param string $query
     * @param int $full_text_search_limit
     * @return mixed
     */
    public static function searchByQuery($query, $full_text_search_limit=20)
    {
        // if empty query, search for all books
        if (trim($query) == '')
        {
            $books = Book::where('is_verified', true)
                ->orderBy('created_at', 'desc')
                ->take(50)
                ->get();
        }
        else
        {
            // Full text search
            //
            // We could have used eloquent model to make full text search work,
            // but I cannot find a possible way to use parameter in select()
            // statement, which allows SQL injection.
            // As suggested by Taylor, we need to run a raw query.
            // https://github.com/laravel/framework/issues/214#issuecomment-12916104

            // Wildcard can only append to the word, i.e.,'*word' is not allowed
            // in MySQL full text search
            $results = DB::select('
                select
                  distinct books.*,
                  MATCH(title, isbn10, isbn13) AGAINST(? IN BOOLEAN MODE) AS score,
                  MATCH(a.full_name) AGAINST(? IN BOOLEAN MODE) AS score_author
                from books, book_authors as a
                where books.id = a.book_id
                and books.is_verified = true
                and (
                  MATCH(title, isbn10, isbn13) AGAINST(? IN BOOLEAN MODE) or
                  MATCH(a.full_name) AGAINST(? IN BOOLEAN MODE)
                )
                ORDER BY score DESC, score_author DESC
                LIMIT ?
                ', [$query.'*', $query.'*', $query.'*', $query.'*', $full_text_search_limit]);

            // make a collection of books from the array
            $books = collect($results)->map(function ($book) {
                return Book::find($book->id);
            });
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
                var_dump($e->getMessage());
                return false;
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
