<?php

dataset('checklist_tasks_added', function () {
    $file = file_get_contents(__DIR__.'/../Fixtures/Updates/checklist_tasks_added.json');

    return [json_decode($file)];
});
