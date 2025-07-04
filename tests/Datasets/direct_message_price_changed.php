<?php

dataset('direct_message_price_changed', function () {
    $file = file_get_contents(__DIR__.'/../Fixtures/Updates/direct_message_price_changed.json');

    return [json_decode($file)];
});
