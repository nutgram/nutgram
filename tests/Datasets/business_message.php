<?php

declare(strict_types=1);

dataset('business_message', function () {
    $file = file_get_contents(__DIR__.'/../Fixtures/Updates/business_message.json');

    return [json_decode($file)];
});
