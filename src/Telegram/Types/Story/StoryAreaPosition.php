<?php

namespace SergiX44\Nutgram\Telegram\Types\Story;

use SergiX44\Hydrator\Annotation\SkipConstructor;
use SergiX44\Nutgram\Telegram\Types\Common\AreaPosition;

/**
 * Describes the position of a clickable area within a story.
 * @see https://core.telegram.org/bots/api#storyareaposition
 * @deprecated Please use {@see AreaPosition}
 */
#[SkipConstructor]
class StoryAreaPosition extends AreaPosition
{
}
