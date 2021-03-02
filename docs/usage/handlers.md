---
sort: 6
---

# Handlers

## Concept

The framework provides to you a nice API event-like to handling incoming updates:

```php
use SergiX44\Nutgram\Nutgram;

$bot = new Nutgram($_ENV['TOKEN']);

$bot->onMessage(function (Nutgram $bot) {
    $bot->sendMessage('You sent a message!');
});

$bot->run();
```

Every `->on*` handler is called based on the update type defined
in [Telegram's update object](https://core.telegram.org/bots/api#update), there are also some specific handlers, which
may respond based on specific patterns or types of messages.

As you can also see from the example above, some required parameters (like the `chat_id`) can be **omitted**, while the
bot is in the context of managing an update, so those fields **are automatically extracted from the current update**.

Of course, **you can override them at any time**, simply by specifying them in the `$opt` array.

## Specific handlers

### Commands

It's possible to listen to specific commands, also with named parameters:

```php
use SergiX44\Nutgram\Nutgram;

$bot = new Nutgram($_ENV['TOKEN']);

// Called when a message contains the command "/start someParameter"
$bot->onCommand('start {parameter}', function (Nutgram $bot, $parameter) {
    $bot->sendMessage("The parameter is {$parameter}");
});

// Called on command "/help"
$bot->onCommand('help', function (Nutgram $bot) {
   $bot->sendMessage('Help me!');
});

$bot->run();
```

## Passing and caching data

## Update Helpers

## Available Handlers

```danger
This documentation page is currently under development!
```