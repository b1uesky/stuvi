<?php

namespace App\Console\Commands;

use App\Events\ProductIsAvailableSoon;
use Illuminate\Console\Command;
use App\Product;

class RemindSellerToSchedulePickup extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'reminder:pickup';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send emails to sellers about scheduling a pickup.';

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
        $products = Product::sold()->availableInDays(2)->get();

        foreach ($products as $product)
        {
            // if seller has not scheduled a pickup for the order
            if (!$product->currentSellerOrder()->scheduledPickupTime())
            {
                event(new ProductIsAvailableSoon($product));
            }
        }
    }
}
