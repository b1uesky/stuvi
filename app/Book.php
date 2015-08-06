<?php namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

use App\Helpers\Price;

class Book extends Model
{

    protected $fillable = ['title', 'edition', 'isbn10', 'isbn13', 'num_pages', 'verified', 'language',
        'list_price', 'lowest_price', 'highest_price'];

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
            ->where('sold', 0)
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
     * Update the lowest and the highest price of the book.
     *
     * @param integer $price
     * @return bool
     */
    public function updateLowestAndHighestPrice($price)
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

            return true;
        }

        // update highest price
        if ($this->highest_price && $price > $this->highest_price) {
            $this->update(['highest_price' => $price]);

            return true;
        }

        return false;
    }

    /**
     * Update book lowest or highest price after a deletion of product.
     *
     * @param $price
     * @return bool
     */
    public function updatePriceAfterProductDelete($price)
    {
        // update the lowest price
        if ($price == $this->lowest_price)
        {
            $this->update(['lowest_price' => $this->products->min('price')]);

            return true;
        }

        // update the highest price
        if ($price == $this->highest_price)
        {
            $this->update(['highest_price' => $this->products->max('price')]);

            return true;
        }

        // do nothing
        return false;
    }

    /**
     * Search for books that can be delivered to buyer's university given query title and buyer id.
     *
     * @param $query
     * @param $buyer_id
     * @return mixed
     */
    public static function queryWithBuyerID($query, $buyer_id)
    {
        $terms = explode(' ', $query);
        $clauses = array();

        foreach ($terms as $term) {
            $clauses[] = 'title LIKE "%' . $term . '%" OR a.full_name LIKE "%' . $term . '%"';
        }

        $filter = implode(' OR ', $clauses);

        $books = Book::whereRaw($filter)
            ->join('book_authors as a', 'a.book_id', '=', 'books.id')
            ->join('products as p', 'p.book_id', '=', 'books.id')
            ->join('users as seller', 'seller.id', '=', 'p.seller_id')
            ->whereIn('seller.university_id', function ($q) use ($buyer_id) {
                $q->select('uu.from_uid')
                    ->from(DB::raw('users as buyer, university_university as uu'))
                    ->where('buyer.id', '=', $buyer_id);
            })
            ->whereIn('seller.university_id', function ($q) {
                $q->select('id')
                    ->from('universities')
                    ->where('is_public', '=', true);
            })
            ->select('books.*')->distinct()->get();

        return $books;
    }

    /**
     * Search for books that can be delivered to a specific university given query title and university id.
     *
     * @param $query
     * @param $university_id
     * @return mixed
     */
    public static function queryWithUniversityID($query, $university_id)
    {
        $terms = explode(' ', $query);
        $clauses = array();

        foreach ($terms as $term) {
            $clauses[] = 'title LIKE "%' . $term . '%" OR a.full_name LIKE "%' . $term . '%"';
        }

        $filter = implode(' OR ', $clauses);

        $books = Book::whereRaw($filter)
            ->join('products as p', 'p.book_id', '=', 'books.id')
            ->join('users as seller', 'seller.id', '=', 'p.seller_id')
            ->whereIn('seller.university_id', function ($q) use ($university_id) {
                $q->select('from_uid')->distinct()
                    ->from('university_university')
                    ->where('to_uid', '=', $university_id);
            })
            ->whereIn('seller.university_id', function ($q) {
                $q->select('id')
                    ->from('universities')
                    ->where('is_public', '=', true);
            })
            ->select('books.*')->distinct()->get();

        return $books;
    }

}
