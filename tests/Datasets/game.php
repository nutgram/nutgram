<?php

declare(strict_types=1);

dataset('game', function () {
    $file = file_get_contents(__DIR__.'/../Fixtures/Updates/game.json');

    return [json_decode($file)];
});
