<?php

namespace SergiX44\Nutgram\Telegram\Types\Sticker;

use SergiX44\Nutgram\Telegram\Types\BaseType;

/**
 * This object describes the model of a unique gift.
 * @see https://core.telegram.org/bots/api#uniquegiftmodel
 */
class UniqueGiftModel extends BaseType
{
    /**
     * Name of the model
     */
    public string $name;

    /**
     * The sticker that represents the unique gift
     */
    public Sticker $sticker;

    /**
     * The number of unique gifts that receive this model for every 1000 gifts upgraded
     */
    public int $rarity_per_mille;
}
