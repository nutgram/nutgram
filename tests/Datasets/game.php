<?php

dataset('game', function () {
    $file = file_get_contents(__DIR__.'/../Updates/game.json');

    return [json_decode($file)];
});
