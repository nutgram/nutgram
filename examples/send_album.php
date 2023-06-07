<?php

use SergiX44\Nutgram\Nutgram;
use SergiX44\Nutgram\Telegram\Types\Input\InputMediaPhoto;
use SergiX44\Nutgram\Telegram\Types\Internal\InputFile;

require 'vendor/autoload.php';

$bot = new Nutgram($_ENV['TOKEN']);

$bot->onText('/from_file', function (Nutgram $bot) {
    file_put_contents('150.png', file_get_contents('https://via.placeholder.com/150'));
    file_put_contents('200.png', file_get_contents('https://via.placeholder.com/200'));
    $bot->sendMediaGroup([
        InputMediaPhoto::make(
            media: InputFile::make(fopen('150.png', 'rb')),
            caption: '150',
        ),
        InputMediaPhoto::make(
            media: InputFile::make(fopen('200.png', 'rb')),
            caption: '200',
        ),
    ]);
});

$bot->onText('/from_url', function (Nutgram $bot) {
    $bot->sendMediaGroup([
        InputMediaPhoto::make(
            media: 'https://via.placeholder.com/150',
            caption: '150',
        ),
        InputMediaPhoto::make(
            media: 'https://via.placeholder.com/200',
            caption: '200',
        ),
    ]);
});

$bot->run();
