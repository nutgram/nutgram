---
sort: 4
---

# Getting Updates

Currently, the framework mainly supports two different methods to process updates: `Polling` and `Webhook` mode.

- **Polling**: mainly useful for small bots or with not much traffic, but especially for development mode, since it
  allows you to start developing a bot in a short time!
- **Webhook**: Strongly recommended for bots with high traffic and more generally for production mode.

To begin to process incoming updates, you must call the `->run()` method, at the end:

```php
use SergiX44\Nutgram\Nutgram;

$bot = new Nutgram($_ENV['TOKEN']); // new instance

// register callbacks
// middlewares
// do your stuff

$bot->run(); // finally, begin to process incoming updates
```

## Polling

This is the **default** running mode, when the `->run()` method is called, will block the script execution aand starts
the update loop. This is meant to be used on a CLI or in a service unit.

```php
use SergiX44\Nutgram\Nutgram;
use SergiX44\Nutgram\RunningMode\Polling;

$bot = new Nutgram($_ENV['TOKEN']); // new instance
$bot->setRunningMode(Polling::class);

// ...

$bot->run(); // start to listen to updates, until stopped
```

## Webhook

This update mode is recommended for deploy your bot to production, but can be also used with [ngrok](https://ngrok.com) or [expose](https://beyondco.de/docs/expose/introduction) for
development, the only difference is that it requires the webhook set manually.

```php
use SergiX44\Nutgram\Nutgram;
use SergiX44\Nutgram\RunningMode\Webhook;

$bot = new Nutgram($_ENV['TOKEN']); // new instance
$bot->setRunningMode(Webhook::class);

// ...

$bot->run(); // after this, the script continues execution 
```

After processing the current update, the script continues execution, **BUT** you shouldn't put long operations after the
method anyway, as Telegram expects a response quickly.

## Customization

You can create your own running mode, if these do not satisfy you, in fact, you will just create a class that extends
the [`RunningMode`](https://github.com/SergiX44/Nutgram/blob/master/src/RunningMode/RunningMode.php) interface.

## Retrieving updates manually

You can also use the low level telegram methods, and take over the whole update management, like in the example:

```php
use SergiX44\Nutgram\Nutgram;
use SergiX44\Nutgram\Telegram\Types\Update;

$bot = new Nutgram($_ENV['TOKEN']);

// Retrieve te list of pending updates..
$updates = $bot->getUpdates();

/** @var Update $update */
foreach ($updates as $update) {
    // do stuff with your updates
}
```