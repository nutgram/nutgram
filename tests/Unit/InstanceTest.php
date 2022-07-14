<?php

test('the instance can be serialized', function () {
    $bot = new \SergiX44\Nutgram\Nutgram('fake');

    $str = serialize($bot);

    expect($str)->toBeString();

    $o = unserialize($str);

    expect($o)->toBeInstanceOf(\SergiX44\Nutgram\Nutgram::class);
});