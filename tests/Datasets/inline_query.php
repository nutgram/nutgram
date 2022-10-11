<?php

dataset('inline_query', function () {
    $file = file_get_contents(__DIR__.'/../Updates/inline_query.json');

    return [json_decode($file)];
});
