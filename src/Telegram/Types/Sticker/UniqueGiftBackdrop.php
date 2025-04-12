<?php

namespace SergiX44\Nutgram\Telegram\Types\Sticker;

use SergiX44\Nutgram\Telegram\Types\BaseType;

/**
 * This object describes the backdrop of a unique gift.
 * @see https://core.telegram.org/bots/api#uniquegiftbackdrop
 */
class UniqueGiftBackdrop extends BaseType
{
    /**
     * Name of the backdrop
     */
    public string $name;

    /**
     * Colors of the backdrop
     */
    public UniqueGiftBackdropColors $colors;

    /**
     * The number of unique gifts that receive this backdrop for every 1000 gifts upgraded
     */
    public int $rarity_per_mille;
}
