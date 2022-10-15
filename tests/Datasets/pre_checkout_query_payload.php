<?php

dataset('pre_checkout_query_payload', function () {
    $file = file_get_contents(__DIR__.'/../Updates/pre_checkout_query_payload.json');

    return [json_decode($file)];
});
