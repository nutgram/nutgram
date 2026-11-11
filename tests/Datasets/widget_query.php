<?php

dataset('widget_query', function () {
    $file = file_get_contents(__DIR__.'/../Fixtures/Updates/widget_query.json');

    return [json_decode($file)];
});
