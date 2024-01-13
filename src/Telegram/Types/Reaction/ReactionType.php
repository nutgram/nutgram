<?php

namespace SergiX44\Nutgram\Telegram\Types\Reaction;

use SergiX44\Hydrator\Resolver\EnumOrScalar;
use SergiX44\Nutgram\Telegram\Properties\ReactionTypeType;
use SergiX44\Nutgram\Telegram\Types\BaseType;

/**
 * This object describes the type of a reaction. Currently, it can be one of:
 * - {@see ReactionTypeEmoji ReactionTypeEmoji}
 * - {@see ReactionTypeCustomEmoji ReactionTypeCustomEmoji}
 * @see https://core.telegram.org/bots/api#reactiontype
 */
#[ReactionTypeResolver]
abstract class ReactionType extends BaseType
{
    /**
     * Type of the reaction
     * @var string|ReactionTypeType
     */
    #[EnumOrScalar]
    public ReactionTypeType|string $type;
}
