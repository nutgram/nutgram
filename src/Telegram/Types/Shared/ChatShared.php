<?php

namespace SergiX44\Nutgram\Telegram\Types\Shared;

use SergiX44\Hydrator\Annotation\ArrayType;
use SergiX44\Nutgram\Telegram\Types\BaseType;
use SergiX44\Nutgram\Telegram\Types\Media\PhotoSize;

/**
 * This object contains information about the chat whose identifier was shared with the bot using a {@see https://core.telegram.org/bots/api#keyboardbuttonrequestchat KeyboardButtonRequestChat} button.
 * @see https://core.telegram.org/bots/api#chatshared
 */
class ChatShared extends BaseType
{
    /** Identifier of the request */
    public int $request_id;

    /**
     * Identifier of the shared chat.
     * This number may have more than 32 significant bits and some programming languages may have difficulty/silent defects in interpreting it.
     * But it has at most 52 significant bits, so a 64-bit integer or double-precision float type are safe for storing this identifier.
     * The bot may not have access to the chat and could be unable to use this identifier, unless the chat is already known to the bot by some other means.
     */
    public int $chat_id;

    /**
     * Optional. Title of the chat, if the title was requested by the bot.
     */
    public ?string $title = null;

    /**
     * Optional. Username of the chat, if the username was requested by the bot and available.
     */
    public ?string $username = null;

    /**
     * Optional. Available sizes of the chat photo, if the photo was requested by the bot
     * @var PhotoSize[]|null
     */
    #[ArrayType(PhotoSize::class)]
    public ?array $photo = null;
}
