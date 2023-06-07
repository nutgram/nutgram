<?php

dataset('response_wrong_file_id', function () {
    $file = file_get_contents(__DIR__.'/../Fixtures/Responses/wrong_file_id.json');

    return [$file];
});
