# NativePHP Mobile URL Launcher

A NativePHP Mobile plugin for communicating with device functionalities like the browser, phone dialer, SMS, map apps, and deep linking schemes.

Similar to Flutter's `url_launcher`, but tailored for NativePHP mobile.

Browser functionalities are already provided by NativePHP, so this plugin is only for other functionalities, for browser functionalities use 
## Browser functionalities

```php
composer require nativephp/mobile-browser
```

## Requirements

- PHP 8.2+
- Laravel 11+
- NativePHP Mobile ^3.0

## Installation

```bash
composer require rajen/nativephp-url-launcher
```

Publish the configuration file:

```bash
php artisan vendor:publish --tag="nativephp-url-launcher-config"
```

## Basic Usage

The plugin exposes a Laravel Facade, making it extremely easy to use:

```php
use Rajen\UrlLauncher\Facades\UrlLauncher;


// Send an email
UrlLauncher::openEmail('hello@nativephp.com', 'Support Request', 'Hello from my app!');

// Dial a phone number
UrlLauncher::openPhone('+1234567890');

// Send an SMS
UrlLauncher::openSms('+1234567890', 'Please reply to this message.');

// Open WhatsApp
UrlLauncher::openWhatsApp('+1234567890', 'Hello!');

// Open Maps
UrlLauncher::openMap('London, UK');

// Open custom app deep link
UrlLauncher::openCustomScheme('myapp://product/123');

// Check if a URL can be launched
if (UrlLauncher::canLaunch('twitter://user?screen_name=NativePHP')) {
    UrlLauncher::launch('twitter://user?screen_name=NativePHP');
}
```

## Deep Linking Configuration

If your app needs to trigger external deep links (e.g. `twitter://`, `whatsapp://`) or needs to handle returns back into your app via Custom Schemes (`myapp://`), you must configure the native project manifests.

### Android Setup (`AndroidManifest.xml`)

Add the following `<queries>` to your manifest if you are targeting Android 11+ to `canLaunch` other apps:

```xml
<manifest package="com.your.app">
    <queries>
        <!-- For WhatsApp -->
        <package android:name="com.whatsapp" />
        
        <!-- For Emails -->
        <intent>
            <action android:name="android.intent.action.SENDTO" />
            <data android:scheme="mailto" />
        </intent>

        <!-- For Custom apps -->
        <intent>
            <action android:name="android.intent.action.VIEW" />
            <data android:scheme="twitter" />
        </intent>
    </queries>
</manifest>
```

### iOS Setup (`Info.plist`)

For iOS, you need to whitelist URL schemes your app wants to open using `LSApplicationQueriesSchemes`.

Add this to your `Info.plist`:

```xml
<key>LSApplicationQueriesSchemes</key>
<array>
    <string>whatsapp</string>
    <string>twitter</string>
    <string>mailto</string>
    <string>tel</string>
    <string>sms</string>
</array>
```

## Listening for Returns / Deep Links

You can listen to URL Launcher events using standard Laravel Event listeners:

- `Rajen\UrlLauncher\Events\UrlLaunched`
- `Rajen\UrlLauncher\Events\UrlLaunchFailed`
- `Rajen\UrlLauncher\Events\DeepLinkReceived`
- `Rajen\UrlLauncher\Events\UrlLaunchCompleted`
- `Illuminate\Support\Facades\Event`

Example:

```php
use Rajen\UrlLauncher\Events\UrlLaunched;
use Rajen\UrlLauncher\Events\UrlLaunchFailed;
use Rajen\UrlLauncher\Events\DeepLinkReceived;
use Rajen\UrlLauncher\Events\UrlLaunchCompleted;
use Illuminate\Support\Facades\Event;

Event::listen(function (DeepLinkReceived $event) {
    // do something
});
```
```

## License

MIT

```markdown
## Support

For bug reports and feature requests, please open an issue on GitHub.

For private inquiries, contact:
- 📧 [laravel.rajen@gmail.com](mailto:laravel.rajen@gmail.com)
*[Markdown Guide](https://www.markdownguide.org)*
```