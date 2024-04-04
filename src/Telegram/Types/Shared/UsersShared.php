<?php

namespace SergiX44\Nutgram\Telegram\Types\Shared;

use SergiX44\Hydrator\Annotation\ArrayType;
use SergiX44\Nutgram\Telegram\Types\BaseType;

/**
 * This object contains information about the user whose identifier was shared
 * with the bot using a {@see https://core.telegram.org/bots/api#keyboardbuttonrequestuser KeyboardButtonRequestUser} button.
 * @see https://core.telegram.org/bots/api#usersshared
 */
class UsersShared extends BaseType
{
    /** Identifier of the request */
    public int $request_id;

    /**
     * Identifiers of the shared users.
     * These numbers may have more than 32 significant bits and some programming languages may have difficulty/silent defects in interpreting them.
     * But they have at most 52 significant bits, so 64-bit integers or double-precision float types are safe for storing these identifiers.
     * The bot may not have access to the users and could be unable to use these identifiers, unless the users are already known to the bot by some other means.
     * @var int[]
     * @deprecated Please use the {@see users} field instead
     */
    public array $user_ids;

    /**
     * Information about users shared with the bot.
     * @var SharedUser[]
     */
    #[ArrayType(SharedUser::class)]
    public array $users;
}
