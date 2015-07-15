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
        'key'    => 'AKIAJ73QMJH63KMVTB5A',
        'secret' => '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',
    ],
    'region' => env('AWS_REGION', 'us-east-1'),
    'version' => 'latest',
    'url' => [
        'domain' => 'https://s3.amazonaws.com/',
        'image' => 'https://s3.amazonaws.com/stuvi-images/'
    ],

    /*
    |--------------------------------------------------------------------------
    | AWS S3 buckets name
    |--------------------------------------------------------------------------
    |
    */
    'buckets' => [
        'image' => 'stuvi-images'
    ],

    /*
    |--------------------------------------------------------------------------
    | AWS S3 object path
    |--------------------------------------------------------------------------
    |
    | The relative path of objects on S3.
    */
    'path' => [
        'textbook'  => [
            'book'      => 'textbook/book/',
            'product'   => 'textbook/product/'
        ]
    ]



];
