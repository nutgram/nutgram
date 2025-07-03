<?php

dataset('checklist_tasks_done', function () {
    $file = file_get_contents(__DIR__.'/../Fixtures/Updates/checklist_tasks_done.json');

    return [json_decode($file)];
});
