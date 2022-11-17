<?php

dataset('web_app_data', function () {
    $file = file_get_contents(__DIR__.'/../Updates/web_app_data.json');

    return [json_decode($file)];
});
