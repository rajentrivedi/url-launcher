## nativephp/url-launcher

A NativePHP Mobile plugin for communicating with device functionalities

### Installation

```bash
composer require nativephp/url-launcher
```

### PHP Usage (Livewire/Blade)

Use the `UrlLauncher` facade:

@verbatim
<code-snippet name="Using UrlLauncher Facade" lang="php">
use Nativephp\UrlLauncher\Facades\UrlLauncher;

// Execute the plugin functionality
$result = UrlLauncher::execute(['option1' => 'value']);

// Get the current status
$status = UrlLauncher::getStatus();
</code-snippet>
@endverbatim

### Available Methods

- `UrlLauncher::execute()`: Execute the plugin functionality
- `UrlLauncher::getStatus()`: Get the current status

### Events

- `UrlLauncherCompleted`: Listen with `#[OnNative(UrlLauncherCompleted::class)]`

@verbatim
<code-snippet name="Listening for UrlLauncher Events" lang="php">
use Native\Mobile\Attributes\OnNative;
use Nativephp\UrlLauncher\Events\UrlLauncherCompleted;

#[OnNative(UrlLauncherCompleted::class)]
public function handleUrlLauncherCompleted($result, $id = null)
{
    // Handle the event
}
</code-snippet>
@endverbatim

### JavaScript Usage (Vue/React/Inertia)

@verbatim
<code-snippet name="Using UrlLauncher in JavaScript" lang="javascript">
import { urlLauncher } from '@nativephp/url-launcher';

// Execute the plugin functionality
const result = await urlLauncher.execute({ option1: 'value' });

// Get the current status
const status = await urlLauncher.getStatus();
</code-snippet>
@endverbatim