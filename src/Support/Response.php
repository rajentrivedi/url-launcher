<?php

namespace Rajen\NativePhpUrlLauncher\Support;

class Response
{
    /**
     * Helper to uniformly format the bridge response.
     */
    public static function make(bool $success, ?string $message = null): array
    {
        $platform = null;
        if (class_exists(\Native\Mobile\System::class)) {
            $system = new \Native\Mobile\System();
            $platform = $system->isIos() ? 'ios' : ($system->isAndroid() ? 'android' : 'unknown');
        }

        return [
            'success' => $success,
            'platform' => $platform,
            'message' => $message,
        ];
    }
}
