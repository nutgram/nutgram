<?php

dataset('response_ChatAdministratorRights', function () {
    $file = file_get_contents(__DIR__.'/../Fixtures/Responses/ChatAdministratorRights.json');
    return [$file];
});
