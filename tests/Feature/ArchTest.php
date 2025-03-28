<?php

use SergiX44\Nutgram\Telegram\Types\BaseType;
use SergiX44\Nutgram\Telegram\Types\Boost\ChatBoostSourceResolver;
use SergiX44\Nutgram\Telegram\Types\Chat\ChatMemberResolver;
use SergiX44\Nutgram\Telegram\Types\Command\BotCommand;
use SergiX44\Nutgram\Telegram\Types\Command\BotCommandScopeResolver;
use SergiX44\Nutgram\Telegram\Types\Command\MenuButtonResolver;
use SergiX44\Nutgram\Telegram\Types\Message\BackgroundFillResolver;
use SergiX44\Nutgram\Telegram\Types\Message\BackgroundTypeResolver;
use SergiX44\Nutgram\Telegram\Types\Message\MessageOriginResolver;
use SergiX44\Nutgram\Telegram\Types\Payment\PaidMediaResolver;
use SergiX44\Nutgram\Telegram\Types\Payment\RevenueWithdrawalStateResolver;
use SergiX44\Nutgram\Telegram\Types\Payment\TransactionPartnerResolver;
use SergiX44\Nutgram\Telegram\Types\Reaction\ReactionTypeResolver;

arch('check that the code is using strict types')
    ->expect('SergiX44\Nutgram')
    ->toUseStrictTypes();

arch('check that Telegram types extends BaseType')
    ->expect('SergiX44\Nutgram\Telegram\Types')
    ->classes()
    ->toExtend(BaseType::class)
    ->ignoring([
        'SergiX44\Nutgram\Telegram\Types\Internal',
        ChatBoostSourceResolver::class,
        ChatMemberResolver::class,
        BotCommandScopeResolver::class,
        MenuButtonResolver::class,
        BackgroundFillResolver::class,
        BackgroundTypeResolver::class,
        MessageOriginResolver::class,
        PaidMediaResolver::class,
        RevenueWithdrawalStateResolver::class,
        TransactionPartnerResolver::class,
        ReactionTypeResolver::class,
    ]);
