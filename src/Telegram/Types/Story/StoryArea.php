<?php

namespace SergiX44\Nutgram\Telegram\Types\Story;

use SergiX44\Nutgram\Telegram\Types\BaseType;

/**
 * Describes a clickable area on a story media.
 * @see https://core.telegram.org/bots/api#storyarea
 */
class StoryArea extends BaseType
{
    /**
     * Position of the area
     */
    public StoryAreaPosition $position;

    /**
     * Type of the area
     */
    public StoryAreaType $type;
}
