<?php

namespace App\Console\Commands;

use App\Book;
use App\BuyerOrder;
use App\Helpers\Email;
use App\Product;
use App\SellerOrder;
use App\User;
use Carbon\Carbon;
use Illuminate\Console\Command;

class DailySummary extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'daily-summary:report';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send website statistics summary to whom it may concern.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $data = [
            'count_signed_up'       => count(User::signedUpAfter(Carbon::today())->get()),
            'count_books'           => count(Book::createdAfter(Carbon::today())->get()),
            'count_products'        => count(Product::createdAfter(Carbon::today())->get()),
            'count_buyer_orders'    => count(BuyerOrder::createdAfter(Carbon::today())->get()),
            'count_seller_orders'   => count(SellerOrder::createdAfter(Carbon::today())->get())
        ];

        foreach (config('summary.mailing_list') as $to)
        {
            $email = new Email('Stuvi daily summary', $to, 'emails.daily-summary', $data);
            $email->send();
        }

    }
}
