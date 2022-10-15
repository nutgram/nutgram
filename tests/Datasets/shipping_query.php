<?php

dataset('shipping_query', function () {
    $file = file_get_contents(__DIR__.'/../Updates/shipping_query.json');

    return [json_decode($file)];
});
