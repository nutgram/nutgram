<?php

declare(strict_types=1);

dataset('channel_post', function () {
    $file = file_get_contents(__DIR__.'/../Fixtures/Updates/channel_post.json');

    return [json_decode($file)];
});
