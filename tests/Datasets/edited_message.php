<?php

declare(strict_types=1);

dataset('edited_message', function () {
    $file = file_get_contents(__DIR__.'/../Fixtures/Updates/edited_message.json');

    return [json_decode($file)];
});
