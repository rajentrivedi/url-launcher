<?php

use Rajen\UrlLauncher\Support\UrlValidator;

it('validates allowed schemes correctly', function () {
    // Default allowed schemes (http, https, mailto, tel, sms, geo, whatsapp)
    expect(UrlValidator::isValidScheme('https://example.com'))->toBeTrue();
    expect(UrlValidator::isValidScheme('mailto:test@example.com'))->toBeTrue();
    expect(UrlValidator::isValidScheme('tel:+1234567890'))->toBeTrue();
    
    // Invalid schemes by default
    expect(UrlValidator::isValidScheme('ftp://example.com'))->toBeFalse();
    expect(UrlValidator::isValidScheme('file:///etc/passwd'))->toBeFalse();
    expect(UrlValidator::isValidScheme('javascript:alert(1)'))->toBeFalse();
    
    // Custom allowed schemes
    expect(UrlValidator::isValidScheme('myapp://product/123', ['myapp']))->toBeTrue();
    expect(UrlValidator::isValidScheme('myapp://product/123', ['http', 'https']))->toBeFalse();
});
