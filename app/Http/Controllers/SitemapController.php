<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\App;

use DB;

class SitemapController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        // create new sitemap object
        $sitemap = App::make("sitemap");

        // set cache (key (string), duration in minutes (Carbon|Datetime|int), turn on/off (boolean))
        // by default cache is disabled
//        $sitemap->setCache('laravel.sitemap', 3600);

        // check if there is cached sitemap and build new only if is not
        if (!$sitemap->isCached()) {
            $current = date(config('database.datetime_format'));
            // add item to the sitemap (url, date, priority, freq)
            $sitemap->add(url('/'), '2015-08-13T20:10:00+02:00', '1.0', 'daily');
            $sitemap->add(url('books'), '2012-08-13T12:30:00+02:00', '0.9', 'daily');

            // get all posts from db
            $books = DB::table('books')->orderBy('created_at', 'desc')->get();

            // add every post to the sitemap
            foreach ($books as $book) {
                $sitemap->add($book->title);
            }
        }

        // show your sitemap (options: 'xml' (default), 'html', 'txt', 'ror-rss', 'ror-rdf')
        return $sitemap->render('xml');
    }
}
