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
use Response;

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
        return $value != null ? Price::convertIntegerToDecimal($value) : null;
    }

    public function setLowestPriceAttribute($value)
    {
        $this->attributes['lowest_price'] = Price::convertDecimalToInteger($value);
    }

    public function getHighestPriceAttribute($value)
    {
        return $value != null ? Price::convertIntegerToDecimal($value) : null;
    }

    public function setHighestPriceAttribute($value)
    {
        $this->attributes['highest_price'] = Price::convertDecimalToInteger($value);
    }

    public function getListPriceAttribute($value)
    {
        return $value != null ? Price::convertIntegerToDecimal($value) : null;
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
     * Get books that have products.
     *
     * @param $query
     * @return mixed
     */
    public function scopeHasProducts($query)
    {
        return $query->join('products as p', 'p.book_id', '=', 'books.id')
            ->where('books.is_verified', true)
            ->select('books.*')
            ->distinct();
    }

    /*
	|--------------------------------------------------------------------------
	| Methods
	|--------------------------------------------------------------------------
	*/

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
        if (!$this->lowest_price && !$this->highest_price) {
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
            $this->update([
                'lowest_price' => $this->products()
                    ->where('sold', false)
                    ->whereNull('deleted_at')
                    ->get()
                    ->min('price')
            ]);
        }

        // update the highest price
        if ($price == $this->highest_price)
        {
            $this->update([
                'highest_price' => $this->products()
                    ->where('sold', false)
                    ->whereNull('deleted_at')
                    ->get()
                    ->max('price')
            ]);
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
            $books = Book::leftJoin('products as p', 'p.book_id', '=', 'books.id')
                ->where('books.is_verified', true)
                ->orderBy('p.verified', 'desc')
                ->orderBy('books.created_at', 'desc')
                ->select('books.*')
                ->distinct()
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
