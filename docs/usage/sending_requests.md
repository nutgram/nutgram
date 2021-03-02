---
sort: 5
---

# Sending Requests

The framework creates a 1:1 mapping of the methods Telegram provides that are directly accessible from the main
instance. The only difference is in the parameters that telegram marks as *Optional*: these are specifiable via the last
parameter (present in almost all methods) as an associative array.

For example:

```php
<?php

use SergiX44\Nutgram\Nutgram;
use SergiX44\Nutgram\Telegram\Types\Message;

$bot = new Nutgram($_ENV['TOKEN']);

// Send a message to a specific user
/** @var Message $message */
$message = $bot->sendMessage('Hi!', ['chat_id' => 111222333]);

// Send a message to a channel
/** @var Message $message */
$message = $bot->sendMessage('Hi cahnnel!', ['chat_id' => '@mychannel']);
```

## Uploading media

For any method that require an [`InputFile`](https://core.telegram.org/bots/api#inputfile), you can pass a resource file
descriptor to the right method, and the framework will take care of how uploading it, like in the following example.

If you already have the Telegram `file_id`, you can simply specify it.

```php
<?php

use SergiX44\Nutgram\Nutgram;
use SergiX44\Nutgram\Telegram\Types\Message;

$bot = new Nutgram($_ENV['TOKEN']);

// Send a photo to a specific user
$photo = fopen('image.png', 'r+'); // open the file
/** @var Message $message */
$message = $bot->sendPhoto($photo, ['chat_id' => 111222333]); // pass the resource
fclose($photo); // close the file!


$video = fopen('funnyvideo.mp4', 'r+');
/** @var Message $message */
$message = $bot->sendPhoto($video, ['chat_id' => 111222333]);
fclose($video);

// send a sticker via file_id
$fileId = $bot->message()->sticker->file_id;
/** @var Message $message */
$message = $bot->sendSticker($fileId, ['chat_id' => 111222333]);
```

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
| `sendContact(string $first_name, string $phone_number, ?array $opt = [])` | `?Message` | [#sendcontact](https://core.telegram.org/bots/api#sendcontact){:target="_blank"} |
| `sendPoll(string $question, array $options, ?array $opt = [])` | `?Message` | [#sendpoll](https://core.telegram.org/bots/api#sendpoll){:target="_blank"} |
| `sendDice(?array $opt = [])` | `?Message` | [#senddice](https://core.telegram.org/bots/api#senddice){:target="_blank"} |
| `sendChatAction(string $action, ?array $opt = [])` | `?bool` | [#sendchataction](https://core.telegram.org/bots/api#sendchataction){:target="_blank"} |
| `getFile(string $file_id)` | `?File` | [#getfile](https://core.telegram.org/bots/api#getfile){:target="_blank"} |
| `kickChatMember(string|int $chat_id, int $user_id, ?array $opt = [])` | `?bool` | [#kickchatmember](https://core.telegram.org/bots/api#kickchatmember){:target="_blank"} |
| `unbanChatMember(string|int $chat_id, int $user_id, ?array $opt = [])` | `?bool` | [#unbanchatmember](https://core.telegram.org/bots/api#unbanchatmember){:target="_blank"} |
| `restrictChatMember(string|int $chat_id, int $user_id, ChatPermissions $permissions, ?array $opt = [])` | `?bool` | [#restrictchatmember](https://core.telegram.org/bots/api#restrictchatmember){:target="_blank"} |
| `promoteChatMember(string|int $chat_id, int $user_id, ?array $opt = [])` | `?bool` | [#promotechatmember](https://core.telegram.org/bots/api#promotechatmember){:target="_blank"} |
| `setChatAdministratorCustomTitle(string|int $chat_id, int $user_id, string $custom_title, ?array $opt = [])` | `?bool` | [#setchatadministratorcustomtitle](https://core.telegram.org/bots/api#setchatadministratorcustomtitle){:target="_blank"} |
| `setChatPermissions(string|int $chat_id, ChatPermissions $permissions, ?array $opt = [])` | `?bool` | [#setchatpermissions](https://core.telegram.org/bots/api#setchatpermissions){:target="_blank"} |
| `exportChatInviteLink(string|int $chat_id)` | `?string` | [#exportchatinvitelink](https://core.telegram.org/bots/api#exportchatinvitelink){:target="_blank"} |
| `setChatPhoto(string|int $chat_id, $photo)` | `?bool` | [#setchatphoto](https://core.telegram.org/bots/api#setchatphoto){:target="_blank"} |
| `deleteChatPhoto(string|int $chat_id)` | `?bool` | [#deletechatphoto](https://core.telegram.org/bots/api#deletechatphoto){:target="_blank"} |
| `setChatTitle(string|int $chat_id, string $title)` | `?bool` | [#setchattitle](https://core.telegram.org/bots/api#setchattitle){:target="_blank"} |
| `setChatDescription(string|int $chat_id, ?string $description = null)` | `?bool` | [#setchatdescription](https://core.telegram.org/bots/api#setchatdescription){:target="_blank"} |
| `pinChatMessage(string|int $chat_id, int $message_id, ?array $opt = [])` | `?bool` | [#pinchatmessage](https://core.telegram.org/bots/api#pinchatmessage){:target="_blank"} |
| `unpinChatMessage(string|int $chat_id, int $message_id)` | `?bool` | [#unpinchatmessage](https://core.telegram.org/bots/api#unpinchatmessage){:target="_blank"} |
| `unpinAllChatMessages(string|int $chat_id)` | `?bool` | [#unpinallchatmessages](https://core.telegram.org/bots/api#unpinallchatmessages){:target="_blank"} |
| `leaveChat(string|int $chat_id)` | `?bool` | [#leavechat](https://core.telegram.org/bots/api#leavechat){:target="_blank"} |
| `getChat(string|int $chat_id)` | `?Chat` | [#getchat](https://core.telegram.org/bots/api#getchat){:target="_blank"} |
| `getChatAdministrators(string|int $chat_id)` | `?array` | [#getchatadministrators](https://core.telegram.org/bots/api#getchatadministrators){:target="_blank"} |
| `getChatMembersCount(string|int $chat_id)` | `?int` | [#getchatmemberscount](https://core.telegram.org/bots/api#getchatmemberscount){:target="_blank"} |
| `getChatMember(string|int $chat_id, int $user_id)` | `?ChatMember` | [#getchatmember](https://core.telegram.org/bots/api#getchatmember){:target="_blank"} |
| `setChatStickerSet(string|int $chat_id, string $sticker_set_name)` | `?bool` | [#setchatstickerset](https://core.telegram.org/bots/api#setchatstickerset){:target="_blank"} |
| `deleteChatStickerSet(string|int $chat_id)` | `?bool` | [#deletechatstickerset](https://core.telegram.org/bots/api#deletechatstickerset){:target="_blank"} |
| `answerCallbackQuery(?array $opt = [])` | `?bool` | [#answercallbackquery](https://core.telegram.org/bots/api#answercallbackquery){:target="_blank"} |
| `setMyCommands(array $commands = [])` | `?bool` | [#setmycommands](https://core.telegram.org/bots/api#setmycommands){:target="_blank"} |
| `getMyCommands()` | `?array` | [#getmycommands](https://core.telegram.org/bots/api#getmycommands){:target="_blank"} |
| `editMessageText(string $text, ?array $opt = [])` | `Message|bool|null` | [#editmessagetext](https://core.telegram.org/bots/api#editmessagetext){:target="_blank"} |
| `editMessageCaption(?array $opt = [])` | `Message|bool|null` | [#editmessagecaption](https://core.telegram.org/bots/api#editmessagecaption){:target="_blank"} |
| `editMessageMedia(array $media, ?array $opt = [])` | `Message|bool|null` | [#editmessagemedia](https://core.telegram.org/bots/api#editmessagemedia){:target="_blank"} |
| `editMessageReplyMarkup(?array $opt = [])` | `Message|bool|null` | [#editmessagereplymarkup](https://core.telegram.org/bots/api#editmessagereplymarkup){:target="_blank"} |
| `stopPoll(string|int $chat_id, int $message_id, ?array $opt = [])` | `?Poll` | [#stoppoll](https://core.telegram.org/bots/api#stoppoll){:target="_blank"} |
| `deleteMessage(string|int $chat_id, int $message_id)` | `?bool` | [#deletemessage](https://core.telegram.org/bots/api#deletemessage){:target="_blank"} |
| `sendSticker($sticker, array $opt = [])` | `?Message` | [#sendsticker](https://core.telegram.org/bots/api#sendsticker){:target="_blank"} |
| `getStickerSet(string $name)` | `?StickerSet` | [#getstickerset](https://core.telegram.org/bots/api#getstickerset){:target="_blank"} |
| `createNewStickerSet(string $name, string $title, ?array $opt = [])` | `?bool` | [#createnewstickerset](https://core.telegram.org/bots/api#createnewstickerset){:target="_blank"} |
| `setStickerPositionInSet(string $sticker, int $position)` | `?bool` | [#setstickerpositioninset](https://core.telegram.org/bots/api#setstickerpositioninset){:target="_blank"} |
| `deleteStickerFromSet(string $sticker)` | `?bool` | [#deletestickerfromset](https://core.telegram.org/bots/api#deletestickerfromset){:target="_blank"} |
| `setStickerSetThumb(string $name, ?array $opt = [])` | `?bool` | [#setstickersetthumb](https://core.telegram.org/bots/api#setstickersetthumb){:target="_blank"} |
| `answerInlineQuery(array $results, ?array $opt = [])` | `?bool` | [#answerinlinequery](https://core.telegram.org/bots/api#answerinlinequery){:target="_blank"} |
| `sendInvoice(string $title, string $description, string $payload, string $provider_token, string $start_parameter, string $currency, array $prices, ?array $opt = [])` | `?Message` | [#sendinvoice](https://core.telegram.org/bots/api#sendinvoice){:target="_blank"} |
| `answerShippingQuery(bool $ok, ?array $opt = [])` | `?bool` | [#answershippingquery](https://core.telegram.org/bots/api#answershippingquery){:target="_blank"} |
| `answerPreCheckoutQuery(bool $ok, ?array $opt = [])` | `?bool` | [#answerprecheckoutquery](https://core.telegram.org/bots/api#answerprecheckoutquery){:target="_blank"} |
| `setPassportDataErrors(int $user_id, array $errors)` | `?bool` | [#setpassportdataerrors](https://core.telegram.org/bots/api#setpassportdataerrors){:target="_blank"} |
| `sendGame(string $game_short_name, ?array $opt = [])` | `?Message` | [#sendgame](https://core.telegram.org/bots/api#sendgame){:target="_blank"} |
| `setGameScore(int $score, ?array $opt = [])` | `?bool` | [#setgamescore](https://core.telegram.org/bots/api#setgamescore){:target="_blank"} |
| `getGameHighScores(?array $opt = [])` | `?array` | [#getgamehighscores](https://core.telegram.org/bots/api#getgamehighscores){:target="_blank"} |
