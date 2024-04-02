<?php

namespace SergiX44\Nutgram\Telegram\Types\Shared;

use SergiX44\Hydrator\Annotation\ArrayType;
use SergiX44\Nutgram\Telegram\Types\BaseType;
use SergiX44\Nutgram\Telegram\Types\Media\PhotoSize;

/**
 * This object contains information about a user that was shared with the bot
 * using a {@see https://core.telegram.org/bots/api#keyboardbuttonrequestuser KeyboardButtonRequestUser} button.
 * @see https://core.telegram.org/bots/api#shareduser
 */
class SharedUser extends BaseType
{
    /**
     * Identifier of the shared user.
     * This number may have more than 32 significant bits and some programming languages may have difficulty/silent defects in interpreting it.
     * But it has at most 52 significant bits, so 64-bit integers or double-precision float types are safe for storing these identifiers.
     * The bot may not have access to the user and could be unable to use this identifier, unless the user is already known to the bot by some other means.
     */
    public int $user_id;

    /**
     * Optional. First name of the user, if the name was requested by the bot
     */
    public ?string $first_name = null;

    /**
     * Optional. Last name of the user, if the name was requested by the bot
     */
    public ?string $last_name = null;

    /**
     * Optional. Username of the user, if the username was requested by the bot
     */
    public ?string $username = null;

    /**
     * Optional. Available sizes of the chat photo, if the photo was requested by the bot
     * @var PhotoSize[]|null
     */
    #[ArrayType(PhotoSize::class)]
    public ?array $photo = null;
}
