<?php

use SergiX44\Hydrator\Annotation\ConcreteResolver;
use SergiX44\Nutgram\Telegram\Types\BaseType;

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
