<?php

namespace SergiX44\Nutgram\Telegram\Types\Chat;

use SergiX44\Nutgram\Telegram\Types\BaseType;
use SergiX44\Nutgram\Telegram\Types\User\User;

/**
 * Describes a service message about an ownership change in the chat.
 * @see https://core.telegram.org/bots/api#chatownerchanged
 */
class ChatOwnerChanged extends BaseType
{
    /**
     * The new owner of the chat
     */
    public User $new_owner;
}
