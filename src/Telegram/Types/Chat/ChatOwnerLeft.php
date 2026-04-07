<?php

declare(strict_types=1);

namespace SergiX44\Nutgram\Telegram\Types\Chat;

use SergiX44\Nutgram\Telegram\Types\BaseType;
use SergiX44\Nutgram\Telegram\Types\User\User;

/**
 * Describes a service message about the chat owner leaving the chat.
 * @see https://core.telegram.org/bots/api#chatownerleft
 */
class ChatOwnerLeft extends BaseType
{
    /**
     * Optional. The user which will be the new owner of the chat if the previous owner does not return to the chat
     */
    public ?User $new_owner = null;
}
