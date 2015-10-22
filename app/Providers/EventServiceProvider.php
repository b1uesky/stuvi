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

		// user
		'App\Events\UserWasSignedUp' => [
			'App\Listeners\EmailSignedUpConfirmation',
		],

		'App\Events\UserEmailWasAdded' => [
			'App\Listeners\EmailUserEmailAddedConfirmation',
		],

		'App\Events\UserPasswordWasChanged' => [
			'App\Listeners\EmailUserPasswordChangedNotification',
		],

		// product that sells to user
		'App\Events\ProductIsAvailableSoon' => [
			'App\Listeners\EmailSellerProductAvailableSoonNotification',
		],

		// product that sells to stuvi
		'App\Events\ProductWasUpdatedPriceAndApproved' => [
			'App\Listeners\EmailSellerProductUpdatedPriceAndApprovedNotification',
		],

		'App\Events\ProductWasRejected' => [
			'App\Listeners\EmailSellerProductRejectedNotification',
		],

		// buyer order
		'App\Events\BuyerOrderWasPlaced' => [
			'App\Listeners\EmailBuyerOrderConfirmation',

			// to stuvi
			'App\Listeners\MessageBuyerOrderPlacedNotification',
		],

		'App\Events\BuyerOrderWasShipped' => [
			'App\Listeners\EmailBuyerOrderShippingNotification',
		],

		'App\Events\BuyerOrderWasDelivered' => [
			'App\Listeners\EmailBuyerOrderDeliveredNotification',
			'App\Listeners\CaptureAuthorizedPaymentFromBuyer',
			'App\Listeners\CreatePayoutToSellers',
		],

        'App\Events\BuyerOrderWasCancelled' => [
            'App\Listeners\EmailBuyerOrderCancelledNotification',
			'App\Listeners\VoidAuthorizedPayment',
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
            'App\Listeners\EmailSellerOrderCancellationToSeller',
		],

		// Donation
		'App\Events\DonationWasCreated' => [
			// to stuvi
			'App\Listeners\EmailDonationPickupNotification',
		],

		'App\Events\DonationWasAssignedToCourier' => [
			// to donator
			'App\Listeners\EmailDonationReadyToPickupNotification',
		],

		// contact
		'App\Events\ContactMessageWasCreated' => [
			'App\Listeners\EmailContactMessageToStaff',
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
