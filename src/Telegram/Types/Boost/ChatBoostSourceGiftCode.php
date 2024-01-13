<?php

namespace SergiX44\Nutgram\Telegram\Types\Boost;

use SergiX44\Hydrator\Resolver\EnumOrScalar;
use SergiX44\Nutgram\Telegram\Properties\ChatBoostSourceSource;
use SergiX44\Nutgram\Telegram\Types\User\User;

/**
 * The boost was obtained by the creation of Telegram Premium gift codes to boost a chat.
 * Each such code boosts the chat 4 times for the duration of the corresponding Telegram Premium subscription.
 * @see https://core.telegram.org/bots/api#chatboostsourcegiftcode
 */
class ChatBoostSourceGiftCode extends ChatBoostSource
{
    /**
     * Source of the boost, always “gift_code”
     */
    #[EnumOrScalar]
    public ChatBoostSourceSource|string $source = ChatBoostSourceSource::GIFT_CODE;

    /**
     * User for which the gift code was created
     */
    public ?User $user;
}
