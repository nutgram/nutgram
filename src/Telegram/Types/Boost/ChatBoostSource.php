<?php

declare(strict_types=1);

namespace SergiX44\Nutgram\Telegram\Types\Boost;

use SergiX44\Nutgram\Telegram\Types\Internal\Resolvers\ChatBoostSourceResolver;
use SergiX44\Nutgram\Telegram\Types\User\User;

/**
 * This object describes the source of a chat boost. It can be one of
 * - {@see ChatBoostSourcePremium}
 * - {@see ChatBoostSourceGiftCode}
 * - {@see ChatBoostSourceGiveaway}
 * @see https://core.telegram.org/bots/api#chatboostsource
 */
#[ChatBoostSourceResolver]
interface ChatBoostSource
{
    public ?User $user = null {
        get;
        set;
    }
}
