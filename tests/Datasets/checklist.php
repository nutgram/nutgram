<?php

dataset('checklist', function () {
    $file = file_get_contents(__DIR__.'/../Fixtures/Updates/checklist.json');

    return [json_decode($file)];
});
