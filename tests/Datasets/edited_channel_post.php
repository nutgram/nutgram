<?php

declare(strict_types=1);

dataset('edited_channel_post', function () {
    $file = file_get_contents(__DIR__.'/../Fixtures/Updates/edited_channel_post.json');

    return [json_decode($file)];
});
