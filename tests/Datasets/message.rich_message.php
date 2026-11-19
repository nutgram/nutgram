<?php

dataset('message.rich_message', function () {
    $file = file_get_contents(__DIR__.'/../Fixtures/Messages/rich_message.json');

    return [json_decode($file)];
});
