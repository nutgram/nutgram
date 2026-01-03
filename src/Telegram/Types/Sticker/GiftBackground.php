<?php

namespace SergiX44\Nutgram\Telegram\Types\Sticker;

use SergiX44\Nutgram\Telegram\Types\BaseType;

/**
 * This object describes the background of a gift.
 * @see https://core.telegram.org/bots/api#giftbackground
 */
class GiftBackground extends BaseType
{
    /**
     * Center color of the background in RGB format
     */
    public int $center_color;

    /**
     * Edge color of the background in RGB format
     */
    public int $edge_color;

    /**
     * Text color of the background in RGB format
     */
    public int $text_color;
}
