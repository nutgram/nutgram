<?php

declare(strict_types=1);

namespace SergiX44\Nutgram\Telegram\Types\Reaction;

use SergiX44\Hydrator\Resolver\EnumOrScalar;
use SergiX44\Nutgram\Telegram\Properties\ReactionTypeType;

/**
 * The reaction is paid.
 * @see https://core.telegram.org/bots/api#reactiontypepaid
 */
class ReactionTypePaid extends ReactionType
{
    /**
     * Type of the reaction, always “paid”
     * @var ReactionTypeType|string
     */
    #[EnumOrScalar]
    public ReactionTypeType|string $type = ReactionTypeType::PAID;
}
