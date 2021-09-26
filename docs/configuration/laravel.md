---
sort: 3
---

# Laravel Integration

If you are using the Laravel framework, much of the setup is handled automatically for you. First, you should install
the package via composer as usual (see [the installation page](installation.md#composer))

In you `.env` file, you should only define the `TELEGRAM_TOKEN` var, that's it!

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

## Configuration

To expose the undelying configuration, you need to publish the configuration file:

```bash
php artisan vendor:publish --provider="SergiX44\Nutgram\NutgramServiceProvider" --tag="nutgram"
```

In the `config/nutgram.php` file, you will find something like that:

```php
return [
    // The Telegram BOT api token
    'token' => env('TELEGRAM_TOKEN', ''),

    // Extra or specific configurations
    'config' => [],

    // Set if the service provider should automatically load
    // handlers from /routes/telegram.php
    'routes' => true,
];
```

The second `config` array, is basically any configuration option, already
explained [here](installation.md#configuration).

The third `routes`, set if the service provider should load the handlers form the folder `routes/telegram.php`, by
default is `true`.

## Commands

The framework automatically register some useful commands in your Laravel application:

- `nutgram:hook:info`
    - Get current webhook status
- `nutgram:hook:remove {--d|drop-pending-updates}`
    - Remove the bot webhook
- `nutgram:hook:set {url}`
    - Set the bot webhook
- `nutgram:register-commands`
    - Register the bot commands, see [automatically-register-bot-commands](../usage/handlers.md#automatically-register-bot-commands)
- `nutgram:run`
    - Start the bot in long polling mode. Useful in development mode.

## Handlers definition

The `routes/telegram.php` should be something like this:

```php
<?php
/** @var SergiX44\Nutgram\Nutgram $bot */

use SergiX44\Nutgram\Nutgram;

/*
|--------------------------------------------------------------------------
| Nutgram Handlers
|--------------------------------------------------------------------------
|
| Here is where you can register telegram handlers for Nutgram. These
| handlers are loaded by the NutgramServiceProvider. Enjoy!
|
*/

$bot->onCommand('start', function (Nutgram $bot) {
    return $bot->sendMessage('Hello, world!');
})->description('The start command!');
```

This file is automatically loaded by the framework, so here is where you should define middleware, handlers and
conversations.

## Webhook updates

For production mode, the webhook mode is recommended. Run the bot in that way is really simple, you should just create a
new controller `php artisan make:controller FrontController`, and call the `run` method on the bot instance:

```php
class FrontController extends Controller
{
    /**
     * Handle the telegram webhook request.
     */
    public function __invoke()
    {
        app(Nutgram::class)->run();
    }
}
```

and remember to register it on you http routes:

```php
// routes/api.php

Route::post('/webhook', 'FrontController');
```