<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Default Launch Mode
    |--------------------------------------------------------------------------
    |
    | When launching http or https URLs without specific options, should it
    | open in the standard external browser ('external') or inside an
    | in-app browser webview ('in_app')?
    |
    */
    'default_mode' => 'external', // 'external' or 'in_app'

    /*
    |--------------------------------------------------------------------------
    | Allowed Schemes
    |--------------------------------------------------------------------------
    |
    | Defines the URL schemes that are permitted to be launched. By default,
    | typical schemes like http, https, mailto, tel, sms, geo, whatsapp
    | are allowed. Custom deep link schemes can be added here.
    |
    */
    'allowed_schemes' => [
        'http',
        'https',
        'mailto',
        'tel',
        'sms',
        'geo',
        'whatsapp',
    ],

    /*
    |--------------------------------------------------------------------------
    | Enable Logging
    |--------------------------------------------------------------------------
    |
    | When enabled, NativePHP mobile bridge calls and responses will be
    | logged to your Laravel application logs for easier debugging.
    |
    */
    'enable_logging' => env('URL_LAUNCHER_LOGGING', false),

];
