<?php

namespace SergiX44\Nutgram\Telegram\Types\Business;

use SergiX44\Nutgram\Telegram\Types\BaseType;

/**
 * @see https://core.telegram.org/bots/api#businessopeninghoursinterval
 */
class BusinessOpeningHoursInterval extends BaseType
{
    /**
     * The minute's sequence number in a week, starting on Monday,
     * marking the start of the time interval during which the business is open; 0 - 7 * 24 * 60
     */
    public int $opening_minute;

    /**
     * The minute's sequence number in a week, starting on Monday,
     * marking the end of the time interval during which the business is open; 0 - 8 * 24 * 60
     */
    public int $closing_minute;
}
