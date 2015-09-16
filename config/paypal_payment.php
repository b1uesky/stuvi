<?php

return [
	# Account credentials from developer portal
	'Account' => [
		'ClientId'     => env('PAYPAL_CLIENT_ID'),
		'ClientSecret' => env('PAYPAL_CLIENT_SECRET'),
	],

	# Connection Information
	'http'    => [
		// 'ConnectionTimeOut' => 30,
		'Retry' => 1,
		//'Proxy' => 'http://[username:password]@hostname[:port][/path]',
	],

	'mode'    => 'sandbox',

	# Service Configuration
	'service' => [
		# Live endpoint:    https://api.paypal.com
		# Sandbox endpoint: https://api.sandbox.paypal.com
		'EndPoint' => 'https://api.sandbox.paypal.com',
	],


	# Logging Information
	'log'     => [
		//'LogEnabled' => true,

		# When using a relative path, the log file is created
		# relative to the .php file that is the entry point
		# for this request. You can also provide an absolute
		# path here
		//'FileName' => '../PayPal.log',

		# Logging level can be one of FINE, INFO, WARN or ERROR
		# Logging is most verbose in the 'FINE' level and
		# decreases as you proceed towards ERROR
		//'LogLevel' => 'FINE',
	],
];
