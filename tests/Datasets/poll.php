<?php

dataset('poll', function () {
    $file = file_get_contents(__DIR__.'/../Updates/poll.json');

    return [json_decode($file)];
});
