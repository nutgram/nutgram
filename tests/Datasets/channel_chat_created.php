<?php

declare(strict_types=1);

dataset('channel_chat_created', function () {
    $file = file_get_contents(__DIR__.'/../Fixtures/Updates/channel_chat_created.json');

    return [json_decode($file)];
});
