<?php

namespace SergiX44\Nutgram\Telegram\Types\Sticker;

use SergiX44\Nutgram\Telegram\Types\BaseType;

/**
 * This object describes the colors of the backdrop of a unique gift.
 * @see https://core.telegram.org/bots/api#uniquegiftbackdropcolors
 */
class UniqueGiftBackdropColors extends BaseType
{
    /**
     * The color in the center of the backdrop in RGB format
     */
    public int $center_color;

    /**
     * The color on the edges of the backdrop in RGB format
     */
    public int $edge_color;

    /**
     * The color to be applied to the symbol in RGB format
     */
    public int $symbol_color;

    /**
     * The color for the text on the backdrop in RGB format
     */
    public int $text_color;
}
