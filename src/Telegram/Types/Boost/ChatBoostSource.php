<?php

declare(strict_types=1);

namespace SergiX44\Nutgram\Telegram\Types\Boost;

use SergiX44\Hydrator\Resolver\EnumOrScalar;
use SergiX44\Nutgram\Telegram\Properties\ChatBoostSourceSource;
use SergiX44\Nutgram\Telegram\Types\BaseType;
use SergiX44\Nutgram\Telegram\Types\Internal\Resolvers\ChatBoostSourceResolver;

/**
 * This object describes the source of a chat boost. It can be one of
 * - {@see ChatBoostSourcePremium}
 * - {@see ChatBoostSourceGiftCode}
 * - {@see ChatBoostSourceGiveaway}
 * @see https://core.telegram.org/bots/api#chatboostsource
 */
#[ChatBoostSourceResolver]
abstract class ChatBoostSource extends BaseType
{
    /**
     * Source of the boost
     */
    #[EnumOrScalar]
    public ChatBoostSourceSource|string $source;
}
