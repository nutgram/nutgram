<?php

dataset('stopped_message_generation', function () {
    $file = file_get_contents(__DIR__.'/../Fixtures/Updates/stopped_message_generation.json');

    return [json_decode($file)];
});
