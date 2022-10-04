<?php

use SergiX44\Nutgram\Nutgram;

require 'vendor/autoload.php';

$bot = new Nutgram($_ENV['TOKEN']);

$chats = [];

// in scripts
$bot->getBulkMessenger()
    ->setChats($chats)
    ->setPayload('sendMessage', ['Hi!'])
    ->startSync();

// inside handlers (polling)
$bot->onCommand('start', function (Nutgram $bot) use ($chats) {
    $bot->getBulkMessenger()
        ->setChats($chats)
        ->setPayload('sendMessage', ['Hi!'])
        ->startAsync();
});

$bot->run();
