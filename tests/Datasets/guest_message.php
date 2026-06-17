<?php

dataset('guest_message', function () {
    $file = file_get_contents(__DIR__.'/../Fixtures/Updates/guest_message.json');

    return [json_decode($file)];
});
