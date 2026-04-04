<?php

dataset('poll_option_deleted', function () {
    $file = file_get_contents(__DIR__.'/../Fixtures/Updates/poll_option_deleted.json');

    return [json_decode($file)];
});
