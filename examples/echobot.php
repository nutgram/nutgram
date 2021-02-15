<?php

use SergiX44\Nutgram\Nutgram;

require 'vendor/autoload.php';

$bot = new Nutgram('TOKEN');

$bot->onText('.*', function ($bot) {
    $text = $bot->getMessage()->text;
    $bot->sendMessage($text);
});

$bot->run();