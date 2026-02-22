<?php

namespace Rajen\UrlLauncher\Events;

use Illuminate\Foundation\Events\Dispatchable;

class DeepLinkReceived
{
    use Dispatchable;

    public string $url;

    public function __construct(string $url)
    {
        $this->url = $url;
    }
}
