<?php

use SergiX44\Nutgram\Nutgram;

require 'vendor/autoload.php';

$bot = new Nutgram($_ENV['TOKEN']);

$bot->onText('.*', function (Nutgram $bot) {
    $text = $bot->message()->text;
    $bot->sendMessage($text);
});

$bot->run();
