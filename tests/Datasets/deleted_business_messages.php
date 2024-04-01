<?php

dataset('deleted_business_messages', function () {
    $file = file_get_contents(__DIR__.'/../Fixtures/Updates/deleted_business_messages.json');

    return [json_decode($file)];
});
