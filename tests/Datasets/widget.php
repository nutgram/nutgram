<?php

dataset('widget', function () {
    $file = file_get_contents(__DIR__.'/../Fixtures/Updates/widget.json');

    return [json_decode($file)];
});
