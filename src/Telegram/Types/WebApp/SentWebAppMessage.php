<?php

namespace SergiX44\Nutgram\Telegram\Types\WebApp;

use SergiX44\Nutgram\Telegram\Types\BaseType;

/**
 * Describes an inline message sent by a {@see https://core.telegram.org/bots/webapps Web App} on behalf of a user.
 * @see https://core.telegram.org/bots/api#sentwebappmessage
 */
class SentWebAppMessage extends BaseType
{
    /**
     * Optional.
     * Identifier of the sent inline message.
     * Available only if there is an {@see https://core.telegram.org/bots/api#inlinekeyboardmarkup inline keyboard} attached to the message.
     */
    public ?string $inline_message_id = null;
}
