<?php

namespace SergiX44\Nutgram\Telegram\Types\Sticker;

use SergiX44\Hydrator\Resolver\EnumOrScalar;
use SergiX44\Nutgram\Telegram\Properties\OwnedGiftType;

/**
 * Describes a unique gift received and owned by a user or a chat.
 * @see https://core.telegram.org/bots/api#ownedgiftunique
 */
class OwnedGiftUnique extends OwnedGift
{
    /**
     * Type of the gift, always “unique”
     */
    #[EnumOrScalar]
    public OwnedGiftType|string $type = OwnedGiftType::UNIQUE;

    /**
     * Information about the unique gift
     */
    public UniqueGift $gift;

    /**
     * Optional. True, if the gift can be transferred to another owner; for gifts received on behalf of business accounts only
     */
    public ?bool $can_be_transferred = null;

    /**
     * Optional. Number of Telegram Stars that must be paid to transfer the gift; omitted if the bot cannot transfer the gift
     */
    public ?int $transfer_star_count = null;
}
