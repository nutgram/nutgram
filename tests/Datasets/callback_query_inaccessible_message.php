<?php

dataset('callback_query_inaccessible_message', function () {
    $file = file_get_contents(__DIR__.'/../Fixtures/Updates/callback_query_inaccessible_message.json');

    return [json_decode($file)];
});
