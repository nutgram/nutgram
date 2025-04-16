<?php

declare(strict_types=1);

namespace SergiX44\Nutgram\Telegram\Types\Reaction;

use SergiX44\Hydrator\Annotation\OverrideConstructor;
use SergiX44\Hydrator\Resolver\EnumOrScalar;
use SergiX44\Nutgram\Telegram\Properties\ReactionTypeType;

/**
 * The reaction is based on a custom emoji.
 * @see https://core.telegram.org/bots/api#reactiontypecustomemoji
 */
#[OverrideConstructor('bindToInstance')]
class ReactionTypeCustomEmoji extends ReactionType
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

    public function __construct(string $custom_emoji_id)
    {
        parent::__construct();
        $this->custom_emoji_id = $custom_emoji_id;
    }
}
