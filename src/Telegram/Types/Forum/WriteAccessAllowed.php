<?php

namespace SergiX44\Nutgram\Telegram\Types\Forum;

use SergiX44\Nutgram\Telegram\Types\BaseType;

/**
 * This object represents a service message about a user allowing a bot to write messages after adding the bot to the attachment menu or launching a Web App from a link.
 * @see https://core.telegram.org/bots/api#writeaccessallowed
 */
class WriteAccessAllowed extends BaseType
{
    /**
     * Optional.
     * Name of the Web App which was launched from a link
     */
    public ?string $web_app_name = null;
}
