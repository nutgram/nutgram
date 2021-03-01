---
sort: 5
---

# Sending Requests

The framework creates a 1:1 mapping of the methods Telegram provides that are directly accessible from the main
instance. The only difference is in the parameters that telegram marks as "Optional": these are specifiable via the last
parameter (present in almost all methods) as an associative array.

Also, the bot is fully usable in a procedural way, useful mainly when using it only to sending messages.

This is a very simple example:

```php
<?php

use SergiX44\Nutgram\Nutgram;
use SergiX44\Nutgram\Telegram\Types\Message;

require 'vendor/autoload.php';

$bot = new Nutgram($_ENV['TOKEN']);

// Retrieve te list of pending updates..
$updates = $bot->getUpdates();

// Send a message to a specific user
/** @var Message $message */
$message = $bot->sendMessage('Hi!', ['chat_id' => 111222333]);

// Send a photo to a specific user
/** @var Message $message */
$photo = fopen('image.png', 'r+');
$message = $bot->sendPhoto($photo, ['chat_id' => 111222333]);
fclose($photo);
```

Easy, to send notifications maybe, but not very practical to handle updates with it ;)

Here you can find the full list of the available methods

## Available methods

| Method | Return Type | Telegram Docs |
| --- | --- | --- |

```danger
This documentation page is currently under development!
```