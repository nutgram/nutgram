<?php

namespace SergiX44\Nutgram\Telegram\Types\Reaction;

use JsonSerializable;
use SergiX44\Hydrator\Resolver\EnumOrScalar;
use SergiX44\Nutgram\Telegram\Properties\ReactionTypeType;
use function SergiX44\Nutgram\Support\array_filter_null;

/**
 * The reaction is paid.
 * @see https://core.telegram.org/bots/api#reactiontypepaid
 */
class ReactionTypePaid extends ReactionType implements JsonSerializable
{
    /**
     * Type of the reaction, always “paid”
     * @var ReactionTypeType|string
     */
    #[EnumOrScalar]
    public ReactionTypeType|string $type = ReactionTypeType::PAID;

    public function jsonSerialize(): array
    {
        return array_filter_null([
            'type' => $this->type,
        ]);
    }
}
