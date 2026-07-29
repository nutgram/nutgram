<?php

declare(strict_types=1);

dataset('paid_media_purchased', function () {
    $file = file_get_contents(__DIR__.'/../Fixtures/Updates/paid_media_purchased.json');

    return [json_decode($file)];
});
