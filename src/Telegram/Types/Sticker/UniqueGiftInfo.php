<?php

namespace SergiX44\Nutgram\Telegram\Types\Sticker;

use SergiX44\Nutgram\Telegram\Types\BaseType;

/**
 * Describes a service message about a unique gift that was sent or received.
 * @see https://core.telegram.org/bots/api#uniquegiftinfo
 */
class UniqueGiftInfo extends BaseType
{
    /**
     * Information about the gift
     */
    public UniqueGift $gift;

    /**
     * Origin of the gift. Currently, either “upgrade” or “transfer”
     */
    public string $origin;

    /**
     * Optional. Unique identifier of the received gift for the bot; only present for gifts received on behalf of business accounts
     */
    public ?string $owned_gift_id = null;

    /**
     * Optional. Number of Telegram Stars that must be paid to transfer the gift; omitted if the bot cannot transfer the gift
     */
    public ?int $transfer_star_count = null;
}
