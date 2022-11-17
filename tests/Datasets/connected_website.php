<?php

dataset('connected_website', function () {
    $file = file_get_contents(__DIR__.'/../Updates/connected_website.json');

    return [json_decode($file)];
});
