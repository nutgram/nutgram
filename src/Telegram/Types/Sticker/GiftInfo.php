<?php

namespace SergiX44\Nutgram\Telegram\Types\Sticker;

use SergiX44\Hydrator\Annotation\ArrayType;
use SergiX44\Nutgram\Telegram\Types\BaseType;
use SergiX44\Nutgram\Telegram\Types\Message\MessageEntity;

/**
 * Describes a service message about a regular gift that was sent or received.
 * @see https://core.telegram.org/bots/api#giftinfo
 */
class GiftInfo extends BaseType
{
    /**
     * Information about the gift
     */
    public Gift $gift;

    /**
     * Optional. Unique identifier of the received gift for the bot; only present for gifts received on behalf of business accounts
     */
    public ?string $owned_gift_id = null;

    /**
     * Optional. Number of Telegram Stars that can be claimed by the receiver by converting the gift; omitted if conversion to Telegram Stars is impossible
     */
    public ?int $convert_star_count = null;

    /**
     * Optional. Number of Telegram Stars that were prepaid by the sender for the ability to upgrade the gift
     */
    public ?int $prepaid_upgrade_star_count = null;

    /**
     * Optional. True, if the gift can be upgraded to a unique gift
     */
    public ?bool $can_be_upgraded = null;

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
}
