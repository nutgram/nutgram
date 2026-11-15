<?php

declare(strict_types=1);

namespace SergiX44\Nutgram\Telegram\Types\Story;

use SergiX44\Nutgram\Telegram\Types\Common\AreaPosition;
use SergiX44\Hydrator\Annotation\OverrideConstructor;

/**
 * Describes the position of a clickable area within a story.
 * @see https://core.telegram.org/bots/api#storyareaposition
 * @deprecated Please use {@see AreaPosition}
 */
#[OverrideConstructor('bindToInstance')]
class StoryAreaPosition extends AreaPosition
{
}
