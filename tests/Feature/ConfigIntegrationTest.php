<?php

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Log;
use Rajen\UrlLauncher\Bridge\MobileBridge;
use Rajen\UrlLauncher\Drivers\AndroidDriver;
use Rajen\UrlLauncher\Support\UrlValidator;

it('respects allowed_schemes from configuration', function () {
    // Initial state (default schemes)
    expect(UrlValidator::isValidScheme('custom://test'))->toBeFalse();

    // Dynamically update config
    Config::set('nativephp-mobile-url-launcher.allowed_schemes', ['custom']);
    
    expect(UrlValidator::isValidScheme('custom://test'))->toBeTrue();
    expect(UrlValidator::isValidScheme('https://test'))->toBeFalse();
});

it('respects enable_logging configuration', function () {
    // Logging disabled (default)
    Config::set('nativephp-mobile-url-launcher.enable_logging', false);
    Log::shouldReceive('info')->never();
    Log::shouldReceive('warning')->never();
    
    MobileBridge::call('Test.Method', ['foo' => 'bar']);

    // Logging enabled
    Config::set('nativephp-mobile-url-launcher.enable_logging', true);
    Log::shouldReceive('info')->once()->with("UrlLauncher Native Call: Test.Method", ['foo' => 'bar']);
    Log::shouldReceive('warning')->once(); // nativephp_call doesn't exist
    
    MobileBridge::call('Test.Method', ['foo' => 'bar']);
});

it('respects default_mode configuration in drivers', function () {
    Config::set('nativephp-mobile-url-launcher.enable_logging', true);
    $driver = new AndroidDriver();

    // Default mode should be 'external'
    Config::set('nativephp-mobile-url-launcher.default_mode', 'external');
    Log::shouldReceive('info')->with("UrlLauncher Native Call: UrlLauncher.Execute", Mockery::on(function ($payload) {
        return ($payload['mode'] ?? null) === 'external';
    }))->once();
    Log::shouldReceive('warning')->once();
    
    $driver->launch('https://example.com');

    // Change to 'in_app'
    Config::set('nativephp-mobile-url-launcher.default_mode', 'in_app');
    Log::shouldReceive('info')->with("UrlLauncher Native Call: UrlLauncher.Execute", Mockery::on(function ($payload) {
        return ($payload['mode'] ?? null) === 'in_app';
    }))->once();
    Log::shouldReceive('warning')->once();
    
    $driver->launch('https://example.com');

    // Manual override in options
    Log::shouldReceive('info')->with("UrlLauncher Native Call: UrlLauncher.Execute", Mockery::on(function ($payload) {
        return ($payload['mode'] ?? null) === 'external';
    }))->once();
    Log::shouldReceive('warning')->once();
    
    $driver->launch('https://example.com', ['mode' => 'external']);
});
