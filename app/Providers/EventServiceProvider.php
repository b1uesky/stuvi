<?php namespace App\Providers;

use Illuminate\Contracts\Events\Dispatcher as DispatcherContract;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider {

	/**
	 * The event handler mappings for the application.
	 *
	 * @var array
	 */
	protected $listen = [

		'App\Events\UserWasSignedUp' => [
			'App\Listeners\EmailSignedUpConfirmation',
		],

		'App\Events\BuyerOrderWasPlaced' => [
			'App\Listeners\EmailBuyerOrderConfirmation',
		],

		// a seller order will be created after a buyer order was placed
		'App\Events\SellerOrderWasCreated' => [
			'App\Listeners\EmailSellerOrderConfirmation',
		],
	];

	/**
	 * Register any other events for your application.
	 *
	 * @param  \Illuminate\Contracts\Events\Dispatcher  $events
	 * @return void
	 */
	public function boot(DispatcherContract $events)
	{
		parent::boot($events);

		//
	}

}
