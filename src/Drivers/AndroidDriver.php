<?php

namespace Nativephp\UrlLauncher\Drivers;

use Nativephp\UrlLauncher\Bridge\MobileBridge;
use Nativephp\UrlLauncher\Contracts\UrlLauncherDriver;
use Nativephp\UrlLauncher\Events\UrlLaunched;
use Nativephp\UrlLauncher\Support\PhoneFormatter;
use Nativephp\UrlLauncher\Support\Response;
use Nativephp\UrlLauncher\Support\UrlValidator;

class AndroidDriver implements UrlLauncherDriver
{
    public function launch(string $url, array $options = []): array
    {
        if (!UrlValidator::isValidScheme($url)) {
            return MobileBridge::fail($url, "Invalid scheme or not allowed.");
        }

        $payload = array_merge(['url' => $url, 'action' => 'launch'], $options);
        $result = MobileBridge::call('UrlLauncher.Execute', $payload);

        UrlLaunched::dispatch($url, $options);

        if ($result && ($decoded = json_decode($result, true))) {
            return Response::make($decoded['success'] ?? false, $decoded['message'] ?? null);
        }

        return Response::make(false, 'Native call failed or returned null');
    }

    public function canLaunch(string $url): bool
    {
        if (!UrlValidator::isValidScheme($url)) {
            return false;
        }

        $result = MobileBridge::call('UrlLauncher.Execute', ['url' => $url, 'action' => 'canLaunch']);

        if ($result && ($decoded = json_decode($result, true))) {
            return $decoded['success'] ?? false;
        }

        return false;
    }

    public function openEmail(string $email, string $subject = '', string $body = ''): array
    {
        $query = http_build_query(['subject' => $subject, 'body' => $body]);
        $url = "mailto:{$email}" . (!empty($query) ? '?' . $query : '');

        return $this->launch($url);
    }

    public function openPhone(string $phoneNumber): array
    {
        $formatted = PhoneFormatter::format($phoneNumber);
        return $this->launch("tel:{$formatted}");
    }

    public function openSms(string $phoneNumber, string $message = ''): array
    {
        $formatted = PhoneFormatter::format($phoneNumber);
        $query = http_build_query(['body' => $message]);
        $url = "sms:{$formatted}" . (!empty($query) ? '?' . $query : '');

        return $this->launch($url);
    }

    public function openWhatsApp(string $phoneNumber, string $message = ''): array
    {
        $formatted = PhoneFormatter::format($phoneNumber);
        $query = http_build_query(['phone' => $formatted, 'text' => $message]);
        return $this->launch("whatsapp://send?{$query}");
    }

    public function openMap(string $query): array
    {
        // Android maps intent
        $encodedQuery = urlencode($query);
        return $this->launch("geo:0,0?q={$encodedQuery}");
    }


    public function openCustomScheme(string $url): array
    {
        // Temporarily bypass config validator (which might not contain the custom scheme)
        $payload = ['url' => $url, 'action' => 'launch'];
        $result = MobileBridge::call('UrlLauncher.Execute', $payload);
        
        UrlLaunched::dispatch($url, []);

        if ($result && ($decoded = json_decode($result, true))) {
            return Response::make($decoded['success'] ?? false, $decoded['message'] ?? null);
        }

        return Response::make(false, 'Native call failed or returned null');
    }
}
