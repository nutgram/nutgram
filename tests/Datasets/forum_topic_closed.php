<?php

declare(strict_types=1);

dataset('forum_topic_closed', function () {
    $file = file_get_contents(__DIR__.'/../Fixtures/Updates/forum_topic_closed.json');

    return [json_decode($file)];
});
