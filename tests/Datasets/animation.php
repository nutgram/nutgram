<?php

dataset('animation', function () {
    $file = file_get_contents(__DIR__.'/../Updates/animation.json');

    return [json_decode($file)];
});
