<?php

use SergiX44\Nutgram\Nutgram;

require 'vendor/autoload.php';

$bot = new Nutgram($_ENV['TOKEN']);

$chats = [];

// ------------ using the default sendMessage

// in scripts
$bot->getBulkMessenger()
    ->setChats($chats)
    ->setText('Hello!')
    ->setOpt([/* optional parameters */])
    ->startSync();

// inside handlers (polling)
$bot->onCommand('start', function (Nutgram $bot) use ($chats) {
    $bot->getBulkMessenger()
        ->setChats($chats)
        ->setText('Hello!')
        ->setOpt([/* optional parameters */])
        ->startAsync();
});

$bot->run();

// ------------ OR

$document = fopen('...', 'r+');

// in scripts
$bot->getBulkMessenger()
    ->setChats($chats)
    ->using(fn (Nutgram $bot, int $chatId) => $bot->sendDocument($document, ['chat_id' => $chatId]))
    ->startSync();

// inside handlers (polling)
$bot->onCommand('start', function (Nutgram $bot) use ($document, $chats) {
    $bot->getBulkMessenger()
        ->setChats($chats)
        ->using(fn (Nutgram $bot, int $chatId) => $bot->sendDocument($document, ['chat_id' => $chatId]))
        ->startAsync();
});
