<?php

namespace Rajen\UrlLauncher\Events;

use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class UrlLauncherCompleted
{
    use Dispatchable, SerializesModels;

    public function __construct(
        public string $result,
        public ?string $id = null
    ) {}
}