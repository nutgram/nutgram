<?php

dataset('message_boost_added', function () {
    $file = file_get_contents(__DIR__.'/../Fixtures/Updates/message_boost_added.json');

    return [json_decode($file)];
});
