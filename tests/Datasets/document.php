<?php

dataset('document', function () {
    $file = file_get_contents(__DIR__.'/../Updates/document.json');

    return [json_decode($file)];
});
