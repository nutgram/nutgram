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

## Available methods

| Method | Return Type | Telegram Docs |
| --- | --- | --- |
| `getMe()` | `?User` | [#getme](https://core.telegram.org/bots/api#getme){:target="_blank"} |
| `logOut()` | `?bool` | [#logout](https://core.telegram.org/bots/api#logout){:target="_blank"} |
| `close()` | `?bool` | [#close](https://core.telegram.org/bots/api#close){:target="_blank"} |
| `sendMessage(string $text, ?array $opt = [])` | `?Message` | [#sendmessage](https://core.telegram.org/bots/api#sendmessage){:target="_blank"} |
| `forwardMessage(string|int $chat_id, string|int $from_chat_id, int $message_id, array $opt = [])` | `?Message` | [#forwardmessage](https://core.telegram.org/bots/api#forwardmessage){:target="_blank"} |
| `copyMessage(string|int $chat_id, string|int $from_chat_id, int $message_id, array $opt = [])` | `?MessageId` | [#copymessage](https://core.telegram.org/bots/api#copymessage){:target="_blank"} |
| `sendPhoto($photo, array $opt = [])` | `?Message` | [#sendphoto](https://core.telegram.org/bots/api#sendphoto){:target="_blank"} |
| `sendAudio($audio, array $opt = [])` | `?Message` | [#sendaudio](https://core.telegram.org/bots/api#sendaudio){:target="_blank"} |
| `sendDocument($document, array $opt = [])` | `?Message` | [#senddocument](https://core.telegram.org/bots/api#senddocument){:target="_blank"} |
| `sendVideo($video, array $opt = [])` | `?Message` | [#sendvideo](https://core.telegram.org/bots/api#sendvideo){:target="_blank"} |
| `sendAnimation($video, array $opt = [])` | `?Message` | [#sendanimation](https://core.telegram.org/bots/api#sendanimation){:target="_blank"} |
| `sendVoice($voice, array $opt = [])` | `?Message` | [#sendvoice](https://core.telegram.org/bots/api#sendvoice){:target="_blank"} |
| `sendVideoNote($video_note, array $opt = [])` | `?Message` | [#sendvideonote](https://core.telegram.org/bots/api#sendvideonote){:target="_blank"} |
| `sendMediaGroup(array $media, array $opt = [])` | `?array` | [#sendmediagroup](https://core.telegram.org/bots/api#sendmediagroup){:target="_blank"} |
| `sendLocation(float $latitude, float $longitude, ?array $opt = [])` | `?Message` | [#sendlocation](https://core.telegram.org/bots/api#sendlocation){:target="_blank"} |
| `editMessageLiveLocation(float $latitude, float $longitude, ?array $opt = [])` | `Message|bool|null` | [#editmessagelivelocation](https://core.telegram.org/bots/api#editmessagelivelocation){:target="_blank"} |
| `stopMessageLiveLocation(?array $opt = [])` | `Message|bool|null` | [#stopmessagelivelocation](https://core.telegram.org/bots/api#stopmessagelivelocation){:target="_blank"} |
| `sendVenue(float $latitude, float $longitude, string $title, string $address, ?array $opt = [])` | `?Message` | [#sendvenue](https://core.telegram.org/bots/api#sendvenue){:target="_blank"} |

```danger
This documentation page is currently under development!
```