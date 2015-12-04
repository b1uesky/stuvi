<?php

    return [

        # All prices in decimal format
        'shipping'          => 0,
        'discount'          => 0,
        'tax'               => 0.0625,
        'payout_service'    => 0,

        # US sent domestic Payouts sent over the Payouts API are priced at $0.25 USD flat per transaction.
        'paypal_payout_fee' => 0.25,

        # minimum book price that seller can set to
        'minimum_book_price'    => 1.00,
    ];
