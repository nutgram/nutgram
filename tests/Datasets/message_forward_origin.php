<?php

dataset('message_forward_origin', function () {
    $file = file_get_contents(__DIR__.'/../Fixtures/Updates/message_forward_origin.json');

    return [json_decode($file)];
});
