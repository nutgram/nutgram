<?php

dataset('venue', function () {
    $file = file_get_contents(__DIR__.'/../Updates/venue.json');

    return [json_decode($file)];
});
