<?php

namespace SergiX44\Nutgram\Telegram\Types\Inline;

use SergiX44\Hydrator\Resolver\EnumOrScalar;
use SergiX44\Nutgram\Telegram\Properties\InlineQueryResultType;
use SergiX44\Nutgram\Telegram\Types\Keyboard\InlineKeyboardMarkup;
use function SergiX44\Nutgram\Support\array_filter_null;

/**
 * Represents a {@see https://core.telegram.org/bots/api#games Game}.
 * @see https://core.telegram.org/bots/api#inlinequeryresultgame
 */
class InlineQueryResultGame extends InlineQueryResult
{
    /** Type of the result, must be game */
    #[EnumOrScalar]
    public InlineQueryResultType|string $type = InlineQueryResultType::GAME;

    /** Unique identifier for this result, 1-64 bytes */
    public string $id;

    /** Short name of the game */
    public string $game_short_name;

    /**
     * Optional.
     * {@see https://core.telegram.org/bots/features#inline-keyboards Inline keyboard} attached to the message
     */
    public ?InlineKeyboardMarkup $reply_markup = null;

    public function __construct(
        string $id,
        string $game_short_name,
        ?InlineKeyboardMarkup $reply_markup = null,
    ) {
        parent::__construct();
        $this->id = $id;
        $this->game_short_name = $game_short_name;
        $this->reply_markup = $reply_markup;
    }

    public static function make(
        string $id,
        string $game_short_name,
        ?InlineKeyboardMarkup $reply_markup = null,
    ): self {
        return new self(
            id: $id,
            game_short_name: $game_short_name,
            reply_markup: $reply_markup
        );
    }

    public function jsonSerialize(): array
    {
        return array_filter_null([
            'type' => $this->type->value,
            'id' => $this->id,
            'game_short_name' => $this->game_short_name,
            'reply_markup' => $this->reply_markup,
        ]);
    }
}
