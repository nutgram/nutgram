<?php

namespace SergiX44\Nutgram\Telegram\Types\User;

use SergiX44\Nutgram\Telegram\Types\BaseType;

/**
 * This object describes the rating of a user based on their Telegram Star spendings.
 * @see https://core.telegram.org/bots/api#userrating
 */
class UserRating extends BaseType
{
    /**
     * Current level of the user, indicating their reliability when purchasing digital goods and services. A higher level suggests a more trustworthy customer; a negative level is likely reason for concern.
     */
    public int $level;

    /**
     * Numerical value of the user's rating; the higher the rating, the better
     */
    public int $rating;

    /**
     * The rating value required to get the current level
     */
    public int $current_level_rating;

    /**
     * Optional. The rating value required to get to the next level; omitted if the maximum level was reached
     */
    public ?int $next_level_rating = null;
}
