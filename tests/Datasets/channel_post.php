<?php

dataset('channel_post', function () {
    $file = file_get_contents(__DIR__.'/../Updates/channel_post.json');

    return [json_decode($file)];
});
