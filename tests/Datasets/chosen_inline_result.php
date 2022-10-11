<?php

dataset('chosen_inline_result', function () {
    $file = file_get_contents(__DIR__.'/../Updates/chosen_inline_result.json');

    return [json_decode($file)];
});
