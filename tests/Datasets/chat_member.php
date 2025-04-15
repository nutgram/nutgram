<?php

declare(strict_types=1);

dataset('chat_member', function () {
    $file = file_get_contents(__DIR__.'/../Fixtures/Updates/chat_member.json');

    return [json_decode($file)];
});
