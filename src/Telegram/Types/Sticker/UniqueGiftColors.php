<?php

namespace SergiX44\Nutgram\Telegram\Types\Sticker;

use SergiX44\Nutgram\Telegram\Types\BaseType;

/**
 * This object contains information about the color scheme for a user's name, message replies and link previews based on a unique gift.
 * @see https://core.telegram.org/bots/api#uniquegiftcolors
 */
class UniqueGiftColors extends BaseType
{
    /**
     * Custom emoji identifier of the unique gift's model
     */
    public string $model_custom_emoji_id;

    /**
     * Custom emoji identifier of the unique gift's symbol
     */
    public string $symbol_custom_emoji_id;

    /**
     * Main color used in light themes; RGB format
     */
    public int $light_theme_main_color;

    /**
     * List of 1-3 additional colors used in light themes; RGB format
     * @var int[]
     */
    public array $light_theme_other_colors;

    /**
     * Main color used in dark themes; RGB format
     */
    public int $dark_theme_main_color;

    /**
     * List of 1-3 additional colors used in dark themes; RGB format
     * @var int[]
     */
    public array $dark_theme_other_colors;
}
