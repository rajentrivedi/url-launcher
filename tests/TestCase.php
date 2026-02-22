<?php

namespace Rajen\NativePhpUrlLauncher\Tests;

use Orchestra\Testbench\TestCase as BaseTestCase;
use Rajen\NativePhpUrlLauncher\UrlLauncherServiceProvider;

abstract class TestCase extends BaseTestCase
{
    protected function getPackageProviders($app): array
    {
        return [
            UrlLauncherServiceProvider::class,
        ];
    }
}
