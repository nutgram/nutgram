<?php

namespace SergiX44\Nutgram\Telegram\Types\User;

use DateTime;
use DateTimeZone;
use SergiX44\Nutgram\Telegram\Types\BaseType;

class Birthdate extends BaseType
{
    /**
     * Day of the user's birth; 1-31
     */
    public int $day;

    /**
     * Month of the user's birth; 1-12
     */
    public int $month;

    /**
     * Optional. Year of the user's birth
     */
    public ?int $year = null;

    public function toDateTime(?DateTimeZone $timezone = null): ?DateTime
    {
        if ($this->year === null) {
            return null;
        }

        return new DateTime("{$this->year}-{$this->month}-{$this->day}", $timezone);
    }
}
