<?php

declare(strict_types=1);

dataset('document', function () {
    $file = file_get_contents(__DIR__.'/../Fixtures/Updates/document.json');

    return [json_decode($file)];
});
