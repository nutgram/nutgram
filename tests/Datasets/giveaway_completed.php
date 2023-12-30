<?php

dataset('giveaway_completed', function () {
    $file = file_get_contents(__DIR__.'/../Fixtures/Updates/giveaway_completed.json');

    return [json_decode($file)];
});
