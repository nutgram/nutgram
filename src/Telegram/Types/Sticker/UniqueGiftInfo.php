<?php

namespace SergiX44\Nutgram\Telegram\Types\Sticker;

use SergiX44\Hydrator\Resolver\EnumOrScalar;
use SergiX44\Nutgram\Telegram\Properties\UniqueGiftInfoOrigin;
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
     * Origin of the gift.
     * Currently, either
     * “upgrade” for gifts upgraded from regular gifts,
     * “transfer” for gifts transferred from other users or channels,
     * “resale” for gifts bought from other users,
     * “gifted_upgrade” for upgrades purchased after the gift was sent, or
     * “offer” for gifts bought or sold through gift purchase offers
     */
    #[EnumOrScalar]
    public UniqueGiftInfoOrigin|string $origin;

    /**
     * Optional.
     * For gifts bought from other users, the currency in which the payment for the gift was done.
     * Currently, one of “XTR” for Telegram Stars or “TON” for toncoins.
     */
    public ?string $last_resale_currency = null;

    /**
     * Optional.
     * For gifts bought from other users, the price paid for the gift in either Telegram Stars or nanotoncoins
     */
    public ?int $last_resale_amount = null;

    /**
     * Optional. Unique identifier of the received gift for the bot; only present for gifts received on behalf of business accounts
     */
    public ?string $owned_gift_id = null;

    /**
     * Optional. Number of Telegram Stars that must be paid to transfer the gift; omitted if the bot cannot transfer the gift
     */
    public ?int $transfer_star_count = null;

    /**
     * Optional. Point in time (Unix timestamp) when the gift can be transferred. If it is in the past, then the gift can be transferred now
     */
    public ?int $next_transfer_date = null;
}
