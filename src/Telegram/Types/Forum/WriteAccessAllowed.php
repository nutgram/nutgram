<?php

namespace SergiX44\Nutgram\Telegram\Types\Forum;

use SergiX44\Nutgram\Telegram\Types\BaseType;

class WriteAccessAllowed extends BaseType
{
    /**
     * Optional. Name of the Web App which was launched from a link
     */
    public ?string $web_app_name = null;
}
