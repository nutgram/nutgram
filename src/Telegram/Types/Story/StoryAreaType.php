<?php

declare(strict_types=1);

namespace SergiX44\Nutgram\Telegram\Types\Story;

use SergiX44\Nutgram\Telegram\Types\Internal\Resolvers\StoryAreaTypeResolver;

/**
 * Describes the type of a clickable area on a story. Currently, it can be one of
 * - {@see StoryAreaTypeLocation}
 * - {@see StoryAreaTypeSuggestedReaction}
 * - {@see StoryAreaTypeLink}
 * - {@see StoryAreaTypeWeather}
 * - {@see StoryAreaTypeUniqueGift}
 */
#[StoryAreaTypeResolver]
interface StoryAreaType
{
}
