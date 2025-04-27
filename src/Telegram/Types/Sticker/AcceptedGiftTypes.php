<?php

namespace SergiX44\Nutgram\Telegram\Types\Sticker;

use SergiX44\Hydrator\Annotation\SkipConstructor;
use SergiX44\Nutgram\Telegram\Types\BaseType;

/**
 * This object describes the types of gifts that can be gifted to a user or a chat.
 * @see https://core.telegram.org/bots/api#acceptedgifttypes
 */
#[SkipConstructor]
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

    public function __construct(
        bool $unlimited_gifts,
        bool $limited_gifts,
        bool $unique_gifts,
        bool $premium_subscription
    ) {
        parent::__construct();
        $this->unlimited_gifts = $unlimited_gifts;
        $this->limited_gifts = $limited_gifts;
        $this->unique_gifts = $unique_gifts;
        $this->premium_subscription = $premium_subscription;
    }
}
