<?php

use SergiX44\Nutgram\Tests\Fixtures\TestingRunningMode;

it('return the right running mode', function ($update) {
    /** @var \SergiX44\Nutgram\Nutgram $bot */
    $bot = getInstance($update);

    expect($bot->getUpdateMode())->toBe(TestingRunningMode::class);
})->with('callback_query');
