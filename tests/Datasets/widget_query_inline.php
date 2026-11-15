<?php

dataset('widget_query_inline', function () {
    $file = file_get_contents(__DIR__.'/../Fixtures/Updates/widget_query_inline.json');

    return [json_decode($file)];
});
