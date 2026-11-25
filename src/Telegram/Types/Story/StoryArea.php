<?php

declare(strict_types=1);

namespace SergiX44\Nutgram\Telegram\Types\Story;

use SergiX44\Hydrator\Annotation\OverrideConstructor;
use SergiX44\Nutgram\Telegram\Types\Internal\BaseType;
use SergiX44\Nutgram\Telegram\Types\Common\AreaPosition;

/**
 * Describes a clickable area on a story media.
 * @see https://core.telegram.org/bots/api#storyarea
 */
#[OverrideConstructor('bindToInstance')]
class StoryArea extends BaseType
{
    /**
     * Position of the area
     */
    public AreaPosition $position;

    /**
     * Type of the area
     */
    public StoryAreaType $type;

    public function __construct(AreaPosition $position, StoryAreaType $type)
    {
        parent::__construct();
        $this->position = $position;
        $this->type = $type;
    }
}
