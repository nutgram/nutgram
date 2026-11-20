<?php

dataset('managed_bot_created', function () {
    $file = file_get_contents(__DIR__.'/../Fixtures/Updates/managed_bot_created.json');

    return [json_decode($file)];
});
