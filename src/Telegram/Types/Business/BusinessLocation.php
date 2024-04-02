<?php

namespace SergiX44\Nutgram\Telegram\Types\Business;

use SergiX44\Nutgram\Telegram\Types\BaseType;
use SergiX44\Nutgram\Telegram\Types\Location\Location;

class BusinessLocation extends BaseType
{
    /**
     * Address of the business
     */
    public string $address;

    /**
     * Optional. Location of the business
     */
    public ?Location $location = null;
}
