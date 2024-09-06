<?php

namespace SergiX44\Nutgram\Telegram\Types\Boost;

use SergiX44\Hydrator\Resolver\EnumOrScalar;
use SergiX44\Nutgram\Telegram\Properties\ChatBoostSourceSource;
use SergiX44\Nutgram\Telegram\Types\User\User;

/**
 * The boost was obtained by the creation of a Telegram Premium giveaway. This boosts the chat 4 times for the duration of the corresponding Telegram Premium subscription.
 * @see https://core.telegram.org/bots/api#chatboostsourcegiveaway
 */
class ChatBoostSourceGiveaway extends ChatBoostSource
{
    /**
     * Source of the boost, always “giveaway”
     */
    #[EnumOrScalar]
    public ChatBoostSourceSource|string $source = ChatBoostSourceSource::GIVEAWAY;

    /**
     * Identifier of a message in the chat with the giveaway; the message could have been deleted already. May be 0 if the message isn't sent yet.
     */
    public int $giveaway_message_id;

    /**
     * Optional. User that won the prize in the giveaway if any
     */
    public ?User $user = null;

    /**
     * Optional. The number of Telegram Stars to be split between giveaway winners; for Telegram Star giveaways only
     */
    public ?int $prize_star_count = null;

    /**
     * Optional. True, if the giveaway was completed, but there was no user to win the prize
     */
    public ?bool $is_unclaimed = null;
}
