<?php

namespace Rajen\UrlLauncher\Events;

use Illuminate\Foundation\Events\Dispatchable;

class UrlLaunched
{
    use Dispatchable;

    public string $url;
    public array $options;

    public function __construct(string $url, array $options = [])
    {
        $this->url = $url;
        $this->options = $options;
    }
}
