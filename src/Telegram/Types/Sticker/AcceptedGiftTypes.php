<?php

namespace SergiX44\Nutgram\Telegram\Types\Sticker;

use SergiX44\Nutgram\Telegram\Types\BaseType;

/**
 * This object describes the types of gifts that can be gifted to a user or a chat.
 * @see https://core.telegram.org/bots/api#acceptedgifttypes
 */
class AcceptedGiftTypes extends BaseType
{
    /**
     * True, if unlimited regular gifts are accepted
     */
    public bool $unlimited_gifts;
    /**
     * True, if limited regular gifts are accepted
     */
    public bool $limited_gifts;
    /**
     * True, if unique gifts or gifts that can be upgraded to unique for free are accepted
     */
    public bool $unique_gifts;
    /**
     * True, if a Telegram Premium subscription is accepted
     */
    public bool $premium_subscription;
}
