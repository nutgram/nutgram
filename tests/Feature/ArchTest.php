<?php

use SergiX44\Hydrator\Annotation\ConcreteResolver;
use SergiX44\Hydrator\Annotation\OverrideConstructor;
use SergiX44\Nutgram\Nutgram;
use SergiX44\Nutgram\Telegram\Types\BaseType;
use SergiX44\Nutgram\Telegram\Types\Common\Response;
use SergiX44\Nutgram\Telegram\Types\Inline\InlineQueryResult;
use SergiX44\Nutgram\Telegram\Types\Input\InputMedia;
use SergiX44\Nutgram\Telegram\Types\Input\InputMessageContent;
use SergiX44\Nutgram\Telegram\Types\Input\InputPaidMedia;
use SergiX44\Nutgram\Telegram\Types\Input\InputProfilePhoto;
use SergiX44\Nutgram\Telegram\Types\Input\InputStoryContent;
use SergiX44\Nutgram\Telegram\Types\Passport\PassportElementError;
use SergiX44\Nutgram\Telegram\Types\Story\StoryAreaType;
use SergiX44\Nutgram\Testing\TypeFaker;
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
        InputProfilePhoto::class,
        InputStoryContent::class,
        StoryAreaType::class,
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

test('check that Telegram Buildable Types does have OverrideConstructor attribute', function () {
    $types = getTelegramTypes(TelegramTypeContext::Buildable);

    foreach ($types as $type) {
        $attributes = $type->getAttributes(OverrideConstructor::class);
        $attribute = array_shift($attributes);

        expect($attribute?->getName())->toBe(
            OverrideConstructor::class,
            sprintf('%s is missing an OverrideConstructor attribute', $type->getName())
        );
    }
});

test('check that Telegram types are json serializable (+ array_filter_null)', function () {
    $typeFaker = Nutgram::fake()->getContainer()->get(TypeFaker::class);

    $allowed = array_map(
        fn (ReflectionClass $class) => $class->getName(),
        getTelegramTypes(TelegramTypeContext::NonAbstract)
    );

    $ignore = [
        Response::class,
    ];

    foreach ($allowed as $type) {
        if (in_array($type, $ignore, true)) {
            continue;
        }

        $result = $typeFaker->fakeInstanceOf($type);

        expect($result)->toBeInstanceOf($type);

        expect(json_encode($result))->toBe(json_encode($result->toArray()));
    }
});
