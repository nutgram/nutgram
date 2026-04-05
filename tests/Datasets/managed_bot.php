<?php

dataset('managed_bot', function () {
    $file = file_get_contents(__DIR__.'/../Fixtures/Updates/managed_bot.json');

    return [json_decode($file)];
});
