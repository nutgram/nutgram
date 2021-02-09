<?php

use SergiX44\Nutgram\Telegram\Types\Message;

test('example', function () {
    $bot = new \SergiX44\Nutgram\Nutgram('xxx');

    $a = $bot->sendMessage('Ciao', [
        'chat_id' => 1234,
    ]);

    print_r($a);
});
