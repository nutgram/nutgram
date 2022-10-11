<?php

dataset('response_user_deactivated', function () {
    $file = file_get_contents(__DIR__.'/../Responses/user_deactivated.json');
    return [$file];
});
