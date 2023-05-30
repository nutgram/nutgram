<?php

use SergiX44\Nutgram\Configuration;
use SergiX44\Nutgram\Nutgram;
use SergiX44\Nutgram\Testing\FakeNutgram;

test('the instance can be serialized', function () {
    $bot = new Nutgram('fake');

    $str = serialize($bot);

    expect($str)->toBeString();

    $o = unserialize($str);

    expect($o)->toBeInstanceOf(Nutgram::class);
});

test('it can serialize with local path transformer as closure', function () {
    $closure = function ($path) {
        return 'blah';
    };

    $bot = new Nutgram('fake', new Configuration(localPathTransformer: $closure));

    $str = serialize($bot);

    expect($str)->toBeString();

    $o = unserialize($str);

    expect($o->getConfig())->toBeInstanceOf(Configuration::class);
});

test('the instance works with local path transformer as callable', function () {
    $bot = new Nutgram('fake', new Configuration(localPathTransformer: DummyPathTransformer::class));

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
