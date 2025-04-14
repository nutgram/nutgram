<?php

namespace SergiX44\Nutgram\Telegram\Types\Sticker;

use SergiX44\Hydrator\Annotation\ArrayType;
use SergiX44\Hydrator\Resolver\EnumOrScalar;
use SergiX44\Nutgram\Telegram\Properties\OwnedGiftType;
use SergiX44\Nutgram\Telegram\Types\Message\MessageEntity;

/**
 * Describes a regular gift owned by a user or a chat.
 * @see https://core.telegram.org/bots/api#ownedgiftregular
 */
class OwnedGiftRegular extends OwnedGift
{
    /**
     * Type of the gift, always “regular”
     */
    #[EnumOrScalar]
    public OwnedGiftType|string $type = OwnedGiftType::REGULAR;

    /**
     * Information about the regular gift
     */
    public Gift $gift;

    /**
     * Optional. Text of the message that was added to the gift
     */
    public ?string $text = null;

    /**
     * Optional. Special entities that appear in the text
     * @var MessageEntity[]
     */
    #[ArrayType(MessageEntity::class)]
    public ?array $entities = null;

    /**
     * Optional. True, if the sender and gift text are shown only to the gift receiver; otherwise, everyone will be able to see them
     */
    public ?bool $is_private = null;

    /**
     * Optional. True, if the gift can be upgraded to a unique gift; for gifts received on behalf of business accounts only
     */
    public ?bool $can_be_upgraded = null;

    /**
     * Optional. True, if the gift was refunded and isn't available anymore
     */
    public ?bool $was_refunded = null;

    /**
     * Optional. Number of Telegram Stars that can be claimed by the receiver instead of the gift; omitted if the gift cannot be converted to Telegram Stars
     */
    public ?int $convert_star_count = null;

    /**
     * Optional. Number of Telegram Stars that were paid by the sender for the ability to upgrade the gift
     */
    public ?int $prepaid_upgrade_star_count = null;
}
