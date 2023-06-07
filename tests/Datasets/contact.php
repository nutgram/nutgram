<?php

dataset('contact', function () {
    $file = file_get_contents(__DIR__.'/../Fixtures/Updates/contact.json');

    return [json_decode($file)];
});
