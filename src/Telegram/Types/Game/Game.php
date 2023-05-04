<?php

namespace SergiX44\Nutgram\Telegram\Types\Game;

use SergiX44\Hydrator\Annotation\ArrayType;
use SergiX44\Nutgram\Telegram\Types\BaseType;
use SergiX44\Nutgram\Telegram\Types\Media\Animation;
use SergiX44\Nutgram\Telegram\Types\Media\PhotoSize;
use SergiX44\Nutgram\Telegram\Types\Message\MessageEntity;

/**
 * This object represents a game.
 * Use BotFather to create and edit games, their short names will act as unique identifiers.
 * @see https://core.telegram.org/bots/api#game
 */
class Game extends BaseType
{
    /** Title of the game */
    public string $title;

    /** Description of the game */
    public string $description;

    /**
     * Photo that will be displayed in the game message in chats.
     * @var PhotoSize[] $photo
     */
    #[ArrayType(PhotoSize::class)]
    public array $photo;

    /**
     * Optional.
     * Brief description of the game or high scores included in the game message.
     * Can be automatically edited to include current high scores for the game when the bot calls {@see https://core.telegram.org/bots/api#setgamescore setGameScore}, or manually edited using {@see https://core.telegram.org/bots/api#editmessagetext editMessageText}.
     * 0-4096 characters.
     */
    public ?string $text = null;

    /**
     * Optional.
     * Special entities that appear in text, such as usernames, URLs, bot commands, etc.
     * @var MessageEntity[] $text_entities
     */
    #[ArrayType(MessageEntity::class)]
    public ?array $text_entities = null;

    /**
     * Optional.
     * Animation that will be displayed in the game message in chats.
     * Upload via {@see https://t.me/botfather BotFather}
     */
    public ?Animation $animation = null;
}
