<?php

declare(strict_types=1);

dataset('response_chat_members', function () {
    $file = file_get_contents(__DIR__.'/../Fixtures/Responses/chat_members.json');
    return [$file];
});
