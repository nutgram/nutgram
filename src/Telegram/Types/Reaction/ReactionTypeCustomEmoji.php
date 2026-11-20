<?php

declare(strict_types=1);

namespace SergiX44\Nutgram\Telegram\Types\Reaction;

use SergiX44\Hydrator\Annotation\OverrideConstructor;
use SergiX44\Hydrator\Resolver\EnumOrScalar;
use SergiX44\Nutgram\Telegram\Properties\ReactionTypeType;
use SergiX44\Nutgram\Telegram\Types\Internal\BaseType;

/**
 * The reaction is based on a custom emoji.
 * @see https://core.telegram.org/bots/api#reactiontypecustomemoji
 */
#[OverrideConstructor('bindToInstance')]
class ReactionTypeCustomEmoji extends BaseType implements ReactionType
{
    /**
     * Type of the reaction, always “custom_emoji”
     */
    #[EnumOrScalar]
    public ReactionTypeType|string $type = ReactionTypeType::CUSTOM_EMOJI;

    /**
     * Custom emoji identifier
     */
    public string $custom_emoji_id;

    public function __construct(string $custom_emoji_id)
    {
        parent::__construct();
        $this->custom_emoji_id = $custom_emoji_id;
    }
}
