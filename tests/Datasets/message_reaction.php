<?php

dataset('message_reaction', function () {
    $file = file_get_contents(__DIR__.'/../Fixtures/Updates/message_reaction.json');

    return [json_decode($file)];
});
