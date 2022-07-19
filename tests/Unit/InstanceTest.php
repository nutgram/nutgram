<?php

use SergiX44\Nutgram\Nutgram;
use SergiX44\Nutgram\Testing\FakeNutgram;

test('the instance can be serialized', function () {
    $bot = new Nutgram('fake');

    $str = serialize($bot);

    expect($str)->toBeString();

    $o = unserialize($str);

    expect($o)->toBeInstanceOf(Nutgram::class);
});

test('the fake instance can be serialized', function () {
    $bot = Nutgram::fake();

    $str = serialize($bot);

    expect($str)->toBeString();

    $o = unserialize($str);

    expect($o)->toBeInstanceOf(FakeNutgram::class);
});
