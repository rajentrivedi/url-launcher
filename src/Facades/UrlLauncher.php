<?php

namespace Rajen\NativePhpUrlLauncher\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static array launch(string $url, array $options = [])
 * @method static bool canLaunch(string $url)
 * @method static array openEmail(string $email, string $subject = '', string $body = '')
 * @method static array openPhone(string $phoneNumber)
 * @method static array openSms(string $phoneNumber, string $message = '')
 * @method static array openWhatsApp(string $phoneNumber, string $message = '')
 * @method static array openMap(string $query)
 * @method static array openInAppBrowser(string $url)
 * @method static array openCustomScheme(string $url)
 *
 * @see \Rajen\NativePhpUrlLauncher\UrlLauncher
 */
class UrlLauncher extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \Rajen\NativePhpUrlLauncher\UrlLauncher::class;
    }
}