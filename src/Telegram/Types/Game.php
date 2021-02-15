<?php

namespace SergiX44\Nutgram\Telegram\Types;

/**
 * This object represents a game.
 * Use BotFather to create and edit games, their short names will act as unique identifiers.
 * @see https://core.telegram.org/bots/api#game
 */
class Game
{
    /**
     * Title of the game
     * @var string $title
     */
    public $title;

    /**
     * Description of the game
     * @var string $description
     */
    public $description;

    /** Photo that will be displayed in the game message in chats.
     * @var PhotoSize[] $photo
     */
    public $photo;

    /**
     * Optional. Brief description of the game or high scores included in the game message.
     * Can be automatically edited to include current high scores for the game when the bot calls
     * {@see https://core.telegram.org/bots/api#setgamescore setGameScore}, or manually edited using
     * {@see https://core.telegram.org/bots/api#editmessagetext editMessageText}. 0-4096 characters.
     * @var string $text
     */
    public $text;

    /**
     * Optional. Special entities that appear in text, such as usernames, URLs, bot commands, etc.
     * @var MessageEntity[] $text_entities
     */
    public $text_entities;

    /**
     * Optional. Animation that will be displayed in the game message in chats.
     * Upload via {@see https://t.me/botfather BotFather}
     * @var Animation $animation
     */
    public $animation;
}
