<?php

namespace SergiX44\Nutgram\Telegram\Types\ManagedBot;

use SergiX44\Hydrator\Annotation\ArrayType;
use SergiX44\Nutgram\Telegram\Types\BaseType;
use SergiX44\Nutgram\Telegram\Types\User\User;

/**
 * This object describes the access settings of a bot.
 * @see https://core.telegram.org/bots/api#botaccesssettings
 */
class BotAccessSettings extends BaseType
{
    /**
     * True, if only selected users can access the bot. The bot's owner can always access it.
     */
    public bool $is_access_restricted;

    /**
     * Optional. The list of other users who have access to the bot if the access is restricted
     * @var User[]|null
     */
    #[ArrayType(User::class)]
    public ?array $added_users = null;
}
