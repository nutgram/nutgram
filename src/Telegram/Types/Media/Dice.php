<?php

namespace SergiX44\Nutgram\Telegram\Types\Media;

/**
 * This object represents a dice with a random value from 1 to 6 for currently supported base emoji.
 * (Yes, we're aware of the “proper” singular of die.
 * But it's awkward, and we decided to help it change. One dice at a time!)
 * @see https://core.telegram.org/bots/api#dice
 */
class Dice
{
    /**
     * Emoji on which the dice throw animation is based
     * @var string $emoji
     */
    public $emoji;

    /**
     * Value of the dice, 1-6 for “🎲” and “🎯” base emoji, 1-5 for “🏀” base emoji
     * @var int $value
     */
    public $value;
}
