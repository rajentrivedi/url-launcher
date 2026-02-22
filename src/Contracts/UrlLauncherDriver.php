<?php

namespace Rajen\NativePhpUrlLauncher\Contracts;

interface UrlLauncherDriver
{
    /**
     * Open a URL.
     */
    public function launch(string $url, array $options = []): array;

    /**
     * Check if a URL can be launched.
     */
    public function canLaunch(string $url): bool;

    /**
     * Launch email app.
     */
    public function openEmail(string $email, string $subject = '', string $body = ''): array;

    /**
     * Launch phone dialer.
     */
    public function openPhone(string $phoneNumber): array;

    /**
     * Launch SMS app.
     */
    public function openSms(string $phoneNumber, string $message = ''): array;

    /**
     * Launch WhatsApp.
     */
    public function openWhatsApp(string $phoneNumber, string $message = ''): array;

    /**
     * Open a map with given coordinates or query.
     */
    public function openMap(string $query): array;


    /**
     * Open a custom scheme (deep link).
     */
    public function openCustomScheme(string $url): array;
}
