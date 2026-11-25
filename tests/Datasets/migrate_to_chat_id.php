<?php

declare(strict_types=1);

dataset('migrate_to_chat_id', function () {
    $file = file_get_contents(__DIR__.'/../Fixtures/Updates/migrate_to_chat_id.json');

    return [json_decode($file)];
});
