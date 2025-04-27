<?php

namespace SergiX44\Nutgram\Telegram\Types\Story;

use SergiX44\Hydrator\Annotation\SkipConstructor;
use SergiX44\Nutgram\Telegram\Types\BaseType;

/**
 * Describes a clickable area on a story media.
 * @see https://core.telegram.org/bots/api#storyarea
 */
#[SkipConstructor]
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

    public function __construct(StoryAreaPosition $position, StoryAreaType $type)
    {
        parent::__construct();
        $this->position = $position;
        $this->type = $type;
    }
}
