<?php

return [

	/*
	|--------------------------------------------------------------------------
	| Third Party Services
	|--------------------------------------------------------------------------
	|
	| This file is for storing the credentials for third party services such
	| as Stripe, Mailgun, Mandrill, and others. This file provides a sane
	| default location for this type of information, allowing packages
	| to have a conventional place to find your various credentials.
	|
	*/

	'mailgun' => [
		'domain' => '',
		'secret' => '',
	],

	'mandrill' => [
		'secret' => 'T1oq1a251BfoXUTRz8RlXw',
	],

	'ses' => [
		'key' => '',
		'secret' => '',
		'region' => 'us-east-1',
	],

    'stripe' => [
        'secret' => 'sk_test_1z2tEIbWtbZVvpWnnzgfymyC',
    ],

	// Amazon Product Advertising API credentials
	'amazon' => [
		'access_key_id'     =>  'AKIAICSPEAJYPA3CBSNQ',
		'secret_access_key' =>  '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',
		'associate_id'      =>  'stuvi07-20',
	],

    'isbndb' => [
        'token' => 'YPKFSSUW'// api key for isbndb.com
    ]
];
