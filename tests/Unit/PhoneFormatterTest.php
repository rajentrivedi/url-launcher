<?php

use Nativephp\UrlLauncher\Support\PhoneFormatter;

it('formats phone numbers correctly', function () {
    expect(PhoneFormatter::format('+1 (234) 567-890'))->toBe('+1234567890');
    expect(PhoneFormatter::format('123 abc 456'))->toBe('123456');
    expect(PhoneFormatter::format('++123--456'))->toBe('++123456'); // Leaves pluses
});
