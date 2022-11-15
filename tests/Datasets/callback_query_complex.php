<?php

dataset('callback_query_complex', function () {
    $file = file_get_contents(__DIR__.'/../Updates/callback_query_complex.json');

    return [json_decode($file)];
});
