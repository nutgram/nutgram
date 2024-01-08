<?php

namespace SergiX44\Nutgram\Telegram\Types\Boost;

use SergiX44\Hydrator\Resolver\EnumOrScalar;
use SergiX44\Nutgram\Telegram\Properties\ChatBoostSourceSource;
use SergiX44\Nutgram\Telegram\Types\User\User;

/**
 * The boost was obtained by subscribing to Telegram Premium or by gifting a Telegram Premium subscription to another user.
 * @see https://core.telegram.org/bots/api#chatboostsourcepremium
 */
class ChatBoostSourcePremium extends ChatBoostSource
{
    /**
     * Source of the boost, always “premium”
     */
    #[EnumOrScalar]
    public ChatBoostSourceSource|string $source = ChatBoostSourceSource::PREMIUM;

    /**
     * User that boosted the chat
     */
    public ?User $user;
}
