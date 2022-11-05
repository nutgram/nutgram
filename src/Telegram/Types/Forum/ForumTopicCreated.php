<?php

namespace SergiX44\Nutgram\Telegram\Types\Forum;

use SergiX44\Nutgram\Telegram\Types\BaseType;

class ForumTopicCreated extends BaseType
{
    /**
     * Name of the topic
     */
    public string $name;

    /**
     * Color of the topic icon in RGB format
     */
    public int $icon_color;

    /**
     * Optional. Unique identifier of the custom emoji shown as the topic icon
     */
    public ?string $icon_custom_emoji_id = null;
}
