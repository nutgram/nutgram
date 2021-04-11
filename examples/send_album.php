<?php

use SergiX44\Nutgram\Nutgram;

require 'vendor/autoload.php';

$bot = new Nutgram($_ENV['TOKEN']);

$bot->onText('/from_file', function (Nutgram $bot) {
    file_put_contents('150.png', file_get_contents('https://via.placeholder.com/150'));
    file_put_contents('200.png', file_get_contents('https://via.placeholder.com/200'));
    $bot->sendMediaGroup([
        [
            'type' => 'photo',
            'media' => fopen('150.png', 'r+')
        ],
        [
            'type' => 'photo',
            'media' => fopen('200.png', 'r+')
        ],
    ]);
});

$bot->onText('/from_url', function (Nutgram $bot) {
    $bot->sendMediaGroup([
        [
            'type' => 'photo',
            'media' => 'https://via.placeholder.com/150'
        ],
        [
            'type' => 'photo',
            'media' => 'https://via.placeholder.com/200'
        ],
    ]);
});

$bot->run();
