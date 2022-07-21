<?php

use SergiX44\Nutgram\Exception\CannotSerializeException;
use SergiX44\Nutgram\Nutgram;
use SergiX44\Nutgram\Testing\FakeNutgram;

test('the instance can be serialized', function () {
    $bot = new Nutgram('fake');

    $str = serialize($bot);

    expect($str)->toBeString();

    $o = unserialize($str);

    expect($o)->toBeInstanceOf(Nutgram::class);
});

test('the instance throw exception with local path transformer as closure', function () {
    $bot = new Nutgram('fake', [
        'local_path_transformer' => function ($path) {
            return 'blah';
        },
    ]);

    serialize($bot);
})->expectException(CannotSerializeException::class);

test('the instance works with local path transformer as callable', function () {
    $bot = new Nutgram('fake', [
        'local_path_transformer' => DummyPathTransformer::class,
    ]);

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

class DummyPathTransformer
{
    public function __invoke($path)
    {
        return 'blah';
    }
}
