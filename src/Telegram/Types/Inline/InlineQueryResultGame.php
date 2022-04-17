<?php

namespace SergiX44\Nutgram\Telegram\Types\Inline;

use SergiX44\Nutgram\Telegram\Types\BaseType;
use SergiX44\Nutgram\Telegram\Types\Keyboard\InlineKeyboardMarkup;

/**
 * Represents a Game.
 *
 * Note: This will only work in Telegram versions released after October 1, 2016.
 * Older clients will not display any inline results if a game result is among them.
 * @see https://core.telegram.org/bots/api#inlinequeryresultgame
 */
class InlineQueryResultGame extends InlineQueryResult
{
    /**
     * Type of the result, must be game
     */
    public string $type;

    /**
     * Unique identifier for this result, 1-64 bytes
     */
    public string $id;

    /**
     * Short name of the game
     */
    public string $game_short_name;

    /**
     * Optional.
     * {@see https://core.telegram.org/bots#inline-keyboards-and-on-the-fly-updating Inline keyboard}
     * attached to the message
     */
    public ?InlineKeyboardMarkup $reply_markup = null;
}
