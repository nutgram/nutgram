<?php

namespace SergiX44\Nutgram\Telegram\Types\Sticker;

use SergiX44\Nutgram\Telegram\Types\BaseType;
use SergiX44\Nutgram\Telegram\Types\Chat\Chat;

/**
 * This object describes a unique gift that was upgraded from a regular gift.
 * @see https://core.telegram.org/bots/api#uniquegift
 */
class UniqueGift extends BaseType
{
    /**
     * Identifier of the regular gift from which the gift was upgraded
     */
    public string $gift_id;

    /**
     * Human-readable name of the regular gift from which this unique gift was upgraded
     */
    public string $base_name;

    /**
     * Unique name of the gift. This name can be used in https://t.me/nft/... links and story areas
     */
    public string $name;

    /**
     * Unique number of the upgraded gift among gifts upgraded from the same regular gift
     */
    public int $number;

    /**
     * Model of the gift
     */
    public UniqueGiftModel $model;

    /**
     * Symbol of the gift
     */
    public UniqueGiftSymbol $symbol;

    /**
     * Backdrop of the gift
     */
    public UniqueGiftBackdrop $backdrop;

    /**
     * Optional. True, if the original regular gift was exclusively purchasable by Telegram Premium subscribers
     */
    public ?bool $is_premium = null;

    /**
     * Optional. True, if the gift is assigned from the TON blockchain and can't be resold or transferred in Telegram
     */
    public ?bool $is_from_blockchain = null;

    /**
     * Optional.
     * The color scheme that can be used by the gift's owner for the chat's name, replies to messages and link previews;
     * for business account gifts and gifts that are currently on sale only
     */
    public ?UniqueGiftColors $colors = null;

    /**
     * Optional.
     * Information about the chat that published the gift
     */
    public ?Chat $publisher_chat = null;
}
