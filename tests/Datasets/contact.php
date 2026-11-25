<?php

declare(strict_types=1);

dataset('contact', function () {
    $file = file_get_contents(__DIR__.'/../Fixtures/Updates/contact.json');

    return [json_decode($file)];
});
