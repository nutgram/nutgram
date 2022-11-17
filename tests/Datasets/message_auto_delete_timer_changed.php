<?php

dataset('message_auto_delete_timer_changed', function () {
    $file = file_get_contents(__DIR__.'/../Updates/message_auto_delete_timer_changed.json');

    return [json_decode($file)];
});
