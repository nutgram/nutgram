<?php

declare(strict_types=1);

dataset('new_chat_members', function () {
    $file = file_get_contents(__DIR__.'/../Fixtures/Updates/new_chat_members.json');

    return [json_decode($file)];
});
