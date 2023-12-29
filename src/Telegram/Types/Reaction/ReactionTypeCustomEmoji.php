<?php

namespace SergiX44\Nutgram\Telegram\Types\Reaction;

use SergiX44\Nutgram\Telegram\Properties\ReactionTypeType;

/**
 * The reaction is based on a custom emoji.
 * @see https://core.telegram.org/bots/api#reactiontypecustomemoji
 */
class ReactionTypeCustomEmoji extends ReactionType
{
    /**
     * Type of the reaction, always “custom_emoji”
     * @var ReactionTypeType
     */
    public ReactionTypeType $type = ReactionTypeType::CUSTOM_EMOJI;

    /**
     * Custom emoji identifier
     * @var string
     */
    public string $custom_emoji;
}
