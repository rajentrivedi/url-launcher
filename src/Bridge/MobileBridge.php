<?php

namespace Nativephp\UrlLauncher\Bridge;

use Illuminate\Support\Facades\Log;
use Nativephp\UrlLauncher\Events\UrlLaunchFailed;

class MobileBridge
{
    /**
     * Call the native side via nativephp_call.
     */
    public static function call(string $method, array $payload = []): ?string
    {
        if (config('nativephp-mobile-url-launcher.enable_logging', false)) {
            Log::info("UrlLauncher Native Call: {$method}", $payload);
        }

        if (function_exists('nativephp_call')) {
            $result = nativephp_call($method, json_encode($payload));

            if (config('nativephp-mobile-url-launcher.enable_logging', false)) {
                Log::info("UrlLauncher Native Response: {$method}", ['result' => $result]);
            }

            return $result ?: null;
        }

        if (config('nativephp-mobile-url-launcher.enable_logging', false)) {
            Log::warning("UrlLauncher: nativephp_call function does not exist. Are you running in NativePHP Mobile?");
        }

        return null;
    }

    /**
     * Dispatch failure and return uniform array.
     */
    public static function fail(string $url, string $reason): array
    {
        UrlLaunchFailed::dispatch($url, $reason);

        return \Nativephp\UrlLauncher\Support\Response::make(false, $reason);
    }
}
