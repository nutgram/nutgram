<?php

namespace SergiX44\Nutgram\Telegram\Types\Sticker;

use JsonSerializable;
use SergiX44\Hydrator\Resolver\EnumOrScalar;
use SergiX44\Nutgram\Telegram\Properties\OwnedGiftType;
use SergiX44\Nutgram\Telegram\Types\BaseType;
use SergiX44\Nutgram\Telegram\Types\User\User;

/**
 * This object describes a gift received and owned by a user or a chat. Currently, it can be one of
 * - {@see OwnedGiftRegular}
 * - {@see OwnedGiftUnique}
 * @see https://core.telegram.org/bots/api#ownedgift
 */
#[OwnedGiftResolver]
abstract class OwnedGift extends BaseType implements JsonSerializable
{
    #[EnumOrScalar]
    public OwnedGiftType|string $type;

    /**
     * Optional. Unique identifier of the received gift for the bot; for gifts received on behalf of business accounts only
     */
    public ?string $owned_gift_id = null;

    /**
     * Optional. Sender of the gift if it is a known user
     */
    public ?User $sender_user = null;

    /**
     * Date the gift was sent in Unix time
     */
    public int $send_date;

    /**
     * Optional. True, if the gift is displayed on the account's profile page; for gifts received on behalf of business accounts only
     */
    public ?bool $is_saved = null;

    public function jsonSerialize(): array
    {
        return $this->toArray();
    }
}
