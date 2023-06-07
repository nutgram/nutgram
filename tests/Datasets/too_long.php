<?php

dataset('too_long', function () {
    $file = file_get_contents(__DIR__.'/../Fixtures/Responses/too_long.json');
    return [$file];
});
