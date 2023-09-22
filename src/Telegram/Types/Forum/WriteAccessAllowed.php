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
     * Optional. True, if the access was granted after the user accepted an explicit request from a
     * Web App sent by the method {@see https://core.telegram.org/bots/webapps#initializing-mini-apps requestWriteAccess}
     */
    public ?bool $from_request = null;
    /**
     * Optional.
     * Name of the Web App which was launched from a link
     */
    public ?string $web_app_name = null;

    /**
     * Optional. True, if the access was granted when the bot was added to the attachment or side menu
     */
    public ?bool $from_attachment_menu = null;
}
