<?php

return array(

    /*
    |--------------------------------------------------------------------------
    | Image Driver
    |--------------------------------------------------------------------------
    |
    | Intervention Image supports "GD Library" and "Imagick" to process images
    | internally. You may choose one of them according to your PHP
    | configuration. By default PHP's "GD Library" implementation is used.
    |
    | Supported: "gd", "imagick"
    |
    */

    'driver' => 'gd',

    'resize' => [
        'small'     => [
            'height'     => 100
        ],
        'medium'    => [
            'height'    => 340
        ],
        'large'     => [
            'height'    => 768
        ]
    ],

    /*
     * Temporary path to store images.
     */
    'temp_path' => storage_path() . '/temp/',

    'debug' => true,

    'lazyload' => 'data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw=='

);
