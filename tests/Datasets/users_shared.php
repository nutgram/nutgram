<?php

dataset('users_shared', function () {
    $file = file_get_contents(__DIR__.'/../Fixtures/Updates/users_shared.json');

    return [json_decode($file)];
});
