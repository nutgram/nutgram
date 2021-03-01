---
sort: 3
---

# Laravel Integration

If you are using the Laravel framework, much of the setup is handled automatically by the framework. In you `.env` file,
you should only define the `TELEGRAM_TOKEN` var, that's it!

```bash
TELEGRAM_TOKEN="api-telegram-token"
```

The framework instance, is available anywhere via the DI container, for example:

```php
<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use SergiX44\Nutgram\Nutgram;

class TelegramController extends Controller
{
    /**
     * Handle the request.
     */
    public function handle()
    {
        $bot = app(Nutgram::class); // also app('nutgram') is a valid alias
        
        // do some stuff with your instance      
    }
}
```

```tip
When calling the `run()` method on the bot instance, it automatically recognize if use the `Polling` method to retrieve updates,
or `Webhook`, based on whether the current instance is running in a cli process, or is serving a web request.
```

## Vendor publish

To expose the undelying configuration, you need to publish the configuration file:

```bash
php artisan vendor:publish --provider="SergiX44\Nutgram\NutgramServiceProvider" --tag="config"
```

In the `config/nutgram.php` file, you will find something like that:

```php
<?php

return [
    // The Telegram BOT api token
    'token' => env('TELEGRAM_TOKEN'),
    // Extra or specific configurations
    'config' => [],
];
```

The second `config` array, is basically any configuration option, already
explained [here](installation.md#configuration).

## Advanced configuration

The framework give you free choice on how to use it, you can simply use it to send notifications, or build a full
featured bot. In the second case, I would recommend a Laravel-like setup, so first of all, create a new service
provider:

```bash
php artisan make:provider TelegramServiceProvider
```

Remeber to registering it in the `config/app.php`, and change the `boot` method of the provider in this way (also, we
don't actually need the `register`):

```php
<?php


namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use SergiX44\Nutgram\Nutgram;

class TelegramServiceProvider extends ServiceProvider
{
    /**
     * Load bot commands and callbacks
     */
    public function boot()
    {
        /** @var Nutgram $bot */
        $bot = $this->app['nutgram'];
        require base_path('routes/telegram.php');
    }
}
```

As you can see from the code, you should also create a new file called `routes/telegram.php`, where you will put all the
callbacks, similar to the Laravel route file:

```php
<?php
/** @var SergiX44\Nutgram\Nutgram $bot */

// here is where you will put all your callbacks definitions, like
$bot->onCommand('start', MyStartCommand::class);
```

And that it! Now every time you call your bot instance, it will always have all the callback definitions loaded. In this
way, you can call it from you a front controller...

```php
class FrontController extends Controller
{
    /**
     * Handle the telegram webhook request.
     */
    public function handle()
    {
        app(Nutgram::class)->run();
    }
}
```

... or in a CLI command:

```php
class MyCommand extends Command
{
    /**
    * The name and signature of the console command.
    *
    * @var string
    */
    protected $signature = 'bot:polling';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Start the bot in long polling mode';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        app(Nutgram::class)->run();
    }

}
```