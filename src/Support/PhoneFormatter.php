<?php

namespace Rajen\NativePhpUrlLauncher\Support;

class PhoneFormatter
{
    /**
     * Remove everything except plus sign and digits from a phone number.
     */
    public static function format(string $phoneNumber): string
    {
        return preg_replace('/[^\d+]/', '', $phoneNumber);
    }
}
