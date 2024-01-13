<?php

namespace SergiX44\Nutgram\Telegram\Types\Forum;

use SergiX44\Hydrator\Resolver\EnumOrScalar;
use SergiX44\Nutgram\Telegram\Properties\ForumIconColor;
use SergiX44\Nutgram\Telegram\Types\BaseType;

/**
 * This object represents a forum topic.
 * @see https://core.telegram.org/bots/api#forumtopic
 */
class ForumTopic extends BaseType
{
    /** Unique identifier of the forum topic */
    public int $message_thread_id;

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
