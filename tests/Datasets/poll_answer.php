<?php

dataset('poll_answer', function () {
    $file = file_get_contents(__DIR__.'/../Updates/poll_answer.json');

    return [json_decode($file)];
});
