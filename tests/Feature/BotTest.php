<?php

it('return the right running mode', function ($update) {
    /** @var \SergiX44\Nutgram\Nutgram $bot */
    $bot = getInstance($update);

    expect($bot->getUpdateMode())->toBe(\SergiX44\Nutgram\Tests\Fixtures\TestingRunningMode::class);
})->with('callback_query');
