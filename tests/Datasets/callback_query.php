<?php

dataset('callback_query', function () {
    $file = file_get_contents(__DIR__.'/../Fixtures/Updates/callback_query.json');

    return [json_decode($file)];
});
