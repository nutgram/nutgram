<?php

namespace SergiX44\Nutgram\Telegram\Types\Business;

use SergiX44\Hydrator\Annotation\ArrayType;
use SergiX44\Nutgram\Telegram\Types\BaseType;

/**
 * @see https://core.telegram.org/bots/api#businessopeninghours
 */
class BusinessOpeningHours extends BaseType
{
    /**
     * Unique name of the time zone for which the opening hours are defined
     */
    public string $time_zone_name;

    /**
     * List of time intervals describing business opening hours
     * @var BusinessOpeningHoursInterval[]
     */
    #[ArrayType(BusinessOpeningHoursInterval::class)]
    public array $opening_hours;
}
