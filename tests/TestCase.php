<?php

namespace Tests;

use Orchestra\Testbench\TestCase as BaseTestCase;
use Rajen\UrlLauncher\UrlLauncherServiceProvider;

abstract class TestCase extends BaseTestCase
{
    protected function getPackageProviders($app): array
    {
        return [
            UrlLauncherServiceProvider::class,
        ];
    }
}
