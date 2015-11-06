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

		/*
		|--------------------------------------------------------------------------
		| User events
		|--------------------------------------------------------------------------
		*/

		'App\Events\UserWasSignedUp' => [
			'App\Listeners\EmailSignedUpConfirmationToUser',
		],

		'App\Events\UserEmailWasAdded' => [
			'App\Listeners\EmailNewEmailAddedConfirmationToUser',
		],

		'App\Events\UserPasswordWasChanged' => [
			'App\Listeners\EmailPasswordChangedNotificationToUser',
		],

		/*
		|--------------------------------------------------------------------------
		| Product events
		|--------------------------------------------------------------------------
		*/

		// product that sells to user
		'App\Events\ProductIsAvailableSoon' => [
			'App\Listeners\EmailProductAvailableSoonNotificationToSeller',
		],

		// product that can trade in to Stuvi
		'App\Events\ProductWasUpdatedPriceAndApproved' => [
			'App\Listeners\EmailProductUpdatedPriceAndApprovedNotificationToSeller',
		],

		'App\Events\ProductWasRejected' => [
			'App\Listeners\EmailProductRejectedNotificationToSeller',
		],

		/*
		|--------------------------------------------------------------------------
		| Buyer order events
		|--------------------------------------------------------------------------
		*/

		'App\Events\BuyerOrderWasPlaced' => [
			'App\Listeners\EmailBuyerOrderConfirmationToBuyer',
			'App\Listeners\MessageBuyerOrderPlacedNotificationToStuvi',
		],

		'App\Events\BuyerOrderWasDeliverable' => [
			'App\Listeners\EmailBuyerOrderDeliverableNotificationToBuyer',
		],

		'App\Events\BuyerOrderDeliveryWasScheduled' => [
			'App\Listeners\EmailBuyerOrderDeliveryScheduledNotificationToStuvi',
		],

		'App\Events\BuyerOrderWasShipped' => [
			'App\Listeners\EmailBuyerOrderShippedNotificationToBuyer',
		],

		'App\Events\BuyerOrderWasDelivered' => [
			'App\Listeners\EmailBuyerOrderDeliveredNotificationToBuyer',
			'App\Listeners\CapturePaypalAuthorizedPaymentFromBuyer',
			'App\Listeners\CreatePaypalPayoutToSellers',
		],

        'App\Events\BuyerOrderWasCancelled' => [
            'App\Listeners\EmailBuyerOrderCancelledNotificationToBuyer',
			'App\Listeners\VoidPaypalAuthorizedPaymentOfBuyerOrder',
        ],

		/*
		|--------------------------------------------------------------------------
		| Seller order events
		|--------------------------------------------------------------------------
		*/

		'App\Events\SellerOrderWasCreated' => [
			'App\Listeners\EmailSellerOrderConfirmationToSeller',
		],

		'App\Events\SellerOrderPickupWasScheduled' => [
			'App\Listeners\EmailSellerOrderPickupScheduledConfirmationToSeller',
			'App\Listeners\EmailSellerOrderPickupScheduledNotificationToStuvi',
		],

		'App\Events\SellerOrderWasAssignedToCourier' => [
			'App\Listeners\EmailSellerOrderReadyToPickupNotificationToSeller',
		],

		'App\Events\SellerOrderWasCancelled' => [
			'App\Listeners\MessageSellerOrderCancelledToCourier',
			'App\Listeners\EmailSellerOrderCancelledToBuyer',
            'App\Listeners\EmailSellerOrderCancelledToSeller',
		],

		/*
		|--------------------------------------------------------------------------
		| Donation events
		|--------------------------------------------------------------------------
		*/

		'App\Events\DonationWasCreated' => [
			'App\Listeners\EmailDonationPickupNotificationToStuvi',
		],

		'App\Events\DonationWasAssignedToCourier' => [
			'App\Listeners\EmailDonationReadyToPickupNotificationToDonator',
		],

		/*
		|--------------------------------------------------------------------------
		| Contact events
		|--------------------------------------------------------------------------
		*/

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
