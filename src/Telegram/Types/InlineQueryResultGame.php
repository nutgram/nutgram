<?php

namespace SergiX44\Nutgram\Telegram\Types;

/**
 * Represents a Game.
 *
 * Note: This will only work in Telegram versions released after October 1, 2016.
 * Older clients will not display any inline results if a game result is among them.
 * @see https://core.telegram.org/bots/api#inlinequeryresultgame
 */
class InlineQueryResultGame
{
    /**
     * Type of the result, must be game
     * @var string
     */
    public string $type;
    
    /**
     * Unique identifier for this result, 1-64 bytes
     * @var string
     */
    public string $id;
    
    /**
     * Short name of the game
     * @var string
     */
    public string $game_short_name;
    
    /**
     * Optional.
     * {@see https://core.telegram.org/bots#inline-keyboards-and-on-the-fly-updating Inline keyboard}
     * attached to the message
     * @var InlineKeyboardMarkup
     */
    public InlineKeyboardMarkup $reply_markup;
}
