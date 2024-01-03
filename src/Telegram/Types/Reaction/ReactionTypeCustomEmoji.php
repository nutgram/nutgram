<?php

namespace SergiX44\Nutgram\Telegram\Types\Reaction;

use JsonSerializable;
use SergiX44\Hydrator\Annotation\SkipConstructor;
use SergiX44\Nutgram\Telegram\Properties\ReactionTypeType;
use function SergiX44\Nutgram\Support\array_filter_null;

/**
 * The reaction is based on a custom emoji.
 * @see https://core.telegram.org/bots/api#reactiontypecustomemoji
 */
#[SkipConstructor]
class ReactionTypeCustomEmoji extends ReactionType implements JsonSerializable
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

    public function __construct(string $custom_emoji)
    {
        parent::__construct();
        $this->custom_emoji = $custom_emoji;
    }

    public static function make(string $custom_emoji): self
    {
        return new self(custom_emoji: $custom_emoji);
    }

    public function jsonSerialize(): array
    {
        return array_filter_null([
            'type' => $this->type->value,
            'custom_emoji' => $this->custom_emoji,
        ]);
    }
}
