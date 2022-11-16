<?php

dataset('proximity_alert_triggered', function () {
    $file = file_get_contents(__DIR__.'/../Updates/proximity_alert_triggered.json');

    return [json_decode($file)];
});
