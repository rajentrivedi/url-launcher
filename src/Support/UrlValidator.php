<?php

namespace Rajen\UrlLauncher\Support;

class UrlValidator
{
    /**
     * Check if a URL has a valid scheme against the allowed config schemes.
     */
    public static function isValidScheme(string $url, array $allowedSchemes = []): bool
    {
        $parsed = parse_url($url);
        
        if ($parsed === false || !isset($parsed['scheme'])) {
            return false;
        }

        $scheme = strtolower($parsed['scheme']);

        if (empty($allowedSchemes)) {
            if (function_exists('config')) {
                $allowedSchemes = config('nativephp-mobile-url-launcher.allowed_schemes', ['http', 'https', 'mailto', 'tel', 'sms', 'geo', 'whatsapp']);
            } else {
                $allowedSchemes = ['http', 'https', 'mailto', 'tel', 'sms', 'geo', 'whatsapp'];
            }
        }

        return in_array($scheme, $allowedSchemes, true);
    }
}
