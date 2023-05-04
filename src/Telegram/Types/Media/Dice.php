<?php

namespace SergiX44\Nutgram\Telegram\Types\Media;

use SergiX44\Nutgram\Telegram\Properties\DiceEmoji;
use SergiX44\Nutgram\Telegram\Types\BaseType;

/**
 * This object represents an animated emoji that displays a random value.
 * @see https://core.telegram.org/bots/api#dice
 */
class Dice extends BaseType
{
    /** Emoji on which the dice throw animation is based */
    public DiceEmoji $emoji;

    /** Value of the dice, 1-6 for “”, “” and “” base emoji, 1-5 for “” and “” base emoji, 1-64 for “” base emoji */
    public int $value;
}
