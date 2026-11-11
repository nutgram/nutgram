<?php

dataset('paid_messages_waived', function () {
    $file = file_get_contents(__DIR__.'/../Fixtures/Updates/paid_messages_waived.json');

    return [json_decode($file)];
});
