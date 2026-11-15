<?php

dataset('shared_widget_query', function () {
    $file = file_get_contents(__DIR__.'/../Fixtures/Updates/shared_widget_query.json');

    return [json_decode($file)];
});
