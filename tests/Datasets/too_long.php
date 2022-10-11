<?php

dataset('too_long', function () {
    $file = file_get_contents(__DIR__.'/../Responses/too_long.json');
    return [$file];
});
