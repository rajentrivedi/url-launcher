<?php

it('has a valid configuration structure in the application', function () {
    $config = config('nativephp-mobile-url-launcher');

    expect($config)->toBeArray();
    expect($config)->toHaveKeys([
        'default_mode',
        'allowed_schemes',
        'enable_logging',
    ]);
});

it('has correct default values in the application', function () {
    $config = config('nativephp-mobile-url-launcher');

    expect($config['default_mode'])->toBe('external');
    expect($config['allowed_schemes'])->toBe([
        'http',
        'https',
        'mailto',
        'tel',
        'sms',
        'geo',
        'whatsapp',
    ]);
    expect($config['enable_logging'])->toBeFalse();
});

it('can access config through direct file require', function () {
    $config = require __DIR__ . '/../../config/nativephp-mobile-url-launcher.php';

    expect($config)->toBeArray();
    expect($config['default_mode'])->toBe('external');
});
