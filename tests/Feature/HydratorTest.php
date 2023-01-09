<?php

use SergiX44\Nutgram\Hydrator\Hydrator;
use SergiX44\Nutgram\Nutgram;
use SergiX44\Nutgram\Telegram\Types\Common\Update;

it('maps one update', function ($update) {
    $r = Nutgram::fake()->getContainer()
        ->get(Hydrator::class)
        ->hydrate($update, new Update());

    expect($r)->toBeInstanceOf(Update::class);
})->with('message');

it('maps multiple updates', function ($update) {
    $r = Nutgram::fake()->getContainer()
        ->get(Hydrator::class)
        ->hydrateArray($update, new Update());

    expect($r)->toBeArray();
    foreach ($r as $u) {
        expect($u)->toBeInstanceOf(Update::class);
    }
})->with('multiple_messages');

it('maps one update with legacy hydrator', function ($update) {
    $r = Nutgram::fake(config: ['mapper' => \SergiX44\Nutgram\Hydrator\LegacyHydrator::class])->getContainer()
        ->get(Hydrator::class)
        ->hydrate($update, new Update());

    expect($r)->toBeInstanceOf(Update::class);
})->with('message');

it('maps multiple updates with legacy hydrator', function ($update) {
    $r = Nutgram::fake(config: ['mapper' => \SergiX44\Nutgram\Hydrator\LegacyHydrator::class])->getContainer()
        ->get(Hydrator::class)
        ->hydrateArray($update, new Update());

    expect($r)->toBeArray();
    foreach ($r as $u) {
        expect($u)->toBeInstanceOf(Update::class);
    }
})->with('multiple_messages');

it('doesnt return the same hydrated instance again', function ($update) {
    $bot = Nutgram::fake();
    $first = $bot->getContainer()
        ->get(Hydrator::class)
        ->hydrate($update, Update::class);

    $first->message->text = 'changed';

    $second = $bot->getContainer()
        ->get(Hydrator::class)
        ->hydrate($update, Update::class);

    expect($first === $second)->toBeFalse();
    expect($first->message->text)->toBe('changed');
    expect($second->message->text)->toBe('Ciao');
})->with('message');
