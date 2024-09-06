<?php

namespace SergiX44\Nutgram\Telegram\Types\Giveaway;

use SergiX44\Nutgram\Telegram\Types\BaseType;

/**
 * This object represents a service message about the creation of a scheduled giveaway. Currently holds no information.
 * @see https://core.telegram.org/bots/api#giveawaycreated
 */
class GiveawayCreated extends BaseType
{
    /**
     * Optional. The number of Telegram Stars to be split between giveaway winners; for Telegram Star giveaways only
     */
    public ?int $prize_star_count = null;
}
