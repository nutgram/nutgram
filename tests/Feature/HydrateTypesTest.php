<?php

use SergiX44\Nutgram\Hydrator\Hydrator;
use SergiX44\Nutgram\Nutgram;
use SergiX44\Nutgram\Telegram\Types\Message\Message;

it('hydrate rich_message', function ($content) {
    $hydrator = Nutgram::fake()->getContainer()->get(Hydrator::class);

    $result = $hydrator->hydrate($content, Message::class);

    expect($result)->toBeInstanceOf(Message::class);
})->with('rich_message');
