<?php

declare(strict_types=1);

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
     * Information about users shared with the bot.
     * @var SharedUser[]
     */
    #[ArrayType(SharedUser::class)]
    public array $users;
}
