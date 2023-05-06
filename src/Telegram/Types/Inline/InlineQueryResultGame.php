<?php

namespace SergiX44\Nutgram\Telegram\Types\Inline;

use SergiX44\Nutgram\Telegram\Properties\InlineQueryResultType;
use SergiX44\Nutgram\Telegram\Types\Keyboard\InlineKeyboardMarkup;

/**
 * Represents a {@see https://core.telegram.org/bots/api#games Game}.
 * @see https://core.telegram.org/bots/api#inlinequeryresultgame
 */
class InlineQueryResultGame extends InlineQueryResult
{
    /** Type of the result, must be game */
    public InlineQueryResultType $type = InlineQueryResultType::GAME;

    /** Unique identifier for this result, 1-64 bytes */
    public string $id;

    /** Short name of the game */
    public string $game_short_name;

    /**
     * Optional.
     * {@see https://core.telegram.org/bots/features#inline-keyboards Inline keyboard} attached to the message
     */
    public ?InlineKeyboardMarkup $reply_markup = null;
}
