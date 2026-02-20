<?php

namespace Nativephp\UrlLauncher\Events;

use Illuminate\Foundation\Events\Dispatchable;

class UrlLaunchFailed
{
    use Dispatchable;

    public string $url;
    public string $reason;

    public function __construct(string $url, string $reason = '')
    {
        $this->url = $url;
        $this->reason = $reason;
    }
}
