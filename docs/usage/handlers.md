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

## Available Handlers

Here a full list of all the handler that listens to specific type of updates:

| Method | Return type |
| --- | --- |

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

## Update Helpers

When dealing with updates, sometimes you may need to access data that is nested in the update structure, which can be
tedious and produce *a lot* of boilerplate, since the same objects can often be nested in other objects, depending on
the type of update. For this reason, the framework provides a number of **support methods to quickly access the most
used data, no matter the update type**, like this:

```php
use SergiX44\Nutgram\Nutgram;

$bot = new Nutgram($_ENV['TOKEN']);

$bot->onCommand('help', function (Nutgram $bot) {
    // Get the Update object
    $bot->update();
    
    // Get the Message object
    $bot->message();
    
    // Access the Chat object
    $bot->chat();
    
    // ...
});

$bot->run();
```

### Available helpers

| Method | Return type |
| --- | --- |

## Persisting data

The framework gives you the ability to store data based on the update context: you can store data as **globally**
or **per-user**:

```php
use SergiX44\Nutgram\Nutgram;

$bot = new Nutgram($_ENV['TOKEN']);

$bot->setGlobalData('mykey', 'Hi!');
$bot->setUserData('mykey', 'Ciao!', $userId);

$value = $bot->getGlobalData('mykey'); // Hi!
$value = $bot->getUserData('mykey', $userId); // Ciao!

// when used inside a context, the $userId can be omitted.
$bot->onCommand('help', function (Nutgram $bot) {
    $bot->setUserData('mykey', 'called help!');
    $value = $bot->getUserData('mykey'); // called help!
    $bot->sendMessage('Help me!');
});

$bot->run();
```

```tip
If you need to persist data on disk, be sure to choose an appropriate cache adapter!
```

### Available methods

| Method | Return type |
| --- | --- |
| `getGlobalData($key, $default = null)` | The data associated to the `$key`, if null `$default` is returned. |
| `setGlobalData($key, $value)` | `bool` |
| `deleteGlobalData($key)` | `bool` |
| `getUserData($key, ?int $userId = null, $default = null)` | The data associated to the `$key`, if null `$default` is returned. |
| `setUserData($key, $value, ?int $userId = null)` | `bool` |
| `deleteUserData($key, ?int $userId = null)` | `bool` |

```danger
This documentation page is currently under development!
```