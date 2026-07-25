<?php

use SergiX44\Nutgram\Nutgram;
use SergiX44\Nutgram\Telegram\Types\Message\Message;

it('hydrate rich_message', function ($content) {
    $hydrator = Nutgram::fake()->getHydrator();

    $result = $hydrator->hydrate(Message::class, $content);

    expect($result)->toBeInstanceOf(Message::class);
})->with('message.rich_message');
