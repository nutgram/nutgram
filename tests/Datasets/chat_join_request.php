<?php

declare(strict_types=1);

dataset('chat_join_request', function () {
    $file = file_get_contents(__DIR__.'/../Fixtures/Updates/chat_join_request.json');

    return [json_decode($file)];
});
