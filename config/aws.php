<?php

return [

    /*
    |--------------------------------------------------------------------------
    | AWS SDK Configuration
    |--------------------------------------------------------------------------
    |
    | The configuration options set in this file will be passed directly to the
    | `Aws\Sdk` object, from which all client objects are created. The minimum
    | required options are declared here, but the full set of possible options
    | are documented at:
    | http://docs.aws.amazon.com/aws-sdk-php/v3/guide/guide/configuration.html
    |
    */
    'credentials' => [
        'key'    => env('AWS_KEY'),
        'secret' => env('AWS_SECRET'),
    ],
    'region' => env('AWS_REGION'),
    'version' => 'latest',

    'url' => [
        'domain' => 'https://s3.amazonaws.com/',

        // buckets
        'stuvi-product-img' => 'https://s3.amazonaws.com/stuvi-product-img/',
        'stuvi-book-img'    => 'https://s3.amazonaws.com/stuvi-book-img/'
    ],

    'buckets' => [
        'product_image' =>  'stuvi-product-img',
        'book_image'    =>  'stuvi-book-img'
    ],
];
