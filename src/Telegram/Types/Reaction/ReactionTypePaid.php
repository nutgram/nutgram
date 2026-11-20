<?php

declare(strict_types=1);

namespace SergiX44\Nutgram\Telegram\Types\Reaction;

use SergiX44\Hydrator\Annotation\OverrideConstructor;
use SergiX44\Hydrator\Resolver\EnumOrScalar;
use SergiX44\Nutgram\Telegram\Properties\ReactionTypeType;
use SergiX44\Nutgram\Telegram\Types\Internal\BaseType;

/**
 * The reaction is paid.
 * @see https://core.telegram.org/bots/api#reactiontypepaid
 */
#[OverrideConstructor('bindToInstance')]
class ReactionTypePaid extends BaseType implements ReactionType
{
    /**
     * Type of the reaction, always “paid”
     */
    #[EnumOrScalar]
    public ReactionTypeType|string $type = ReactionTypeType::PAID;
}
