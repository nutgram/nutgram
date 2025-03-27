<?php

declare(strict_types=1);

namespace SergiX44\Nutgram\Telegram\Types\Reaction;

use JsonSerializable;
use SergiX44\Hydrator\Resolver\EnumOrScalar;
use SergiX44\Nutgram\Telegram\Properties\ReactionTypeType;
use function SergiX44\Nutgram\Support\array_filter_null;

/**
 * The reaction is based on a custom emoji.
 * @see https://core.telegram.org/bots/api#reactiontypecustomemoji
 */
class ReactionTypeCustomEmoji extends ReactionType implements JsonSerializable
{
    /**
     * Type of the reaction, always “custom_emoji”
     * @var ReactionTypeType|string
     */
    #[EnumOrScalar]
    public ReactionTypeType|string $type = ReactionTypeType::CUSTOM_EMOJI;

    /**
     * Custom emoji identifier
     * @var string
     */
    public string $custom_emoji_id;

    public static function make(string $custom_emoji_id): self
    {
        $instance = new self;
        $instance->custom_emoji_id = $custom_emoji_id;

        return $instance;
    }

    public function jsonSerialize(): array
    {
        return array_filter_null([
            'type' => $this->type,
            'custom_emoji_id' => $this->custom_emoji_id,
        ]);
    }
}
