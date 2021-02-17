<?php

use SergiX44\Nutgram\Nutgram;

require 'vendor/autoload.php';

$bot = new Nutgram($_ENV['TOKEN']);

$bot->onCommand('/start', function (Nutgram $bot) {
    $bot->sendMessage('Welcome!');
});

$bot->onText('.*', function (Nutgram $bot) {
    $text = $bot->message()->text;
    $bot->sendMessage($text);
});

$bot->run();