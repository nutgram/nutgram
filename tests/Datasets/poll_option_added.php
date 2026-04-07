<?php

dataset('poll_option_added', function () {
    $file = file_get_contents(__DIR__.'/../Fixtures/Updates/poll_option_added.json');

    return [json_decode($file)];
});
