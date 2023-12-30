<?php

dataset('message_reaction_count', function () {
    $file = file_get_contents(__DIR__.'/../Fixtures/Updates/message_reaction_count.json');

    return [json_decode($file)];
});
