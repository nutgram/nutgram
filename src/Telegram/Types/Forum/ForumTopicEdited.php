<?php

namespace SergiX44\Nutgram\Telegram\Types\Forum;

use SergiX44\Nutgram\Telegram\Types\BaseType;

/**
 * This object represents a service message about an edited forum topic.
 * @see https://core.telegram.org/bots/api#forumtopicedited
 */
class ForumTopicEdited extends BaseType
{
    /**
     * Optional.
     * New name of the topic, if it was edited
     */
    public ?string $name = null;

    /**
     * Optional.
     * New identifier of the custom emoji shown as the topic icon, if it was edited;
     * an empty string if the icon was removed
     */
    public ?string $icon_custom_emoji_id = null;
}
