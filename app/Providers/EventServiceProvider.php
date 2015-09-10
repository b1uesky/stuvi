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

		'App\Events\UserEmailWasAdded' => [
			'App\Listeners\EmailUserEmailAddedConfirmation',
		],

		'App\Events\UserPasswordWasChanged' => [
			'App\Listeners\EmailUserPasswordChangedNotification',
		],

		// buyer order
		'App\Events\BuyerOrderWasPlaced' => [
			'App\Listeners\EmailBuyerOrderConfirmation',
		],

		'App\Events\BuyerOrderWasShipped' => [
			'App\Listeners\EmailBuyerOrderShippingNotification',
		],

		'App\Events\BuyerOrderWasDelivered' => [
			'App\Listeners\EmailBuyerOrderDeliveredNotification',
			'App\Listeners\CaptureAuthorizedPaymentFromBuyer',
			'App\Listeners\CreatePayoutToSellers',
		],

		// seller order
		'App\Events\SellerOrderWasCreated' => [
			'App\Listeners\EmailSellerOrderConfirmation',
		],

		'App\Events\SellerOrderPickupWasScheduled' => [
			// to seller
			'App\Listeners\EmailSellerOrderPickupConfirmation',
//			'App\Listeners\MessageSellerOrderPickupConfirmation',

			// to stuvi
			'App\Listeners\EmailSellerOrderPickupNotification',
		],

		'App\Events\SellerOrderWasAssignedToCourier' => [
			// to seller
			'App\Listeners\EmailSellerOrderReadyToPickupNotification',
//			'App\Listeners\MessageSellerOrderReadyToPickupNotification',
		],

		'App\Events\SellerOrderWasCancelled' => [
			'App\Listeners\MessageSellerOrderCancellationToCourier',
			'App\Listeners\EmailSellerOrderCancellationToBuyer',
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
