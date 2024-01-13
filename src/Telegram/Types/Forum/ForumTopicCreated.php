<?php

namespace SergiX44\Nutgram\Telegram\Types\Forum;

use SergiX44\Hydrator\Resolver\EnumOrScalar;
use SergiX44\Nutgram\Telegram\Properties\ForumIconColor;
use SergiX44\Nutgram\Telegram\Types\BaseType;

/**
 * This object represents a service message about a new forum topic created in the chat.
 * @see https://core.telegram.org/bots/api#forumtopiccreated
 */
class ForumTopicCreated extends BaseType
{
    /** Name of the topic */
    public string $name;

    /** Color of the topic icon in RGB format */
    #[EnumOrScalar]
    public ForumIconColor|int $icon_color;

    /**
     * Optional.
     * Unique identifier of the custom emoji shown as the topic icon
     */
    public ?string $icon_custom_emoji_id = null;
}
