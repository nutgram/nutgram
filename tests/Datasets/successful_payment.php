<?php

dataset('successful_payment', function () {
    $file = file_get_contents(__DIR__.'/../Fixtures/Updates/successful_payment.json');

    return [json_decode($file)];
});
