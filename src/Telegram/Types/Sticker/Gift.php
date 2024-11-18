<?php

namespace SergiX44\Nutgram\Telegram\Types\Sticker;

use SergiX44\Nutgram\Telegram\Types\BaseType;

/**
 * This object represents a gift that can be sent by the bot.
 * @see https://core.telegram.org/bots/api#gift
 */
class Gift extends BaseType
{
    /**
     * Unique identifier of the gift
     */
    public string $id;

    /**
     * The sticker that represents the gift
     */
    public Sticker $sticker;

    /**
     * The number of Telegram Stars that must be paid to send the sticker
     */
    public int $star_count;

    /**
     * Optional.
     * The total number of the gifts of this type that can be sent; for limited gifts only
     */
    public ?int $total_count = null;

    /**
     * Optional.
     * The number of remaining gifts of this type that can be sent; for limited gifts only
     */
    public ?int $remaining_count = null;
}
