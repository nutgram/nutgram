<?php

namespace SergiX44\Nutgram\Telegram\Types\Giveaway;

use SergiX44\Hydrator\Annotation\ArrayType;
use SergiX44\Nutgram\Telegram\Types\BaseType;
use SergiX44\Nutgram\Telegram\Types\Chat\Chat;

/**
 * This object represents a message about a scheduled giveaway.
 * @see https://core.telegram.org/bots/api#giveaway
 */
class Giveaway extends BaseType
{
    /**
     * The list of chats which the user must join to participate in the giveaway
     * @var Chat[]
     */
    #[ArrayType(Chat::class)]
    public array $chats;

    /**
     * Point in time (Unix timestamp) when winners of the giveaway will be selected
     * @var int
     */
    public int $winners_selection_date;

    /**
     * The number of users which are supposed to be selected as winners of the giveaway
     * @var int
     */
    public int $winner_count;

    /**
     * Optional. True, if only users who join the chats after the giveaway started should be eligible to win
     * @var bool|null
     */
    public ?bool $only_new_members = null;

    /**
     * Optional. True, if the list of giveaway winners will be visible to everyone
     * @var bool|null
     */
    public ?bool $has_public_winners = null;

    /**
     * Optional. Description of additional giveaway prize
     * @var string|null
     */
    public ?string $prize_description = null;

    /**
     * Optional. A list of two-letter ISO 3166-1 alpha-2 country codes indicating the countries from which eligible users for the giveaway must come. If empty, then all users can participate in the giveaway. Users with a phone number that was bought on Fragment can always participate in giveaways.
     * @var string[]|null
     */
    public ?array $country_codes = null;

    /**
     * Optional. The number of months the Telegram Premium subscription won from the giveaway will be active for
     * @var int|null
     */
    public ?int $premium_subscription_month_count = null;
}
