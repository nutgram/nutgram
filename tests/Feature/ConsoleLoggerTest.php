<?php

use SergiX44\Nutgram\Logger\ConsoleLogger;
use SergiX44\Nutgram\Nutgram;

it('logs with ConsoleLogger', function () {
    $bot = Nutgram::fake(config: ['logger' => ConsoleLogger::class]);

    $bot->sendMessage('Hello World!', ['chat_id' => 123]);

    expect(ob_get_contents())
        ->toContain('DEBUG: sendMessage', '{"parameters":{"text":"Hello World!","chat_id":123},"options":[]}');
});
