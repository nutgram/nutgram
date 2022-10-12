<?php

dataset('edited_channel_post', function () {
    $file = file_get_contents(__DIR__.'/../Updates/edited_channel_post.json');

    return [json_decode($file)];
});
