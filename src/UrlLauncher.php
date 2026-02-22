<?php

namespace Rajen\UrlLauncher;

use Rajen\UrlLauncher\Contracts\UrlLauncherDriver;
use Rajen\UrlLauncher\Drivers\AndroidDriver;
use Rajen\UrlLauncher\Drivers\IOSDriver;
use Native\Mobile\System;

class UrlLauncher implements UrlLauncherDriver
{
    protected ?UrlLauncherDriver $driver = null;

    public function __construct()
    {
        $this->resolveDriver();
    }

    protected function resolveDriver(): void
    {
        if (class_exists(System::class)) {
            $system = new System();
            if ($system->isIos()) {
                $this->driver = new IOSDriver();
                return;
            } elseif ($system->isAndroid()) {
                $this->driver = new AndroidDriver();
                return;
            }
        }

        // Fallback for tests or unsupported platforms
        // In a real scenario, this could throw an exception or return a mock driver.
        $this->driver = new AndroidDriver();
    }

    public function launch(string $url, array $options = []): array
    {
        return $this->driver->launch($url, $options);
    }

    public function canLaunch(string $url): bool
    {
        return $this->driver->canLaunch($url);
    }

    public function openEmail(string $email, string $subject = '', string $body = ''): array
    {
        return $this->driver->openEmail($email, $subject, $body);
    }

    public function openPhone(string $phoneNumber): array
    {
        return $this->driver->openPhone($phoneNumber);
    }

    public function openSms(string $phoneNumber, string $message = ''): array
    {
        return $this->driver->openSms($phoneNumber, $message);
    }

    public function openWhatsApp(string $phoneNumber, string $message = ''): array
    {
        return $this->driver->openWhatsApp($phoneNumber, $message);
    }

    public function openMap(string $query): array
    {
        return $this->driver->openMap($query);
    }


    public function openCustomScheme(string $url): array
    {
        return $this->driver->openCustomScheme($url);
    }
}