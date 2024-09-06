<?php

namespace SergiX44\Nutgram\Telegram\Types\Giveaway;

use SergiX44\Nutgram\Telegram\Types\BaseType;
use SergiX44\Nutgram\Telegram\Types\Message\Message;

/**
 * This object represents a service message about the completion of a giveaway without public winners.
 * @see https://core.telegram.org/bots/api#giveawaycompleted
 */
class GiveawayCompleted extends BaseType
{
    /**
     * Number of winners in the giveaway
     */
    public int $winner_count;

    /**
     * Optional. Number of undistributed prizes
     */
    public ?int $unclaimed_prize_count = null;

    /**
     * Optional. Message with the giveaway that was completed, if it wasn't deleted
     */
    public ?Message $giveaway_message = null;

    /**
     * Optional. True, if the giveaway is a Telegram Star giveaway.
     * Otherwise, currently, the giveaway is a Telegram Premium giveaway.
     */
    public ?bool $is_star_giveaway = null;
}
