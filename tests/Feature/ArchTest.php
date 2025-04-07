<?php

use SergiX44\Hydrator\Annotation\ConcreteResolver;
use SergiX44\Nutgram\Telegram\Types\BaseType;
use SergiX44\Nutgram\Telegram\Types\Inline\InlineQueryResult;
use SergiX44\Nutgram\Telegram\Types\Input\InputMedia;
use SergiX44\Nutgram\Telegram\Types\Input\InputMessageContent;
use SergiX44\Nutgram\Telegram\Types\Input\InputPaidMedia;
use SergiX44\Nutgram\Telegram\Types\Passport\PassportElementError;
use SergiX44\Nutgram\Tests\TelegramTypeContext;

arch('check that the code is using strict types')
    ->expect('SergiX44\Nutgram')
    ->toUseStrictTypes();

arch('check that Telegram types extends BaseType')
    ->expect('SergiX44\Nutgram\Telegram\Types')
    ->classes()
    ->toExtend(BaseType::class)
    ->ignoring('SergiX44\Nutgram\Telegram\Types\Internal');

arch('check that Type Resolvers extends ConcreteResolver')
    ->expect('SergiX44\Nutgram\Telegram\Types\Internal\Resolvers')
    ->toExtend(ConcreteResolver::class);

test('check that abstract Telegram Input Types have a ConcreteResolver attribute', function () {
    $types = getTelegramTypes(TelegramTypeContext::Abstract);

    $ignore = [
        InlineQueryResult::class,
        InputMedia::class,
        InputMessageContent::class,
        InputPaidMedia::class,
        PassportElementError::class,
    ];

    foreach ($types as $type) {
        if (in_array($type->getName(), $ignore)) {
            continue;
        }

        $attributes = $type->getAttributes();
        $attribute = array_shift($attributes);

        expect($attribute?->newInstance())->toBeInstanceOf(
            ConcreteResolver::class,
            sprintf('%s is missing a ConcreteResolver attribute', $type->getName())
        );
    }
});

test('check that Telegram Buildable Types does not have a "make" method', function () {
    $types = getTelegramTypes(TelegramTypeContext::Buildable);

    foreach ($types as $type) {
        try {
            $type->getMethod('make');
            $hasMakeMethod = true;
        } catch (ReflectionException) {
            $hasMakeMethod = false;
        }

        expect($hasMakeMethod)->toBeFalse(sprintf('%s has a make method', $type->getName()));
    }
});
