<?php

namespace SergiX44\Nutgram\Telegram\Types\Story;

use SergiX44\Hydrator\Resolver\EnumOrScalar;
use SergiX44\Nutgram\Telegram\Properties\StoryAreaTypeType;
use SergiX44\Nutgram\Telegram\Types\BaseType;
use SergiX44\Nutgram\Telegram\Types\Reaction\ReactionType;

/**
 * Describes a story area pointing to a suggested reaction. Currently, a story can have up to 5 suggested reaction areas.
 * @see https://core.telegram.org/bots/api#storyareatypesuggestedreaction
 */
class StoryAreaTypeSuggestedReaction extends BaseType
{
    /**
     * Type of the area, always “suggested_reaction”
     */
    #[EnumOrScalar]
    public StoryAreaTypeType|string $type = StoryAreaTypeType::SUGGESTED_REACTION;

    /**
     * Type of the reaction
     */
    public ReactionType $reaction_type;

    /**
     * Optional. Pass True if the reaction area has a dark background
     */
    public ?bool $is_dark = null;

    /**
     * Optional. Pass True if reaction area corner is flipped
     */
    public ?bool $is_flipped = null;
}
