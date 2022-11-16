<?php

dataset('passport_data', function () {
    $file = file_get_contents(__DIR__.'/../Updates/passport_data.json');

    return [json_decode($file)];
});
