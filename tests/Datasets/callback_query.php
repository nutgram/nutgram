<?php

dataset('callback_query', function () {
    $file = file_get_contents(__DIR__.'/../Updates/callback_query.json');

    return [json_decode($file)];
});
