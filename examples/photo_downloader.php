<?php


use SergiX44\Nutgram\Nutgram;
use SergiX44\Nutgram\Telegram\Attributes\MessageTypes;

require 'vendor/autoload.php';

$bot = new Nutgram($_ENV['TOKEN']);

$bot->onMessageType(MessageTypes::PHOTO, function (Nutgram $bot) {
    $photo = end($bot->message()->photo);
    $bot->getFile($photo->file_id)?->save('./');
    $bot->sendMessage('Photo saved!');
});

$bot->run();
